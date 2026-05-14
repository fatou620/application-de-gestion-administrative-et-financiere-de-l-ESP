<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Reçu de paiement — {{ $paiement->reference_trans }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
  body { font-family:'Inter',Arial,sans-serif; padding:40px; color:#1a1a2e; background:#f5f5f5; }
  .recu { max-width:600px; margin:0 auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 10px 40px rgba(0,0,0,.1); }
  .header { text-align:center; border-bottom:3px solid #00853F; padding-bottom:20px; margin-bottom:24px; }
  h1 { color:#00853F; font-size:24px; }
  h2 { font-size:16px; color:#555; font-weight:600; margin-top:6px; }
  .row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; font-size:14px; }
  .label { color:#6b7280; font-weight:600; }
  .val { font-weight:700; }
  .total { font-size:24px; color:#00853F; font-weight:800; text-align:center; margin-top:24px; padding:18px; background:rgba(0,133,63,.06); border-radius:10px; }
  .footer { text-align:center; margin-top:30px; font-size:11px; color:#999; }
  .flag { display:flex; gap:4px; justify-content:center; margin-top:10px; }
  .flag span { height:5px; border-radius:2px; width:60px; }
  .print-btn { display:block; margin:24px auto 0; padding:12px 28px; background:#00853F; color:#fff; border:none; border-radius:10px; cursor:pointer; font-weight:600; font-family:inherit; font-size:14px; }
  @media print {
    body { background:#fff; padding:0; }
    .recu { box-shadow:none; }
    .print-btn { display:none; }
  }
</style>
</head>
<body>

<div class="recu">
  <div class="header">
    <h1>🎓 ESP — Plateforme Numérique</h1>
    <h2>Reçu de Paiement Officiel</h2>
  </div>

  <div class="row"><span class="label">Référence</span><span class="val">{{ $paiement->reference_trans }}</span></div>
  <div class="row"><span class="label">Date</span><span class="val">{{ $paiement->date_paiement->format('d/m/Y à H:i') }}</span></div>
  <div class="row"><span class="label">Étudiant</span><span class="val">{{ $paiement->etudiant?->utilisateur?->prenom }} {{ $paiement->etudiant?->utilisateur?->nom }}</span></div>
  <div class="row"><span class="label">N° étudiant</span><span class="val">{{ $paiement->etudiant?->numero_etudiant }}</span></div>
  <div class="row"><span class="label">Mode de paiement</span><span class="val">{{ ucfirst(str_replace('_', ' ', $paiement->mode)) }}</span></div>
  <div class="row"><span class="label">Statut</span><span class="val">{{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}</span></div>

  <div class="total">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</div>

  <div class="footer">
    <p>École Supérieure Polytechnique · Dakar, Sénégal</p>
    <p>Ce reçu est généré automatiquement et fait foi de paiement.</p>
    <div class="flag">
      <span style="background:#00853F"></span>
      <span style="background:#FDEF42"></span>
      <span style="background:#E31E24"></span>
    </div>
  </div>

  <button class="print-btn" onclick="window.print()">🖨️ Imprimer ce reçu</button>
</div>

</body>
</html>
