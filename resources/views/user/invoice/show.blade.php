<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">

        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                <user-invoice-show-component v-bind:id="{{ $id }}"></user-invoice-show-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
