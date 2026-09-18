<?php
include 'db_connect1.php';
session_start();
if (!isset($_SESSION['gebruiker_id']) || $_SESSION['usertype'] != 1) {
    die("Geen toegang");
}
$result = $conn->query("SELECT * FROM producten");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Verwijderen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#0f0f0f; font-family:'DM Sans',sans-serif; color:#fff; }
        .navbar { background:#1a1a1a !important; border-bottom:1px solid #2a2a2a; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; }
        .list-card { background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; overflow:hidden; }
        .product-row { display:flex; align-items:center; gap:1rem; padding:.85rem 1.25rem; border-bottom:1px solid #222; cursor:pointer; transition:background .15s; }
        .product-row:last-child { border-bottom:none; }
        .product-row:hover { background:#222; }
        .product-row input[type=checkbox] { width:1.2em; height:1.2em; accent-color:#ef4444; flex-shrink:0; }
        .product-row label { color:#ddd; font-size:.95rem; cursor:pointer; flex-grow:1; margin:0; }
        .danger-banner { background:#2a1010; border:1px solid #5a1a1a; border-radius:12px; color:#f87171; padding:1rem 1.25rem; font-size:.9rem; }
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
            <h2 class="page-title mb-2">Producten verwijderen</h2>
            <div class="danger-banner mb-4">
                 Verwijderde producten kunnen niet worden hersteld.
            </div>

            <form action="verwerk_verwijderen.php" method="POST">
                <div class="list-card mb-4">
                    <?php while($row = $result->fetch_assoc()): ?>
                    <div class="product-row">
                        <input type="checkbox"
                               name="verwijder[]"
                               id="p<?php echo $row['product_id']; ?>"
                               value="<?php echo $row['product_id']; ?>">
                        <label for="p<?php echo $row['product_id']; ?>">
                            <?php echo htmlspecialchars($row['naam']); ?>
                        </label>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-lg" style="border-radius:10px;font-weight:600;">
                         Geselecteerde producten verwijderen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>