<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-work-report-show-item-component></user-work-report-show-item-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>