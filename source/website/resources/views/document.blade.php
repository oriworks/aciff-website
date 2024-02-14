<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        .page-break {
            page-break-after: always;
        }
        img {
            width: 100%;
        }
    </style>
</head>
<body>
    @foreach ($pages as $page)
        <img src="{{ $page }}">
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
