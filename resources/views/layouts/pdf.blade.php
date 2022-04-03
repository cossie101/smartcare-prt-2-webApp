<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
</head>
<body  >

        <div style="width: 100%; text-align: center; top: 0;">
            <h5>Smart Care</h5>
        </div>

        <div style="width: 100%; margin-top: -15px; text-align: center; float: left; ">
            <h6 style="margin-top: 0; letter-spacing: 4px;">{{ $title }} Report</h6>
        </div>

        <div style="margin-top: -23px; margin-left: 10px; width: 100%; float: right;">
            <h6>Period: {{ $period }}</h6>
        </div>

        <hr style="width: 100%; margin-top: 30px;">
            
        <main class="" >
            @yield('content')
        </main>
    </div>
</body>
</html>
