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
            padding: 5px;
            border-radius: 5px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            color: white;
        }

        nav a {
            color: white;
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
            background-color: #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }

        h5 {
            color: #f0f0f0;
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

        .left-table {
            margin-left: auto;
        }

        .monthly-profit-table {
            width: 100%; /* عرض جدول سود ماهانه را به 80% تنظیم می‌کند */
            max-width: 1100px; /* حداکثر عرض 1000 پیکسل */
        }

        .values-table {
            width: 80%; /* عرض جدول سود ماهانه را به 80% تنظیم می‌کند */
            max-width: 400px;
        }

        .dropdown-container {
            position: relative;
            top: 60px;
            right: 10px;
        }

        .dropdown-select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
            appearance: none;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        /* هنگام هاور کردن (حرکت ماوس) */
        .dropdown-select:hover {
            border-color: #888;
            background-color: #f1f1f1;
        }

        /* هنگام فوکوس (انتخاب شدن) */
        .dropdown-select:focus {
            border-color: #555;
            box-shadow: 0 0 5px rgba(85, 85, 85, 0.2);
        }

        /* استایل دادن به گزینه‌های select */
        .dropdown-select option {
            padding: 10px;
            font-size: 14px;
        }

        /* استایل کلی برای فرم */
        form {
            display: inline-block; /* برای جلوگیری از تغییر مکان */
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

<div>

    <div class="dropdown-container" >
        <form action="{{ route('profits.index') }}" method="GET">
            <select name="date" class="dropdown-select" onchange="this.form.submit()">
                @foreach($allDateTimes as $key => $date)
                    <option value="{{ $key }}" {{ request('date') == $key ? 'selected' : '' }}>{{ $date }}</option>
                @endforeach
            </select>
        </form>
    </div>


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



    <!-- استفاده از سیستم گرید بوت‌استرپ برای نمایش جداول کنار هم -->
    <div class="row">
        <!-- جدول حساب‌ها (چپ) -->
        <div class="col-md-5 left-table" style="position: relative;bottom: 20px;right: 1200px">
            <h5 style="position: relative;right: 130px">جدول حساب‌ها</h5>
            <table class="table table-bordered table-striped table-hover values-table">
                <thead class="table-primary">
                <tr>
                    <th>ردیف</th>
                    <th>نام حساب</th>
                    <th>مقدار</th>
                    {{--                    <th>تاریخ</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($accountValues as $account)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $account['account_name'] }}</td>
                        <td>{{ $account['value'] }} تومان</td>
                        {{--                        <td>{{ $account['jdatetime'] }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- جدول سود ماهیانه (راست) -->
        <div class="col-md-7" style=";position: relative;bottom: 20px;right: -420px">
            <h5 style="text-align: center">جدول سود ماهیانه</h5>
            <table class="table table-bordered table-striped table-hover monthly-profit-table">
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
                    {{--                    <th>تاریخ</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($monthlyProfits as $profit)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profit['person_name'] }}</td>
                        <td>{{ number_format($profit['current_wealth']) }} تومان</td>
                        <td>{{ number_format($profit['current_belongings']) }} تومان</td>
                        <td>{{ $profit['current_participation_percentage'] }}%</td>
                        <td>{{ number_format($profit['wealth_profit']) }} تومان</td>
                        <td>{{ number_format($profit['belongings_profit']) }} تومان</td>
                        <td>{{ number_format($profit['participation_profit']) }} تومان</td>
                        <td>{{ number_format($profit['total_profit']) }} تومان</td>
                        {{--                        <td>{{ $profit['jdatetime'] }}</td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function redirectToRoute(selectElement) {
        const selectedValue = selectElement.value;

        if (selectedValue) {
            // ساخت آدرس URL و ارسال پارامتر
            const url = `{{ route('profits.store') }}?datetime=${selectedValue}`;
            window.location.href = url; // هدایت به URL
        }
    }
</script>
</body>
</html>
