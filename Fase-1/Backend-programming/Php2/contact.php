<?php
require_once __DIR__ . '/includes/session.php';

$sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $error = 'Vul alle velden in.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Vul een geldig e-mailadres in.';
    } else {
        // In een echte omgeving zou hier mail() of een mailservice aangeroepen worden.
        // Voor deze opdracht slaan we het bericht simpelweg op als "verzonden".
        $sent = true;
    }
}

$pageTitle = 'Contact';
require __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h1 class="h3 mb-4">Contact</h1>

        <?php if ($sent): ?>
            <div class="alert alert-success">Bedankt voor je bericht! Ik neem zo snel mogelijk contact op.</div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" action="contact.php">
                <div class="mb-3">
                    <label class="form-label">Naam</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mailadres</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bericht</label>
                    <textarea class="form-control" name="message" rows="5" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Versturen</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
