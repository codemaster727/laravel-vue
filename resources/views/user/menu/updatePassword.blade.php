<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-menu-password-update-component></user-menu-password-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
