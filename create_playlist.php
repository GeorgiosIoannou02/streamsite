<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO playlists (user_id, title, is_private) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['title'], isset($_POST['is_private']) ? 1 : 0]);
    echo "Η λίστα δημιουργήθηκε! <a href='view_playlists.php'>Προβολή λιστών</a>";
}
?>
<form method="POST">
    <input name="title" placeholder="Τίτλος λίστας" required><br>
    <label><input type="checkbox" name="is_private"> Ιδιωτική λίστα</label><br>
    <button type="submit">Δημιουργία Λίστας</button>
</form>