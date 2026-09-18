<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratie — Winkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem 0; }
        .brand-title { font-family:'Playfair Display',serif; font-size:2rem; color:#1a1a1a; }
        .card { border:none; border-radius:16px; box-shadow:0 8px 40px rgba(0,0,0,0.10); }
        .btn-dark { border-radius:8px; font-weight:500; }
        .form-control, .form-check-input { border-radius:8px; border-color:#ddd; padding:0.6rem 0.9rem; }
        .form-control:focus { border-color:#1a1a1a; box-shadow:0 0 0 0.2rem rgba(26,26,26,0.10); }
        .form-check-input { width:1.2em; height:1.2em; cursor:pointer; }
        .admin-badge { background:#fff3cd; border:1px solid #ffc107; border-radius:10px; padding:.75rem 1rem; font-size:.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <div class="brand-title"> Winkel</div>
                    <p class="text-muted mt-1 mb-0" style="font-size:.95rem;">Maak een nieuw account aan</p>
                </div>
                <div class="card p-4">
                    <form action="verwerk_registratie.php" method="POST">
                        <div class="mb-3">
                            <label for="naam" class="form-label">Naam</label>
                            <input type="text" class="form-control" id="naam" name="naam" placeholder="Volledige naam" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mailadres</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="naam@voorbeeld.nl" required>
                        </div>
                        <div class="mb-3">
                            <label for="wachtwoord" class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Minimaal 8 tekens" required>
                        </div>
                        <div class="mb-4">
                            <label for="herhaal_wachtwoord" class="form-label">Wachtwoord herhalen</label>
                            <input type="password" class="form-control" id="herhaal_wachtwoord" name="herhaal_wachtwoord" placeholder="••••••••" required>
                        </div>
                        <div class="admin-badge mb-4 d-flex align-items-center gap-3">
                            <input class="form-check-input mt-0" type="checkbox" id="admin_account" name="admin_account">
                            <label for="admin_account" class="mb-0">
                                <span class="fw-bold">Adminaccount</span><br>
                                <span class="text-muted" style="font-size:.82rem;">Geeft toegang tot productbeheer</span>
                            </label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">Account aanmaken</button>
                        </div>
                    </form>
                </div>
                <p class="text-center mt-4 text-muted" style="font-size:.9rem;">
                    Al een account?
                    <a href="inlog.php" class="text-dark fw-bold text-decoration-none"> Log hier in →</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>