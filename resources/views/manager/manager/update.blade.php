<!DOCTYPE html>
<html>
@include("../components/head-owner")
<body>
	<div id="app">
		@include("../components/nav-owner")
		<main>
            <manager-manager-update v-bind:id="{{ $id }}"></manager-manager-update>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>