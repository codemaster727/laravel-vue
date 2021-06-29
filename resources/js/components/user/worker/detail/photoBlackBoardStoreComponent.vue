<template>
	<div class="l-worker">
		<div class="l-worker--wrap">
			<div class="l-worker--inner">
                <div class="l-alart errorAlart" v-if="hasNoOutput">
                    <p>画像を生成ください。</p>
                </div>
				<div class="l-worker--header">
					<div class="l-worker--header__back">
						<!-- 写真を撮り直す（パソコンの場合は、ライブラリ選択に戻る） -->
						<a href="javascript:void(0)" onclick="history.back(); return false">
							<img src="/img/icon-arrow-left-black.png">
						</a>
					</div>
					<p class="title">黒板情報の位置を決める</p>
				</div>
				<div class="l-worker--body">
					<div class="l-worker--body__wrap">
						<div class="l-worker--body__main">
							<div class="l-worker--body__box">
								<div class="l-worker--body__box__headline"></div>
								<div class="l-worker--body__main__position">
									<div class="l-worker--body__main__position__inner">
										<!-- <img src="/img/189007_m.jpg"> -->
										<div id="preview" style="position: relative; height: 500px; top: 0; left: 0" ref="printMe" class="l-worker--body__main__blackboard">
											<movable class="testmove" posTop="0" :grid="1" target="preview" :bounds="{x:[0, parent_width], y:[0, parent_height]}" v-bind:style="blackboardStyle" id="bound">
												<p>{{ work_name }}</p>
												<p>{{ worker_name }}</p>
												<p>{{ charger_name }}</p>
												<p>{{ black_content }}</p>
												<p>{{ created_at }}</p>
											</movable>
											<img v-if="url" :src="url" style="position: absolute; top: 0; left: 0; width: 100%;"/>
										</div>
										<hr style="margin: 10px auto; display: none;">
										<input class="" type="file" name="eee" value="アップロード" @change="uploadBackground">
										<img :src="output" name="output">
										<div id="result" style="display: none;"></div>
                                        <div class="text-center">
                                            <button class="btn btn-primary" type="primary" @click="print">画像を生成</button>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="l-worker--body__submit">
					<input class="c-button--yellowRounded" type="submit" @click="uploadBlackboard" name="" value="確定する">
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import VueHtml2Canvas from 'vue-html2canvas';
	import movable from "v-movable";
	Vue.use(VueHtml2Canvas);
	Vue.use(movable);
	export default {
		props: ["charger", "name", "content", "work_id", "worker_name", "blackboard_width", "blackboard_height"],
		data() {
			return {
			    hasNoOutput: false,
				url: '',
				output: null,
				uploadInput: null,

				charger_name: '',
				black_content: '',
				created_at: '',
				work_name: '',

				parent_width: 580 - this.blackboard_width - 1,
				parent_height: 500 - this.blackboard_height - 1,

                blackboardStyle: {
			        'z-index': 10,
                    'background': 'green',
                    'width': this.blackboard_width + 'px',
                    'height': this.blackboard_height + 'px',
                }
            }
		},
		created: function() {
			this.init();
		},
		computed: {},
		methods: {
			init: function() {
				let params = {
					work_id: 1
				};
				axios.get('/api/user/workers/' + this.work_id)
					.then(result => {
						let data = result.data.data;
						this.charger_name = this.charger;
						this.black_content = this.content;
						this.created_at = data.worker.period_start_date;
						this.work_name = data.worker.name;
					})
					.catch(error => {
						console.log('error', error)
					});

			},
			setBound: function() {
				let height = $('#preview').height();
				let width = $('#preview').width();
				console.log('kkk', this.parent_width, this.parent_height);
			},
			async print() {
				const el = this.$refs.printMe;
				const options = {
					type: 'dataURL'
				}
				this.output = await this.$html2canvas(el, options);
				this.setBound();
			},
			uploadBackground: function(e) {
				const file = e.target.files[0];
				this.url = URL.createObjectURL(file);
				this.setBound();
			},
			uploadBlackboard: function() {
			    this.hasNoOutput = false;
                if (this.output == null || this.output == undefined) {
                    this.hasNoOutput = true;
                    return;
                }
                let formData = new FormData();
				const file = this.DataURIToBlob(this.output)
				formData.append('files', file);
				formData.append('work_id', this.work_id);
				axios.post('/api/uploadBlackboard', formData, {
						headers: {
							'Content-Type': 'multipart/form-data'
						}
          			})
					.then(result => {

					})
					.catch(error => {

					})
			},
			DataURIToBlob: function(dataURI) {
				const splitDataURI = dataURI.split(',')
				const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
				const mimeString = splitDataURI[0].split(':')[1].split(';')[0]

				const ia = new Uint8Array(byteString.length)
				for (let i = 0; i < byteString.length; i++)
					ia[i] = byteString.charCodeAt(i)

				return new Blob([ia], { type: mimeString })
			},
		},
		mounted() {
			// this.print()
		},
		watch: {},
	}
</script>

<style>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}
.vm--container {
	z-index: 0;
	width: auto;
	height: auto;
}
.vm--overlay {
	width: auto;
	height: auto;
}
.vm--modal {
	box-shadow: none;
}
.testmove {
	display:block;
	position: absolute;
	top: 0;
	left: 0;
	background: #333;
	color: white;
}
</style>
