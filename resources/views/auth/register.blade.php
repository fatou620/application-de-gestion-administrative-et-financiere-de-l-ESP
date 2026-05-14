@extends('layouts.auth')

@section('form')
<form method="POST" action="{{ url('/register') }}">
  @csrf
  <div class="form-row cols-2">
    <div class="form-group">
      <label>Nom</label>
      <div class="input-wrap">
        <i class="fas fa-user"></i>
        <input type="text" name="nom" placeholder="DIOP" required value="{{ old('nom') }}">
      </div>
    </div>
    <div class="form-group">
      <label>Prénom</label>
      <div class="input-wrap">
        <i class="fas fa-user"></i>
        <input type="text" name="prenom" placeholder="Amadou" required value="{{ old('prenom') }}">
      </div>
    </div>
  </div>

  <div class="form-row" style="margin-top:16px">
    <div class="form-group">
      <label>Email</label>
      <div class="input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="amadou@esp.sn" required value="{{ old('email') }}">
      </div>
    </div>
  </div>

  <div class="form-row cols-2" style="margin-top:16px">
    <div class="form-group">
      <label>Numéro étudiant</label>
      <div class="input-wrap">
        <i class="fas fa-id-card"></i>
        <input type="text" name="numero_etudiant" placeholder="ESP2026001" required value="{{ old('numero_etudiant') }}">
      </div>
    </div>
    <div class="form-group">
      <label>Téléphone</label>
      <div class="input-wrap">
        <i class="fas fa-phone"></i>
        <input type="tel" name="telephone" placeholder="77 000 00 00" value="{{ old('telephone') }}">
      </div>
    </div>
  </div>

  <div class="form-row" style="margin-top:16px">
    <div class="form-group">
      <label>Date de naissance</label>
      <div class="input-wrap">
        <i class="fas fa-calendar"></i>
        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}">
      </div>
    </div>
  </div>

  <div class="form-row cols-2" style="margin-top:16px">
    <div class="form-group">
      <label>Mot de passe</label>
      <div class="input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="pw-reg" placeholder="••••••••" required minlength="6">
        <button type="button" class="toggle-pw" onclick="togglePw('pw-reg', this)">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
    <div class="form-group">
      <label>Confirmer</label>
      <div class="input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="password_confirmation" id="pw-confirm" placeholder="••••••••" required>
        <button type="button" class="toggle-pw" onclick="togglePw('pw-confirm', this)">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>
  </div>

  <button type="submit" class="btn-primary" style="margin-top:20px">
    <i class="fas fa-user-plus"></i> Créer mon compte
  </button>
</form>
@endsection
