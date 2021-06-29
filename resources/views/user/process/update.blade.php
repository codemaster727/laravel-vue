<!DOCTYPE html>
<html>
@include("../components/head")
<body>

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-login">
                <user-process-update-component :id="{{ $id }}"></user-process-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
