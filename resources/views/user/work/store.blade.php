<!DOCTYPE html>
<html>
@include("../components/head")
<body>

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-login">
                <user-work-store-component :userid="{{ $user_id }}" />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
