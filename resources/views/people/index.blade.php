@extends('layout')

@section('title', 'لیست افراد')

@section('content')
    <h2 class="text-center">لیست افراد</h2>

    <div class="text-center mb-3">
        <button type="button" class="btn btn-primary" onclick="openSideModal()">افزودن فرد جدید</button>
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

    <table class="table table-sm table-bordered mt-3"
           style="width: 80%; margin: auto; background-color: #f7f7f7; direction: rtl;">
        <thead style="background-color: #007bff; color: white;">
        <tr style="text-align:center">
            <th>آیدی</th>
            <th>نام</th>
            <th>موبایل</th>
            <th style="width: 20%;">سرمایه</th>
            <th style="width: 20%;">متعلقات</th>
            <th>درصد مشارکت</th>
            <th>عضو شرکا</th>
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
                    {{ number_format($person->wealth) }}
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
                    {{ $person->belongings }}
                </td>
                <td>{{ $person->percentage_of_participation }}%</td>
                <td>{{ $person->is_partner ? 'هست' : 'نیست' }}</td>
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

                <button type="submit" class="btn btn-success">ذخیره</button>
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

                <button type="submit" class="btn btn-success">ذخیره</button>
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

                <button type="submit" class="btn btn-success">ذخیره</button>
            </form>
        </div>
    </div>


    <!-- مدال کشویی برای تخصیص درصد شرکا -->
    <div id="partnersModal" class="side-modal">
        <div class="side-modal-content">
            <span class="close" onclick="closePartnersModal()">&times;</span>
            <h3>تخصیص درصد شرکا</h3>
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

                <button type="submit" class="btn btn-success">ذخیره</button>
            </form>
        </div>
    </div>

    <style>

        /* تغییر موقعیت نماد منفی */
        .input-prefix::before {
            content: '-'; /* محتوا */
            font-size: 24px; /* اندازه بزرگتر */
            color: red; /* رنگ */
            position: absolute;
            right: 10px; /* فاصله از سمت راست */
            top: 30%; /* موقعیت پایین‌تر */
            transform: translateY(-50%); /* مرکز کردن عمودی */
            pointer-events: none; /* جلوگیری از کلیک بر روی نماد */
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
    </style>

    <script>
        function openPartnersModal() {
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
