<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title></title>
    <meta name="description" content="">

    <!-- OGPタグ/twitterカード -->
    <meta property="og:url" content="ページのURL" />
    <meta property="og:title" content="ページのタイトル" />
    <meta property="og:type" content="ページのタイプ">
    <meta property="og:description" content="記事の抜粋" />
    <meta property="og:image" content="画像のURL" />
    <meta name="twitter:card" content="カード種類" />
    <meta name="twitter:site" content="@Twitterユーザー名" />
    <meta property="og:site_name" content="サイト名" />
    <meta property="og:locale" content="ja_JP" />
    <meta property="fb:app_id" content="appIDを入力" />
    {{-- <link rel="shortcut icon" href="/public/img/favicon.ico" type="image/x-icon" /> --}}
    <!-- スマホ用アイコン画像 -->
    {{-- <link rel="apple-touch-icon-precomposed" href="/public/img/favicon.png" /> --}}

    <!-- Windows用タイル設定 -->
    <meta name="msapplication-TileImage" content="画像のURL" />
    <meta name="msapplication-TileColor" content="カラーコード（例：#F89174）"/>

    <!-- フィードページの指定 -->
    <link rel="alternate" type="application/rss+xml" title="フィード" href="フィードページのURL" />
    <link rel="stylesheet" media="all" href="/css/styles.css">
    <link rel="stylesheet" media="all" href="/css/foundation/single/calendar.css">
    <link rel="stylesheet" media="all" href="/css/foundation/single/calendar.css">
    <link rel="stylesheet" media="all" href="/css/gantt/style.css">
    <link rel="stylesheet" media="all" href="/css/gantt/reset.css">

</head>
<body id="calendar">
    <div class="sp-only">
        @include("../components/nav")
    </div>
    <div id="app">
        <div class="pc-only">
            <user-process-pc-component></user-process-pc-component>
        </div>
        <div class="sp-only">
            <user-process-sp-component></user-process-sp-component>
        </div>
    </div>
    @include("../components/footer")
</body>
</html>
