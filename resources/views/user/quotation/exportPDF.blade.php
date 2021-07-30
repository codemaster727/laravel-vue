<!DOCTYPE html>
<html>
<head>
	<title>見積書</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link rel="stylesheet" media="all" href="{{ asset('css/styles.css') }}"> --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href='{{ public_path("css/bootstrap-3.3.7-dist/css/bootstrap.min.css")}}'> --}}
    <style>
        /* @import url('https://fonts.googleapis.com/css?family=Roboto'); */
        @font-face{

            font-family: "ipag";

            font-style: normal;

            font-weight: normal;

            src:'{{ asset('ipag.ttf')}}';

        }
        body {
            font-family: 'ipag', Fallback, sans-serif !important;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
                padding: 1.5rem;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }
        .pretable > td:first{
            width: 50%;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .text-right{
            text-align: right;
        }
        .table-bordered tr, .table-bordered th, .table-bordered td{
            border: solid 1px black;
            padding: .5rem;
            height: 1rem;
        }
        .table-bordered th{
            background-color: lightgrey;
        }
        .font-normal{

        }
        .pretable h4 {
            word-spacing: 10rem;
        }
        .mb-1{
            margin-bottom: .5rem;
        }
        .mb-2{
            margin-bottom: 1rem;
        }
        .pb-1{
            padding-bottom: .5rem;
        }
        .pb-2{
            padding-bottom: 1rem;
        }
        .p-1{
            padding: .5rem;
        }
        #watermark {
            position: relative;
            text-align: right;
            margin-top: 3rem;
            height: 3rem;
            background-image: url("data:image/png;base64,{{ $image }}");
            background-repeat: no-repeat;
            background-position: 72% 0%;
            background-size: 3rem;
            padding: .5rem;
        }
        .hr-custom{
            margin-top: -1rem;
            margin-bottom: 2rem;
            width: 77%;
            margin-left: 0;
        }
    </style>
</head>
<body>
    <?php 
        $sum = 0;
        foreach($quotation->quotationItems as $key=>$value){
            if(isset($value->total))
            $sum += $value->total;
        }
    ?>
    <div class="container">
    <div class="text-right mb-2"><?php echo date("Y/m/d");?></div>
    <div class="text-right">見積番号: {{ $quotation->number }}</div>
    <h1 class="text-center" style="padding: 1rem;">見積書</h1>
        <div class="page">
            <table class="pretable">
                <tr>
                    <td><h3>{{ $quotation->client->name }} 様</h3></td>
                    <td><h4>{{ $quotation->bill_company_name }}</h4></td>
                </tr>
                <tr>
                    <td>件　名: {{ $quotation->name }}</td>
                    <td>TEL: {{ $quotation->bill_tel }}</td>
                </tr>
                <tr>
                    <td class="pb-2">有効期限: {{ str_replace("-", "/", $quotation->expiration_date) }}</td>
                    <td>{{ $quotation->bill_email }}</td>
                </tr>
                <tr>
                    <td>
                        下記のとおりお見積申し上げます。
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>お見積金額 ¥{{number_format($sum*1.1)}}</h4>
                        <hr class="hr-custom">
                    </td>
                </tr>
            </table>
            <table class="table table-bordered">
                <thead>
                    <th>品番・品名</th>
                    <th>数量</th>
                    <th>単位</th>
                    <th>単価</th>
                    <th>合計</th>
                </thead>
                <tbody>
                    @foreach ($quotation->quotationItems as $key => $value)
                    <tr class="text-right p-1">
                        <td class="text-left" style="width: 50%;">{{ $value->name }}</td>
                        <td>{{ number_format($value->quantity) }}</td>
                        <td>{{ $value->unit }}</td>
                        <td>{{ number_format($value->price) }}</td>
                        <td>{{ number_format($value->total) }}</td>
                    </tr>
                    @endforeach
                    @for ($i = 0; $i < 9 - count($quotation->quotationItems); $i++)
                    <tr><td></td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                    <tr>
                        <td colspan="2" style="border-left: hidden; border-bottom-color: white"></td>
                        <td colspan="2"><b>小計</b></td>
                        <td class="text-right">¥{{number_format($sum)}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-left-color: white; border-bottom-color: white"></td>
                        <td colspan="2"><b>消費税 (10%)</b></td>
                        <td class="text-right">¥<?php echo number_format($sum/10);?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-left-color: white; border-bottom-color: white"></td>
                        <td colspan="2"><b>合計</b></td>
                        <td class="text-right">¥{{number_format($sum*1.1)}}</td>
                    </tr>
                </tbody>
            </table>
            {{-- <h4>件　名: {{ $quotation->name }}</h4>
            <h4>発行日: {{ $quotation->publish_date }}</h4>
            <h4>有効期限: {{ $quotation->expiration_date }}</h4>
            <h4>合　計: {{ $quotation->total }}</h4>
            <h4>備　考: <?php echo nl2br($quotation->remark) ?></h4>
            <h4>社内メモ: <?php echo nl2br($quotation->memo) ?></h4> --}}
            <?php echo nl2br($quotation->remark) ?>
        </div>
        {{-- <div id="watermark"> --}}
            {{-- <img src="data:image/png;base64,{{ $image }}"/> --}}
            {{-- - 見積書作成サービス --}}
        {{-- </div> --}}
        {{-- {{$quotation}} --}}
    </div>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
</body>
</html>
