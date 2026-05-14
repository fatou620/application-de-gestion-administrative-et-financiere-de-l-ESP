<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $titlePage ?? 'ESP — Plateforme' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --green:#00853F; --green2:#005f2d; --yellow:#FDEF42; --red:#E31E24;
    --sidebar:#0f2234; --bg:#f0f4f8; --card:#fff; --text:#1a1a2e;
    --muted:#6b7280; --border:#e5e7eb; --radius:14px; --sidebar-w:260px;
  }
  body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }
  a { color:inherit; text-decoration:none; } button { font-family:inherit; }

  .sidebar {
    width:var(--sidebar-w); background:var(--sidebar); min-height:100vh;
    position:fixed; top:0; left:0; display:flex; flex-direction:column;
    z-index:100; transition:transform .3s;
  }
  .sidebar-header { padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,.07); }
  .logo { display:flex; align-items:center; gap:12px; }
  .logo-icon {
    width:42px; height:42px;
    background:linear-gradient(135deg, var(--green), #005f2d);
    border-radius:10px; display:flex; align-items:center; justify-content:center;
  }
  .logo-icon i { color:#fff; font-size:18px; }
  .logo-text h2 { color:#fff; font-size:16px; font-weight:700; }
  .logo-text p { color:rgba(255,255,255,.45); font-size:11px; }

  .sidebar-user {
    padding:18px 24px; border-bottom:1px solid rgba(255,255,255,.07);
    display:flex; align-items:center; gap:12px;
  }
  .avatar {
    width:40px; height:40px;
    background:linear-gradient(135deg, var(--green), var(--yellow));
    border-radius:50%; display:flex; align-items:center; justify-content:center;
    font-weight:700; color:#fff; font-size:15px; flex-shrink:0; overflow:hidden;
  }
  .avatar img { width:100%; height:100%; object-fit:cover; }
  .user-info .name { color:#fff; font-size:13px; font-weight:600; }
  .user-info .num  { color:rgba(255,255,255,.4); font-size:11px; }

  .sidebar-nav { flex:1; padding:16px 12px; overflow-y:auto; }
  .nav-section { margin-bottom:24px; }
  .nav-label {
    color:rgba(255,255,255,.3); font-size:10px; font-weight:700;
    letter-spacing:1.2px; text-transform:uppercase; padding:0 12px 8px;
  }
  .nav-link {
    display:flex; align-items:center; gap:12px;
    padding:11px 12px; border-radius:10px;
    color:rgba(255,255,255,.6); font-size:14px; font-weight:500;
    transition:all .2s; margin-bottom:2px;
  }
  .nav-link i { width:18px; text-align:center; font-size:15px; }
  .nav-link:hover { background:rgba(255,255,255,.07); color:#fff; }
  .nav-link.active { background:rgba(0,133,63,.25); color:#fff; }
  .nav-link.active i { color:var(--yellow); }

  .sidebar-footer { padding:16px 12px; border-top:1px solid rgba(255,255,255,.07); }
  .btn-logout {
    display:flex; align-items:center; gap:10px;
    width:100%; padding:11px 12px; border-radius:10px;
    background:rgba(227,30,36,.15); color:#ff6b6b;
    font-size:14px; font-weight:500; border:none; cursor:pointer;
    transition:background .2s;
  }
  .btn-logout:hover { background:rgba(227,30,36,.3); }

  .main {
    margin-left:var(--sidebar-w); flex:1;
    display:flex; flex-direction:column; min-height:100vh;
  }
  .topbar {
    background:var(--card); border-bottom:1px solid var(--border);
    padding:0 28px; height:64px;
    display:flex; align-items:center; justify-content:space-between;
    position:sticky; top:0; z-index:50;
  }
  .topbar-left h1 { font-size:18px; font-weight:700; }
  .topbar-left p { font-size:12px; color:var(--muted); }
  .topbar-right { display:flex; align-items:center; gap:12px; }
  .notif-btn {
    width:38px; height:38px; border:1.5px solid var(--border); border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; background:none; color:var(--muted);
    transition:all .2s; position:relative;
  }
  .notif-btn:hover { border-color:var(--green); color:var(--green); }
  .badge {
    position:absolute; top:-4px; right:-4px;
    width:16px; height:16px; background:var(--red); color:#fff;
    font-size:9px; font-weight:700; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
  }
  .hamburger { display:none; border:none; background:none; font-size:20px; cursor:pointer; }
  .overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:99; }

  .content { padding:28px; flex:1; }

  /* Cards & stats */
  .stats-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:18px; margin-bottom:28px;
  }
  .stat-card {
    background:var(--card); border-radius:var(--radius); padding:22px 20px;
    border:1px solid var(--border); display:flex; gap:16px; align-items:center;
    transition:transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
  .stat-icon {
    width:50px; height:50px; border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-size:20px; flex-shrink:0;
  }
  .stat-icon.green  { background:rgba(0,133,63,.12);  color:var(--green); }
  .stat-icon.blue   { background:rgba(59,130,246,.12); color:#3b82f6; }
  .stat-icon.orange { background:rgba(249,115,22,.12); color:#f97316; }
  .stat-icon.purple { background:rgba(139,92,246,.12); color:#8b5cf6; }
  .stat-icon.red    { background:rgba(227,30,36,.12);  color:var(--red); }
  .stat-value { font-size:26px; font-weight:800; line-height:1; }
  .stat-label { font-size:12px; color:var(--muted); margin-top:4px; }

  .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
  .grid-3 { display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:20px; }
  .card {
    background:var(--card); border-radius:var(--radius);
    border:1px solid var(--border); overflow:hidden;
  }
  .card-head {
    padding:18px 22px 14px; border-bottom:1px solid var(--border);
    display:flex; align-items:center; justify-content:space-between;
  }
  .card-head h3 { font-size:15px; font-weight:700; display:flex; align-items:center; gap:8px; }
  .card-head h3 i { color:var(--green); font-size:14px; }
  .card-body-inner { padding:18px 22px; }
  .see-all { font-size:12px; color:var(--green); font-weight:600; }
  .see-all:hover { text-decoration:underline; }

  .alert { padding:12px 18px; border-radius:10px; font-size:13.5px; margin-bottom:20px; display:flex; align-items:center; gap:10px; }
  .alert-success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
  .alert-error   { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }

  table { width:100%; border-collapse:collapse; }
  thead th {
    background:#f8fafc; padding:12px 18px; text-align:left;
    font-size:12px; font-weight:700; color:var(--muted);
    text-transform:uppercase; letter-spacing:.5px;
    border-bottom:1px solid var(--border);
  }
  tbody td { padding:14px 18px; border-bottom:1px solid var(--border); font-size:14px; }
  tbody tr:last-child td { border-bottom:none; }
  tbody tr:hover { background:#f9fafb; }

  .btn {
    display:inline-flex; align-items:center; gap:6px;
    padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600;
    border:none; cursor:pointer; transition:all .15s;
  }
  .btn-green { background:var(--green); color:#fff; }
  .btn-green:hover { background:var(--green2); }
  .btn-red { background:var(--red); color:#fff; }
  .btn-red:hover { background:#b91c1c; }
  .btn-outline { background:#fff; border:1.5px solid var(--border); color:var(--text); }
  .btn-outline:hover { border-color:var(--green); color:var(--green); }
  .btn-blue { background:#3b82f6; color:#fff; }

  .badge-status {
    display:inline-flex; align-items:center; gap:5px;
    padding:3px 10px; border-radius:20px;
    font-size:11px; font-weight:600;
  }
  .badge-valide, .badge-validee { background:#f0fdf4; color:var(--green); }
  .badge-en_attente, .badge-attente, .badge-nouveau, .badge-en_cours { background:#fffbeb; color:#92400e; }
  .badge-rejete, .badge-rejetee, .badge-incomplet { background:#fef2f2; color:var(--red); }

  .empty { text-align:center; padding:30px; color:var(--muted); font-size:13px; }
  .empty i { font-size:30px; display:block; margin-bottom:8px; opacity:.4; }

  /* Form basics */
  .form-group { margin-bottom:16px; }
  .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; }
  .iw { position:relative; display:flex; align-items:center; }
  .iw i { position:absolute; left:14px; color:var(--muted); font-size:14px; }
  .iw input, .iw select, .iw textarea {
    width:100%; padding:11px 14px 11px 40px;
    border:1.5px solid var(--border); border-radius:10px;
    font-size:14px; font-family:inherit; background:#f9fafb; color:var(--text);
  }
  .iw textarea { padding-left:14px; padding-top:11px; resize:vertical; min-height:80px; }
  .iw input:focus, .iw select:focus, .iw textarea:focus {
    outline:none; border-color:var(--green); background:#fff;
  }

  @media (max-width:1100px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
  @media (max-width:900px)  { .grid-2, .grid-3 { grid-template-columns:1fr; } }
  @media (max-width:768px) {
    .sidebar { transform:translateX(-100%); }
    .sidebar.open { transform:translateX(0); }
    .main { margin-left:0; }
    .hamburger { display:block; }
    .overlay.show { display:block; }
    .content { padding:18px; }
    .stats-grid { grid-template-columns:1fr 1fr; }
  }
  @media (max-width:480px) { .stats-grid { grid-template-columns:1fr; } }
</style>
@stack('styles')
</head>
<body>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <div class="logo">
      <div class="logo-icon"><i class="fas fa-graduation-cap"></i></div>
      <div class="logo-text">
        <h2>ESP Plateforme</h2>
        <p>{{ $espaceLabel ?? 'Espace utilisateur' }}</p>
      </div>
    </div>
  </div>

  @auth
    <div class="sidebar-user">
      <div class="avatar">
        @if (auth()->user()->photo)
          <img src="{{ asset('storage/'.auth()->user()->photo) }}" alt="">
        @else
          {{ strtoupper(substr(auth()->user()->prenom,0,1).substr(auth()->user()->nom,0,1)) }}
        @endif
      </div>
      <div class="user-info">
        <div class="name">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</div>
        <div class="num">
          @if(auth()->user()->etudiant)
            {{ auth()->user()->etudiant->numero_etudiant }}
          @else
            {{ ucfirst(str_replace('_',' ', auth()->user()->role?->nom ?? '—')) }}
          @endif
        </div>
      </div>
    </div>
  @endauth

  <nav class="sidebar-nav">
    @yield('nav')
  </nav>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="btn-logout">
        <i class="fas fa-sign-out-alt"></i> Déconnexion
      </button>
    </form>
  </div>
</aside>

<div class="main">
  <header class="topbar">
    <div class="topbar-left">
      <button class="hamburger" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
      <h1>@yield('page_title', $titlePage ?? 'Page')</h1>
      <p>@yield('page_sub', \Carbon\Carbon::now()->translatedFormat('l d F Y'))</p>
    </div>
    <div class="topbar-right">
      @yield('topbar_extra')
    </div>
  </header>

  <div class="content">
    @if (session('success'))
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="list-style:none">
          @foreach ($errors->all() as $e)<li>• {{ $e }}</li>@endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </div>
</div>

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('overlay').classList.toggle('show');
}
</script>
@stack('scripts')
</body>
</html>
