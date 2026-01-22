<?php
session_start();
if (!isset($_SESSION['unlocked'])) {
    header("Location: ../index.html");
    exit;
} else {
    header("Location: ../pages/ticket_submit.html");
    exit;
}
?>
