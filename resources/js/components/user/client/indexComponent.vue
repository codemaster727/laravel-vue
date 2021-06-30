<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>お客様の削除に失敗しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>お客様の削除に成功しました。</p>
        </div>

        <!-- お客様修正 -->
        <div class="l-modal" :class="{'open': isClientEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleClientEdit">
            <!-- <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleClientEdit(client.id)"> -->
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="`/user/client-edit/${modalClientId}`">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteClient">削除する</a></div>
                </div>
            </div>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="/user/client">
                        <img src="/public/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">お客様一覧</h1>
                <div class="l-wrap--header__inner__sub">
                    <!-- <ul class="l-wrap--header__inner__list pc-only">
                        <li class="select-charge">
                            <div class="c-select--triangle">
                                <div class="c-select--triangle"> -->
                                    <!-- <select class="" v-model="searchMember" @change="loadDocuments">
                                        <template v-for="(member, index) in members">
                                            <option :value="member.id" :class="{'selected': member.id === searchMember}">{{ member.name }}</option>
                                        </template>
                                    </select> -->
                                    <!-- <select class="">
                                        <option v-for="(member, index) in members" :key="index" :value="member.id">{{ member.name }}</option> -->
                                        <!-- <template v-for="(member, index) in members">
                                            <option :value="member.id">{{ member.name }}</option>
                                        </template> -->
                                    <!-- </select>
                                </div>
                            </div>
                        </li>
                    </ul> -->
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a href="/user/process">
                                <img src="/public/img/icon-chart-black.png">
                                <span>工程表</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__table l-wrap--body__search">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/client-register">お客様を追加する</a>
                    </div>
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
                        <div class="l-wrap--body__table__tr" v-for="(client, index) in clients" :key="index">
                            <a class="c-link--edit" @click.prevent="toggleClientEdit(client.id)">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ client.name }}</div>
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ client.tel }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ client.memo }}</div>
                                </div>
                            </a>
                        </div>
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
        props: ['user_id'],
		data() {
			return {
                isClientEdit: false,
                clients: [],
                modalClientId: '',
                hasError: false,
                hasSuccess: false,
                searchKeyword: ''
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadClients();
		},
        mounted: function () {
            // this.workStart = dayjs(this.work.period_start_date).month(5).format();
			// $("#header-user > div.header-user__top > div > div > div.header-user__top__search.c-search--box.l-inputLabel > input").on('keyup', (e) => {
			// 	if (e.key === 'Enter' || e.keyCode === 13) {
			// 		// this.searchKeyword = '';
			// 		// if(!e.target.value) return;
			// 		this.searchKeyword = e.target.value;
			// 		this.loadClients_s();
			// 	}
			// });
        },
		computed: {},
		methods: {
            // お客様一覧を取得するAPI
            loadClients: function() {
                axios.get('/api/clients')
                    .then(result => {
                        this.clients = result.data.data
                    })
                    .catch(error => {
                        console.log('err', error);
                    })
            },
            // お客様一覧を取得するAPI-new
            loadClients_s: function() {
                axios.post('/api/clients/search',{
                    keyword: this.searchKeyword,
                })
                    .then(result => {
                        console.log(result);
                        this.clients = result.data.data;
                    })
                    .catch(error => {
                        console.log('err', error);
                    })
            },
            // 編集のモーダル表示
            toggleClientEdit: function(id) {
                this.isClientEdit = !this.isClientEdit;
                this.modalClientId = id;
            },
            // 担当者を削除するAPI
            deleteClient: function(id) {
                this.hasError = false
                this.hasSuccess = false
                this.isClientEdit = false
                axios.delete(`/api/clients/${this.modalClientId}`)
                    .then(result => {
                        this.hasSuccess = true
                        setTimeout(function() {
                            location.href = '/user/client';
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true
                    })
            },
        },
		watch: {},
	}
</script>
