@extends('layout')

@section('content')
    <h2>لیست سهام و شرکا</h2>

    <a href="{{ route('setting.create') }}">ایجاد سهام جدید</a>

    @if ($message = Session::get('success'))
        <div>
            {{ $message }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>درصد سهامدارها</th>
            <th>درصد شرکا</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($setting as $stake)
            <tr>
                <td>{{ $stake->percent_shareholders }}%</td>
                <td>{{ $stake->percent_partners }}%</td>
                <td>
                    <a href="{{ route('setting.edit', $stake->id) }}">ویرایش</a>
                    <form action="{{ route('setting.destroy', $stake->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
