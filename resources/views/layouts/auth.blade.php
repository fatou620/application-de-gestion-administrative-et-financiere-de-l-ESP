<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ESP — Plateforme Numérique</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --green:#00853F; --yellow:#FDEF42; --red:#E31E24; --dark:#0D1B2A;
    --text:#1a1a2e; --muted:#6b7280; --border:#e5e7eb; --input-bg:#f9fafb;
    --shadow:0 20px 60px rgba(0,0,0,.12); --radius:16px;
  }
  body {
    font-family:'Inter',sans-serif; background:var(--dark); min-height:100vh;
    display:flex; align-items:center; justify-content:center;
    padding:40px 20px; position:relative; overflow-x:hidden; overflow-y:auto;
  }
  body::before {
    content:''; position:fixed; inset:0;
    background:
      radial-gradient(ellipse at 20% 50%, rgba(0,133,63,.25) 0%, transparent 60%),
      radial-gradient(ellipse at 80% 20%, rgba(227,30,36,.15) 0%, transparent 50%),
      radial-gradient(ellipse at 60% 80%, rgba(253,239,66,.10) 0%, transparent 50%);
    animation:bgPulse 8s ease-in-out infinite alternate;
    pointer-events:none;
  }
  @keyframes bgPulse { from{opacity:.7} to{opacity:1} }
  .auth-card {
    background:rgba(255,255,255,.97); backdrop-filter:blur(20px);
    border-radius:var(--radius); box-shadow:var(--shadow);
    width:100%; max-width:480px; overflow:hidden; position:relative; z-index:10;
    animation:slideUp .5s ease;
  }
  @keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
  .card-header {
    background:linear-gradient(135deg, var(--green) 0%, #005f2d 100%);
    padding:32px 40px 28px; text-align:center; position:relative;
  }
  .card-header::after {
    content:''; position:absolute; bottom:-1px; left:0; right:0; height:4px;
    background:linear-gradient(90deg, var(--green), var(--yellow), var(--red));
  }
  .logo-circle {
    width:72px; height:72px; background:rgba(255,255,255,.15); border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 14px; border:2px solid rgba(255,255,255,.3);
  }
  .logo-circle i { font-size:30px; color:#fff; }
  .card-header h1 { color:#fff; font-size:22px; font-weight:700; }
  .card-header p { color:rgba(255,255,255,.75); font-size:13px; margin-top:4px; }
  .tab-bar { display:flex; border-bottom:1px solid var(--border); background:#f8fafc; }
  .tab-btn {
    flex:1; padding:14px; border:none; background:transparent;
    font-size:14px; font-weight:600; color:var(--muted); cursor:pointer;
    font-family:inherit; text-decoration:none; text-align:center;
    transition:all .25s; position:relative;
  }
  .tab-btn.active { color:var(--green); background:#fff; }
  .tab-btn.active::after {
    content:''; position:absolute; bottom:0; left:0; right:0; height:2px; background:var(--green);
  }
  .card-body { padding:32px 40px 36px; }
  .alert {
    padding:12px 16px; border-radius:10px; font-size:13.5px;
    margin-bottom:20px; display:flex; align-items:center; gap:10px;
  }
  .alert-error   { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
  .alert-success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
  .form-row { display:grid; gap:16px; }
  .form-row.cols-2 { grid-template-columns:1fr 1fr; }
  .form-group { display:flex; flex-direction:column; gap:6px; }
  .form-group label { font-size:13px; font-weight:600; color:var(--text); }
  .input-wrap { position:relative; display:flex; align-items:center; }
  .input-wrap i {
    position:absolute; left:14px; color:var(--muted);
    font-size:15px; pointer-events:none;
  }
  .input-wrap input {
    width:100%; padding:11px 14px 11px 42px; border:1.5px solid var(--border);
    border-radius:10px; font-size:14px; font-family:inherit;
    background:var(--input-bg); color:var(--text);
    transition:border-color .2s, box-shadow .2s;
  }
  .input-wrap input:focus {
    outline:none; border-color:var(--green);
    box-shadow:0 0 0 3px rgba(0,133,63,.12); background:#fff;
  }
  .toggle-pw {
    position:absolute; right:14px; cursor:pointer; color:var(--muted);
    font-size:15px; background:none; border:none; padding:0;
  }
  .btn-primary {
    width:100%; padding:13px; background:linear-gradient(135deg, var(--green), #005f2d);
    color:#fff; border:none; border-radius:10px; font-size:15px; font-weight:600;
    font-family:inherit; cursor:pointer; margin-top:8px;
    display:flex; align-items:center; justify-content:center; gap:8px;
    transition:transform .15s, box-shadow .15s; text-decoration:none;
  }
  .btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,133,63,.35); }
  .divider {
    text-align:center; color:var(--muted); font-size:12px;
    margin:20px 0; position:relative;
  }
  .divider::before, .divider::after {
    content:''; position:absolute; top:50%; width:40%; height:1px; background:var(--border);
  }
  .divider::before { left:0; } .divider::after { right:0; }
  .flag-bar { display:flex; justify-content:center; gap:4px; margin-top:24px; }
  .flag-bar span { height:5px; border-radius:3px; flex:1; max-width:60px; }
  .flag-bar .f-green { background:var(--green); }
  .flag-bar .f-yellow { background:var(--yellow); }
  .flag-bar .f-red { background:var(--red); }
  .errors { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; padding:10px 14px; border-radius:8px; font-size:12.5px; margin-bottom:16px; }
  .errors li { list-style:none; padding:2px 0; }
  @media (max-width:520px) {
    .auth-card { max-width:100%; border-radius:12px; }
    .card-body { padding:24px 24px 28px; }
    .card-header { padding:24px 24px 20px; }
    .form-row.cols-2 { grid-template-columns:1fr; }
  }
</style>
</head>
<body>

<div class="auth-card">
  <div class="card-header">
    <div class="logo-circle"><i class="fas fa-graduation-cap"></i></div>
    <h1>ESP — Plateforme Numérique</h1>
    <p>École Supérieure Polytechnique · Dakar</p>
  </div>

  <div class="tab-bar">
    <a href="{{ route('login') }}" class="tab-btn {{ request()->routeIs('login') ? 'active' : '' }}">
      <i class="fas fa-sign-in-alt"></i> Connexion
    </a>
    <a href="{{ route('register') }}" class="tab-btn {{ request()->routeIs('register') ? 'active' : '' }}">
      <i class="fas fa-user-plus"></i> Créer un compte
    </a>
  </div>

  <div class="card-body">
    @if (session('success'))
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <ul class="errors">
        @foreach ($errors->all() as $err)<li>• {{ $err }}</li>@endforeach
      </ul>
    @endif

    @yield('form')

    <div class="flag-bar">
      <span class="f-green"></span><span class="f-yellow"></span><span class="f-red"></span>
    </div>
  </div>
</div>

<script>
function togglePw(id, btn) {
  const input = document.getElementById(id);
  const isText = input.type === 'text';
  input.type = isText ? 'password' : 'text';
  btn.querySelector('i').className = isText ? 'fas fa-eye' : 'fas fa-eye-slash';
}
</script>
</body>
</html>
