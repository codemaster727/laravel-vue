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
						<h1>新規登録 営業担当追加(2/2)</h1>
					</div>
					<div class="l-form__area">
						<div class="l-form__explain">
							<p class="c-sentence">営業担当を登録してください。<br>現場登録時や、見積書、請求書、診断報告書、作業報告書に記載される情報です。<br>
							あとで変更することができます。</p>
						</div>
						<div class="l-inputLabel u-inputBox">
							<label>営業担当名</label>
							<input class="c-input--white" type="password" name="" placeholder="例）田中太郎">
						</div>
						<div class="l-button--add">
							<button class="c-button--addGreen">営業担当を追加する</button>
						</div>
						<div class="l-button--submit">
							<input class="c-button--yellowRounded" type="submit" name="" value="登録完了する">
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>