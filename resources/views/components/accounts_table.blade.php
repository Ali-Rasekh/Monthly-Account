<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            direction: rtl;
            font-family: Vazir, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-height: 100vh;
        }

        /* کانتینری برای راست چین کردن لیست */
        .container {
            display: flex;
            justify-content: flex-end; /* انتقال به سمت راست */
            width: 100%;
        }

        .tree {
            list-style-type: none;
            padding: 0;
            position: relative;
            width: 500px; /* پهنای لیست */
        }

        .tree li {
            margin: 10px 0;
            position: relative;
            padding: 8px 12px;
            background: #bbdefb;
            border-radius: 4px;
            color: #2196f3;
            transition: background 0.3s;
            cursor: pointer;
        }

        .tree li:hover {
            background: #2196f3;
            color: white;
        }

        .tree ul {
            padding-right: 20px;
            padding-left: 0;
            display: block;
        }

        .tree li ul li {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .tree li ul li:hover {
            background: #b3e5fc;
        }

        input[type="number"] {
            width: 30%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-left: 15px;
            text-align: left;
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        label {
            font-weight: bold;
            color: white;
            background-color: #0d47a1;
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.85em;
            margin-left: 15px;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #007bff; /* رنگ پیش‌فرض */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            width: 200px;
            height: 50px;
            margin-top: auto;
            margin-left: -220px;
            align-self: flex-end;
            transition: all 0.3s ease; /* ایجاد انیمیشن برای تغییرات */
        }

        button:hover {
            background-color: #0056b3; /* تغییر رنگ پس‌زمینه هنگام هاور */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* ایجاد سایه برای دکمه */
            transform: scale(1.05); /* کمی بزرگ‌تر شدن دکمه هنگام هاور */
        }

        /* استایل ورودی تاریخ */
        input[type="text"] {
            position: relative;
            top: -110px;
            width: 100px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /*margin-top: -150px;*/
            text-align: center;
        }

        nav {
            width: 100%;
            position: relative;
            top: -30px;
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
            color: #f0f0f0;
        }

        nav a {
            color: #f0f0f0;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #f0f0f0; /* سفید کم‌رنگ */
            color: #2c2c2c;
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


<div class="container">
    <ul class="tree">
        @foreach ($accounts as $account)
            <li>
                <div style="display: flex; align-items: center;">
                    <span style="flex-grow: 1;">{{ $account['name'] }}</span>
                    @if (!empty($account['children']))
                        <!-- اگر اکانت فرزند داشته باشد، یک لیبل نمایش داده می‌شود -->
                        <label id="total_{{ $account['id'] }}">
                            جمع: 0
                        </label>
                    @else
                        <!-- اگر اکانت فرزند نداشته باشد، یک اینپوت نمایش داده می‌شود -->
                        <input type="number" name="{{ $account['id'] }}" placeholder="0" required>
                    @endif
                </div>

                @if (!empty($account['children']))
                    <ul>
                        @foreach ($account['children'] as $child)
                            <li>
                                <div style="display: flex; align-items: center;">
                                    <span style="flex-grow: 1;">{{ $child['name'] }}</span>
                                    <input type="number" name="{{ $child['id'] }}"
                                           placeholder="0" required
                                           oninput="updateTotal({{ $account['id'] }})"
                                           data-parent-id="{{ $account['id'] }}">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<form id="calculateForm" action="{{ route('calculate') }}" method="POST">
    @csrf
    <label for="dateInput" style="width:50px;margin-right: 800px;position: relative;top: -110px;left: -33px ">تاریخ:</label>
    <input type="text" id="dateInput" name="date" value="{{ $today }} " required style="position: relative;left: -33px" >
    <input type="hidden" name="shareholder_interest_percentage" value="{{ $info['Shareholder_interest_percentage'] }}">
    <input type="hidden" name="partners_percentage" value="{{ $info['partners_percentage'] }}">
    <input type="hidden" name="total_wealth" value="{{ $info['total_wealth'] }}">
    <input type="hidden" name="total_belongings" value="{{ $info['total_belongings'] }}">
    <input type="hidden" name="total_capital" value="{{ $info['total_capital'] }}">
    <!-- ورودی تاریخ شمسی با مقدار پیش‌فرض -->
</form>


<!-- نمایش پیغام خطا در صورت نامعتبر بودن تاریخ -->
<p id="error-message" style="color:red; display:none;">فرمت تاریخ باید به شکل YYYY/MM/DD باشد.</p>

<div class="button-container" style="margin-right: 800px;margin-top: -105px">
    <button type="button" onclick="submitForm()"  style="position: relative;left: -33px">محاسبه</button>
</div>

<script>
    // به روز رسانی جمع کل برای حساب‌های دارای زیرشاخه
    function updateTotal(accountId) {
        const inputs = document.querySelectorAll(`input[data-parent-id='${accountId}']`);
        let total = 0;

        inputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });

        document.getElementById(`total_${accountId}`).textContent = `جمع: ${total}`;
    }

    // ارسال فرم همراه با مقادیر ورودی حساب‌ها
    function submitForm() {
        const form = document.getElementById('calculateForm');
        const inputs = document.querySelectorAll('input[type="number"]');
        const accountValues = {};  // شیء برای ذخیره مقادیر حساب‌ها

        inputs.forEach(input => {
            const accountId = input.name;  // آیدی حساب
            const accountValue = input.value || 0;  // مقدار حساب (در صورت خالی بودن، null می‌گذاریم)
            accountValues[accountId] = accountValue;  // ذخیره مقادیر در شیء

            // ایجاد فیلد مخفی برای ارسال مقادیر به سرور
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `accounts[${accountId}]`;  // کلید به فرمت "accounts[ID]"
            hiddenInput.value = accountValue;
            form.appendChild(hiddenInput);
        });

        const dateInput = document.getElementById('dateInput').value;
        const errorMessage = document.getElementById('error-message');

        // ارسال فرم به سرور
        form.submit();
    }

    document.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // جلوگیری از عملکرد پیش‌فرض (مثل ارسال فرم توسط مرورگر)
            submitForm(); // فراخوانی تابع ارسال فرم
        }
    });
</script>

</body>

</html>
