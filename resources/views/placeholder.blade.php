<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>{{ $titre ?? 'Espace' }} — ESP</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap" rel="stylesheet">
<style>
  body { font-family:'Inter',sans-serif; background:#0D1B2A; color:#fff;
    min-height:100vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:20px;}
  h1 { font-size:28px; margin-bottom:12px; }
  p { color:#94a3b8; max-width:480px; margin:0 auto 24px; }
  a { color:#fff; background:#00853F; padding:12px 24px; border-radius:10px; text-decoration:none; font-weight:600;}
</style>
</head>
<body>
  <div>
    <h1>{{ $titre ?? 'Espace' }}</h1>
    <p>Cet espace sera développé par un autre membre de l'équipe. La connexion fonctionne déjà — la mise en page complète viendra ensuite.</p>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
      @csrf
      <button style="background:#E31E24;color:#fff;border:none;padding:12px 24px;border-radius:10px;font-weight:600;cursor:pointer;font-family:inherit">Déconnexion</button>
    </form>
  </div>
</body>
</html>
