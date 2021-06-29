<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <?php $user = Auth::user(); ?>
                <user-menu-profile-update-component v-bind:user_id="{{ isset($user) ? $user->id : 0 }}"></user-menu-profile-update-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
