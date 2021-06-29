<!DOCTYPE html>
<html>
<head>
	<title>現場報告書</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        table img {max-width: 200px;}
    </style>
</head>
<body>
<div class="container">
    <div class="page">
        <h1>{{ $workReport->title }}</h1>
        @if ($workReport->logo)
            <h2><img src="{{ asset($workReport->logo) }}"></h2>
        @endif
    </div>
    <div class="page">
        <table class="table table-bordered">
            <thead>
                <th>写真</th>
                <th>項目名</th>
                <th>撮影内容</th>
                <th>撮影者名</th>
                <th>備考（共有メモ）</th>
                <th>社内メモ</th>
                <th>日付</th>
            </thead>
            <tbody>
                @foreach ($workReport->workReportItems as $key => $value)
                <tr>
                    <td>
                        @if ($value->photo)
                            <img src="{{ asset($value->photo) }}">
                        @endif
                    </td>
                    <td>{{ $value->name }}</td>
                    <td><?php echo nl2br($value->content); ?></td>
                    <td>{{ $value->photographer }}</td>
                    <td><?php echo nl2br($value->remark); ?></td>
                    <td><?php echo nl2br($value->memo); ?></td>
                    <td>{{ $value->work_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
