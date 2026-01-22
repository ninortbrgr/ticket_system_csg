<?php
session_start();
if(!isset($_SESSION["loggedIn"])){
    echo json_encode(["success"=>false,"message"=>"Nicht eingeloggt"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$index = $input['index'] ?? null;

if($index === null){
    echo json_encode(["success"=>false,"message"=>"Kein Index angegeben"]);
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

// Ticket löschen
array_splice($tickets, $index, 1);
file_put_contents($ticketsPath, json_encode($tickets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

echo json_encode(["success"=>true]);
