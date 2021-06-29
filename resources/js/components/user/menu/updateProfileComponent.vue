<template>
    <div class="l-wrap--inner">
        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">プロフィールを編集</h1>
            </div>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>入力資料が正しくではありません。<br>もう一度、入力をお願いいたします。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">プロフィールを編集に成功しました。</div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>会社名</label>
                            <input type="" name="" v-model="profile.company" placeholder="診断報告書のタイトルを記入してください">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>電話番号</label>
                            <input class="c-input--white" type="text" name="" v-model="profile.tel" placeholder="電話番号を入力してください。">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>郵便番号</label>
                            <input class="c-input--post__one u-mr10" type="" name="" v-model="postal1" placeholder="000">
                            <input class="c-input--post__two" type="" name="" v-model="postal2" placeholder="0000">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>住所</label>
                            <input type="" name="" v-model="profile.address" placeholder="住所を入力してください">
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>パスワード</label>
                            <a href="/user/menu/password-edit" class="u-color--blue">パスワードを変更する</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit" @click.prevent.stop="updateProfile">
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
	    props: ['user_id'],
		data() {
			return {
                panelActive: '1',
                isMemberEdit: false,
                isClientEdit: false,
                isWorkerEdit: false,
                profile: [],
                postal1: '',
                postal2: '',
                hasError: false,
                hasSuccess: false,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
            this.loadProfile();
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
            loadProfile: function() {
                axios.get('/api/users/' + this.user_id)
                    .then(result => {
                        let data = result.data.data;
                        if (data) {
                            this.profile = data;
                            this.postal1 = data.postal.substr(0, 3);
                            this.postal2 = data.postal.substr(3);
                        }
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
            },
            updateProfile: function() {
                this.hasError = false;
                this.hasSuccess = false;
		        let params = {
		            company: this.profile.company,
                    tel: this.profile.tel,
                    postal: this.postal1 + this.postal2,
                    address: this.profile.address,
                };
                axios.put('/api/users/' + this.user_id, params)
                    .then(result => {
                        this.hasSuccess = true;
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
