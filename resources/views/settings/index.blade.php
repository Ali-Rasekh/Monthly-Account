@extends('layout')

@section('title', 'لیست تنظیمات')

@section('content')
    <h2>لیست تنظیمات</h2>

    <a href="{{ route('settings.create') }}" class="btn btn-primary">ایجاد تنظیم جدید</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            {{ $message }}
        </div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>درصد سهامدارها</th>
            <th>درصد شرکا</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($settings as $setting)
            <tr>
                <td>{{ $setting->Shareholder_interest_percentage }}%</td>
                <td>{{ $setting->partners_percentage }}%</td>
                <td>
                    <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-warning">ویرایش</a>
                    <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
