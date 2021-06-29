@include("../../components/head")
<body>
	<div id="app">
		@include("../../components/header")
		<main>
			<div class="l-login">
                <user-store-info-component :token="'{{ isset($token) ? $token : '' }}'"  v-bind:status="{{ isset($status) ? $status : 0 }}"></user-store-info-component>
			</div>
		</main>
	</div>
	@include("../../components/footer")
</body>
</html>
