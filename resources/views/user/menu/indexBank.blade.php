<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                <user-menu-bank-index-component
                    :bank_id="{{ isset($user->bank_id) ? $user->bank_id : 'NULL' }}"
                />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
