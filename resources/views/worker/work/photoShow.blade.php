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
                            <p class="title">作業報告用写真詳細</p>
                        </div>
                        <div class="l-worker--body">
                            <div class="l-worker--body__button">
                                <ul class="l-worker--body__button__list one-button">
                                    <li class="selected"><a href="">画像を追加する</a></li>
                                </ul>
                            </div>
                            <div class="l-worker--body__wrap">
                                <div class="l-worker--body__main">
                                    <div class="l-worker--body__box">
                                        <div class="l-worker--body__box__headline">現場情報詳細</div>
                                        <div class="l-worker--body__main__table">
                                            <table>
                                                <tr>
                                                    <th class="u-w100">項目名</th>
                                                    <td>タイトル</td>
                                                </tr>
                                                <tr>
                                                    <th>撮影者</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>撮影日付</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>撮影内容</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>写真</th>
                                                    <td><img src="/img"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="l-worker--body__box">
                                        <div class="l-worker--body__box__headline">共有情報</div>
                                        <div class="l-worker--body__main__table">
                                            <div class="textarea">
                                                <p class="c-sentence">共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共有情報共共有</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/footer")
</body>
</html>