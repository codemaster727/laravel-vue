<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                
                <user-work-index-component mykeyword="qweqwe"></user-work-index-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
    <script>
		
	</script>
</body>
</html>