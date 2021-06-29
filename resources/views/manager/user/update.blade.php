<!DOCTYPE html>
<html>
@include("../components/head-owner")
<body>
	<div id="app">
		@include("../components/nav-owner")
		<main>
            <manager-user-update-component v-bind:id="{{ $id }}"></manager-user-update-component>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>