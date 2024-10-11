<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نمودار درختی</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        body {
            direction: rtl;
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .tree {
            list-style-type: none;
            padding: 0;
            position: relative;
            max-width: 500px;
            width: 100%;
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

        .tree li.open > ul {
            display: block;
        }

        .tree li ul li {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .tree li ul li:hover {
            background: #b3e5fc;
        }

        .button {
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.3s;
            margin-left: 5px;
        }

        .add-account {
            margin-bottom: 20px;
            padding: 10px 15px;
            font-size: 1.1em;
            background-color: #2196f3; /* رنگ آبی */
            float: right; /* دکمه به سمت راست */
        }

        .add-account:hover {
            background-color: #1976d2; /* رنگ تیره‌تر در هاور */
        }

        .edit-button {
            background-color: #ff9800; /* نارنجی برای دکمه ویرایش */
        }

        .edit-button:hover {
            background-color: #f57c00; /* رنگ تیره‌تر در هاور */
        }

        .delete-button {
            background-color: #f44336;
        }

        .delete-button:hover {
            background-color: #c62828;
        }

        .detail-button {
            background-color: #2196f3;
        }

        .detail-button:hover {
            background-color: #1976d2;
        }

        button {
            background-color: #007bff; /* رنگ آبی */
            color: white; /* رنگ متن سفید */
            border: none;
            border-radius: 5px; /* گوشه‌های گرد */
            padding: 10px 15px; /* فضای داخلی */
            font-size: 1em; /* اندازه فونت */
            cursor: pointer; /* نشانگر دست */
            transition: background 0.3s, transform 0.3s; /* انیمیشن‌ها */
        }

        button:hover {
            background-color: #0056b3; /* رنگ تیره‌تر در هاور */
            transform: scale(1.05); /* بزرگ‌تر شدن در هاور */
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
            transition: color 0.3s;
        }

        .close:hover,
        .close:focus {
            color: black; /* تغییر رنگ در هاور */
        }

        h2 {
            color: #333; /* رنگ عنوان */
            margin-bottom: 20px; /* فاصله از پایین */
        }

        input[type="text"], input[type="number"] {
            width: calc(100% - 30px); /* عرض ورودی */
            padding: 10px; /* فضای داخلی */
            border: 2px solid #007bff; /* حاشیه رنگی */
            border-radius: 5px; /* گوشه‌های گرد */
            font-size: 1em; /* اندازه فونت */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* سایه نرم */
            transition: border 0.3s, box-shadow 0.3s; /* انیمیشن‌ها */
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #0056b3; /* تغییر رنگ حاشیه در فوکوس */
            box-shadow: 0 0 5px rgba(0, 91, 255, 0.5); /* سایه در فوکوس */
        }

        /* modal */
        .side-modal {
            transition: all 0.4s ease-out;
            position: fixed;
            right: 0;
            top: 0;
            width: 0;
            height: 100%;
            background-color: white;
            overflow-x: hidden;
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

        .form-group {
            text-align: right;
        }

        label {
            float: right;
        }

        .btn {
            width: 100%;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
    @stack('styles')
</head>
<body>
<h1>نمودار درختی حساب‌ها</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<button class="button add-account" onclick="openAccountModal('addMainAccountModal')">افزودن حساب معین</button>


<ul class="tree">
    @foreach ($accounts as $account)
        @include('accounts.item', ['account' => $account])
    @endforeach
</ul>

<x-account-modal modal-id="addMainAccountModal" action="{{ route('accounts.store') }}"/>
<x-account-modal modal-id="addChildAccountModal" action="{{ route('accounts.store') }}"/>
<x-account-modal modal-id="editAccountModal" action="{{ route('accounts.update', 0)}}" method="1"/>

<script>

    function openAccountModal(modalId, parentId = null, updateId = null) {
        closeAllModals();
        if (parentId !== null) {
            console.log('Parent ID (Account ID):', parentId);
            document.querySelector(`#${modalId} input[name="parent_id"]`).value = parentId;
        }

        if (updateId !== null) {
            console.log('Update ID:', updateId);
            document.querySelector(`#${modalId} input[name="update_id"]`).value = updateId;
        }


        document.getElementById(modalId).style.width = '340px';
        document.getElementById('name_' + modalId).focus();
    }

    function closeAccountModal(modalId) {
        document.getElementById(modalId).style.width = '0';
    }

    function closeAllModals() {
        let openModals = document.querySelectorAll('.side-modal'); // پیدا کردن همه مدال‌ها
        openModals.forEach(function(modal) {
            modal.style.width = '0'; // بستن هر مدال
        });
    }

    // بستن مدال با کلید Escape
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            // تمامی مدال‌های باز را پیدا کرده و ببندید
            let openModals = document.querySelectorAll('.side-modal[style*="width: 340px"]');
            openModals.forEach(function (modal) {
                modal.style.width = '0';
            });
        }
    });

    document.querySelectorAll('.tree li').forEach(function (li) {
        li.addEventListener('click', function (e) {
            e.stopPropagation();
            li.classList.toggle('open');
        });
    });


</script>
</body>
</html>
