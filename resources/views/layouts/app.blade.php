<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'ESP — Plateforme Numérique' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --green:   #00853F;
    --green2:  #005f2d;
    --yellow:  #FDEF42;
    --red:     #E31E24;
    --dark:    #0D1B2A;
    --sidebar: #0f2234;
    --bg:      #f0f4f8;
    --card:    #ffffff;
    --text:    #1a1a2e;
    --muted:   #6b7280;
    --border:  #e5e7eb;
    --radius:  14px;
    --sidebar-w: 260px;
  }
  body {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
  }
  a { color: inherit; text-decoration: none; }
  button { font-family: inherit; }
  .flag-stripe {
    height: 3px;
    background: linear-gradient(90deg, var(--green), var(--yellow), var(--red));
  }
</style>
@stack('styles')
</head>
<body>
@yield('body')
@stack('scripts')
</body>
</html>
