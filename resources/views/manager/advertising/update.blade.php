<!DOCTYPE html>
<html>
@include("../components/head-owner")
<body>
	<div id="app">
		@include("../components/nav-owner")
		<main>
			<manager-advertising-update-component v-bind:id="{{ $id }}"></manager-advertising-update-component>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
