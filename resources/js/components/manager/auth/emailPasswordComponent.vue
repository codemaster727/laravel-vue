<template>

    <div class="l-login__wrap">

        <!-- case1：送信完了 -->
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>メールアドレスに、パスワード再発行用URLを送信しました。有効期限は1時間です。</p>
        </div>

        <!-- case2：パスワード再登録URLの有効期限切れ -->
        <div class="l-alart errorAlart" v-if="hasInvalidToken">
            <p>1時間経過したため、パスワード再登録URLの有効期限が切れ、再登録に失敗しました。</p>
        </div>

        <!-- case3：入力したメールアドレスが、DBに登録がなかった場合 -->
        <div class="l-alart errorAlart" v-if="hasError">
            <p>入力されたメールアドレスは、登録がありません。<br>再度ご入力をお願いいたします。</p>
        </div>

        <div class="l-login__title">
            <h1>パスワードを忘れた方へ</h1>
        </div>
        <div class="l-login__body">
            <div class="l-inputLabel u-inputBox">
                <label>メールアドレス</label>
                <input class="c-input--gray" type="text" name="" v-model="email" placeholder="メールアドレスを入力してください。">
            </div>
            <div class="l-button--submit" @click.prevent.stop="sentResetMail">
                <input class="c-button--yellowRounded" type="submit" name="" value="パスワード再発行リクエスト">
            </div>
            <div class="l-login__back">
                <a href="/manager/login" class="textLink">ログイン画面へ戻る</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['status'],
        data() {
            return {
                email: '',
                hasSuccess: false,
                hasInvalidToken: false,
                hasError: false,
            }
        },
        created() {
            switch (this.status) {
                case 1:
                    this.hasError = true; break;
                case 2:
                    this.hasInvalidToken = true; break;
            }
        },
        methods: {
            sentResetMail: function() {
                this.hasSuccess = false;
                this.hasInvalidToken = false;
                this.hasError = false;
                let params = {
                    email: this.email,
                };
                axios.post('/api/manager/password-sent', params)
                .then(result => {
                    console.log(result.data);
                    switch (result.data) {
                        case 'passwords.user':
                            this.hasError = true; break;
                        case 'passwords.sent':
                            this.hasSuccess = true; break;
                    }
                })
                .catch(error => {
                    let err = error.response;
                    this.hasError = true;
                });
            }
        },
        computed: {
        }
    }
</script>
