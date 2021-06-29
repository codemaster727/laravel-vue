<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title">検索結果</h1>
            </div>
        </div>
        <div class="l-wrap--search">
            <div class="l-wrap--search__inner">
                <div class="l-wrap--search__select">
                    <ul class="l-wrap--search__select__list">
                        <li :class="{'selected': itemTabActive === 1}"><a @click.prevent="changeItemTab(1)">現場</a></li>
                        <li :class="{'selected': itemTabActive === 2}"><a @click.prevent="changeItemTab(2)">職人</a></li>
                        <li :class="{'selected': itemTabActive === 3}"><a @click.prevent="changeItemTab(3)">お客様</a></li>
                        <li :class="{'selected': itemTabActive === 4}"><a @click.prevent="changeItemTab(4)">書類</a></li>
                    </ul>
                </div>
                <div class="l-wrap--search__area">
                    <div class="c-input--search">
                        <input type="text" @change="doSearch" v-model="searchKey" placeholder="検索するキーワードを入力してください">
                    </div>
                </div>
            </div>
        </div>

        <!-- 現場一覧 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="itemTabActive === 1">
            <div class="l-wrap--button">
                <ul class="l-wrap--button__list button-three select-tab">
                    <li :class="{'selected': workStatus === 1}"><a @click.prevent="changeWorkStatus(1)">進行中</a></li>
                    <li :class="{'selected': workStatus === 0}"><a @click.prevent="changeWorkStatus(0)">未確定</a></li>
                    <li :class="{'selected': workStatus === 2}"><a @click.prevent="changeWorkStatus(2)">完了済み</a></li>
                </ul>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-wflex1_pc">現場名<br>住所 / お客様名</div>
                                <div class="l-wrap--body__table__th u-w100_pc">開始日</div>
                                <div class="l-wrap--body__table__th u-w100_pc">終了日</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(data, index) in workResults">
                        <div class="l-wrap--body__table__tr">
                            <a class="c-link--detail" href="">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-wflex1">
                                        <p class="c-text--main">{{ data.name }}</p>
                                        <p class="c-text--sub_sp u-mb0">{{ data.address }}<span class="pc-only"> / </span>
                                            <br class="sp-only">{{ data.client }}
                                        </p>
                                    </div>
                                    <div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
                                        <span class="u-color--grayNavy">{{ data.startDate }}</span>
                                    </div>
                                    <div class="l-wrap--body__table__td u-w100_pc u-w60_sp">
                                        <span class="u-color--grayNavy">{{ data.finishDate }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- 職人一覧 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="itemTabActive === 2">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">職人名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">メールアドレス</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(data, index) in workerResults">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--detail" href="">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ data.name }}</div>
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ data.email }}</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ data.memo }}</div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- お客様 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="itemTabActive === 3">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">お客様名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">電話番号</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(data, index) in clientResults">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--detail" href="">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ data.name }}</div>
                                        <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ data.tel }}</div>
                                        <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ data.memo }}</div>
                                    </div>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>


        <!-- 書類 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="itemTabActive === 4">
            <div class="l-wrap--button">
                <ul class="l-wrap--button__list button-two select-tab">
                    <li :class="{'selected': documentType === 1}"><a @click.prevent="changeDocumentType(1)">見積書</a></li>
                    <li :class="{'selected': documentType === 2}"><a @click.prevent="changeDocumentType(2)">請求書</a></li>
                </ul>
            </div>
            <div class="l-wrap--total">
                <p>合計<span>{{ totalAmount | formatNumber }}円</span>（<span>{{ totalCount }}</span>件）</p>
            </div>
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-wflex1_pc">件名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">取引先名</div>
                                <div class="l-wrap--body__table__th u-w200_pc">有効期限</div>
                                <div class="l-wrap--body__table__th u-w150_pc">金額</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(data, index) in documentResults">
                            <div class="l-wrap--body__table__tr">
                                <a class="c-link--detail" href="">
                                    <div class="l-wrap--body__table__tr__inner">
                                        <div class="l-wrap--body__table__tr__inner u-wflex1">
                                            <div class="l-wrap--body__table__td u-wflex1_pc c-text--main">{{ data.name }}</div>
                                            <div class="l-wrap--body__table__td u-w200_pc c-text--sub_sp">{{ data.customer }}</div>
                                            <div class="l-wrap--body__table__td u-w200_pc c-text--sub_sp"><span class="sp-only">有効期限：</span>{{ data.date }}</div>
                                        </div>
                                        <div class="l-wrap--body__table__td u-w150_pc u-w130_sp">
                                            <span class="u-color--grayNavy">¥{{ data.amount | formatNumber }}</span>
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
</template>

