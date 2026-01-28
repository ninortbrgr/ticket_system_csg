<?php
session_start();
if (!isset($_SESSION["unlocked"])) {
    header("Location: ../index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Schul-IT Ticketsystem</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
</head>
<body>
  <div class="container">
    <div class="header-with-image">
      <h2>CSG IT Ticket System</h2>
      <img src="../img/csg.png" width="100" />
    </div>

    <form action="../php/save_ticket.php" method="post">
      <label for="title">Betreff</label>
      <input type="text" id="title" name="title" required />

      <label for="description">Problem-Beschreibung</label>
      <textarea id="description" name="description" rows="5" required></textarea>

      <label for="room">Raum</label>
      <input type="number" id="room" name="room" required />

      <label for="name">Name, Vorname</label>
      <input type="text" id="name" name="name" required>

      <label for="category">Kategorie</label>
        <select id="category" name="category">
          <option value="Whiteboard">Whiteboard</option>
          <option value="Internet">Internet</option>
          <option value="Schülerportal">Schülerportal</option>
          <option value="Ipad(Koffer)">Ipad(Koffer)</option>
          <option value="Apple TV">Apple TV</option>
          <option value="DocuCam">Docu Kamera</option>
          <option value="Sonstiges">Sonstiges</option>
        </select>
      
      <button type="submit">Ticket absenden</button>
      <a href="../pages/login.html" class="login-btn">Admin Login</a>

    </form>
  </div>
</body>
</html>
