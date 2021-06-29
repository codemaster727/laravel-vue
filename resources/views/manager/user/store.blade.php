<!DOCTYPE html>
<html>
@include("../components/head-owner")
<body>
	<div id="app">
        @include("../components/nav-owner")
		<main>
            <manager-user-store-component :manager={{ $manager_id }}></manager-user-store-component>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
