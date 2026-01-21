<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: ../pages/login.html");
    exit;
}
echo "Willkommen im Dashboard, ".$_SESSION['role']."!";
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../css/style.css"> <!-- Pfad zu CSS anpassen -->
<style>
  body {
    display: flex;
    margin: 0;
    font-family: Arial, sans-serif;
  }
  /* Sidebar */
  .sidebar {
    width: 220px;
    background-color: #2b79c2;
    color: white;
    height: 100vh;
    padding-top: 2rem;
    display: flex;
    flex-direction: column;
  }
  .sidebar a {
    color: white;
    text-decoration: none;
    padding: 1rem 1.5rem;
    display: block;
    transition: background 0.3s;
  }
  .sidebar a:hover, .sidebar a.active {
    background-color: #1d5fa0;
  }

  /* Content */
  .content {
    flex: 1;
    padding: 2rem;
    background: #f0f2f5;
    min-height: 100vh;
  }

  h2 {
    margin-top: 0;
  }

  .button-panel {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
  }

  .button-panel button {
    padding: 1rem 1.5rem;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    background-color: #2b79c2;
    color: white;
    transition: background 0.3s;
  }

  .button-panel button:hover {
    background-color: #1d5fa0;
  }
</style>
</head>
<body>

<div class="sidebar">
  <a href="#" class="active" data-section="welcome">Willkommen</a>
  <a href="#" data-section="tickets">Tickets</a>
  <a href="#" data-section="users">Benutzer</a>
  <a href="#" data-section="settings">Persönliche Einstellungen</a>
  <a href="./logout.php">Logout</a>
</div>

<div class="content" id="main-content">
  <!-- Start: Welcome -->
  <div class="welcome-box">
    <h2>Admin Dashboard</h2>
    <p>Angemeldet als: <?= htmlspecialchars($_SESSION["username"]) ?></p>
    <a href="./logout.php">Logout</a>
  </div>
</div>

<script>
  const username = "<?php echo $username; ?>"; // Variable aus PHP ins JS

  const links = document.querySelectorAll('.sidebar a');
  const content = document.getElementById('main-content');

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      links.forEach(l => l.classList.remove('active'));
      this.classList.add('active');

      const section = this.dataset.section;
      switch(section) {
        case 'welcome':
          content.innerHTML = `
            <div class="welcome-box">
              <h2>Willkommen, ${username}!</h2>
              <p>Hier siehst du eine Übersicht und kannst über die Buttons neue Bereiche öffnen:</p>
              <div class="button-panel">
                <button onclick="window.location.href='./users.php'">Benutzer erstellen</button>
                <button onclick="window.location.href='./admin.php'">Tickets verwalten</button>
                <button onclick="window.location.href='./deleted_tickets.php'">Gelöschte Tickets</button>
                <button onclick="window.location.href='./settings.php'">Persönliche Einstellungen</button>
              </div>
            </div>`;
          break;
        case 'tickets':
          content.innerHTML = '<h2>Tickets</h2><p>Tickets-Panel wird hier geladen...</p>';
          break;
        case 'users':
          content.innerHTML = '<h2>Benutzerverwaltung</h2><p>Hier kannst du Benutzer hinzufügen, bearbeiten oder löschen.</p>';
          break;
        case 'settings':
          content.innerHTML = '<h2>Persönliche Einstellungen</h2><p>Hier kannst du dein Passwort oder andere Einstellungen ändern.</p>';
          break;
        default:
          content.innerHTML = '<p>Unbekannte Sektion</p>';
      }
    });
  });
</script>

</body>
</html>
