<template>
	<div class="l-worker">
		<div class="l-worker--wrap">
			<div class="l-worker--inner">
				<div class="l-worker--inner">
					<div class="l-worker--header">
						<div class="l-worker--header__back">
							<a href="javascript:void(0)" onclick="history.back(); return false">
								<img src="/img/icon-arrow-left-black.png">
							</a>
						</div>
						<p class="title">黒板情報を登録する</p>
					</div>
					<div class="l-worker--body">
						<div class="l-worker--body__wrap">
							<div class="l-worker--body__main">
								<div class="l-worker--body__box">
									<div class="l-worker--body__box__headline"></div>
									<div class="l-worker--body__main__input">
										<div class="l-worker--body__main__input__list">
											<label>撮影者</label>
											<div class="c-select--triangle">
												<select name="charger">
													<option v-for="data in chargers">{{ data }}</option>
												</select>
											</div>
										</div>
										<div class="l-worker--body__main__input__list">
											<label>黒板内容</label>
											<textarea name="content"></textarea>
										</div>
										<div id="preview" style="position: relative; height: 500px; display: none;" ref="printMe">
											<movable class="testmove" posTop="0" :grid="1" target="preview" :bounds="{x:[0,100], y:[0,120]}"><span>grid:20</span></movable>
											<img v-if="url" :src="url" :draggable="true"/>
										</div>
										<hr style="margin: 10px auto; display: none;">

										<img :src="output" style="display: none;">

										<div id="result" style="display: none;"></div>

										<input type="file" @change="uploadBackground" value="選択する" name="blackboard" style="display: none;">
										<button type="primary" @click="print" style="display: none;">画像を生成</button>

									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="l-worker--body__submit">
						<input class="c-button--yellowRounded" type="submit" name="" value="写真を撮影する" @click="gotoPhoto">
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  

<script>
	import VueHtml2Canvas from 'vue-html2canvas';
	import movable from "v-movable";
	Vue.use(VueHtml2Canvas);
	Vue.use(movable);
	export default {
		props: ["work_id"],
		data() {
			return {
				url: '',
				output: null,

				chargers: [],
				content: '',

			}
		},
		created: function() {
			this.init();
		},
		computed: {},
		methods: {
			init: function() {
				let params = {
					work_id: this.work_id
				};
				axios.post('/api/chargers', params)
					.then(result => {
						console.log('status ok')
						console.log(result.data);
						this.chargers = result.data;
					})
					.catch(error => {

					});
			},
			async print() {
				const el = this.$refs.printMe;
				const options = {
					type: 'dataURL'
				}
				this.output = await this.$html2canvas(el, options);
			},
			uploadBackground: function(e) {
				const file = e.target.files[0];
				this.url = URL.createObjectURL(file);
			},
			 show : function() {
				this.$modal.show('hello-world');
			},
			hide : function () {
				this.$modal.hide('hello-world');
			},
			generate(){
                    //まずはテキスト部分だけ生成させる
                    let vc = this;

                    html2canvas(document.querySelector("#preview"), {
                        scale: 2 //文字がぼやけないように
                    }).then(function(canvas) {
                        //その後、メイン画像として生成
						var result = document.querySelector("#result");
						// result.innerHTML = $('#preview').html();
						result.appendChild(canvas);
                    });
			},
			gotoPhoto: function() {
				window.location.href = '/worker/work-detail/photo-position?work_id=1&name=' + $('[name=charger]').val() + '&content=' + $('[name=content]').val();
			}
		},
		mounted() {
			this.print()
		},
		watch: {},
		  plugins: [
			'~plugins/vue-js-modal.js'
		],
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