<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="loginFailed">
            <p>メールアドレスとパスワードが一致しませんでした。<br>もう一度、入力をお願いいたします。</p>
        </div>

        <div class="l-alart errorAlart" v-if="hasEmpty">
            <p>未入力があります。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <h1 class="l-wrap--header__title u-w100per">ログイン画面</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <div class="l-wrap--login__area">
                    <div class="l-wrap--login__box">
                        <label>メールアドレス</label>
                        <input :class="{'is-invalid': errorMsg.email != ''}" type="text" name="" v-model="email" @keydown="checkEnter" placeholder="メールアドレスを入力してください。">
                        <span v-if="errorMsg.email" class="invalid-feedback">{{ errorMsg.email }}</span>
                    </div>
                    <div class="l-wrap--login__box">
                        <label>パスワード</label>
                        <input :class="{'is-invalid': errorMsg.password != ''}" type="password" name="" v-model="password" @keydown="checkEnter" placeholder="パスワードを入力してください。">
                        <span v-if="errorMsg.password" class="invalid-feedback">{{ errorMsg.password }}</span>
                        <a class="u-color--blue" href="/password-send">パスワードを忘れた方はコチラ</a>
                    </div>
                    <div class="l-wrap--login__box l-wrap--login__confirm">
                        <div class="c-checkbox--confirm">
                            <label class="l-select__wrap l-flex l-start">
                                <div class="l-select__area">
                                    <div class="c-checkbox--select">
                                        <input type="checkbox" name="" v-model="remember">
                                        <div class="c-checkbox--color" />
                                    </div>
                                </div>
                                ログイン状態を保持する
                            </label>
                        </div>
                    </div>
                    <div class="l-wrap--login__box c-button--submit">
                        <button type="submit" class="c-button--yellowRounded" @click.prevent.stop="doLogin">ログイン</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        data() {
            return {
                email: '',
                password: '',
                remember: false,
                loginFailed: false,
                hasEmpty: false,
                errorMsg: {
                    email: '',
                    password: '',
                }
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {},
        methods: {
            checkEnter: function(e) {
                if (e.keyCode == 13) {
                    this.doLogin();
                }
            },
            doLogin: function() {
                /*this.hasEmpty = false;
                if (this.email == '' || this.password == '') {
                    this.hasEmpty = true;
                    return;
                }*/
                this.loginFailed = false;
                let params = {
                    email: this.email,
                    password: this.password,
                    remember_token: this.remember,
                };
                axios.post('/api/users/auth', params)
                    .then(result => {
                        let response = result.data;
                        this.errorMsg = {
                            email: '',
                            password: '',
                        };
                        if (!response || response.session_id == '') {
                            this.loginFailed = true;
                        }
                        else {
                            location.href = '/user/work';
                        }
                    })
                    .catch(error => {
                        this.loginFailed = true;
                        let errorMsg = error.response.data.errors.original;
                        if (errorMsg) {
                            if (errorMsg.email) {
                                this.errorMsg.email = errorMsg.email[0];
                            }
                            if (errorMsg.password) {
                                this.errorMsg.password = errorMsg.password[0];
                            }
                        }
                    });
            }
        },
        watch: {},
	}
</script>
