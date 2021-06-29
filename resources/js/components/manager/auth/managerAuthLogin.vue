<template>
    <div class="l-wrap l-wrap--login">
        <div class="l-wrap--inner">
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
                            <input type="email" name="email" v-model="fields.email" placeholder="メールアドレスを入力してください。"> <!-- v-model="fields.email" -->
                        </div>
                        <div class="l-wrap--login__box color-red" v-if="errors.email" style="font-size:0.85em">
                            <label>メールアドレスを入力してください。</label>
                        </div>
                        <div class="l-wrap--login__box">
                            <label>パスワード</label>
                            <input type="password" name="password" v-model="fields.password" placeholder="パスワードを入力してください。">
                            <a class="u-color--blue" href="/manager/password-reset">パスワードを忘れた方はコチラ</a>
                        </div>
                        <div class="l-wrap--login__box color-red" v-if="errors.password" style="font-size:0.85em">
                            <label>パスワードを忘れた方はコチラ</label>
                        </div>
                        <div class="l-wrap--login__box l-wrap--login__confirm">
                            <div class="c-checkbox--confirm">
                                <label class="l-select__wrap l-flex l-start">
                                    <div class="l-select__area">
                                        <div class="c-checkbox--select">
                                            <input type="checkbox" name="">
                                            <div class="c-checkbox--color"></div>
                                        </div>
                                    </div>
                                    ログイン状態を保持する
                                </label>
                            </div>
                        </div>
                        <div class="l-wrap--login__box c-button--submit">
                            <input type="button" class="c-button--yellowRounded" @click="login" name="" value="ログイン">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

    <script>
        import {mapGetters} from 'vuex'

        export default {
            name: "ManagerAuthLogin",
            data(){
                return {
                    fields:{
                        email:"",
                        password:"",
                        remember:true
                    },
                    errors:{
                        email: false,
                        password: false
                    }
                }
            },
            mounted() {
                // this.$store.dispatch('fetchDailyReports')
            },
            methods: {
                login(){
                    this.errors.email = false;
                    this.errors.password = false;
                    if(this.fields.email == ""){
                        this.errors.email = true;
                    }
                    if(this.fields.password == ""){
                        this.errors.password = true;
                    }
                    if(!this.errors.email && !this.errors.password){
                        var fields = this.fields;
                        axios.post('/api/manager/auth',{
                            email: this.fields.email,
                            password: this.fields.password,
                            remember: true
                        })
                            .then(res => {
                                console.log(res);
                                if (res.data === 'ok')
                                    commit('DELETE_POST', post)
                                // ログイン成功後、ユーザー一覧へURL遷移
                                location.href = '/manager/user'
                            }).catch(err => {
                            // TODO:ログイン認証失敗時、メールアドレスorパスワードが異なる旨のレスポンスを画面に表示する
                            alert("サーバーエラー");
                            console.log(err)
                        })
                    }
                }
            },
            computed: {
                // ...mapGetters([
                //     'dailyReports'
                // ])
            }
        }
    </script>
