<!DOCTYPE html>
<html>
@include("../components/head-owner")
<body>
	<div id="app">
		@include("../components/nav-owner")
		<main>
			<!-- ユーザー一覧 -->
            <manager-user-list-component></manager-user-list-component>
		</main>
	</div>
	@include("../components/footer")
</body>
</html>
