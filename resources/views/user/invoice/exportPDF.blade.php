<!DOCTYPE html>
<html>
<head>
	<title>請求書</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="page">
        <h3>請求書番号: {{ $invoice->number }}</h3>
        <h4>件　名: {{ $invoice->name }}</h4>
        <h4>発行日: {{ $invoice->publish_date }}</h4>
        <h4>お支払い期限: {{ $invoice->limit_date }}</h4>
        <h4>合　計: {{ $invoice->total }}</h4>
        <h4>備　考: <?php echo nl2br($invoice->remark) ?></h4>
        <h4>社内メモ: <?php echo nl2br($invoice->memo) ?></h4>
        <table class="table table-bordered">
            <thead>
                <th>品番・品名</th>
                <th>数量</th>
                <th>単位</th>
                <th>単価</th>
                <th>合計</th>
            </thead>
            <tbody>
                @foreach ($invoice->invoiceItems as $key => $value)
                <tr>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->quantity }}</td>
                    <td>{{ $value->unit }}</td>
                    <td>{{ $value->price }}</td>
                    <td>{{ $value->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
