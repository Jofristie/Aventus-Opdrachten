<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kleine helperfuncties voor authenticatie, gebruikt door alle pagina's.
 */

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function currentUser(): ?User
{
    if (!isLoggedIn()) {
        return null;
    }

    return User::findById((int) $_SESSION['user_id']);
}
