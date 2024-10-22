<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="http://127.0.0.1:8000/aida.ico" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>محاسبه سود</title>

    <style>
        nav {
            width: 100%;
            background-color: #3a3a3a;
            color: #e0e0e0;
            padding: 5px;
            border-radius: 5px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            color: #f0f0f0;
        }

        nav a {
            color: #f0f0f0;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #f0f0f0;
            color: #2c2c2c;
        }

        body {
            background-color: #2c2c2c;
            font-family: 'Vazir', sans-serif;
            color: #f0f0f0;
        }

        .content {
            max-width: 1500px;
            margin: 20px auto;
        }

        table {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        h5 {
            color: #0056b3;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table th {
            /*color: #f0f0f0;*/
        }

        .monthly-profit-table {
            width: 80%; /* عرض جدول سود ماهانه */
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        .values-table {
            width: 80%;
            max-width: 400px;
        }
    </style>

</head>
<body>
<nav>
    <ul>
        <li>
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('aida.ico') }}" alt="لوگو" style="width: 50px; height: 40px;">
            </a>
        </li>
        <li><a href="{{ route('people.index') }}">مدیریت سرمایه داران</a></li>
        <li><a href="{{ route('accounts.index') }}">مدیریت حساب‌ها</a></li>
        <li><a href="{{ route('transactions.index') }}">گزارش تراکنش ها</a></li>
        <li><a href="{{ route('profits.index') }}">گزارش سودها</a></li>
        <li><a href="{{ route('settings.index') }}">تنظیمات</a></li>
        <li><a href="{{ route('logout') }}">خروج</a></li>
    </ul>
</nav>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="content">
    <!-- جدول سود ماهیانه -->
    <h5 style="color:#f0f0f0;position: relative;top: -20px;left: -400px" >جدول سود ماهیانه</h5>
    <table class="table table-bordered table-striped table-hover monthly-profit-table" style="position: relative;right: -230px;top: -19px">
        <thead class="table-primary">
        <tr>
            <th>ردیف</th>
            <th>نام</th>
            <th>دارایی فعلی</th>
            <th>متعلقات فعلی</th>
            <th>درصد شرکا فعلی</th>
            <th>سود سهام</th>
            <th>سود متعلقات</th>
            <th>سود شراکت</th>
            <th>کل سود</th>
{{--            <th>تاریخ</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($monthlyProfitsShow as $profit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $profit['name'] }}</td>
                <td>{{ number_format($profit['current_wealth']) }} تومان</td>
                <td>{{ number_format($profit['current_belongings']) }} تومان</td>
                <td>{{ $profit['current_participation_percentage'] }}%</td>
                <td>{{ number_format($profit['wealth_profit']) }} تومان</td>
                <td>{{ number_format($profit['belongings_profit']) }} تومان</td>
                <td>{{ number_format($profit['participation_profit']) }} تومان</td>
                <td>{{ number_format($profit['total_profit']) }} تومان</td>
{{--                <td>{{ $profit['jdatetime'] }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- جدول حساب‌ها -->
    <h5 style="color:#f0f0f0;position: relative;right: 1200px;top: -150px">جدول حساب‌ها</h5>
    <table class="table table-bordered table-striped table-hover values-table" style="position: relative;right: 1100px;top: -150px">
        <thead class="table-primary">
        <tr>
            <th>ردیف</th>
            <th>نام حساب</th>
            <th>مقدار</th>
{{--            <th>تاریخ</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($accountValuesShow as $account)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $account['account_name'] }}</td>
                <td>{{ number_format($account['value']) }} تومان</td>
{{--                <td>{{ $account['jdatetime'] }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <!-- فرم برای ارسال داده‌ها -->
        <form method="POST" action="{{ route('dashboard.store') }}">
            @csrf
            <input type="hidden" name="accountValuesTable" value="{{ json_encode($accountValuesTable) }}">
            <input type="hidden" name="monthlyProfitsTable" value="{{ json_encode($monthlyProfitsTable) }}">
            <button type="submit" class="btn btn-primary me-2">ذخیره</button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">بازگشت</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
