<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--table">
                {{-- <user-member-index-component v-bind:user_id="{{ Auth::user()->id }}"></user-member-index-component> --}}
                <user-member-index-component :user_id="{{ Auth::user()->id }}" />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
