<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen — Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .brand-title { font-family:'Playfair Display',serif; font-size:2rem; color:#1a1a1a; }
        .card { border:none; border-radius:16px; box-shadow:0 8px 40px rgba(0,0,0,0.10); }
        .btn-dark { border-radius:8px; font-weight:500; letter-spacing:0.3px; }
        .form-control { border-radius:8px; border-color:#ddd; padding:0.6rem 0.9rem; }
        .form-control:focus { border-color:#1a1a1a; box-shadow:0 0 0 0.2rem rgba(26,26,26,0.10); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="text-center mb-4">
                    <div class="brand-title"> Winkel</div>
                    <p class="text-muted mt-1 mb-0" style="font-size:.95rem;">Log in op je account</p>
                </div>
                <div class="card p-4">
                    <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 mb-3" style="border-radius:8px;font-size:.9rem;">
                        Onjuist e-mailadres of wachtwoord.
                    </div>
                    <?php endif; ?>
                    <form action="verwerk_inlog.php" method="POST">
                        <div class="mb-3">
                            <label for="naam" class="form-label">Naam</label>
                            <input type="text" class="form-control" id="naam" name="name" placeholder="Jouw naam" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="naam@voorbeeld.nl" required>
                        </div>
                        <div class="mb-4">
                            <label for="wachtwoord" class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="••••••••" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">Inloggen</button>
                        </div>
                    </form>
                </div>
                <p class="text-center mt-4 text-muted" style="font-size:.9rem;">
                    Nog geen account?
                    <a href="registratie.php" class="text-dark fw-bold text-decoration-none"> Registreer je nu →</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>