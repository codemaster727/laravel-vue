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
                            <p class="title">プロフィール</p>
                        </div>
                        <div class="l-worker--body">
                            <div class="l-worker--body__button">
                                <ul class="l-worker--body__button__list one-button">
                                    <li class="selected"><a href="">編集する</a></li>
                                </ul>
                            </div>
                            <div class="l-worker--body__main">
                                <div class="l-worker--body__box">
                                    <div class="l-worker--body__main__table">
                                        <table>
                                            <tr>
                                                <th>ID</th>
                                                <td>00bjvfabd</td>
                                            </tr>
                                            <tr>
                                                <th>名前</th>
                                                <td>中澤　寛</td>
                                            </tr>
                                            <tr>
                                                <th>メールアドレス</th>
                                                <td>chankan77@gmail.com</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="l-worker--body__box">
                                    <div class="l-worker--body__main__table">
                                        <table>
                                            <tr>
                                                <td colspan="2" class="u-text--center"><a href="" class="u-color--blue">運営にお問い合わせ</a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="u-text--center"><a href="" class="u-color--blue">ログアウト</a></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="u-text--center"><a href="" class="u-color--blue">退会</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include("../components/nav-worker")
    @include("../components/footer")
</body>
</html>