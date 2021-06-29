<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-menu-client-update-component :client_id="{{ $client_id }}"></user-menu-client-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
