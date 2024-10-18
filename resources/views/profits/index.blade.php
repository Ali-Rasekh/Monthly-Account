@extends('layout')

@section('title', ' گزارش سودها')

@section('content')

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

    <style>
        body {
            background: linear-gradient(135deg, #6e7dff, #b03c9a);
            font-family: 'Vazir', sans-serif;
        }
    </style>
@endsection

