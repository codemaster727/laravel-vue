<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>お客様の編集に成功しました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="/user/client">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">お客様を編集</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">
                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>お客様名</label>
                            <input :class="{'is-invalid': errorMsg.name != ''}" type="" name="" v-model="data.name" placeholder="お客様の名前">
                            <span v-if="errorMsg.name" class="invalid-feedback">{{ errorMsg.name }}</span>
                        </div>
                    </li>
                    <li>
                        <div class="l-input__wrap">
                            <label>電話番号</label>
                            <input :class="{'is-invalid': errorMsg.tel != ''}" type="" name="" v-model="data.tel" placeholder="00000000000">
                            <span v-if="errorMsg.tel" class="invalid-feedback">{{ errorMsg.tel }}</span>
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
            <div class="l-button--submit" @click.prevent.stop="editClient">
                <button type="submit" class="c-button--yellowRounded">変更内容を保存する</button>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        props: ['client_id'],
		data() {
			return {
                data: [],
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
            this.loadClient();
		},
		computed: {},
		methods: {
            loadClient: function() {
                this.hasError = false;
                axios.get('/api/clients/' + this.client_id)
                    .then(result => {
                        let data = result.data.data;
                        this.data = data;
                    })
                    .catch(error => {
                        this.hasError = true;
                    });
            },
            editClient: function() {
                this.hasError = false;
                this.hasSuccess = false;
                axios.put('/api/clients/' + this.client_id, this.data)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorMsg = {
                            name: '',
                            tel: '',
                            memo: '',
                        }
                        setTimeout(function() {
                            location.reload();
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
