@include("../components/head")
		@include("../components/header")
<body>
	<div id="app">
		<div class="container">
			<!--　case1：パスワードの再登録が成功した場合 -->
			<!--
			<div class="l-alart successAlart">
				<p>パスワードの再登録が完了しました。<br>新しいパスワードで、ログインしてください。</p>	
			</div>
			-->

			<!--　case2：ログアウト時 -->
			<!--
			<div class="l-alart successAlart">
				<p>ログアウトしました。</p>	
			</div>
			-->

			<!-- case3：メールアドレス、パスワードが一致しなかった場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>メールアドレスとパスワードが一致しませんでした。<br>もう一度、入力をお願いいたします。</p>
			</div>
			-->

			<!--　case4；新規登録時に、URLの有効期限が切れた場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>1時間経過したため、新規登録用URLの有効期限が切れました。<br class="pc-only">お手数おかけしますが、営業担当へお問い合わせください。</p>
			</div>
			-->


			<!--　case5：管理画面で、ステータスを一時停止にされた場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>運営者により、強制的に一時停止中です。<br>営業担当へ、お問い合わせください。</p>
			</div>
			-->

			<!-- case6：未入力がある場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>未入力があります。</p>
			</div>
			-->

			<!-- <div class="l-wrap l-wrap--login">
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
									<input type="text" name="" placeholder="メールアドレスを入力してください。">
								</div>
								<div class="l-wrap--login__box">
									<label>パスワード</label>
									<input type="password" name="" placeholder="パスワードを入力してください。">
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
									<input type="submit" class="c-button--yellowRounded" name="" value="ログイン">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> -->
			<manager-auth-login></manager-auth-login>
		</div>
	</div>
	@include("../components/footer")
</body>
</html>