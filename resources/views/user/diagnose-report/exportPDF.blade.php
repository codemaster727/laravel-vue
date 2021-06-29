<!DOCTYPE html>
<html>
<head>
	<title>診断報告書</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page">
        <h1>{{ $diagnoseReport->title }}</h1>
        @if ($diagnoseReport->logo)
            <h2><img src="{{ asset($diagnoseReport->logo) }}"></h2>
        @endif
    </div>
    <div class="page">
        <table class="table table-bordered">
            <thead>
                <th>写真</th>
                <th>項目名</th>
                <th>撮影内容</th>
            </thead>
            <tbody>
                @foreach ($diagnoseReport->diagnoseReportItems as $key => $value)
                <tr>
                    <td>
                        @if ($value->photo)
                            <img src="{{ asset($value->photo) }}">
                        @endif
                    </td>
                    <td>{{ $value->name }}</td>
                    <td><?php echo nl2br($value->content); ?></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
