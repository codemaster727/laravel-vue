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
			<worker-request-register-complete-component v-bind:worker_id = "'{{ $worker_id }}'"></worker-request-register-complete-component>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>