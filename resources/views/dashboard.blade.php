@include('components.accounts_table', ['accounts' => $accounts])
    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="http://127.0.0.1:8000/aida.ico" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>داشبورد</title>
    <style>


        table {
            position: relative;
            top: 26px;
            width: 55%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* سایه برای زیبایی */
            border-radius: 8px; /* گوشه‌های گرد */
            overflow: hidden; /* برای گرد شدن حاشیه‌ها */
        }

        th, td {
            padding: 12px 15px; /* افزایش پدینگ برای نمایش بهتر محتوا */
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff; /* رنگ آبی برای هدر */
            color: white; /* رنگ سفید برای متن هدر */
            text-transform: uppercase; /* حروف بزرگ برای متن */
            font-weight: bold; /* ضخیم کردن متن هدر */
            letter-spacing: 1px; /* فاصله بین حروف */
        }

        td {
            background-color: #f2f2f2; /* رنگ خاکستری برای سلول‌های داده */
            color: #333; /* رنگ تیره‌تر برای متن */
        }

        tr:nth-child(even) td {
            background-color: #e0e0e0; /* رنگ متفاوت برای سطرهای زوج */
        }

        tr:hover td {
            background-color: #ddd; /* تغییر رنگ سطر هنگام هاور */
        }

        .table-container {
            display: flex;
            justify-content: flex-start;
            margin-top: -648px;
            margin-left: 100px;
        }

        body {
            background-color: #2c2c2c; /* یک رنگ خاکستری تیره */
            font-family: 'Vazir', sans-serif;
            color: #f0f0f0; /* برای خوانایی متن روی پس‌زمینه تیره */
        }

        .percentages {
            margin-top: -125px; /* فاصله کمتر از جدول */
            padding: 5px 10px; /* پدینگ کمتر از بالا و پایین، و کمی بیشتر از چپ و راست */
            background-color: #007bff; /* پس‌زمینه سفید */
            border: 1px solid #ddd; /* حاشیه خاکستری */
            border-radius: 8px; /* گوشه‌های گرد */
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* سایه کمتر */
            text-align: center; /* مرکز چین کردن متن */
            max-width: 300px; /* حداکثر عرض */
            margin-left: 500px; /* خودکار برای راست چین کردن */
            margin-right: auto; /* خودکار برای راست چین کردن */
        }

        .percentage-item {
            margin: 3px 0; /* فاصله کمتر بین درصدها */
            font-size: 16px; /* اندازه متن کمتر */
            color: #fff; /* رنگ متن */
        }
    </style>
</head>
<body>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-container">
    <table>
        <thead>
        <tr>
            <th>ردیف</th>
            <th>نام</th>
            <th>درصد از متعلقات</th>
            <th>درصد مشارکت</th>
            <th>درصد از سرمایه</th>
            <th>سرمایه</th>
            {{--            <th>متعلقات</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach ($people as $person)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $person['name'] }}</td>
                <td>{{ $person['percent_of_belongings'] }}%</td>
                <td>{{ $person['percentage_of_participation'] }}%</td>
                <td>{{ $person['percent_of_wealth'] }}%</td>
                <td>{{ number_format($person['wealth']) }} تومان</td>
                {{--                <td>{{ $person['belongings'] }}</td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Percentages Section -->
<div class="percentages" style="position: relative;top: 35px; right: -10px">
    <div class="percentage-item">
        درصد سهامدارها: {{ $info['Shareholder_interest_percentage'] }}%
    </div>
    <div class="percentage-item">
        درصد شرکا: {{ $info['partners_percentage'] }}%
    </div>
    <div class="percentage-item">
        مجموع سرمایه: {{ number_format($info['total_wealth']) }}
    </div>
    <div class="percentage-item">
        مجموع متعلقات: {{ number_format($info['total_belongings']) }}
    </div>
    <div class="percentage-item">
        کل سرمایه: {{ number_format($info['total_capital']) }}
    </div>
</div>

</body>
</html>
