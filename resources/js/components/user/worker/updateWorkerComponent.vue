<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>職人情報の編集に失敗しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>職人情報の編集に成功しました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">職人情報を編集</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap l-inputLabel">
                            <label>職人名<span>（変更できません）</span></label>
                            <input :class="{'is-invalid': errorMsg.name != ''}" type="text" v-model="data.name" placeholder="職人の名前" disabled>
                            <span v-if="errorMsg.name" class="invalid-feedback">{{ errorMsg.name }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap l-inputLabel">
                            <label>メールアドレス<span>（変更できません）</span></label>
                            <input :class="{'is-invalid': errorMsg.email != ''}" type="text" v-model="data.email" placeholder="職人のメールアドレス" disabled>
                            <span v-if="errorMsg.email" class="invalid-feedback">{{ errorMsg.email }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>社内メモ</label>
                            <textarea :class="{'is-invalid': errorMsg.memo != ''}" v-model="data.memo"></textarea>
                            <span v-if="errorMsg.memo" class="invalid-feedback">{{ errorMsg.memo }}</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit">
                <button class="c-button--yellowRounded" type="submit" @click.prevent.stop="editWorker">変更内容を保存する</button>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        props: ['workerId'],
		data() {
			return {
                data: [],
                errorMsg: {
                    name: '',
                    memo: '',
                },
                hasError: false,
                hasSuccess: false,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadWorker();
		},
		computed: {},
		methods: {
            // 職人を取得する
            loadWorker: function() {
                this.hasError = false;
                axios.get(`/api/user/charge-users/${this.workerId}`)
                    .then(result => {
                        this.data = result.data
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            // 職人編集（ユーザーのみ）
            editWorker: function() {
                this.hasError = false;
                this.hasSuccess = false;
                axios.put(`/api/user/charge-users/${this.workerId}`, this.data)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorMsg = {
                            name: '',
                            email: '',
                            memo: '',
                        }
                        setTimeout(function() {
                            location.href = '/user/worker';
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors;
                        if (errorMsg) {
                            if (errorMsg.name) {
                                this.errorMsg.name = errorMsg.name[0];
                            }
                            if (errorMsg.memo) {
                                this.errorMsg.memo = errorMsg.memo[0];
                            }
                        }
                    });
            },
        },
		watch: {},
	}
</script>
