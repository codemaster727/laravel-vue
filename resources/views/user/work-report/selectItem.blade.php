<!DOCTYPE html>
<html>
@include("../components/head")
<body>
    <div id="app">
        @include("../components/header-user")
        <main>
            <!-- <div class="l-alart errorAlart">
            <p>未入力の項目があります。</p>
            </div> -->
            <div class="l-wrap l-wrap--form">
                <div class="l-wrap--inner">
                    <div class="l-wrap--header">
                        <div class="l-wrap--header__inner">
                            <div class="l-wrap--header__back">
                                <a href="javascript:void(0)" onclick="history.back(); return false">
                                    <img src="/img/icon-arrow-left-black.png">
                                </a>
                            </div>
                            <h1 class="l-wrap--header__title u-w100per">PDF用写真を選択する</h1>
                        </div>
                    </div>
                    <div class="l-wrap--body l-wrap--body__list">
                        <div class="l-wrap--body__inner">
                            <div class="l-wrap--body__list__block">
                                <ul class="noLink">
                                    <li>
                                        <label class="l-select__wrap l-flex">
                                            <div class="l-select__area">
                                                <div class="c-checkbox--select">
                                                    <input type="checkbox" name="">
                                                    <div class="c-checkbox--color"></div>
                                                </div>
                                            </div>
                                            <div class="l-select__detail l-flex">
                                                <div class="c-detail--img">
                                                    <img src="/img/384597_s.png">
                                                </div>
                                                <div class="c-detail--text">
                                                    <p class="c-detail--text__headline">足場</p>
                                                    <p class="c-detail--text__other">
                                                        <span>2020-12-10</span>
                                                        <span>撮影者名前</span>
                                                    </p>
                                                    <p class="c-detail--text__other">撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮</p>
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="l-select__wrap l-flex">
                                            <div class="l-select__area">
                                                <div class="c-checkbox--select">
                                                    <input type="checkbox" name="">
                                                    <div class="c-checkbox--color"></div>
                                                </div>
                                            </div>
                                            <div class="l-select__detail l-flex">
                                                <div class="c-detail--img">
                                                    <img src="/img/384597_s.png">
                                                </div>
                                                <div class="c-detail--text">
                                                    <p class="c-detail--text__headline">足場</p>
                                                    <p class="c-detail--text__other">
                                                        <span>2020-12-10</span>
                                                        <span>撮影者名前</span>
                                                    </p>
                                                    <p class="c-detail--text__other">撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮</p>
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="l-select__wrap l-flex">
                                            <div class="l-select__area">
                                                <div class="c-checkbox--select">
                                                    <input type="checkbox" name="">
                                                    <div class="c-checkbox--color"></div>
                                                </div>
                                            </div>
                                            <div class="l-select__detail l-flex">
                                                <div class="c-detail--img">
                                                    <img src="/img/384597_s.png">
                                                </div>
                                                <div class="c-detail--text">
                                                    <p class="c-detail--text__headline">足場</p>
                                                    <p class="c-detail--text__other">
                                                        <span>2020-12-10</span>
                                                        <span>撮影者名前</span>
                                                    </p>
                                                    <p class="c-detail--text__other">撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮</p>
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="l-button--submit">
                            <input class="c-button--yellowRounded" type="submit" name="" value="PDF用写真を決定する">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>