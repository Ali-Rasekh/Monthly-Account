@extends('layout')

@section('title', 'ایجاد تنظیمات جدید')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="form-container">
            <h2 class="text-center">ایجاد تنظیمات جدید</h2>
            <p class="text-center"><strong>جمع درصدها باید 100 شود.</strong></p>

            <!-- فرم اصلی -->
            <form action="javascript:void(0);" onsubmit="return openModal();">
                @csrf
                <div class="form-group" style="max-width: 300px;">
                    <label for="Shareholder_interest_percentage">درصد سهامدارها</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="Shareholder_interest_percentage" name="Shareholder_interest_percentage" required step="0.01" placeholder="{{ $lastSettings['Shareholder_interest_percentage'] }}" style="max-width: 70px;">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="max-width: 300px;">
                    <label for="partners_percentage">درصد شرکا</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="partners_percentage" name="partners_percentage" required step="0.01" placeholder="{{ $lastSettings['partners_percentage'] }}" style="max-width: 70px;">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <!-- پیام خطا -->
                <p id="error-message" class="error-message" style="display:none;">جمع درصدها باید دقیقا 100 باشد!</p>

                <button type="submit" class="btn btn-primary">تعیین درصد شرکا و ذخیره</button>
            </form>
        </div>
    </div>

    <!-- مودال Bootstrap -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalLabel">تعیین درصد برای شرکا</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- افزودن فرم برای ارسال به روت settings.store -->
                    <form id="modalForm" action="{{ route('settings.store') }}" method="POST" onsubmit="return validateModalForm();">
                        @csrf
                        <input type="hidden" id="hidden_shareholders" name="Shareholder_interest_percentage">
                        <input type="hidden" id="hidden_partners" name="partners_percentage">

                        <div id="namesList">
                            <!-- اینجا لیست اسامی و اینپوت‌ها نمایش داده می‌شود -->
                            @foreach ($people as $person)
                                <div class="form-group" style="max-width: 300px;">
                                    <label for="each_partner_percent_{{ $person['id'] }}">{{ $person['name'] }}</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control modal-percent" id="each_partner_percent_{{ $person['id'] }}" name="each_partner_percent[{{ $person['id'] }}]" required step="0.01" placeholder="{{ $person['percentage_of_participation'] }}" style="max-width: 70px;">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- پیام خطا -->
                        <p id="modal-error-message" class="error-message" style="display:none;">جمع درصدها باید دقیقا 100 باشد!</p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">لغو</button>
                            <button type="submit" id="saveModalButton" class="btn btn-primary">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- اسکریپت برای مدیریت مودال و کلید Enter و Focus -->
    <script>
        // باز کردن مودال و افزودن فیلدهای اسامی
        function openModal() {
            var percentShareholders = parseFloat(document.getElementById('Shareholder_interest_percentage').value);
            var percentPartners = parseFloat(document.getElementById('partners_percentage').value);

            if ((percentShareholders + percentPartners) !== 100) {
                document.getElementById('error-message').style.display = 'block';
                return false;
            }

            document.getElementById('error-message').style.display = 'none';

            // تنظیم درصدها در فیلدهای hidden در مودال
            document.getElementById('hidden_shareholders').value = percentShareholders;
            document.getElementById('hidden_partners').value = percentPartners;

            $('#resultModal').modal('show');

            // فوکوس روی اولین اینپوت داخل مودال
            setTimeout(() => {
                document.querySelector('#namesList input').focus();
            }, 500);
        }

        // بررسی درصدها در مودال
        function validateModalForm() {
            var total = 0;
            document.querySelectorAll('.modal-percent').forEach(function(input) {
                total += parseFloat(input.value) || 0;
            });

            if (total !== 100) {
                document.getElementById('modal-error-message').style.display = 'block';
                return false;
            }

            document.getElementById('modal-error-message').style.display = 'none';
            return true; // ارسال فرم به روت settings.store
        }

        // مدیریت کلید Enter در مودال
        document.getElementById('resultModal').addEventListener('keydown', function(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // جلوگیری از بسته شدن مودال
                document.getElementById('saveModalButton').click(); // شبیه‌سازی کلیک دکمه ذخیره
            }
        });

        // فوکوس روی اولین اینپوت فرم اصلی هنگام بارگذاری صفحه
        window.onload = function() {
            document.getElementById('Shareholder_interest_percentage').focus();
        };
    </script>

    <!-- استایل برای حذف فلش‌ها از input[type=number] -->
    <style>
        /* برای Webkit-based مرورگرها مانند Chrome و Safari */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* برای Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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


    </style>
@endsection
