<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <user-memo-update-component :memo_id="{{ $memoId }}" :url="'{{ url('') }}'" />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
