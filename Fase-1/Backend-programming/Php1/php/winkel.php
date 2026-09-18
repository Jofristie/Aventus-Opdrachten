<?php
session_start();
include 'db_connect1.php';
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php"); exit();
}
$sql = "SELECT product_id, naam, beschrijving, prijs, voorraad, afbeelding FROM producten";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; }
        .navbar { background:#1a1a1a !important; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .nav-link { color:rgba(255,255,255,.75) !important; font-size:.9rem; }
        .nav-link:hover { color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; font-size:2rem; }
        .product-card { border:none; border-radius:16px; box-shadow:0 2px 16px rgba(0,0,0,.07); transition:transform .2s, box-shadow .2s; overflow:hidden; }
        .product-card:hover { transform:translateY(-4px); box-shadow:0 8px 32px rgba(0,0,0,.12); }
        .product-card img { height:200px; object-fit:cover; width:100%; }
        .product-card .no-img { height:200px; background:linear-gradient(135deg,#e8e2d9,#d4cdc3); display:flex; align-items:center; justify-content:center; font-size:3rem; }
        .badge-stock { font-size:.75rem; border-radius:20px; }
        .qty-input { width:80px; border-radius:8px; border-color:#ddd; text-align:center; }
        .qty-input:focus { border-color:#1a1a1a; box-shadow:0 0 0 .2rem rgba(26,26,26,.1); }
        .btn-order { background:#1a1a1a; color:#fff; border-radius:10px; font-weight:500; border:none; }
        .btn-order:hover { background:#333; color:#fff; }
        .price-tag { font-family:'Playfair Display',serif; font-size:1.25rem; color:#1a1a1a; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"> Winkel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item"><a class="nav-link" href="winkelwagen.php"> Winkelwagen</a></li>
                <li class="nav-item"><a class="nav-link" href="account.php"> Account</a></li>
                <li class="nav-item"><a class="nav-link" href="review.php"> Reviews</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="page-title mb-0">Onze producten</h1>
    </div>

    <form action="verwerk_bestelling.php" method="POST">
        <div class="row g-4">
            <?php while ($p = $result->fetch_assoc()): ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card product-card h-100">
                    <?php if (!empty($p['afbeelding'])): ?>
                        <img src="<?php echo htmlspecialchars($p['afbeelding']); ?>"
                             alt="<?php echo htmlspecialchars($p['naam']); ?>">
                    <?php else: ?>
                        <div class="no-img">📦</div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1"><?php echo htmlspecialchars($p['naam']); ?></h5>
                        <p class="text-muted mb-3" style="font-size:.88rem;flex-grow:1;">
                            <?php echo nl2br(htmlspecialchars($p['beschrijving'])); ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="price-tag">€<?php echo number_format($p['prijs'], 2); ?></span>
                            <?php if ($p['voorraad'] > 5): ?>
                                <span class="badge bg-success badge-stock">Op voorraad (<?php echo (int)$p['voorraad']; ?>)</span>
                            <?php elseif ($p['voorraad'] > 0): ?>
                                <span class="badge bg-warning text-dark badge-stock">Nog <?php echo (int)$p['voorraad']; ?> over</span>
                            <?php else: ?>
                                <span class="badge bg-danger badge-stock">Uitverkocht</span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted" style="font-size:.85rem;">Aantal:</label>
                            <input type="number"
                                   class="form-control qty-input"
                                   name="product_<?php echo $p['product_id']; ?>"
                                   min="0" max="<?php echo (int)$p['voorraad']; ?>"
                                   value="0"
                                   <?php echo $p['voorraad'] == 0 ? 'disabled' : ''; ?>>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="text-center mt-5">
            <button type="submit" class="btn btn-order btn-lg px-5 py-3" style="font-size:1.05rem;">
                 Bestelling plaatsen
            </button>
        </div>
    </form>
</div>
<?php $conn->close(); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>