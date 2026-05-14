@extends('layouts.auth')

@section('form')
<form method="POST" action="{{ url('/login') }}">
  @csrf
  <div class="form-row">
    <div class="form-group">
      <label>Adresse email</label>
      <div class="input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="votre@email.com" required
               value="{{ old('email') }}" autofocus>
      </div>
    </div>
    <div class="form-group">
      <label>Mot de passe</label>
      <div class="input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="pw-login" placeholder="••••••••" required>
        <button type="button" class="toggle-pw" onclick="togglePw('pw-login', this)">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
  </div>
  <button type="submit" class="btn-primary">
    <i class="fas fa-sign-in-alt"></i> Se connecter
  </button>
</form>

<div class="divider">Pas encore de compte ?</div>
<a href="{{ route('register') }}" class="btn-primary" style="background:linear-gradient(135deg,#1d4ed8,#1e3a8a)">
  <i class="fas fa-user-plus"></i> Créer mon compte étudiant
</a>

<div style="margin-top:18px;padding:12px 14px;background:#f8fafc;border-radius:8px;font-size:11.5px;color:#6b7280">
  <strong style="color:#1a1a2e">Comptes de test :</strong><br>
  Étudiant : <code>etudiant@esp.sn</code> / <code>password</code><br>
  Agent admin : <code>agent@esp.sn</code> / <code>password</code><br>
  Finance : <code>finance@esp.sn</code> / <code>password</code>
</div>
@endsection
