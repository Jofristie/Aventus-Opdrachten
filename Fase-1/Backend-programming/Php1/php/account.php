<?php
session_start();
include 'db_connect1.php';
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit();
}
$gebruiker_id = (int)$_SESSION['gebruiker_id'];
$sql = "SELECT * FROM gebruikers WHERE gebruiker_id = $gebruiker_id";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $naam  = $row['gebruikersnaam'];
    $email = $row['email'];
} else {
    echo "Fout: Gebruiker niet gevonden."; exit();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account — Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; }
        .navbar { background:#1a1a1a !important; }
        .navbar-brand { font-family:'Playfair Display',serif; font-size:1.4rem; color:#fff !important; }
        .nav-link { color:rgba(255,255,255,.75) !important; font-size:.9rem; }
        .nav-link:hover { color:#fff !important; }
        .card { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .avatar { width:72px; height:72px; border-radius:50%; background:#1a1a1a; display:flex; align-items:center; justify-content:center; font-size:2rem; color:#fff; font-family:'Playfair Display',serif; }
        .form-control { border-radius:8px; border-color:#ddd; }
        .form-control:focus { border-color:#1a1a1a; box-shadow:0 0 0 .2rem rgba(26,26,26,.10); }
        .btn-dark { border-radius:8px; font-weight:500; }
        .section-label { font-size:.7rem; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#aaa; }
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
                <li class="nav-item"><a class="nav-link" href="winkelwagen.php">Winkelwagen</a></li>
                <li class="nav-item"><a class="nav-link" href="review.php">Reviews</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success border-0 mb-4" style="border-radius:12px;">
                ✅ Je accountgegevens zijn bijgewerkt.
            </div>
            <?php endif; ?>

            <div class="card p-4">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="avatar"><?php echo strtoupper(mb_substr($naam,0,1)); ?></div>
                    <div>
                        <div class="fw-bold" style="font-size:1.1rem;"><?php echo htmlspecialchars($naam); ?></div>
                        <div class="text-muted" style="font-size:.88rem;"><?php echo htmlspecialchars($email); ?></div>
                    </div>
                </div>

                <p class="section-label mb-3">Gegevens bijwerken</p>

                <form action="update_account.php" method="POST">
                    <div class="mb-3">
                        <label for="naam" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="naam" name="naam"
                               value="<?php echo htmlspecialchars($naam); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mailadres</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="wachtwoord" class="form-label">Nieuw wachtwoord
                            <span class="text-muted" style="font-size:.8rem;">(leeg = ongewijzigd)</span>
                        </label>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="••••••••">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>