<!DOCTYPE html>
<html>
@include("../components/head")
<body>
	<div id="app">
		@include("../components/header")
		<main>
			<!-- case1：パスワードと確認用パスワードが一致しなかった場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>パスワードと確認用パスワードが異なります。</p>
			</div>
			-->

			<!-- case2：パスワードが8文字未満の場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>パスワードは8文字以上です。</p>
			</div>
			-->

			<!-- case3：未入力がある場合 -->
			<!--
			<div class="l-alart errorAlart">
				<p>未入力があります。</p>
			</div>
			-->
			<div class="l-login">
				<div class="l-login__wrap">
					<div class="l-login__title">
						<h1>パスワード再登録</h1>
					</div>
					<div class="l-login__body">
						<div class="l-inputLabel u-inputBox">
							<label>新規パスワード</label>
							<input class="c-input--gray" type="password" name="" placeholder="パスワードを入力してください。">
						</div>
						<div class="l-inputLabel u-inputBox">
							<label>確認用 新規パスワード</label>
							<input class="c-input--gray" type="password" name="" placeholder="パスワードを入力してください。">
						</div>
						<div class="l-button--submit">
							<input class="c-button--yellowRounded" type="submit" name="" value="パスワード再登録">
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>