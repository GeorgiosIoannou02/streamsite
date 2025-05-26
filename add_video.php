<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$playlists = $pdo->prepare("SELECT * FROM playlists WHERE user_id = ?");
$playlists->execute([$_SESSION['user_id']]);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $playlist_id = $_POST['playlist_id'];
    $title = $_POST['title'];
    $youtube_id = $_POST['youtube_id'];
    $stmt = $pdo->prepare("INSERT INTO playlist_items (playlist_id, title, youtube_id) VALUES (?, ?, ?)");
    $stmt->execute([$playlist_id, $title, $youtube_id]);
    echo "Το video προστέθηκε! <a href='view_playlists.php'>Προβολή</a>";
}
?>
<form method="POST">
    <label>Λίστα:
        <select name="playlist_id">
            <?php foreach ($playlists as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <input name="title" placeholder="Τίτλος Video" required><br>
    <input name="youtube_id" placeholder="YouTube ID (π.χ. dQw4w9WgXcQ)" required><br>
    <button type="submit">Προσθήκη Video</button>
</form>
