<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title">見積書・請求書一覧</h1>
                <div class="l-wrap--header__inner__sub">

                    <ul class="l-wrap--header__inner__list pc-only">
                        <li class="select-charge">
                            <div class="c-select--triangle">
                                <div class="c-select--triangle">
                                    <!-- <select class="" v-model="searchMember" @change="loadDocuments">
                                        <template v-for="(member, index) in members">
                                            <option :value="member.id" :class="{'selected': member.id === searchMember}">{{ member.name }}</option>
                                        </template>
                                    </select> -->
                                    <select
                                        v-model="searchMember"
                                        @change="loadDocuments"
                                    >
                                        <option
                                            v-for="(member, index) in members"
                                            :key="index"
                                            :value="member.id"
                                            :class="{'selected': member.id === searchMember}"
                                        >
                                            {{ member.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleSearchActive">
                                <img src="/public/img/icon-add-black.png">
                                <span>現場作成</span>
                            </a>
                        </li>
                        <li class="icon">
                            <a @click.prevent="toggleSearchActive">
                                <img src="/public/img/icon-search-black.png">
                                <span>検索</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--select sp-only">
            <div class="l-wrap--select__inner">
                <div class="c-select--triangle">
                    <select class="" v-model="searchMember" @change="loadDocuments">
                        <!-- <template v-for="(member, index) in members">
                            <option
                                :value="member.id"
                                :class="{'selected': member.id === searchMember}"
                            >
                                {{ member.name }}
                            </option>
                        </template> -->
                        <option
                            v-for="(member, index) in members"
                            :key="index"
                            :value="member.id"
                            :class="{'selected': member.id === searchMember}"
                        >
                            {{ member.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="l-wrap--tab">
            <ul class="l-wrap--tab__list tab-two">
                <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">見積書</a></li>
                <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">請求書</a></li>
            </ul>
        </div>

        <!-- 見積書 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-if="panelActive === '1'">
            <div class="l-wrap--button sp-only">
                <ul class="l-wrap--button__list button-two select-tab">
                    <li class="selected"><a href="">確定済み</a></li>
                    <li><a href="">未確定</a></li>
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
                        <template v-for="(data, index) in quotationResults">
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

        <!-- 請求書 -->
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search" v-else-if="panelActive === '2'">
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
                                <div class="l-wrap--body__table__th u-w200_pc">お支払い期限</div>
                                <div class="l-wrap--body__table__th u-w150_pc">金額</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <template v-for="(data, index) in invoiceResults">
                        <div class="l-wrap--body__table__tr">
                            <a class="c-link--detail" href="">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__tr__inner u-wflex1">
                                        <div class="l-wrap--body__table__td u-wflex1_pc c-text--main">{{ data.name }}</div>
                                        <div class="l-wrap--body__table__td u-w200_pc c-text--sub_sp">{{ data.customer }}</div>
                                        <div class="l-wrap--body__table__td u-w200_pc c-text--sub_sp"><span class="sp-only">お支払い期限：</span>{{ data.date }}</div>
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
                panelActive: '1',
                isSearchActive: false,
                searchMember: 0,
                quotationResults: [],
                invoiceResults: [],
                members: [],
                totalAmount: 0,
                totalCount: 0,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
            this.loadDocuments();
        },
        mounted: function () {
            // this.workStart = dayjs(this.work.period_start_date).month(5).format();
			$("#header-user > div.header-user__top > div > div > div.header-user__top__search.c-search--box.l-inputLabel > input").on('keyup', (e) => {
				if (e.key === 'Enter' || e.keyCode === 13) {
					// this.searchKeyword = '';
					// if(!e.target.value) return;
					this.searchKeyword = e.target.value;
					this.loadDocuments();
				}
			});
        },
        computed: {},
        methods: {
            changePanel: function(panel) {
                this.panelActive = panel;
                this.loadDocuments();
            },
            toggleSearchActive: function() {
                this.isSearchActive = !this.isSearchActive
            },
            loadMembers: function() {
                this.members = [{
                    id: 0,
                    name: '全ての担当',
                }];
                axios.get('/api/user/members')
                    .then(result => {
                        let datas = result.data.data;
                        if (datas) {
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.members.push({
                                    id: data.id,
                                    name: data.name,
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
                    member: this.searchMember,
                    keyword: this.searchKeyword,
                };
                if (this.panelActive === '1') {
                    axios.post('/api/user/quotations/search', params)
                        .then(result => {
                            let datas = result.data.data;
                            if (datas) {
                                this.quotationResults.splice(0);
                                this.totalAmount = 0;
                                for (let index = 0; index < datas.length; index++) {
                                    let data = datas[index];
                                    this.quotationResults.push({
                                        name: data.name,
                                        customer: data.client.name + '/' + data.member.name,
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
                else if (this.panelActive === '2') {
                    axios.post('/api/user/invoices/search', params)
                        .then(result => {
                            let datas = result.data.data;
                            if (datas) {
                                this.invoiceResults.splice(0);
                                this.totalAmount = 0;
                                for (let index = 0; index < datas.length; index++) {
                                    let data = datas[index];
                                    this.invoiceResults.push({
                                        name: data.name,
                                        customer: data.client.name + '/' + data.member.name,
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
