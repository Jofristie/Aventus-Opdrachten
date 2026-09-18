<?php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/classes/User.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = User::login($email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRole();
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Onjuist e-mailadres of wachtwoord.';
}

$pageTitle = 'Inloggen';
require __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <h1 class="h3 mb-4">Inloggen</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" novalidate>
            <div class="mb-3">
                <label class="form-label" for="email">E-mailadres</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Wachtwoord</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Inloggen</button>
        </form>
        <p class="mt-3 text-center">Nog geen account? <a href="register.php">Registreer je</a></p>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
