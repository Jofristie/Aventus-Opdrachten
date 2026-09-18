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
    <title>Product Bewerken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#0f0f0f; font-family:'DM Sans',sans-serif; color:#fff; }
        .navbar { background:#1a1a1a !important; border-bottom:1px solid #2a2a2a; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; }
        .product-edit-card { background:#1a1a1a; border:1px solid #2a2a2a; border-radius:14px; }
        .form-label { color:#bbb; font-size:.85rem; }
        .form-control { background:#0f0f0f !important; border-color:#333 !important; color:#fff !important; border-radius:8px; }
        .form-control:focus { border-color:#666 !important; box-shadow:none !important; }
        .product-name-header { font-size:1rem; font-weight:600; color:#eee; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark">
    <div class="container">
        <span class="navbar-brand"> Admin Panel</span>
        <a href="productBeheer.php" class="btn btn-outline-light btn-sm" style="border-radius:8px;">← Terug</a>
    </div>
</nav>

<div class="container py-5">
    <h2 class="page-title mb-4">Producten bewerken</h2>

    <form action="verwerk_bewerken.php" method="POST">
        <div class="d-flex flex-column gap-3">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="product-edit-card p-4">
            <p class="product-name-header mb-3"> <?php echo htmlspecialchars($row['naam']); ?></p>
            <input type="hidden" name="id[]" value="<?php echo $row['product_id']; ?>">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Naam</label>
                    <input type="text" name="naam[]" class="form-control" value="<?php echo htmlspecialchars($row['naam']); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prijs (€)</label>
                    <input type="number" step="0.01" name="prijs[]" class="form-control" value="<?php echo $row['prijs']; ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Voorraad</label>
                    <input type="number" name="voorraad[]" class="form-control" value="<?php echo $row['voorraad']; ?>">
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-warning btn-lg px-5 text-dark" style="border-radius:10px;font-weight:600;">
                 Wijzigingen opslaan
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>