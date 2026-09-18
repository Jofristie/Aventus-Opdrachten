<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/classes/User.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = 'Vul alle verplichte velden in.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Vul een geldig e-mailadres in.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Het wachtwoord moet minimaal 6 tekens bevatten.';
    }
    if ($password !== $passwordConfirm) {
        $errors[] = 'De wachtwoorden komen niet overeen.';
    }

    if (empty($errors)) {
        $registered = User::register($username, $email, $password, 'student');
        if ($registered) {
            $success = true;
        } else {
            $errors[] = 'Deze gebruikersnaam of dit e-mailadres is al in gebruik.';
        }
    }
}

$pageTitle = 'Registreren';
require __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <h1 class="h3 mb-4">Registreren</h1>

        <?php if ($success): ?>
            <div class="alert alert-success">
                Je account is aangemaakt! Je kunt nu <a href="login.php">inloggen</a>.
            </div>
        <?php else: ?>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="register.php" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="username">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">E-mailadres</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Wachtwoord</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password_confirm">Bevestig wachtwoord</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Account aanmaken</button>
            </form>
            <p class="mt-3 text-center">Heb je al een account? <a href="login.php">Log in</a></p>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
