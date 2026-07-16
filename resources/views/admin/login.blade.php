<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Rekomendasi Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#0f1117;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .login-card{background:#1a1d27;border:1px solid #2d3248;border-radius:24px;padding:48px 40px;width:100%;max-width:420px;box-shadow:0 30px 60px rgba(0,0,0,0.5)}
        .login-icon{width:64px;height:64px;background:linear-gradient(135deg,#f39c12,#d35400);border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.6em;color:white;margin:0 auto 24px}
        h1{text-align:center;font-size:1.5em;color:#f1f5f9;margin-bottom:4px;font-weight:800}
        .subtitle{text-align:center;color:#64748b;font-size:0.85em;margin-bottom:32px}
        .form-group{margin-bottom:18px}
        label{display:block;font-size:0.78em;font-weight:700;color:#94a3b8;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#475569;font-size:0.9em}
        input{width:100%;background:#0f1117;border:1px solid #2d3248;border-radius:12px;padding:13px 16px 13px 42px;color:#f1f5f9;font-family:inherit;font-size:0.9em;outline:none;transition:0.2s}
        input:focus{border-color:#f39c12;box-shadow:0 0 0 3px rgba(243,156,18,0.15)}
        .btn-login{width:100%;background:linear-gradient(135deg,#f39c12,#d35400);color:white;border:none;border-radius:12px;padding:14px;font-size:0.95em;font-weight:700;cursor:pointer;font-family:inherit;margin-top:8px;transition:0.2s;display:flex;align-items:center;justify-content:center;gap:10px}
        .btn-login:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(243,156,18,0.35)}
        .alert{padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:0.85em;font-weight:600;display:flex;align-items:center;gap:8px}
        .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171}
        .alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#4ade80}
        .back-link{display:block;text-align:center;margin-top:20px;color:#475569;font-size:0.8em;text-decoration:none}
        .back-link:hover{color:#94a3b8}
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon"><i class="fas fa-lock"></i></div>
        <h1>Admin Login</h1>
        <p class="subtitle">Masuk untuk mengelola resep & saran</p>

        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrap">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username admin" required autocomplete="username">
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrap">
                    <i class="fas fa-key"></i>
                    <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-right-to-bracket"></i> Masuk ke Panel Admin
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke website</a>
    </div>
</body>
</html>
