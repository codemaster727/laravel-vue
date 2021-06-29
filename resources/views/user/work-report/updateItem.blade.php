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
                            <h1 class="l-wrap--header__title u-w100per">撮影項目編集</h1>
                        </div>
                    </div>
                    <div class="l-wrap--body l-wrap--body__input">
                        <div class="l-wrap--body__inner">
                            <ul class="noLink">
                                <li>
                                    <div class="l-input__wrap">
                                        <label>現場項目タイトル</label>
                                        <input type="" name="" placeholder="診断報告書のタイトルを記入してください">
                                    </div>
                                </li>
                                <li>
                                    <div class="l-input__wrap">
                                        <label>共有メモ</label>
                                        <textarea placeholder="職人に共有するメモを記入してください"></textarea>
                                    </div>
                                </li>
                                <li>
                                    <div class="l-input__wrap">
                                        <label>社内メモ</label>
                                        <textarea placeholder="社内用のメモを記入してください"></textarea>
                                    </div>
                                </li>
                                <!-- <li>
                                    <div class="l-input__wrap">
                                        <label>診断写真</label>
                                        <div class="l-input__file">
                                            <div class="l-input__preview">
                                                <img src="/public/img/1560031.jpg">
                                                <button>削除する</button>
                                            </div>
                                            <div class="l-input__upload">
                                                <input type="file" name="">
                                            </div>
                                        </div>
                                    </div>
                                </li> -->
                            </ul>
                        </div>
                        <div class="l-button--submit">
                            <input class="c-button--yellowRounded" type="submit" name="" value="変更内容を保存する">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>