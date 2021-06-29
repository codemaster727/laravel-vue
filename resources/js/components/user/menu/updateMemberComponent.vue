<template>
    <div class="l-wrap--inner">
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>営業担当者編集に成功されました。</p>
        </div>

        <div class="l-wrap--header">
            <div class="l-wrap--header__inner">
                <div class="l-wrap--header__back">
                    <a href="javascript:void(0)" onclick="history.back(); return false">
                        <img src="/img/icon-arrow-left-black.png">
                    </a>
                </div>
                <h1 class="l-wrap--header__title u-w100per">営業担当者を編集</h1>
            </div>
        </div>
        <div class="l-wrap--body l-wrap--body__input">
            <div class="l-wrap--body__inner">

                <ul class="noLink">
                    <li>
                        <div class="l-input__wrap">
                            <label>営業担当者名</label>
                            <input :class="{'is-invalid': errorMsg.name != ''}" type="" name="" v-model="data.name" placeholder="営業担当者の名前">
                            <span v-if="errorMsg.name" class="invalid-feedback">{{ errorMsg.name }}</span>
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
                <button class="c-button--yellowRounded" type="submit" @click.prevent.stop="editMember">変更内容を保存する</button>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
	    props: ['member_id'],
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
            this.loadMember();
		},
		computed: {},
		methods: {
            loadMember: function() {
                this.hasError = false;
                axios.get('/api/user/members/' + this.member_id)
                    .then(result => {
                        let data = result.data.data;
                        this.data = data[0];
                    })
                    .catch(error => {
                        this.hasError = true;
                    });
            },
            editMember: function() {
                this.hasError = false;
                this.hasSuccess = false;
                axios.put('/api/user/members/' + this.member_id, this.data)
                    .then(result => {
                        this.hasSuccess = true;
                        this.errorMsg = {
                            name: '',
                            memo: '',
                        }
                        setTimeout(function() {
                            location.href = '/user/member';
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
