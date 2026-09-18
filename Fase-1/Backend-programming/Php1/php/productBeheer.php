<?php
session_start();
if (!isset($_SESSION['gebruiker_id']) || $_SESSION['usertype'] != 1) {
    header("Location: inlog.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Product Beheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#0f0f0f; font-family:'DM Sans',sans-serif; color:#fff; min-height:100vh; }
        .navbar { background:#1a1a1a !important; border-bottom:1px solid #2a2a2a; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; font-size:2.2rem; }
        .admin-card { background:#1a1a1a; border:1px solid #2a2a2a; border-radius:16px; transition:border-color .2s, transform .2s; }
        .admin-card:hover { border-color:#555; transform:translateY(-3px); }
        .admin-card .icon { font-size:2.5rem; }
        .admin-card p { color:#aaa; font-size:.9rem; }
        .subtitle { color:#888; font-size:.95rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand">Admin Panel</span>
        <a href="winkel.php" class="btn btn-outline-light btn-sm" style="border-radius:8px;">← Naar winkel</a>
    </div>
</nav>

<div class="container py-5">
    <div class="mb-5">
        <h1 class="page-title mb-1">Product Beheer</h1>
        <p class="subtitle">Beheer het assortiment van de winkel</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="admin-card p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold mb-2">Product toevoegen</h5>
                <p class="flex-grow-1">Voeg een nieuw product toe aan de webshop.</p>
                <a href="product_toevoegen.php" class="btn btn-success btn-sm mt-2" style="border-radius:8px;align-self:flex-start;">
                    Ga naar toevoegen →
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold mb-2">Product bewerken</h5>
                <p class="flex-grow-1">Pas naam, prijs of voorraad van bestaande producten aan.</p>
                <a href="product_bewerken.php" class="btn btn-warning btn-sm mt-2 text-dark" style="border-radius:8px;align-self:flex-start;">
                    Ga naar bewerken →
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card p-4 h-100 d-flex flex-column">
                <h5 class="fw-bold mb-2">Product verwijderen</h5>
                <p class="flex-grow-1">Verwijder producten permanent uit de database.</p>
                <a href="product_verwijderen.php" class="btn btn-danger btn-sm mt-2" style="border-radius:8px;align-self:flex-start;">
                    Ga naar verwijderen →
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>