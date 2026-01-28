<?php
session_start();

$pass = "test123";
$try = $_POST['password'] ?? '';
$unlocked = false;

if ($pass === $try) {
    $unlocked = true;
}

if ($unlocked) {
    $_SESSION['unlocked'] = true;
    header("Location: ./ticket_submit.php");
    exit;
} else {
    header("Location: ../index.html?error=1");
    exit;
}
