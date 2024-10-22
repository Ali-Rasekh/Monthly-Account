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
            background-color: #3a3a3a;
            color: #e0e0e0;
            padding: 5px; /* کاهش ارتفاع نوار */
            border-radius: 5px;
            /*margin-bottom: 20px;*/
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            color: #f0f0f0
        }

        nav a {
            color: #f0f0f0;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #f0f0f0; /* سفید کم‌رنگ */
            color: #2c2c2c;
            /*text-decoration: underline; !* زیر خط لینک‌ها هنگام هاور *!*/
        }

        body {
            background-color: #2c2c2c; /* یک رنگ خاکستری تیره */
            font-family: 'Vazir', sans-serif;
            color: #f0f0f0; /* برای خوانایی متن روی پس‌زمینه تیره */
        }

        .content {
            max-width: 1000px;
            margin: 20px auto; /* وسط‌چین کردن محتوا */
        }

        table {
            margin-bottom: 20px;
            background-color: #fff; /* رنگ پس‌زمینه جداول */
            border-radius: 10px; /* گوشه‌های گرد */
            overflow: hidden; /* جلوگیری از نمایش بیرون زدگی */
        }

        h5 {
            color: #0056b3; /* رنگ عنوان‌ها */
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
            vertical-align: middle; /* تنظیم عمودی متن داخل سلول‌ها */
        }
    </style>

</head>
<body>
<nav>
    <ul>
        <li><a href="{{ route('people.index') }}">مدیریت سرمایه داران</a></li>
        <li><a href="{{ route('accounts.index') }}">مدیریت حساب‌ها</a></li>
        <li><a href="{{ route('transactions.index') }}">گزارش تراکنش ها</a></li>
        <li><a href="{{ route('profits.index') }}">گزارش سودها</a></li>
        <li><a href="{{ route('settings.index') }}">تنظیمات</a></li>
        <li><a href="{{ route('logout') }}">خروج</a></li>
        <li>
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('aida.ico') }}" alt="لوگو" style="width: 50px; height: 40px;">
            </a>
        </li>
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
    <h5>جدول سود ماهیانه</h5>
    <table class="table table-bordered table-striped table-hover">
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
            <th>تاریخ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($monthlyProfitsShow as $profit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $profit['name'] }}</td>
                <td>{{ $profit['current_wealth'] }}</td>
                <td>{{ $profit['current_belongings'] }}</td>
                <td>{{ $profit['current_participation_percentage'] }}</td>
                <td>{{ $profit['wealth_profit'] }}</td>
                <td>{{ $profit['belongings_profit'] }}</td>
                <td>{{ $profit['participation_profit'] }}</td>
                <td>{{ $profit['total_profit'] }}</td>
                <td>{{ $profit['jdatetime'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- جدول حساب‌ها -->
    <h5>جدول حساب‌ها</h5>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-success">
        <tr>
            <th>ردیف</th>
            <th>نام حساب</th>
            <th>مقدار</th>
            <th>تاریخ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($accountValuesShow as $account)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $account['account_name'] }}</td>
                <td>{{ $account['value'] }}</td>
                <td>{{ $account['jdatetime'] }}</td>
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
