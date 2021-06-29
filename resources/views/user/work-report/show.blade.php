<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                <user-work-report-show-component></user-work-report-show-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>