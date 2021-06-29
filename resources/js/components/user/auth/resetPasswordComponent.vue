<template>
    <div class="l-login__wrap">
        <!-- case1：パスワードと確認用パスワードが一致しなかった場合 -->
        <div class="l-alart errorAlart" v-if="hasError">
            <p>パスワードと確認用パスワードが異なります。</p>
        </div>

        <!-- case2：パスワードが8文字未満の場合 -->
        <div class="l-alart errorAlart" v-if="hasInvalid">
            <p>パスワードは8文字以上です。</p>
        </div>

        <!-- case3：未入力がある場合 -->
        <div class="l-alart errorAlart" v-if="hasEmpty">
            <p>未入力があります。</p>
        </div>

        <div class="l-login__title">
            <h1>パスワード再登録</h1>
        </div>
        <div class="l-login__body">
            <div class="l-inputLabel u-inputBox">
                <label>新規パスワード</label>
                <input class="c-input--gray" type="password" name="" v-model="password" placeholder="パスワードを入力してください。">
            </div>
            <div class="l-inputLabel u-inputBox">
                <label>確認用 新規パスワード</label>
                <input class="c-input--gray" type="password" name="" v-model="confirmPassword" placeholder="パスワードを入力してください。">
            </div>
            <div class="l-button--submit" @click.prevent.stop="doResetPassword">
                <input class="c-button--yellowRounded" type="submit" name="" value="パスワード再登録">
            </div>
        </div>
    </div>
</template>

<script>
	export default {
	    props: ['email'],
        data() {
            return {
                password: '',
                confirmPassword: '',
                hasError: false,
                hasInvalid: false,
                hasEmpty: false,
            }
        },
        created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
        },
        computed: {},
        methods: {
            doResetPassword: function() {
                this.hasEmpty = false;
                if (this.password == '' || this.confirmPassword == '') {
                    this.hasEmpty = true;
                    return;
                }
                this.hasError = false;
                this.hasInvalid = false;
                let params = {
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.confirmPassword,
                };
                axios.post('/api/users/password-reset', params)
                    .then(result => {
                        if (result.data == 0) {
                            location.href = '/login';
                        }
                        else {
                            this.hasError = true;
                        }
                    })
                    .catch(error => {
                        let err = error.response;
                        this.hasError = true;
                    });
            }
        },
        watch: {},
	}
</script>
