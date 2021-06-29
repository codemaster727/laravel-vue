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
						<h1>ユーザー登録失敗</h1>
					</div>
					<div class="l-login__body">
						<p class="c-sentence textCenter">8時間以内の登録またはその他原因で、登録が完了できませんでした。<br>お手数ですが、管理者へお問い合わせください。</p>
						<div class="l-button--submit">
							<a href="" class="c-button--yellowRounded">管理者へお問い合わせ</a>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
