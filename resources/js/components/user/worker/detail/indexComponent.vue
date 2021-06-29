<template>
	<div class="l-worker--inner">
		<!-- 職人用：案件詳細 現場完了ボタン -->
		<div class="l-modal" :class="{'open': isWorkerTypeQuestion}">
			<div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleWorkerTypeQuestion">
				<div class="l-modal__iosModel">
					<div class="l-modal__iosModel__inner">
						<p class="c-sentence textCenter">職長ですか？<br>子方ですか？</p>
						<ul class="l-flex trueFalse">
							<li><a @click="toggleWorkerTypeQuestion()">職長です</a></li>
							<li><a @click="toggleWorkerTypeQuestion()">子方です</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- fin 職人用：案件詳細 現場完了ボタン -->
		<div class="l-worker--header">
			<div class="l-worker--header__back">
				<a href="javascript:void(0)" onclick="history.back(); return false">
					<img src="/img/icon-arrow-left-black.png">
				</a>
			</div>
			<p class="title">現場詳細</p>
		</div>
		<div class="l-worker--body">
			<div class="l-worker--body__tab l-wrap--tab">
				<ul class="l-wrap--tab__list tab-two">
					<li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">詳細情報</a></li>
					<li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">作業報告用写真</a></li>
				</ul>
			</div>
            <!-- case1：作業未開始 -->
			<div class="l-worker--body__submit" v-if="status == 1">
                <button
                    class="c-button--yellowRounded"
                    @click="isUpdate()"
                >
                    作業開始する
                </button>
				<!-- <input class="c-button--yellowRounded" type="submit" name="" value="作業開始する" > -->
			</div>
            <!-- case2：作業開始後 -->
			<div class="l-worker--body__submit" v-else-if="status == 2">
                <button
                    class="c-button--yellowRounded"
                    @click="isUpdate()"
                >
                    作業を終了する
                </button>
				<!-- <input class="c-button--yellowRounded" type="submit" name="" value="作業を終了する" @click="isUpdate()"> -->
			</div>
			<!-- case3：作業終了後 -->
			<div class="l-worker--body__submit" v-else-if="status == 3">
				<p class="u-color--grayNavy u-text--center">作業は終了しております。</p>
			</div>

			<div class="l-worker--body__wrap" v-if="panelActive === '1'">
				<!-- 詳細情報 -->
				<div class="l-worker--body__main">
					<div class="l-worker--body__box">
						<div class="l-worker--body__main__table">
							<table>
								<tr>
									<th class="u-w120">期間</th>
									<td>{{ term1 }}</td>
								</tr>
								<tr>
									<th>現場名</th>
									<td>{{ work_space1 }}</td>
								</tr>
								<tr>
									<th>郵便番号</th>
									<td>{{ postal_code1 }}</td>
								</tr>
								<tr>
									<th>現場住所</th>
									<td>{{ address }}</td>
								</tr>
								<tr>
									<th>共有情報</th>
									<td>{{ share_info }}</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="l-worker--body__box">
						<div class="l-worker--body__main__table">
							<table>
								<tr>
									<th class="u-w120">期間</th>
									<td>{{ term2 }}</td>
								</tr>
								<tr>
									<th>現場名</th>
									<td>{{ work_space2 }}</td>
								</tr>
								<tr>
									<th>郵便番号</th>
									<td>{{ postal_code2 }}</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- 作業報告用写真 -->
			<div class="l-worker--body__wrap" v-else-if="panelActive === '2'">
				<div class="l-worker--body__main">


					<div class="l-worker--body__box">
						<div class="l-worker--body__box__headline"></div>
						<div class="l-worker--body__main__detail">
							<div class="l-worker--body__main__detail__add">
								<a v-bind:href="'/worker/work-detail/photo-blackboard?work_id=' + work_id" class="c-button--addGreen">項目を追加する</a>
							</div>
							<div class="l-worker--body__main__detail__table">
								<template v-for="(data, index) in reportList">
									<div class="l-worker--body__main__detail__tr">
										<a v-bind:href="'work/word-detail/' + data.id" class="c-link--detail">
											<div class="tr-inner">
												<div class="u-w70">
													<div class="img">
														<img v-bind:src="data.photo">
													</div>
												</div>
												<div class="u-wflex1">
													<p class="c-text--main">{{ data.title }}</p>
													<p class="c-text--sub">{{ data.work_date }} / {{ data.photographer }}</p>
													<p class="c-text--sub">{{ data.content }}</p>
												</div>
											</div>
											<div class="tr-inner">
												<div class="c-text--sharedInfomation">
													<p>{{ data.memo }}</p>
												</div>
											</div>
										</a>
									</div>
								</template>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
	export default {
		props: ["work_id"],
		data() {
			return {
				id: 0,
				term1: '',
				work_space1: '',
				postal_code1: '111-111',
				address: '',
				share_info: '',
				term2: '',
				work_space2: '',
				postal_code2: '',
				status: 0,

				reportList: [],

                ja: vdp_translation_ja.js,
                panelActive: '1', // タブ切り替え
				isWorkerTypeQuestion: false,
			}
		},
		created: function() {
			this.loadWorkInfo();
		},
		computed: {},
		methods: {
			loadWorkInfo: function() {
				axios.get('/api/works/' + this.work_id)
					.then(result => {
						console.log(result);
						let data = result.data.data;
						if(data) {
							this.term1 = data.startDate.replace('/', '月') + '日' + '-' + data.finishDate.replace('/', '月') + '日';
							this.work_space1 = data.name;
							this.postal_code1 = data.postal;
							this.address = data.address;
							this.share_info = data.memo;
							this.status = data.status;

							this.term2 = this.term1;
							this.work_space2 = data.user.company;
							this.postal_code2 = data.user.postal;

							axios.get('/api/workReportItems')
								.then(result => {
									if(data) {
										let tmp = [];
										let work_id = this.work_id;
										data = result.data.data;
										data.forEach(function(item, key) {
											if(item.work_id == work_id)
												tmp.push(item);
										});
										this.reportList = tmp;
									}
								})
								.catch(error => {
									console.log(error)
								});
						}

					})
			},
			isUpdate: function() {
				if(this.isWorkerTypeQuestion == true)
					this.isWorkerTypeQuestion = false;
				else
					this.isWorkerTypeQuestion = true;
			},
			toggleWorkerTypeQuestion: function() {
				let api_url = '';
				if(this.status == 1) {
					api_url = '/api/works/confirmWork/' + this.work_id;
				} else if(this.status == 2) {
					api_url = '/api/works/completeWork/' + this.work_id;
				} else {
					api_url = '/api/works/updateMemo/' + this.work_id;
				}

				axios.post(api_url)
					.then(result => {
						this.isWorkerTypeQuestion = false;
						this.status = result.data.data.status;
						console.log(result);
					})
					.catch(error => {
						console.log(error);
					});
			},
            // パネルの切り替え
            changePanel: function(num) {
                this.panelActive = num
            },
		},
		watch: {},
	}
</script>
