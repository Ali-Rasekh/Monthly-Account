@extends('layout')

@section('title', 'لیست تنظیمات')

@section('content')
    <h2 class="text-center">لیست تنظیمات</h2>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary" onclick="openSideModal()">تغییر درصد سود بین شرکا و سهامداران</button>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2 text-center">
            {{ $message }}
        </div>
    @endif

    <table class="table table-sm table-bordered mt-3" style="width: 50%; margin: auto; background-color: #f7f7f7; direction: rtl;">
        <thead style="background-color: #007bff; color: white;">
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
    <div id="sideModal" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closeSideModal()">&times;</span>
            <h3>ایجاد تنظیم جدید</h3>
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

                <button type="submit" class="btn btn-success">ذخیره</button>
            </form>
        </div>
    </div>

    <style>
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
    </script>
@endsection
