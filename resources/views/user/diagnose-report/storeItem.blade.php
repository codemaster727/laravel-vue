<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <user-diagnose-report-store-item-component :id="{{ $id }}" />
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
