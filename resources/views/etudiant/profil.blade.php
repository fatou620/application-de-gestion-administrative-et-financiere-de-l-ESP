@extends('layouts.etudiant', ['titlePage' => 'Mon Profil — ESP'])

@section('page_title', 'Mon Profil')
@section('page_sub', 'Gérez vos informations personnelles')

@section('content')
<div style="display:grid;grid-template-columns:300px 1fr;gap:24px" class="profil-layout">
  <div class="card" style="height:fit-content;overflow:hidden">
    <div style="background:linear-gradient(135deg,#00853F,#005f2d);padding:32px 24px;text-align:center;position:relative">
      <div style="position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#00853F,#FDEF42,#E31E24)"></div>
      <div style="width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,.2);border:3px solid rgba(255,255,255,.4);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:28px;font-weight:800;color:#fff;overflow:hidden">
        @if ($user->photo)
          <img src="{{ asset('storage/'.$user->photo) }}" style="width:100%;height:100%;object-fit:cover" alt="">
        @else
          {{ strtoupper(substr($user->prenom,0,1).substr($user->nom,0,1)) }}
        @endif
      </div>
      <div style="color:#fff;font-size:18px;font-weight:700">{{ $user->prenom }} {{ $user->nom }}</div>
      <div style="color:rgba(255,255,255,.65);font-size:12px;margin-top:4px">{{ $etudiant->numero_etudiant }}</div>
      <div style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.15);color:#fff;padding:3px 12px;border-radius:20px;font-size:11px;font-weight:600;margin-top:8px">
        <span style="width:7px;height:7px;border-radius:50%;background:#4ade80"></span> Compte actif
      </div>
    </div>
    <div style="padding:20px">
      <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb">
        <span style="font-size:12px;color:#6b7280;font-weight:600"><i class="fas fa-envelope" style="color:#00853F"></i> Email</span>
        <span style="font-size:13px;font-weight:600">{{ $user->email }}</span>
      </div>
      <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #e5e7eb">
        <span style="font-size:12px;color:#6b7280;font-weight:600"><i class="fas fa-phone" style="color:#00853F"></i> Tél.</span>
        <span style="font-size:13px;font-weight:600">{{ $user->telephone ?? '—' }}</span>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:16px">
        <div style="background:#f8fafc;border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:20px;font-weight:800;color:#00853F">{{ $stats['moyenne'] ?: '0' }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:2px">Moyenne</div>
        </div>
        <div style="background:#f8fafc;border-radius:10px;padding:14px;text-align:center">
          <div style="font-size:20px;font-weight:800;color:#00853F">{{ $stats['nb_notes'] }}</div>
          <div style="font-size:10px;color:#6b7280;margin-top:2px">Notes</div>
        </div>
      </div>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:20px">
      <div class="card-head"><h3><i class="fas fa-user-edit"></i> Informations personnelles</h3></div>
      <div style="padding:20px 24px">
        <form method="POST" action="{{ route('etudiant.profil') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label>Photo de profil</label>
            <div class="iw" style="padding-left:0"><input type="file" name="photo" accept="image/*" style="padding-left:14px"></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
              <label>Téléphone</label>
              <div class="iw"><i class="fas fa-phone"></i><input type="tel" name="telephone" value="{{ $user->telephone }}" placeholder="77 000 00 00"></div>
            </div>
            <div class="form-group">
              <label>N° étudiant</label>
              <div class="iw"><i class="fas fa-id-card"></i><input type="text" value="{{ $etudiant->numero_etudiant }}" readonly style="background:#f0fdf4"></div>
            </div>
          </div>
          <div class="form-group">
            <label>Préférences de notification</label>
            <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e5e7eb">
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;margin-bottom:8px;font-size:14px">
                <input type="checkbox" name="notif_email" value="1" {{ $user->notif_email ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#00853F">
                Recevoir les alertes par Email
              </label>
              <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:14px">
                <input type="checkbox" name="notif_sms" value="1" {{ $user->notif_sms ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#00853F">
                Recevoir les alertes par SMS
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-green" style="padding:12px 24px">
            <i class="fas fa-save"></i> Enregistrer les modifications
          </button>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-head"><h3><i class="fas fa-key"></i> Sécurité</h3></div>
      <div style="padding:20px 24px">
        <form method="POST" action="{{ route('etudiant.profil.password') }}">
          @csrf
          <div class="form-group">
            <label>Ancien mot de passe</label>
            <div class="iw"><i class="fas fa-lock"></i><input type="password" name="ancien_pw" required></div>
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div class="form-group">
              <label>Nouveau mot de passe</label>
              <div class="iw"><i class="fas fa-shield-alt"></i><input type="password" name="nouveau_pw" required minlength="6"></div>
            </div>
            <div class="form-group">
              <label>Confirmer</label>
              <div class="iw"><i class="fas fa-check-double"></i><input type="password" name="nouveau_pw_confirmation" required></div>
            </div>
          </div>
          <button type="submit" class="btn" style="padding:12px 24px;background:#1a1a2e;color:#fff">
            <i class="fas fa-sync"></i> Mettre à jour le mot de passe
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>@media(max-width:900px){ .profil-layout { grid-template-columns:1fr !important; } }</style>
@endpush
@endsection
