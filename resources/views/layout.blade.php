<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- اضافه کردن استایل‌ها -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.fontcdn.ir/Font/Vazir/vazir.css" rel="stylesheet">

    <title>@yield('title')</title>
    @stack('styles')
</head>
<body style="direction:rtl">


<div class="container mt-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- اضافه کردن جاوااسکریپت‌های Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- فایل JavaScript خودتان -->
<script src="{{ asset('js/accounts.js') }}"></script>
@stack('scripts')
<style>
    body {
        background: linear-gradient(135deg, #6e7dff, #b03c9a);
        font-family: 'Vazir', sans-serif;
    }
</style>
</body>
</html>
