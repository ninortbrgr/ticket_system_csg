<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header("Location: ../pages/login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div class="container-dashboard">
    <div class="header-with-image">
      <h2>Admin Dashboard</h2>
      <img src="../img/csg.png" width="100" />
    </div>

    <a href="../php/logout.php" class="logout-btn">Logout</a>

    <div class="dashboard">
      <!-- Linke Ticket-Übersicht -->
      <div id="ticket-list" class="ticket-list">
        <h3>Tickets Übersicht</h3>
        <ul id="tickets-ul"></ul>
      </div>

      <!-- Rechte Ticket-Details -->
      <div id="ticket-details" class="ticket-details">
        <p>Wähle ein Ticket aus der Liste links aus.</p>
      </div>
    </div>
  </div>

<script>
let tickets = [];

async function ladeTickets() {
    try {
        const response = await fetch('../data/tickets.json?ts=' + Date.now(), {cache:"no-store"});
        tickets = await response.json();

        const ul = document.getElementById('tickets-ul');
        ul.innerHTML = '';

        if (!Array.isArray(tickets) || tickets.length === 0) {
            ul.innerHTML = '<li>Keine Tickets vorhanden</li>';
            return;
        }

        tickets.forEach((ticket, index) => {
            const li = document.createElement('li');
            li.textContent = ticket.title ?? "Kein Titel";
            li.className = 'ticket-item';
            li.addEventListener('click', () => showTicketDetails(index));
            ul.appendChild(li);
        });

    } catch (error) {
        console.error(error);
        document.getElementById('ticket-details').innerHTML = 'Fehler beim Laden der Tickets.';
    }
}

function showTicketDetails(index) {
    const ticket = tickets[index];
    const details = document.getElementById('ticket-details');

    details.innerHTML = `
        <h3>${ticket.title ?? "Kein Titel"}</h3>
        <p><strong>Kategorie:</strong> ${ticket.category ?? "-"}</p>
        <p><strong>Raum:</strong> ${ticket.room ?? "-"}</p>
        <p><strong>Name:</strong> ${ticket.name ?? "-"}</p>
        <p>${ticket.description ?? "-"}</p>
        <p><em>${ticket.date ?? "-"}</em></p>

        <label>Status ändern:</label>
        <select id="status-select">
            <option value="To-Do" ${ticket.status==="To-Do"?"selected":""}>To-Do</option>
            <option value="InProgress" ${ticket.status==="InProgress"?"selected":""}>InProgress</option>
            <option value="Done" ${ticket.status==="Done"?"selected":""}>Done</option>
        </select>
        <button id="save-status">Speichern</button>
        <button id="delete-ticket" class="delete-btn">Löschen</button>
    `;

    document.getElementById('save-status').addEventListener('click', async () => {
        const newStatus = document.getElementById('status-select').value;
        ticket.status = newStatus;

        const res = await fetch('./update_ticket.php', {
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({index, ticket})
        });
        const data = await res.json();
        if(data.success){
            alert("Status aktualisiert!");
            ladeTickets();
        } else {
            alert("Fehler beim Aktualisieren!");
        }
    });

    document.getElementById('delete-ticket').addEventListener('click', async () => {
        if(!confirm("Ticket wirklich löschen?")) return;

        const res = await fetch('./backend/delete_ticket.php', {
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({index})
        });
        const data = await res.json();
        if(data.success){
            alert("Ticket gelöscht!");
            details.innerHTML = "<p>Wähle ein Ticket aus der Liste links aus.</p>";
            ladeTickets();
        } else {
            alert("Fehler beim Löschen!");
        }
    });
}

ladeTickets();
</script>
</body>
</html>
