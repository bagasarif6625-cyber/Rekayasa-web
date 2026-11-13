<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#173b58">
    <title>Login Admin — Sistem Informasi</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <style>
        :root { color-scheme: light; }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px 16px;
            font-family: Arial, Helvetica, sans-serif;
            background:
                linear-gradient(115deg, rgba(9, 34, 49, .30), rgba(8, 30, 47, .48)),
                url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=2200&q=85') center 48% / cover fixed,
                #173b58;
        }
        .login-card {
            width: min(100%, 332px);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.55);
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 18px 55px rgba(8, 22, 34, .3);
        }
        .login-brand {
            padding: 10px 16px;
            background: #ffc400;
            color: #202020;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .035em;
        }
        .login-body { padding: 18px 20px 20px; }
        .login-title { margin: 0 0 18px; text-align: center; font-size: 18px; font-weight: 600; color: #30343a; }
        .form-label { margin-bottom: 6px; color: #41464b; font-size: 13px; }
        .form-control { min-height: 38px; font-size: 14px; border-color: #d8dee5; }
        .form-control:focus { border-color: #86b7fe; box-shadow: 0 0 0 .2rem rgba(13,110,253,.2); }
        .remember-label { color: #42474c; font-size: 13px; }
        .btn-login { min-height: 38px; background: #1672ed; border-color: #1672ed; font-size: 14px; }
        .btn-login:hover { background: #0d63d4; border-color: #0d63d4; }
        @media (max-width: 480px) { body { background-attachment: scroll; } }
    </style>
</head>
<body>
    <main class="login-card" aria-labelledby="login-title">
        <div class="login-brand">SISTEM INFORMASI</div>
        <div class="login-body">
            <h1 id="login-title" class="login-title">Login Admin</h1>
            @if ($errors->any())
                <div class="alert alert-danger py-2 small" role="alert">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" autocomplete="current-password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
                    <label class="form-check-label remember-label" for="remember">Ingat saya</label>
                </div>
                <button class="btn btn-primary btn-login w-100" type="submit">Login</button>
            </form>
        </div>
    </main>
</body>
</html>
