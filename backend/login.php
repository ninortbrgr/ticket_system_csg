<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$usersFile = __DIR__ . "/users.json";
if (!file_exists($usersFile)) {
    die("Benutzerdaten fehlen!");
}

$users = json_decode(file_get_contents($usersFile), true);
$loginOk = false;

if (is_array($users)) {
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $loginOk = true;
            break;
        }
    }
}

if ($loginOk) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['username'] = $username;
    header("Location: ../admin.php");
    exit;
} else {
    header("Location: ../login.html?error=1");
    exit;
}