<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <div class="l-wrap l-wrap--form">
                <div class="l-wrap--inner">
                    <div class="l-wrap--header">
                        <div class="l-wrap--header__inner">
                            <div class="l-wrap--header__back">
                                <a href="javascript:void(0)" onclick="history.back(); return false">
                                    <img src="/img/icon-arrow-left-black.png">
                                </a>
                            </div>
                            <h1 class="l-wrap--header__title u-w100per">退会する</h1>
                        </div>
                    </div>
                    <div class="l-wrap--body l-wrap--body__input">
                        <div class="l-wrap--body__inner">
                            <ul class="noLink">
                                <li>
                                    <div class="l-input__wrap">
                                        <p class="c-sentence">退会すると、全ての情報が削除されます。<br>よろしいでしょうか。</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="l-button--submit">
                            <input class="c-button--yellowRounded" type="submit" name="" value="退会する">
                            <!-- ログイン画面に移動、alartをログイン画面で表示 -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>