
    <!doctype html>
    <html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Vue.js app</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

        <link rel="stylesheet" href="{{mix('css/app.css')}}">

        <!-- Styles -->
        <style>
            html, body {
                padding: 45px;
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
    {{--<div class="flex-center position-ref full-height">--}}

    <div id="app">
        <main>
            <div class="l-worker">
                <div class="l-worker--wrap">
                    <div class="l-worker--inner">
                        <div class="l-worker--header">
                            <p class="title">現場進捗状況</p>
                        </div>
                        <div class="l-worker--body">
                            <div class="l-worker--body__tab l-wrap--tab">
                                <ul class="l-wrap--tab__list tab-three">
                                    <li :class="{'selected': panelActive === '1'}"><a @click.prevent="changePanel('1')">詳細情報</a></li>
                                    <li :class="{'selected': panelActive === '2'}"><a @click.prevent="changePanel('2')">現場報告写真</a></li>
                                    <li :class="{'selected': panelActive === '3'}"><a @click.prevent="changePanel('3')">ダウンロード</a></li>
                                </ul>
                            </div>
                            <div class="l-worker--body__wrap" v-if="panelActive === '1'">
                                <div class="l-worker--body__main">
                                    <div class="l-worker--body__box">
                                        <div class="l-worker--body__main__table">
                                            <table>
                                                <tr>
                                                    <td style="white-space: nowrap;"></td>
                                                    <td style="white-space: nowrap;"></td>
                                                    <td class="u-color--grayNavy u-textSize--small">開始時間</td>
                                                    <td class="u-color--grayNavy u-textSize--small">終了時間</td>
                                                </tr>
                                                <tr>
                                                    <td class="u-color--grayNavy u-textSize--small">2月8日</td>
                                                    <td class="u-text--right">佐藤　吉次<br>田中　田中</td>
                                                    <td>14:00<br>15:00</td>
                                                    <td>16:00<br>17:00</td>
                                                </tr>
                                                <tr>
                                                    <td class="u-color--grayNavy u-textSize--small">2月8日</th>
                                                    <td class="u-text--right">佐藤　吉次<br>田中　田中</td>
                                                    <td>14:00<br>15:00</td>
                                                    <td>16:00<br>17:00</td>
                                                </tr>
                                                <tr>
                                                    <td class="u-color--grayNavy u-textSize--small">2月8日</th>
                                                    <td class="u-text--right">佐藤　吉次<br>田中　田中</td>
                                                    <td>14:00<br>15:00</td>
                                                    <td>16:00<br>17:00</td>
                                                </tr>
                                                <tr>
                                                    <td class="u-color--grayNavy u-textSize--small">2月8日</th>
                                                    <td class="u-text--right">佐藤　吉次<br>田中　田中</td>
                                                    <td>14:00<br>15:00</td>
                                                    <td>16:00<br>17:00</td>
                                                </tr>
                                                <tr>
                                                    <td class="u-color--grayNavy u-textSize--small">2月8日</th>
                                                    <td class="u-text--right">佐藤　吉次<br>田中　田中</td>
                                                    <td>14:00<br>15:00</td>
                                                    <td>16:00<br>17:00</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-worker--body__wrap" v-else-if="panelActive === '2'">
                                <div class="l-worker--body__main">
                                    <div class="l-worker--body__box">
                                        <div class="l-worker--body__main__detail">
                                            <div class="l-worker--body__main__detail__table">
                                                <?php for($i = 1; $i < 3; $i++) : ?>
                                                    <div class="l-worker--body__main__detail__tr">
                                                        <div class="tr-inner">
                                                            <div class="u-w70">
                                                                <div class="img">
                                                                    <img src="/img/384597_s.png">
                                                                </div>
                                                            </div>
                                                            <div class="u-wflex1">
                                                                <p class="c-text--main">足場</p>
                                                                <p class="c-text--sub">2020-12-10 / 撮影者名前</p>
                                                                <p class="c-text--sub">撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮影内容撮</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="l-worker--body__wrap" v-else-if="panelActive === '3'">
                                <div class="l-worker--body">
                                    <div class="l-worker--body__main">
                                        <div class="l-worker--body__box">
                                            <div class="l-worker--body__main__list">
                                                <div class="l-worker--body__main__list__box">
                                                    <a href="" class="u-color--blue">「見積書」をダウンロード</a>
                                                </div>
                                                <div class="l-worker--body__main__list__box">
                                                    <a href="" class="u-color--blue">「請求書」をダウンロード</a>
                                                </div>
                                                <div class="l-worker--body__main__list__box">
                                                    <a href="" class="u-color--blue">「診断報告書」をダウンロード</a>
                                                </div>
                                                <div class="l-worker--body__main__list__box">
                                                    <a href="" class="u-color--blue">「作業報告書」をダウンロード</a>
                                                </div>
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
