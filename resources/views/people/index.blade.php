@extends('layout')

@section('title', 'لیست سرمایه داران')

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

    <h2 class="text-center" style="color: #f0f0f0">لیست سرمایه داران</h2>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary " style="color: #f0f0f0" onclick="openSideModal()">افزودن فرد
            جدید
        </button>
    </div>

    <div class="text-end mb-3" style="margin-left: 840px;">
        <button type="button" class="btn btn-primary" onclick="openPartnersModal()">تخصیص درصد
            شرکا
        </button>
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

    <table class="table table-sm table-bordered mt-3"
           style="width: 80%; margin: auto; background-color: #f7f7f7; direction: rtl;">
        <thead style="background-color: #007bff; color: white;">
        <tr style="text-align:center;color: #f0f0f0">
            <th>ردیف</th>
            <th>نام</th>
            <th>موبایل</th>
            <th style="width: 25%;">سرمایه</th>
            <th style="width: 25%;">متعلقات</th>
            <th>عضو شرکا</th>
            <th>درصد مشارکت</th>
            <th>ویرایش</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($people as $person)
            <tr style="text-align:center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $person->name }}</td>
                <td>{{ $person->mobile ?? 'وارد نشده' }}</td>
                <td class="field-with-buttons">
                    <div class="d-inline-block buttons-inline">
                        <button class="btn btn-success btn-sm"
                                onclick="openSideModalAction({{ $person->id }}, 1,'+')">+
                        </button>
                        <button class="btn btn-danger btn-sm"
                                onclick="openSideModalAction({{ $person->id }}, 1,'-')">-
                        </button>
                    </div>
                    {{ number_format($person->wealth) }} تومان
                </td>
                <td class="field-with-buttons">
                    <div class="d-inline-block buttons-inline">
                        <button class="btn btn-success btn-sm"
                                onclick="openSideModalAction({{ $person->id }}, 2,'+')">+
                        </button>
                        <button class="btn btn-danger btn-sm"
                                onclick="openSideModalAction({{ $person->id }}, 2,'-')">-
                        </button>
                    </div>
                    {{ number_format($person->belongings) }} تومان
                </td>
                <td>{{ $person->is_partner ? 'هست' : 'نیست' }}</td>
                <td>{{ $person->percentage_of_participation }}%</td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm"
                            onclick="openEditModal({{ $person->id }}, '{{ $person->name }}', '{{ $person->mobile }}', {{ $person->is_partner }})">
                        ویرایش
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- مدال کشویی برای اضافه یا کم کردن مبلغ -->
    <div id="sideModalAction" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closeSideModalAction()">&times;</span>
            <h3 id="sideModalActionTitle">عملیات</h3>
            <form id="updateAmountForm" action="{{ route('transactions.store') }}" method="POST"
                  onsubmit="return handleSubmit(event, 'sideModalAction')">
                @csrf
                <input type="hidden" id="personId" name="person_id">
                <input type="hidden" id="transaction_type" name="transaction_type"> <!-- نوع تراکنش -->
                <input type="hidden" name="operation" id="operation" value="+">

                <div class="form-group text-right">
                    <label for="transaction_amount">مبلغ:</label>
                    <div class="input-container" style="position: relative; direction: rtl;">
                        <input type="number" class="form-control" id="transaction_amount" name="transaction_amount"
                               required>
                    </div>
                </div>


                <div class="form-group text-right">
                    <label for="description">توضیحات (اختیاری):</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>

    <!-- مدال کشویی برای افزودن فرد جدید -->
    <div id="sideModal" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closeSideModal()">&times;</span>
            <h3>افزودن فرد جدید</h3>
            <form id="createPersonForm" action="{{ route('people.store') }}" method="POST"
                  onsubmit="return handleSubmit(event, 'sideModal')">
                @csrf
                <div class="form-group text-right">
                    <label for="name">نام:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group text-right">
                    <label for="mobile">موبایل (اختیاری):</label>
                    <input type="text" class="form-control" id="mobile" name="mobile">
                </div>

                <div class="form-group text-right">
                    <label for="is_partner">عضو شرکا:</label>
                    <label class="switch">
                        <input type="checkbox" id="is_partner" name="is_partner">
                        <span class="slider round"></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>

    <!-- مدال کشویی برای ویرایش فرد -->
    <div id="editModal" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h3>ویرایش فرد</h3>
            <form id="editPersonForm" action="{{ url('dashboard/people') }}" method="POST"
                  onsubmit="return handleEditSubmit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPersonId" name="person_id">

                <div class="form-group text-right">
                    <label for="editName">نام:</label>
                    <input type="text" class="form-control" id="editName" name="name" required>
                </div>

                <div class="form-group text-right">
                    <label for="editMobile">موبایل (اختیاری):</label>
                    <input type="text" class="form-control" id="editMobile" name="mobile">
                </div>

                <div class="form-group text-right">
                    <label for="editIsPartner">عضو شرکا:</label>
                    <label class="switch">
                        <input type="checkbox" id="editIsPartner" name="is_partner">
                        <span class="slider round"></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">ذخیره</button>
            </form>
        </div>
    </div>


    <!-- مدال کشویی برای تخصیص درصد شرکا -->
    <div id="partnersModal" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closePartnersModal()">&times;</span>
            <h3 style="color: #f0f0f0">تخصیص درصد شرکا</h3>
            <form id="partnersForm" action="{{ route('setPartnersPercentage') }}" method="POST"
                  onsubmit="return handlePartnersSubmit(event)">
                @csrf

                @foreach($partners as $partner)
                    <div class="form-group text-right">
                        <label for="partner_{{ $partner->id }}">{{ $partner->name }}</label>
                        <input type="number" class="form-control" id="partner_{{ $partner->id }}"
                               name="partner[{{ $partner->id }}]" required>
                    </div>
                @endforeach

                <div class="form-group text-right">
                    <label for="total">جمع درصدها:</label>
                    <input type="number" class="form-control" id="total" name="total" readonly>
                </div>

                <button type="submit" class="btn btn-primary">ذخیره</button>
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
            background-color: #3a3a3a;
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

        /* تنظیم دکمه‌ها برای چسبیدن به سمت چپ */
        .field-with-buttons {
            position: relative;
            text-align: center;
        }

        .buttons-inline {
            display: inline-flex;
            position: absolute;
            left: 0;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        /* راست‌چین کردن فرم‌ها */
        .form-group {
            text-align: center;
        }

        label {
            float: right;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        /* مخفی کردن چک‌باکس */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* طراحی اسلایدر */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 2.5px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        /* وقتی چک‌باکس فعال باشد */
        input:checked + .slider {
            background-color: #2c2c2c;
        }

        /* تغییر مکان دایره هنگام فعال شدن */
        input:checked + .slider:before {
            transform: translateX(24px);
        }
    </style>

    <script>
        function openPartnersModal() {
            closeEditModal()
            closeSideModal();
            closeSideModalAction();
            document.getElementById('partnersModal').style.width = '300px';

            const firstPartnerInput = document.getElementById('partner_{{ $partners[0]['id'] }}');
            if (firstPartnerInput) {
                firstPartnerInput.focus();
            }
            // Reset total input
            updateTotal();
        }

        function closePartnersModal() {
            document.getElementById('partnersModal').style.width = '0';
        }

        function updateTotal() {
            const inputs = document.querySelectorAll('[name^="partner"]');
            let total = 0;

            inputs.forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('total').value = total;
        }

        // Add event listeners to partner inputs to update total on input
        document.querySelectorAll('[name^="partner"]').forEach(input => {
            input.addEventListener('input', updateTotal);
        });

        function handlePartnersSubmit(event) {
            const total = parseFloat(document.getElementById('total').value);
            if (total !== 100) {
                alert('جمع درصدها باید برابر با 100 باشد.');
                event.preventDefault();
                return false;
            }

            // ارسال فرم
            event.preventDefault();
            event.target.submit();
            closePartnersModal();
        }


        // تابع برای باز کردن مدال کشویی
        function openSideModal() {
            closeEditModal()
            closePartnersModal()
            closeSideModalAction()
            document.getElementById('sideModal').style.width = '300px';
            document.getElementById('name').focus(); // تمرکز روی فیلد نام
        }

        function closeSideModal() {
            document.getElementById('sideModal').style.width = '0';
        }

        function openSideModalAction(personId, field, operation) {
            closePartnersModal()
            closeSideModal();
            closeEditModal();

            document.getElementById('personId').value = personId;
            document.getElementById('transaction_type').value = field;
            document.getElementById('sideModalAction').style.width = '300px';

            // Focus on the transaction amount input
            document.getElementById('transaction_amount').focus();
            document.getElementById('operation').value = operation;

            // تنظیم عنوان بر اساس operation و field
            if (operation === '-' && field === 1) {
                document.getElementById('sideModalActionTitle').innerHTML = 'کاهش سرمایه';
            }
            if (operation === '-' && field === 2) {
                document.getElementById('sideModalActionTitle').innerHTML = 'کاهش متعلقات';
            }
            if (operation === '+' && field === 1) {
                document.getElementById('sideModalActionTitle').innerHTML = 'افزایش سرمایه';
            }
            if (operation === '+' && field === 2) {
                document.getElementById('sideModalActionTitle').innerHTML = 'افزایش متعلقات';
            }

        }


        // تابع برای بسته شدن مدال عملیات
        function closeSideModalAction() {
            document.getElementById('sideModalAction').style.width = '0';
        }

        // تابع برای ویرایش
        function openEditModal(personId, name, mobile, isPartner) {
            closeSideModal()
            closeSideModalAction()
            closePartnersModal()
            document.getElementById('editModal').style.width = '300px';
            document.getElementById('editPersonId').value = personId;
            document.getElementById('editName').value = name;
            document.getElementById('editMobile').value = mobile;
            document.getElementById('editIsPartner').checked = isPartner === 1; // اگر isPartner برابر با 1 باشد
            document.getElementById('editPersonForm').action = `/dashboard/people/${personId}`; // تغییر آدرس روت
            document.getElementById('editName').focus()
        }

        function closeEditModal() {
            document.getElementById('editModal').style.width = '0';
        }

        function handleSubmit(event, modalId) {
            event.preventDefault();
            // ارسال فرم
            event.target.submit();
            // بستن مدال
            document.getElementById(modalId).style.width = '0';
        }

        function handleEditSubmit(event) {
            event.preventDefault();
            // ارسال فرم ویرایش
            event.target.submit();
            // بستن مدال
            document.getElementById('editModal').style.width = '0';
        }


        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAllModals();
            }
        });

        function closeAllModals() {
            closeSideModal();
            closeSideModalAction();
            closeEditModal();
            closePartnersModal();
        }

    </script>
@endsection
