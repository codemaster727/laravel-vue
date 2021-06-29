<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">パスワードを変更する</h1>
            </div>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>入力資料が正しくではありません。<br>もう一度、入力をお願いいたします。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">パスワードを変更に成功しました。</div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>旧パスワード</label>
                            <input type="password" name="" v-model="oldPassword" placeholder="旧パスワードを入力してください">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>新パスワード</label>
                            <input type="password" name="" v-model="newPassword" placeholder="旧パスワードを入力してください">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>確認用新パスワード</label>
                            <input type="password" name="" v-model="confirmPassword" placeholder="旧パスワードを入力してください">
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit" @click.prevent.stop="updatePassword">
                <input class="c-button--yellowRounded" type="submit" name="" value="変更内容を保存する">
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
		data() {
			return {
                panelActive: '1',
                isMemberEdit: false,
                isClientEdit: false,
                isWorkerEdit: false,
                oldPassword: '',
                newPassword: '',
                confirmPassword: '',
                hasError: false,
                hasSuccess: false,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
		},
		computed: {},
		methods: {
		    changePanel: function(panel) {
		        this.panelActive = panel;
            },
            toggleMemberEdit: function() {
		        this.isMemberEdit = !this.isMemberEdit;
            },
            toggleClientEdit: function() {
		        this.isClientEdit = !this.isClientEdit;
            },
            toggleWorkerEdit: function() {
		        this.isWorkerEdit = !this.isWorkerEdit;
            },
            updatePassword: function() {
                this.hasError = false;
                this.hasSuccess = false;
		        let params = {
		            old_password: this.oldPassword,
                    password: this.newPassword,
                    password_confirmation: this.confirmPassword,
                };
                axios.post('/api/users/password-reset1', params)
                    .then(result => {
                        if (result.data === 0) {
                            this.hasSuccess = true;
                        }
                        else {
                            this.hasError = true;
                        }
                    })
                    .catch(error => {
                        this.hasError = true;
                        console.log('err', error);
                    });
            }
        },
		watch: {},
	}
</script>
