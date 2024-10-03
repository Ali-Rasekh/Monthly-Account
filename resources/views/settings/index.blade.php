@extends('layout')

@section('title', 'لیست تنظیمات')

@section('content')
    <h2 class="text-center">لیست تنظیمات</h2> <!-- وسط‌چین کردن عنوان -->

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary" onclick="openCreateModal()">تغییر درصد سود بین شرکا و سهامداران
        </button>
        <!-- دکمه باز کردن مدال -->
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2 text-center"> <!-- وسط‌چین کردن پیام موفقیت -->
            {{ $message }}
        </div>
    @endif

    <table class="table table-sm table-bordered mt-3" style="width: 50%; margin: auto; background-color: #f7f7f7;">
        <!-- تغییر رنگ پس زمینه جدول -->
        <thead style="background-color: #007bff; color: white;"> <!-- رنگ پس زمینه و متن هدر -->
        <tr>
            <th style="width: 33%;">درصد سهامدارها</th>
            <th style="width: 33%;">درصد شرکا</th>
            <th style="width: 33%;">تاریخ و زمان</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($settings as $setting)
            <tr>
                <td>{{ $setting->Shareholder_interest_percentage }}%</td>
                <td>{{ $setting->partners_percentage }}%</td>
                <td>{{ $setting->jdatetime }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- مدال Bootstrap -->
    <div class="modal fade" id="createSettingModal" tabindex="-1" aria-labelledby="createSettingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSettingModalLabel">ایجاد تنظیمات جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSettingForm" action="{{ route('settings.store') }}" method="POST"
                          onsubmit="return validateCreateForm();">
                        @csrf

                        <div class="form-group">
                            <label for="partners_percentage">درصد شرکا:</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="partners_percentage"
                                       name="partners_percentage" required step="0.01" min="0" max="100"
                                       oninput="updateShareholderPercentage()" style="max-width: 70px;">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="Shareholder_interest_percentage">درصد سهامدارها:</label>
                            <input type="text" class="form-control" id="Shareholder_interest_percentage"
                                   name="Shareholder_interest_percentage" readonly style="max-width: 70px;">
                        </div>

                        <p id="modal-error-message" class="error-message" style="display:none;">جمع درصدها باید دقیقا
                            100 باشد!</p>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // تابع برای باز کردن مدال
        function openCreateModal() {
            document.getElementById('partners_percentage').value = ''; // پاک کردن فیلد
            document.getElementById('Shareholder_interest_percentage').value = ''; // پاک کردن فیلد
            document.getElementById('modal-error-message').style.display = 'none'; // پنهان کردن پیام خطا
            $('#createSettingModal').modal('show'); // نمایش مدال

            // فوکوس روی فیلد درصد شرکا
            setTimeout(() => {
                document.getElementById('partners_percentage').focus();
            }, 500);
        }

        // به‌روزرسانی درصد سهامدار
        function updateShareholderPercentage() {
            const partnersPercentage = parseFloat(document.getElementById('partners_percentage').value) || 0;
            const shareholderPercentage = 100 - partnersPercentage;
            document.getElementById('Shareholder_interest_percentage').value = Math.max(0, shareholderPercentage).toFixed(2); // درصد منفی نمی‌شود و فرمت float با دو رقم اعشار
        }

        // اعتبارسنجی فرم
        function validateCreateForm() {
            const partnersPercentage = parseFloat(document.getElementById('partners_percentage').value) || 0;
            const shareholderPercentage = parseFloat(document.getElementById('Shareholder_interest_percentage').value) || 0;

            if ((partnersPercentage + shareholderPercentage) !== 100) {
                document.getElementById('modal-error-message').style.display = 'block';
                return false;
            }

            document.getElementById('modal-error-message').style.display = 'none';
            return true; // فرم به درستی اعتبارسنجی شده و ارسال می‌شود
        }
    </script>

    <style>
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

        /* حذف فلش‌های بالا و پایین در input[type=number] */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* برای مرورگر فایرفاکس */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* تنظیم CSS برای هم‌ترازی متن‌ها و تغییر رنگ جدول */
        .table td, .table th {
            text-align: center; /* هم‌ترازی وسط محتویات سلول‌ها */
        }

        .table tbody tr:nth-child(odd) {
            background-color: #e9ecef; /* رنگ پس زمینه ردیف‌های فرد */
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa; /* رنگ پس زمینه ردیف‌های زوج */
        }
    </style>
@endsection
