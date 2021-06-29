<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>営業担当の削除に失敗しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>営業担当の削除に成功しました。</p>
        </div>

        <!-- 営業担当修正 -->
        <div class="l-modal" :class="{'open': isMemberEdit}">
            <div class="l-modal__inner l-flex l-center l-v__center" @click.self="toggleMemberEdit">
                <div class="l-modal__iosModel">
                    <div class="l-modak__list"><a :href="`/user/member-edit/${modalMemberId}`">編集する</a></div>
                    <div class="l-modak__list"><a @click="deleteMember(modalMemberId)">削除する</a></div>
                </div>
            </div>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="sp-only l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/public/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title">営業担当一覧</h1>
                <div class="l-wrap--header__inner__sub">
                    <!-- <ul class="l-wrap--header__inner__list pc-only">
                        <li class="select-charge">
                            <div class="c-select--triangle">
                                    <select class="">
                                        <template v-for="(member, index) in members">
                                            <option :value="member.id">{{ member.name }}</option>
                                        </template>
                                    </select>
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
        <div class="l-wrap--body l-wrap--body__table">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--body__table__area">
                    <div class="l-wrap--body__table__button">
                        <a class="c-button--addGreen" href="/user/menu/member-register">営業担当を追加する</a>
                    </div>
                    <div class="l-wrap--body__table__thead">
                        <div class="l-wrap--body__table__tr">
                            <div class="l-wrap--body__table__tr__inner">
                                <div class="l-wrap--body__table__th u-w200_pc">営業担当名</div>
                                <div class="l-wrap--body__table__th u-wflex1_pc">社内メモ</div>
                            </div>
                        </div>
                    </div>
                    <div class="l-wrap--body__table__tbody">
                        <div class="l-wrap--body__table__tr" v-for="(member, index) in members" :key="index">
                            <a class="c-link--edit" @click="toggleMemberEdit(member.id)">
                                <div class="l-wrap--body__table__tr__inner">
                                    <div class="l-wrap--body__table__td u-w200_pc u-w100per_sp c-text--main_sp">{{ member.name }}</div>
                                    <div class="l-wrap--body__table__td u-wflex1_pc u-w100per_sp c-text--sub_sp">{{ member.memo }}</div>
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
                isMemberEdit: false,
                members: [],
                modalMemberId: '',
                hasError: false,
                hasSuccess: false,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
        },
        computed: {},
        methods: {
            // 担当者一覧を取得するAPI
            // loadMembers: function() {
            //     this.members = [{
            //         id: 0,
            //         name: '全ての担当',
            //     }];
            //     axios.get('/api/user/members')
            //         .then(result => {
            //             let datas = result.data.data;
            //             if (datas) {
            //                 for (let index = 0; index < datas.length; index ++) {
            //                     let data = datas[index];
            //                     this.members.push({
            //                         id: data.id,
            //                         name: data.name,
            //                     });
            //                 }
            //             }
            //         })
            //         .catch(error => {
            //             console.log('err', error);
            //         });
            // },
            // 営業担当一覧を取得するAPI
            loadMembers: function() {
                axios.get('/api/user/members')
                    .then(result => {
                        // const APIDatas = result.data.data
                        // console.log(APIDatas)
                        // this.members = APIDatas.find(data => data.user.id == this.user_id);
                        this.members = result.data.data
                    })
                    .catch(error => {
                        console.log('err', error);
                    })
            },
            deleteMember: function(id) {
                this.hasError = false
                this.hasSuccess = false
                this.isMemberEdit = false
                axios.delete(`/api/user/members/${id}`)
                    .then(result => {
                        this.hasSuccess = true
                        setTimeout(function() {
                            location.href = '/user/member';
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true
                    })
            },
            toggleMemberEdit: function(id) {
                this.isMemberEdit = !this.isMemberEdit;
                this.modalMemberId = id;
            },
        },
        watch: {},
    }
</script>
