<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-login">
                <user-work-update-component v-bind:id="{{ $id }}"></user-work-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
