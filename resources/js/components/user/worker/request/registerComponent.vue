<template>
	<div class="l-wrap--inner">
        <div class="l-alart successAlart" v-if="hasSuccess">
            <p>職人の登録が成功しました。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasConfirm">
            <p>パスワードと確認用パスワードと異なります。</p>
        </div>
        <div class="l-alart errorAlart" v-if="hasError">
            <p>エラーが発生しました。</p>
        </div>
		<div class="l-login__title l-user__header">
			<div class="l-user__header__inner">
				<h1>職人用新規登録</h1>
			</div>
		</div>
		<div class="l-form__area">
			<div class="l-inputLabel u-inputBox">
				<p class="c-sentence">ぬりえもんの職人用新規登録のご案内です。<br>パスワードは、ログイン情報として使用しますので、必ず保存してください。</p>
			</div>
			<!-- <template v-if="errorStatus == true">
				<ul class="l-inputLabel u-inputBox">
					<li
                        class="c-sentence"
                        v-for="(data, index) in errors"
                        :key="index"
                        style="color: red; list-style: disc;"
                    >
                        {{ String(data) }}
                    </li>
				</ul>
			</template> -->
			<div class="l-inputLabel u-inputBox">
				<label>職人ID</label>
				<input class="c-input--white" type="text" v-model="worker.code" placeholder="12345678">
			</div>
			<div class="l-inputLabel u-inputBox">
				<label>お名前</label>
				<input class="c-input--white" type="text" v-model="worker.name" placeholder="山田">
			</div>
			<div class="l-inputLabel u-inputBox">
				<label>メールアドレス</label>
				<input class="c-input--white" type="email" v-model="worker.email" placeholder="test@gmail.com">
			</div>
			<div class="l-inputLabel u-inputBox">
				<label>パスワード</label>
				<input class="c-input--white" type="password" v-model="worker.password">
			</div>
			<div class="l-inputLabel u-inputBox">
				<label>確認用パスワード</label>
				<input class="c-input--white" type="password" v-model="worker.confirm_password">
			</div>
			<div class="l-button--submit">
                <button
                    class="c-button--yellowRounded"
                    type="button"
                    :disabled="!form_all"
                    :class="{'notSubmit':!form_all}"
                    @click="registerWorker()"
                >
                    新規登録
                </button>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				id: '',
				password: '',
				confirm_pass: '',
				errors: [],
                errorStatus: false,
                worker: {
                    code: '',
                    name: '',
                    email: '',
                    password: '',
                    confirm_password: '',
                },
                // バリデーション用
                hasSuccess: false,
                hasConfirm: false,
                hasError: false,
			}
		},
		created: function() {
            // 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
		},
        computed: {
            // 入力状況でsubmitができる
            form_all: function() {
                let required_fields = [
                    this.worker.code,
                    this.worker.name,
                    this.worker.email,
                    this.worker.password,
                    this.worker.confirm_password,
                ]
                return required_fields.indexOf('') === -1
            },
        },
		methods: {
			registerWorker: function() {
                this.hasSuccess = false
                this.hasConfirm = false
                this.hasError = false
                // パスワードと確認用パスワードが一致しているか確認する
                if(this.worker.password != this.worker.confirm_password) {
                    this.hasConfirm = true
                } else {
                    // 一致していた場合の処理を記述
                    let params = {
                        name: this.worker.name,
                        code: this.worker.code,
                        email: this.worker.email,
                        password: this.worker.password,
                    };
                    // APIを送信する
                    axios.post('/api/user/workers', params)
						.then(result => {
							let status = result.status;
							let data = result.data;
							this.errorStatus = false;
							if (status == 204 && data == "") {
								console.log("Status: ")
								window.location.href = '/worker/request-new/complete?id=' + params.code;
							} else {
								console.log(result);
							}
						})
						.catch(error => {
							this.errorStatus = true;
							console.log(error.response);
							if(error.response.data.errors == undefined || error.response.data.errors.length == 0)
								this.errors[0] = error.response.data.message;
							else
								this.errors = error.response.data.errors;
						});
                }
			},
			// validate: function(params) {
			// 	// if(params.password != params.confirm_pass) {
			// 	// 	return false;
			// 	// }
			// 	// if(params.worker_id == undefined || params.worker_id.length < 6) {
			// 	// 	return false;
			// 	// }

			// 	return true;
			// }

		},
		watch: {},
	}
</script>
