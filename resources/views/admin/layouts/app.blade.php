<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#0f1117;color:#e2e8f0;display:flex;min-height:100vh}

        /* SIDEBAR */
        .sidebar{width:260px;background:#1a1d27;border-right:1px solid #2d3248;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100}
        .sidebar-brand{padding:28px 24px;border-bottom:1px solid #2d3248}
        .sidebar-brand h2{font-size:1.1em;font-weight:800;color:#f39c12;display:flex;align-items:center;gap:10px}
        .sidebar-brand p{font-size:0.75em;color:#64748b;margin-top:4px}
        .sidebar-nav{padding:16px 0;flex:1}
        .nav-label{font-size:0.65em;font-weight:700;color:#475569;padding:12px 24px 6px;text-transform:uppercase;letter-spacing:1px}
        .nav-item{display:flex;align-items:center;gap:12px;padding:12px 24px;color:#94a3b8;text-decoration:none;font-weight:600;font-size:0.88em;transition:all 0.2s;border-left:3px solid transparent}
        .nav-item:hover,.nav-item.active{background:rgba(243,156,18,0.08);color:#f39c12;border-left-color:#f39c12}
        .nav-item i{width:18px;text-align:center}
        .badge-new{background:#ef4444;color:white;font-size:0.65em;padding:2px 7px;border-radius:20px;margin-left:auto;font-weight:700}
        .sidebar-footer{padding:20px 24px;border-top:1px solid #2d3248}
        .sidebar-footer form button{width:100%;background:transparent;border:1px solid #374151;color:#94a3b8;padding:10px;border-radius:10px;cursor:pointer;font-family:inherit;font-size:0.85em;display:flex;align-items:center;justify-content:center;gap:8px;transition:0.2s}
        .sidebar-footer form button:hover{background:#7f1d1d;border-color:#ef4444;color:white}

        /* MAIN */
        .main{margin-left:260px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{background:#1a1d27;padding:18px 32px;border-bottom:1px solid #2d3248;display:flex;align-items:center;justify-content:space-between}
        .topbar h1{font-size:1.15em;font-weight:700;color:#f1f5f9}
        .topbar .admin-tag{background:rgba(243,156,18,0.15);color:#f39c12;padding:6px 14px;border-radius:20px;font-size:0.8em;font-weight:700}
        .content{padding:32px;flex:1}

        /* ALERTS */
        .alert{padding:14px 18px;border-radius:12px;margin-bottom:24px;font-weight:600;font-size:0.9em;display:flex;align-items:center;gap:10px}
        .alert-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#4ade80}
        .alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171}

        /* CARDS */
        .stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:32px}
        .stat-card{background:#1a1d27;border:1px solid #2d3248;border-radius:16px;padding:24px;display:flex;flex-direction:column;gap:8px}
        .stat-card .icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2em}
        .stat-card .val{font-size:2em;font-weight:800;color:#f1f5f9}
        .stat-card .lbl{font-size:0.8em;color:#64748b;font-weight:600}

        /* TABLES */
        .card{background:#1a1d27;border:1px solid #2d3248;border-radius:16px;overflow:hidden}
        .card-header{padding:20px 24px;border-bottom:1px solid #2d3248;display:flex;align-items:center;justify-content:space-between}
        .card-header h3{font-size:0.95em;font-weight:700;color:#f1f5f9}
        table{width:100%;border-collapse:collapse}
        th{text-align:left;padding:14px 20px;font-size:0.75em;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;border-bottom:1px solid #2d3248}
        td{padding:14px 20px;font-size:0.88em;color:#cbd5e1;border-bottom:1px solid #1e2235;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:rgba(255,255,255,0.02)}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:10px;font-weight:700;font-size:0.82em;text-decoration:none;cursor:pointer;border:none;font-family:inherit;transition:all 0.2s}
        .btn-primary{background:linear-gradient(135deg,#f39c12,#d35400);color:white}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(243,156,18,0.35)}
        .btn-secondary{background:#1e2235;border:1px solid #374151;color:#94a3b8}
        .btn-secondary:hover{border-color:#94a3b8;color:#f1f5f9}
        .btn-danger{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171}
        .btn-danger:hover{background:#ef4444;color:white;border-color:#ef4444}
        .btn-success{background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.3);color:#4ade80}
        .btn-success:hover{background:#22c55e;color:white;border-color:#22c55e}
        .btn-sm{padding:6px 12px;font-size:0.78em}

        /* FORMS */
        .form-group{margin-bottom:20px}
        label{display:block;font-size:0.82em;font-weight:700;color:#94a3b8;margin-bottom:8px;text-transform:uppercase;letter-spacing:0.5px}
        .form-control{width:100%;background:#0f1117;border:1px solid #2d3248;border-radius:10px;padding:12px 16px;color:#f1f5f9;font-family:inherit;font-size:0.9em;transition:0.2s;outline:none}
        .form-control:focus{border-color:#f39c12;box-shadow:0 0 0 3px rgba(243,156,18,0.15)}
        select.form-control option{background:#1a1d27}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
        .steps-container{display:flex;flex-direction:column;gap:12px}
        .step-row{display:grid;grid-template-columns:100px 1fr auto;gap:12px;align-items:center;background:#0f1117;padding:12px;border-radius:10px;border:1px solid #2d3248}
        .step-row input,.step-row textarea{background:transparent;border:none;outline:none;color:#f1f5f9;font-family:inherit;font-size:0.88em;resize:none}
        .step-row textarea{width:100%}
        .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:0.72em;font-weight:700}
        .badge-orange{background:rgba(243,156,18,0.15);color:#f39c12}
        .badge-blue{background:rgba(59,130,246,0.15);color:#60a5fa}
        .badge-green{background:rgba(34,197,94,0.15);color:#4ade80}
        .badge-gray{background:rgba(100,116,139,0.2);color:#94a3b8}
        .empty-state{text-align:center;padding:60px 20px;color:#475569}
        .empty-state i{font-size:2.5em;margin-bottom:16px;opacity:0.5}

        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .main{margin-left:0}
            .form-row,.form-row-3{grid-template-columns:1fr}
        }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <h2><i class="fas fa-utensils"></i> Rekomendasi Menu</h2>
        <p>Admin Panel</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('admin.resep.index') }}" class="nav-item {{ request()->routeIs('admin.resep.*') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i> Kelola Resep
        </a>
        <a href="{{ route('admin.saran.index') }}" class="nav-item {{ request()->routeIs('admin.saran.*') ? 'active' : '' }}">
            <i class="fas fa-comment-dots"></i> Kotak Saran
            @php $saranBaru = \App\Models\Suggestion::where('status','baru')->count() @endphp
            @if($saranBaru > 0)
                <span class="badge-new">{{ $saranBaru }}</span>
            @endif
        </a>

        <div class="nav-label" style="margin-top:12px">Lainnya</div>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"><i class="fas fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</aside>

{{-- MAIN CONTENT --}}
<main class="main">
    <div class="topbar">
        <h1>@yield('title', 'Dashboard')</h1>
        <span class="admin-tag"><i class="fas fa-shield-halved"></i> Admin: {{ session('admin_name') }}</span>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</main>

</body>
</html>
