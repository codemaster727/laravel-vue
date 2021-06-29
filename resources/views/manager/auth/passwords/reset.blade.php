@include("../components/head")
<body>
	<div id="app">
		@include("../components/header")
		<main>
			<div class="l-login">
				<manager-auth-password-reset-component v-bind:email="'{{ isset($email) ? $email : '' }}'"></manager-auth-password-reset-component>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
