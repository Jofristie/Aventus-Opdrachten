<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen — Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; }
        .navbar { background:#1a1a1a !important; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .nav-link { color:rgba(255,255,255,.75) !important; font-size:.9rem; }
        .nav-link:hover { color:#fff !important; }
        .page-title { font-family:'Playfair Display',serif; font-size:2rem; }
        .card { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .order-row { border-bottom:1px solid #f0ebe4; padding:.85rem 0; }
        .order-row:last-child { border-bottom:none; }
        .order-num { font-size:.75rem; color:#aaa; font-weight:600; letter-spacing:.5px; text-transform:uppercase; }
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
                <li class="nav-item"><a class="nav-link" href="winkel.php">Winkel</a></li>
                <li class="nav-item"><a class="nav-link" href="account.php"> Account</a></li>
                <li class="nav-item"><a class="nav-link" href="review.php"> Reviews</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h1 class="page-title mb-5">Mijn bestellingen</h1>

    <?php
    session_start();
    include 'db_connect1.php';
    if (!isset($_SESSION['gebruiker_id'])) {
        header("Location: inlog.php"); exit();
    }
    $gebruiker_id = $_SESSION['gebruiker_id'];

    $sql_bestellingen = "
        SELECT b.bestelling_id, p.naam, bp.aantal, b.bestel_datum
        FROM bestellingen AS b
        JOIN bestelling_producten AS bp ON b.bestelling_id = bp.bestelling_id
        JOIN producten AS p ON bp.product_id = p.product_id
        WHERE b.gebruiker_id = {$gebruiker_id}
        ORDER BY b.bestel_datum DESC
    ";
    $result_bestellingen = mysqli_query($conn, $sql_bestellingen);

    if (mysqli_num_rows($result_bestellingen) > 0):
        // Group by order
        $orders = [];
        while ($row = mysqli_fetch_assoc($result_bestellingen)) {
            $orders[$row['bestelling_id']]['datum'] = $row['bestel_datum'];
            $orders[$row['bestelling_id']]['items'][] = $row;
        }
    ?>
    <div class="card">
        <div class="card-body p-0">
            <?php foreach ($orders as $bid => $order): ?>
            <div class="px-4 py-3">
                <div class="order-num mb-2">Bestelling #<?php echo $bid; ?> &mdash; <?php echo htmlspecialchars($order['datum']); ?></div>
                <?php foreach ($order['items'] as $item): ?>
                <div class="order-row d-flex justify-content-between align-items-center ps-3">
                    <span> <?php echo htmlspecialchars($item['naam']); ?></span>
                    <span class="badge bg-dark" style="border-radius:20px;">× <?php echo (int)$item['aantal']; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="card p-5 text-center">
        <h4 class="mt-3 mb-1" style="font-family:'Playfair Display',serif;">Nog geen bestellingen</h4>
        <p class="text-muted mb-4">Je hebt nog niets besteld. Bekijk de winkel!</p>
        <a href="winkel.php" class="btn btn-dark d-inline-block px-4" style="border-radius:10px;">Naar de winkel →</a>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>