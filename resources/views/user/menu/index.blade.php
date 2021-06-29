<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                <?php $user = Auth::user(); ?>
                <user-menu-index-component v-bind:user_id="{{ isset($user) ? $user->id: 0 }}"></user-menu-index-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
