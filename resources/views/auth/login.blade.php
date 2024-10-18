<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6e7dff, #b03c9a);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* برای استفاده از position:absolute در پیغام‌ها */
        }

        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .btn-primary {
            background-color: #ff416c;
            border-color: #ff416c;
            border-radius: 50px;
            padding: 10px 0;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ff4b2b;
            border-color: #ff4b2b;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            font-size: 14px;
            background-color: #f5f5f5;
            border: none;
            transition: background-color 0.3s ease;
        }

        .form-control:focus {
            background-color: #e0e0e0;
            border-color: #ff416c;
            box-shadow: none;
        }

        .alert {
            position: absolute; /* موقعیت ثابت برای پیغام‌ها */
            left: 50%; /* مرکزیت افقی */
            transform: translateX(-50%); /* جابجایی برای مرکزیت */
            width: 300px; /* عرض پیغام */
            z-index: 1000; /* در بالای سایر عناصر */
        }

        .text-danger {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">
        {{ $message }}
    </div>
@endif

@if ($message = Session::get('failed'))
    <div class="alert alert-danger mt-2" style="top: 130px">
        {{ $message }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" style="top: 100px">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <h3>Login</h3>
    <form method="POST" action="{{ route('check-it') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>
</div>

</body>
</html>
