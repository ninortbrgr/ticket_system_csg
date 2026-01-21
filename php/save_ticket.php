<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$category = $_POST['category'] ?? 'Sonstiges';
$room = trim($_POST['room'] ?? '');
$name = trim($_POST['name'] ?? '');
$date = date("Y-m-d H:i:s");

$newTicket = [
    'title' => $title,
    'description' => $description,
    'category' => $category,
    'room' => $room,
    'name' => $name,
    'status' => 'To-Do',
    'date' => $date
];

$ticketsPath = __DIR__ . '../data/tickets.json';
$tickets = [];

if (file_exists($ticketsPath)) {
    $json = file_get_contents($ticketsPath);
    $tickets = json_decode($json, true);
    if (!is_array($tickets)) $tickets = [];
}

$tickets[] = $newTicket;

file_put_contents($ticketsPath, json_encode($tickets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

// Redirect zurück ins Dashboard oder zur Hauptseite
header('Location: ../pages/ticket_submit.html?success=1');
exit;
