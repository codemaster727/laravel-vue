@include("../components/head")
<body>
	<div id="app">
		@include("../components/header")
		<main>
			<div class="l-login">
				<user-auth-password-reset-component v-bind:email="'{{ isset($email) ? $email : '' }}'"></user-auth-password-reset-component>
			</div>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
