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
			<div class="l-wrap l-wrap--login">
				<div class="l-wrap--inner">
					<worker-request-register-component></worker-request-register-component>
				</div>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>