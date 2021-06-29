<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>入力資料が正しくではありません。<br>もう一度、入力をお願いいたします。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>編集に成功しました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <!-- <a href="javascript:void(0)" onclick="history.back(); return false"> -->
                    <a href="/user/memo">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">メモ編集</h1>
                <div class="l-wrap--header__inner__sub">
                    <ul class="l-wrap--header__inner__list sp-only">
                        <li class="icon">
                            <a @click.prevent="toggleModalTrush">
                                <img src="/img/icon-dust-black.png">
                                <span>削除</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>
                                タイトル
                            </label>
                            <input
                                :class="{'is-invalid': errorMsg.title != ''}"
                                v-model="data.title"
                                placeholder="タイトルを記入してください"
                            >
                            <span
                                v-if="errorMsg.title"
                                class="invalid-feedback"
                            >
                                {{ errorMsg.title }}
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>
                                作成者
                            </label>
                            <div class="c-selectBox">
                                <select
                                    class="c-selectBox"
                                    :class="{'is-invalid': errorMsg.member_id != ''}"
                                    v-model="data.member"
                                >
                                    <!-- <template v-for="(member, index) in members">
                                        <option :value="member.id">{{ member.name }}</option>
                                    </template> -->
                                    <option
                                        v-for="(member, index) in members"
                                        :key="index"
                                        :value="member.id"
                                    >
                                        {{ member.name }}
                                    </option>
                                </select>
                            </div>
                            <span
                                v-if="errorMsg.member_id"
                                class="invalid-feedback"
                            >
                                {{ errorMsg.member_id }}
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>メモ内容</label>
                            <textarea
                                :class="{'is-invalid': errorMsg.text != ''}"
                                v-model="data.text"
                            />
                            <span
                                v-if="errorMsg.text"
                                class="invalid-feedback"
                            >
                                {{ errorMsg.text }}
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit">
                <button
                    class="c-button--yellowRounded"
                    type="button"
                    @click.prevent.stop="updateData"
                >
                    変更内容を保存する
                </button>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        props: ['memo_id', 'url'],
        data() {
            return {
                hasError: false,
                hasSuccess: false,
                errorMsg: {
                    title: '',
                    member_id: '',
                    text: '',
                },
                data: [],
                members: [],
                field1: '',
                field2: '',
                ja: vdp_translation_ja.js,
                DatePickerFormat: 'yyyy-MM-dd', // datepicker
                panelActive: '1', // タブ切り替え
                isModalSms: false, // SMSモーダル
                isModalTrash: false, // 削除モーダル
                isModalConfirm: false, // 現場確定モーダル
                isModalComplete: false, // 現場完了モーダル
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
            this.loadData();
        },
        computed: {},
        methods: {
            // パネルの切り替え
            changePanel: function(num) {
                this.panelActive = num
            },
            // SMSモーダル
            toggleModalSms: function() {
                this.isModalSms = !this.isModalSms
            },
            // 削除モーダル
            toggleModalTrush: function() {
                this.isModalTrash = !this.isModalTrash
            },
            // 現場確定モーダル
            toggleModalConfirm: function() {
                this.isModalConfirm = !this.isModalConfirm
            },
            // 現場完了モーダル
            toggleModalComplete: function() {
                this.isModalComplete = !this.isModalComplete
            },
            editUrl: function() {
                return this.url + '/user/memo/edit?id=' + this.memo_id;
            },
            loadMembers: function() {
                axios
                    .get('/api/user/members')
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
                        this.data.member = this.members[0]['id']
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            loadData: function() {
                axios
                    .get('/api/user/memos/' + this.memo_id)
                    .then(result => {
                        let data = result.data.data
                        if (data) {
                            this.data = {
                                member: data.member_id,
                                title: data.title,
                                text: data.text,
                            }
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            updateData: function() {
                this.hasSuccess = false;
                this.hasError = false;
                let params = {
                    title: this.data.title,
                    member_id: this.data.member,
                    text: this.data.text,
                };
                axios
                    .put('/api/user/memos/' + this.memo_id, params)
                    .then(result => {
                        let url = this.url;
                        this.hasSuccess = true;
                        this.errorMsg = {
                            title: '',
                            member_id: '',
                            text: '',
                        }
                        setTimeout(function() {
                            location.href = '/user/memo';
                        }, 1000)
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors;
                        if (errorMsg) {
                            if (errorMsg.title) {
                                this.errorMsg.title = errorMsg.title[0];
                            }
                            if (errorMsg.member_id) {
                                this.errorMsg.member_id = errorMsg.member_id[0];
                            }
                            if (errorMsg.text) {
                                this.errorMsg.text = errorMsg.text[0];
                            }
                        }
                    });
            }
        },
        watch: {},
	}
</script>
