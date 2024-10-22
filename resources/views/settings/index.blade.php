@extends('layout')

@section('title', ' تنظیمات')

@section('content')

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

    <h2 class="text-center"> تنظیمات</h2>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary" style="color: #f0f0f0" onclick="openSideModal()">تغییر درصد سود بین شرکا و سهامداران</button>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2 text-center">
            {{ $message }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-sm table-bordered mt-3" style="width: 50%; margin: auto; background-color: #f7f7f7; direction: rtl;">
        <thead style="background-color: #007bff; color: #f0f0f0;">
        <tr>
            <th style="width: 33%;">درصد شرکا</th>
            <th style="width: 33%;">درصد سهامداران</th>
            <th style="width: 33%;">تاریخ و زمان</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($settings as $setting)
            <tr>
                <td>{{ $setting->partners_percentage }}%</td>
                <td>{{ $setting->Shareholder_interest_percentage }}%</td>
                <td>{{ $setting->jdatetime }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- مدال کشویی برای افزودن تنظیم جدید -->
    <div id="sideModal" class="side-modal" style="background-color:#2c2c2c ">
        <div class="side-modal-content">
            <span class="close" onclick="closeSideModal()">&times;</span>
            <h3 style="color: #f0f0f0">ایجاد تنظیم جدید</h3>
            <form id="createSettingForm" action="{{ route('settings.store') }}" method="POST" onsubmit="return validateCreateForm();">
                @csrf
                <div class="form-group text-right">
                    <label for="partners_percentage">درصد شرکا:</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="partners_percentage" name="partners_percentage" required step="0.01" min="0" max="100" oninput="updateShareholderPercentage()" style="max-width: 70px;">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <label for="Shareholder_interest_percentage">درصد سهامداران:</label>
                    <input type="text" class="form-control" id="Shareholder_interest_percentage" name="Shareholder_interest_percentage" readonly style="max-width: 70px;">
                </div>

                <p id="modal-error-message" class="error-message" style="display:none;">جمع درصدها باید دقیقا 100 باشد!</p>

                <button type="submit" class="btn btn-primary" style="position: relative;left: 80px;width: 100px">ذخیره</button>
            </form>
        </div>
    </div>

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
            color: #f0f0f0;
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

        /* استایل برای مدال کشویی */
        .side-modal {
            position: fixed;
            right: 0;
            top: 0;
            width: 0;
            height: 100%;
            background-color: white;
            overflow-x: hidden;
            transition: 0.5s;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .side-modal-content {
            padding: 20px;
            width: 300px;
        }

        .close {
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .side-modal input {
            margin-bottom: 15px;
        }

        /* راست‌چین کردن فرم‌ها */
        .form-group {
            text-align: right;
        }

        label {
            float: right;
        }

        /* استایل پیام خطا */
        .error-message {
            border: 2px solid red;
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }

        /* تنظیم دکمه‌ها برای چسبیدن به سمت چپ */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* برای مرورگر فایرفاکس */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        function openSideModal() {
            document.getElementById('sideModal').style.width = '300px';
            document.getElementById('partners_percentage').focus();
        }

        function closeSideModal() {
            document.getElementById('sideModal').style.width = '0';
        }

        function updateShareholderPercentage() {
            const partnersPercentage = parseFloat(document.getElementById('partners_percentage').value) || 0;
            const shareholderPercentage = 100 - partnersPercentage;
            document.getElementById('Shareholder_interest_percentage').value = Math.max(0, shareholderPercentage).toFixed(2);
        }

        function validateCreateForm() {
            const partnersPercentage = parseFloat(document.getElementById('partners_percentage').value) || 0;
            const shareholderPercentage = parseFloat(document.getElementById('Shareholder_interest_percentage').value) || 0;

            if ((partnersPercentage + shareholderPercentage) !== 100) {
                document.getElementById('modal-error-message').style.display = 'block';
                return false;
            }

            document.getElementById('modal-error-message').style.display = 'none';
            return true;
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSideModal();
            }
        });
    </script>
@endsection