<script>
    var numeral = require('numeral');

    Vue.filter("formatNumber", function (value) {
        return numeral(value).format("0,0");
    });

	export default {
		data() {
			return {
                itemTabActive: 1,
                searchKey: '',
                workStatus: 1,
                workResults: [],
                workerResults: [],
                clientResults: [],
                documentType: 1,
                documentResults: [],
                totalAmount: 0,
                totalCount: 0,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadWorks();
            this.loadDocuments();
		},
        filters: {
            moment(value, format) {
                return moment(value).format(format);
            }
        },
		computed: {},
		methods: {
            changeItemTab: function(tab) {
                this.itemTabActive = tab;
                this.doSearch();
            },
            changeWorkStatus: function(status) {
                this.workStatus = status;
                this.loadWorks();
            },
            changeDocumentType: function(type) {
                this.documentType = type;
                this.loadDocuments();
            },
            doSearch: function() {
                switch (this.itemTabActive) {
                    case 1:
                        this.loadWorks(); break;
                    case 2:
                        this.loadWorkers(); break;
                    case 3:
                        this.loadClients(); break;
                    case 4:
                        this.loadDocuments(); break;
                }
            },
            loadWorks: function() {
		        let params = {
		            keyword: this.searchKey,
                    status: this.workStatus,
                };
                axios.post('/api/works/search', params)
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            this.workResults.splice(0);
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.workResults.push({
                                    name: data.name,
                                    address: data.address,
                                    client: data.client.name,
                                    startDate: data.startDate,
                                    finishDate: data.finishDate,
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadWorkers: function() {
                axios.get('/api/user/workers?keyword=' + this.searchKey)
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            this.workerResults.splice(0);
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.workerResults.push({
                                    name: data.name,
                                    email: data.email,
                                    memo: data.worker.memo,
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadClients: function() {
                axios.get('/api/clients?keyword=' + this.searchKey)
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            this.clientResults.splice(0);
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.clientResults.push({
                                    name: data.name,
                                    tel: data.tel,
                                    memo: data.memo,
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadDocuments: function() {
		        let params = {
		            member: 0,
		            keyword: this.searchKey,
                };
		        if (this.documentType == 1) {
		            // 見積書一覧
                    axios.post('/api/user/quotations/search', params)
                        .then(result => {
                            let datas = result.data.data;
                            if (datas) {
                                this.documentResults.splice(0);
                                this.totalAmount = 0;
                                for (let index = 0; index < datas.length; index ++) {
                                    let data = datas[index];
                                    this.documentResults.push({
                                        name: data.name,
                                        customer: data.client.name,
                                        date: data.expiration_date,
                                        amount: data.total,
                                    });
                                    this.totalAmount += parseInt(data.total);
                                }
                                this.totalCount = datas.length;
                            }
                        })
                        .catch(error => {
                            console.log('err', error);
                        });
                }
		        else if (this.documentType == 2) {
                    // 請求書一覧
                    axios.post('/api/user/invoices/search', params)
                        .then(result => {
                            let datas = result.data.data;
                            if (datas) {
                                this.documentResults.splice(0);
                                this.totalAmount = 0;
                                for (let index = 0; index < datas.length; index ++) {
                                    let data = datas[index];
                                    this.documentResults.push({
                                        name: data.name,
                                        customer: data.client.name,
                                        date: data.limit_date,
                                        amount: data.total,
                                    });
                                    this.totalAmount += parseInt(data.total);
                                }
                                this.totalCount = datas.length;
                            }
                        })
                        .catch(error => {
                            console.log('err', error);
                        });
                }
            }
		},
		watch: {},
	}
</script>
