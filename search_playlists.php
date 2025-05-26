<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$results = [];
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['q'])) {
    $query = "%" . $_GET['q'] . "%";
    $stmt = $pdo->prepare("SELECT p.title AS playlist_title, v.title AS video_title, v.youtube_id
                           FROM playlists p
                           JOIN playlist_items v ON p.id = v.playlist_id
                           WHERE p.user_id = ? AND (p.title LIKE ? OR v.title LIKE ?)");
    $stmt->execute([$_SESSION['user_id'], $query, $query]);
    $results = $stmt->fetchAll();
}
?>
<form method="GET">
    <input name="q" placeholder="Αναζήτηση..." required>
    <button type="submit">Αναζήτηση</button>
</form>
<?php foreach ($results as $row): ?>
    <p><b><?= htmlspecialchars($row['playlist_title']) ?></b><br>
    <?= htmlspecialchars($row['video_title']) ?><br>
    <iframe width="300" height="200" src="https://www.youtube.com/embed/<?= htmlspecialchars($row['youtube_id']) ?>"></iframe></p>
<?php endforeach; ?>