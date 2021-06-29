<!DOCTYPE html>
<html>
@include("../../components/head")
<body>
	<div id="app">
		@include("../../components/header")
		<main>
			<!-- case1：送信完了 -->
			<!--
			<div class="l-alart successAlart">
				<p>メールアドレスに、パスワード再発行用URLを送信しました。有効期限は1時間です。</p>
			</div>
			-->

			<!-- case2：パスワード再登録URLの有効期限切れ -->
			<!--
			<div class="l-alart errorAlart">
				<p>1時間経過したため、パスワード再登録URLの有効期限が切れ、再登録に失敗しました。</p>
			</div>
			-->

			<!-- case3：入力したメールアドレスが、DBに登録がなかった場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>入力されたメールアドレスは、登録がありません。<br>再度ご入力をお願いいたします。</p>
			</div>
			-->

			<div class="l-login">
				<div class="l-login__wrap">
					<div class="l-login__title">
						<h1>パスワードを忘れた方へ</h1>
					</div>
					<div class="l-login__body">
						<div class="l-inputLabel u-inputBox">
							<label>メールアドレス</label>
							<input class="c-input--gray" type="text" name="" placeholder="メールアドレスを入力してください。">
						</div>
						<div class="l-button--submit">
							<input class="c-button--yellowRounded" type="submit" name="" value="パスワード再発行リクエスト">
						</div>
						<div class="l-login__back">
							<a href="" class="textLink">ログイン画面へ戻る</a>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	@include("../../components/footer")
</body>
</html>