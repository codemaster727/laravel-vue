<!DOCTYPE html>
<html>
@include("../components/head-worker")
<body>
    <div id="app">
        <main>
            <div class="l-worker">
                <div class="l-worker--wrap">
                    <div class="l-worker--inner">
                        <div class="l-worker--header">
                            <div class="l-worker--header__back">
                                <a href="javascript:void(0)" onclick="history.back(); return false">
                                    <img src="/img/icon-arrow-left-black.png">
                                </a>
                            </div>
                            <p class="title">プロフィールを編集する</p>
                        </div>
                        <div class="l-worker--body">
                            <div class="l-worker--body__wrap">
                                <div class="l-worker--body__main">
                                    <div class="l-worker--body__box">
                                        <div class="l-worker--body__box__headline"></div>
                                        <div class="l-worker--body__main__input">
                                            <div class="l-worker--body__main__input__list">
                                                <label>ID</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="l-worker--body__main__input__list">
                                                <label>名前</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="l-worker--body__main__input__list">
                                                <label>メールアドレス</label>
                                                <input type="text" name="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="l-worker--body__submit">
                            <input class="c-button--yellowRounded" type="submit" name="" value="写真を撮影する">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>