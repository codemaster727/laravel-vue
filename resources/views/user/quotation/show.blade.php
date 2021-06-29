<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">

        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
            <user-quotation-show-component v-bind:id="{{ $id }}"></user-quotation-show-component>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
