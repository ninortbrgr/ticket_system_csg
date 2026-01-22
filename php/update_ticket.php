<?php
session_start();
if(!isset($_SESSION["loggedIn"])){
    echo json_encode(["success"=>false,"message"=>"Nicht eingeloggt"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$index = $input['index'] ?? null;
$ticket = $input['ticket'] ?? null;

if($index === null || $ticket === null){
    echo json_encode(["success"=>false,"message"=>"Keine Daten"]);
    exit;
}

$ticketsPath = '../data/tickets.json';
$tickets = [];

if(file_exists($ticketsPath)){
    $tickets = json_decode(file_get_contents($ticketsPath), true);
}

if(!isset($tickets[$index])){
    echo json_encode(["success"=>false,"message"=>"Ticket existiert nicht"]);
    exit;
}

// Ticket aktualisieren
$tickets[$index] = $ticket;
file_put_contents($ticketsPath, json_encode($tickets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

echo json_encode(["success"=>true]);
