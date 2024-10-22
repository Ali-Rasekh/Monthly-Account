@extends('layout')

@section('title', 'لیست تراکنش‌ها')

@section('content')
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
    </style>

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
    <h2 class="text-center" style="color: #f0f0f0">لیست تراکنش‌ها</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-bordered table-striped" style="width: 80%; margin: auto; direction: rtl;">
        <thead style="background-color: #007bff; color: #f0f0f0;">
        <tr class="text-center">
            <th>ردیف</th>
            <th>نام فرد</th>
            <th>نوع تراکنش</th>
            <th>مبلغ تراکنش</th>
            <th>توضیحات</th>
            <th>تاریخ تراکنش</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $transaction)
            <tr class="text-center"
                style="background-color: {{ $transaction->transaction_amount < 0 ? '#f5b5b8' : '#a9dfb6' }};">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaction->person_name }}</td>
                <td>{{ $transaction->transaction_type }}</td>
                <td>{{ number_format($transaction->transaction_amount) }} تومان</td>
                <td>{{ $transaction->description ?? 'ندارد' }}</td>
                <td>{{ $transaction->jdatetime }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
