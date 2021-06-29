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
							<input type="text" name="email" placeholder="メールアドレスを入力してください。">
						</div>
						<div class="l-wrap--login__box">
							<label>パスワード</label>
							<input type="password" name="password" placeholder="パスワードを入力してください。">
							<a class="u-color--blue" href="">パスワードを忘れた方はコチラ</a>
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
							<input type="submit" class="c-button--yellowRounded" name="" value="ログイン" @click="login">
						</div>
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
				confirm_pass: ''
			}
		},
		created: function() {
			// 必要に応じて、初期表示時に使用するLaravelのAPIを呼び出すメソッドを定義
		},
		computed: {},
		methods: {
			login: function() {
				let params = {
					email: $('[name=email]').val(),
					password: $('[name=password]').val(),
					remember_token: 0,
				};
                axios.post('/api/user/login', params)
                    .then(result => {
						let data = '';
						if(result) {
							data = result.data.session_id;
							window.location.href = '/worker/work-list';
						}
						
						
                    })
                    .catch(error => {
                        console.log('err', error);
                    });
			}

		},
		watch: {},
	}
</script>