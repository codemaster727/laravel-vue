<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    @include("../components/nav")

    <div id="app">
        @include("../components/header-user")
        <main>
            {{-- <div class="l-alart errorAlart">
                <p>メールアドレスとパスワードが一致しませんでした。<br>もう一度、入力をお願いいたします。</p>
            </div>
            <div class="l-alart successAlart"></div> --}}
            <div class="l-wrap l-wrap--table">
                <user-work-show-component :id="{{ $id }}" />
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>
