<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                {{-- <user-worker-index-component v-bind:user_id="{{ Auth::user()->id }}"></user-worker-index-component> --}}
                <user-worker-index-component />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
