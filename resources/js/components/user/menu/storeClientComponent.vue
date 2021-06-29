<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>お客様を追加に成功されました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">お客様を追加</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">

                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>お客様名</label>
                            <input :class="{'is-invalid': errorMsg.name != ''}" type="" name="" v-model="name" placeholder="お客様の名前">
                            <span v-if="errorMsg.name" class="invalid-feedback">{{ errorMsg.name }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>電話番号</label>
                            <input :class="{'is-invalid': errorMsg.tel != ''}" type="" name="" v-model="tel" placeholder="00000000000">
                            <span v-if="errorMsg.tel" class="invalid-feedback">{{ errorMsg.tel }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>備考</label>
                            <textarea :class="{'is-invalid': errorMsg.memo != ''}" v-model="memo"></textarea>
                            <span v-if="errorMsg.memo" class="invalid-feedback">{{ errorMsg.memo }}</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="l-button--submit" @click.prevent.stop="registerClient">
                <input class="c-button--yellowRounded" type="submit" name="" value="追加する">
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
                name: '',
                tel: '',
                memo: '',
                errorMsg: {
                    name: '',
                    tel: '',
                    memo: '',
                },
                hasError: false,
                hasSuccess: false,
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
		},
		computed: {},
		methods: {
            registerClient: function() {
                this.hasError = false;
                this.hasSuccess = false;
                let params = {
                    name: this.name,
                    tel: this.tel,
                    memo: this.memo,
                }
                axios.post('/api/clients', params)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorMsg = {
                            name: '',
                            tel: '',
                            memo: '',
                        }
                        setTimeout(function() {
                            location.href = '/user/client';
                        }, 1000);
                    })
                    .catch(error => {
                        this.hasError = true;
                        let errorMsg = error.response.data.errors;
                        if (errorMsg) {
                            if (errorMsg.name) {
                                this.errorMsg.name = errorMsg.name[0];
                            }
                            if (errorMsg.tel) {
                                this.errorMsg.tel = errorMsg.tel[0];
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
