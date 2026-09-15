<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login — KebunKode</title>
    @vite('resources/css/admin.css')
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-header">
            <div class="login-brand">
                <span class="login-brand-mark">&lt;/&gt;</span>
                <span class="login-brand-name">kebun<span>kode</span></span>
            </div>
            <p class="login-subtitle">Panel Administrator</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@kebunkode.com" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password" />
            </div>
            <div class="form-group form-check">
                <label>
                    <input type="checkbox" name="remember" />
                    <span>Ingat saya</span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-full">Masuk</button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}">&larr; Kembali ke website</a>
        </div>
    </div>
</body>
</html>
