<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>入力資料が正しくではありません。<br>もう一度、入力をお願いいたします。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            登録に成功しました。
        </div>
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="/user/memo">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">メモ作成</h1>
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
                                type="text"
                                v-model="title"
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
                                    v-model="member"
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
                            <label>
                                メモ内容
                            </label>
                            <textarea
                                :class="{'is-invalid': errorMsg.text != ''}"
                                v-model="text"
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
                    type="submit"
                    @click.prevent.stop="registerMemo"
                >
                    メモを作成する
                </button>
                <!-- <input class="c-button--yellowRounded" type="submit" @click.prevent.stop="registerMemo" value="メモを作成する"> -->
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        props: ['url'],
		data() {
			return {
                title: '',
                member: '',
                text: '',
                members: [],
                hasError: false,
                hasSuccess: false,
                errorMsg: {
                    title: '',
                    member_id: '',
                    text: '',
                }
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadMembers();
		},
		computed: {},
		methods: {
            loadMembers: function() {
                this.members = [];
                axios
                    .get('/api/user/members')
                    .then(result => {
                        let datas = result.data.data
                        if (datas) {
                            for (let index = 0; index < datas.length; index ++) {
                                let data = datas[index];
                                this.members.push({
                                    id: data.id,
                                    name: data.name,
                                });
                                this.member = data.id
                            }
                        }

                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            registerMemo: function() {
                this.hasSuccess = false;
                this.hasError = false;
                let params = {
                    title: this.title,
                    member_id: this.member,
                    text: this.text,
                };
                axios.post('/api/user/memos', params)
                    .then(result => {
                        var url = this.url;
                        this.hasSuccess = true;
                        this.errorMsg = {
                            title: '',
                            member_id: '',
                            text: '',
                        };
                        setTimeout(function() {
                            location.href = url + '/user/memo';
                        }, 1000);
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
