<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>職人を削除に失敗しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>職人を削除に成功しました。</p>
        </div>

        <!-- 職人修正 -->
        <div class="l-modal" :class="{'open': isWorkerEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleWorkerEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="`/user/worker-edit/${modalWorkerId}`">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteWorker(modalWorkerId)">削除する</a></div>
                </div>
            </div>
        </div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="/user/worker">
                        <img src="/public/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">職人一覧</h1>
                <div class="l-wrap--header__inner__sub">
                    <!--
                    <ul class="l-wrap--header__inner__list pc-only">
                        <li class="select-charge">
                            <div class="c-select--triangle">
                                <div class="c-select--triangle">
                                    // <select class="" v-model="searchMember" @change="loadDocuments">
                                    //    <template v-for="(member, index) in members">
                                    //        <option :value="member.id" :class="{'selected': member.id === searchMember}">{{ member.name }}</option>
                                    //    </template>
                                    // </select>
                                    <select class="">
                                    //    <option v-for="(member, index) in members" :key="index" :value="member.id">{{ member.name }}</option>
                                    //    <template v-for="(member, index) in members">
                                    //        <option :value="member.id">{{ member.name }}</option>
                                    //    </template>
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul>
                    -->
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
                        <a class="c-button--addGreen" href="/user/worker-register">職人を追加する</a>
                    </div>
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
                        <div class="l-wrap--body__table__tr" v-for="(worker, index) in workers" :key="index">
                            <a class="c-link--edit" @click="toggleWorkerEdit(worker.id)">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ worker.name }}</div>
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--sub_sp">{{ worker.email }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ worker.memo }}</div>
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
                isWorkerEdit: false,
                members: [],
                workers: [],
                modalWorkerId: '',
                hasError: false,
                hasSuccess: false,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
            this.loadWorkers();
        },
        mounted: function () {
            // this.workStart = dayjs(this.work.period_start_date).month(5).format();
			$("#header-user > div.header-user__top > div > div > div.header-user__top__search.c-search--box.l-inputLabel > input").on('keyup', (e) => {
				if (e.key === 'Enter' || e.keyCode === 13) {
					// this.searchKeyword = '';
					// if(!e.target.value) return;
					this.searchKeyword = e.target.value;
					this.loadWorkers_s();
				}
			});
        },
        computed: {},
        methods: {
            // 担当者を取得するAPI
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
            toggleWorkerEdit: function(id) {
                this.isWorkerEdit = !this.isWorkerEdit;
                this.modalWorkerId = id;
            },
            // 職人一覧を取得するAPI
            loadWorkers: function() {
                axios.get('/api/user/charge-users')
                    .then(result => {
                        console.log(result);
                        this.workers = result.data
                    })
                    .catch(error => {
                        console.log('err', error);
                    })
            },
            // 職人一覧を取得するAPI-new
            loadWorkers_s: function() {
                axios.post('/api/user/workers/searchNew',{
                    keyword: this.searchKeyword,
                })
                    .then(result => {
                        console.log(result);
                        this.workers = result.data.data
                    })
                    .catch(error => {
                        console.log('err', error);
                    })
            },
            // 職人削除API
            deleteWorker: function(id) {
                this.hasError = false
                this.hasSuccess = false
                this.isWorkerEdit = false
                axios.delete(`/api/user/charge-users/${id}`)
                    .then(result => {
                        this.hasSuccess = true
                        setTimeout(function() {
                            location.href = '/user/worker';
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
