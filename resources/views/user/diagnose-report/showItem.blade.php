<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-diagnose-report-show-item-component :id="{{ $id }}" />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>

