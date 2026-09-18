<?php
session_start();
if (!isset($_SESSION['gebruiker_id']) || $_SESSION['usertype'] != 1) {
    die("Geen toegang");
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#0f0f0f; font-family:'DM Sans',sans-serif; color:#fff; }
        .navbar { background:#1a1a1a !important; border-bottom:1px solid #2a2a2a; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; }
        .form-card { background:#1a1a1a; border:1px solid #2a2a2a; border-radius:16px; }
        .form-label { color:#ccc; font-size:.9rem; }
        .form-control, textarea { background:#0f0f0f !important; border-color:#333 !important; color:#fff !important; border-radius:8px; }
        .form-control:focus, textarea:focus { border-color:#666 !important; box-shadow:0 0 0 .2rem rgba(255,255,255,.05) !important; }
        .form-control::placeholder { color:#555; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand">Admin Panel</span>
        <a href="productBeheer.php" class="btn btn-outline-light btn-sm" style="border-radius:8px;">← Terug</a>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <h2 class="page-title mb-4">Nieuw product toevoegen</h2>
            <div class="form-card p-4">
                <form action="verwerk_toevoegen.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="text" name="naam" class="form-control" placeholder="Productnaam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Beschrijving</label>
                        <textarea name="beschrijving" class="form-control" rows="3" placeholder="Korte productomschrijving..." required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Prijs (€)</label>
                            <input type="number" step="0.01" name="prijs" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Voorraad</label>
                            <input type="number" name="voorraad" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Afbeelding (URL) <span style="color:#666;font-size:.8rem;">optioneel</span></label>
                        <input type="text" name="afbeelding" class="form-control" placeholder="https://...">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg" style="border-radius:10px;">
                             Product toevoegen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>