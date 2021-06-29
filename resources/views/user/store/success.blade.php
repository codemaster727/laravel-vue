<!DOCTYPE html>
<html>
@include("../components/head")
<body>
	<div id="app">
		@include("../components/header")
		<main>
			<!-- <div class="l-alart errorAlart">
				<p>メールアドレスとパスワードが一致しませんでした。<br>もう一度、入力をお願いいたします。</p>
			</div>
			<div class="l-alart successAlart"></div> -->
			<div class="l-login">
				<div class="l-login__wrap">
					<div class="l-login__title">
						<h1>ユーザー登録完了</h1>
					</div>
					<div class="l-login__body">
						<p class="c-sentence textCenter">登録が完了しました！<br>ログイン画面より、登録したメールアドレス及びパスワードで、ログインしてください。</p>
						<div class="l-button--submit">
							<a href="" class="c-button--yellowRounded">ログイン画面へ戻る</a>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>