@extends('layout')

@section('title', 'لیست تراکنش‌ها')

@section('content')
    <h2 class="text-center">لیست تراکنش‌ها</h2>

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
        <thead style="background-color: #007bff; color: white;">
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
                style="background-color: {{ $transaction->transaction_amount < 0 ? '#f8d7da' : '#d4edda' }};">
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
