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
    <input type="text" name="q" placeholder="Αναζήτηση σε λίστες ή τίτλους video..." required>
    <button type="submit">Αναζήτηση</button>
</form>

<?php if (!empty($results)): ?>
    <h3>Αποτελέσματα:</h3>
    <?php foreach ($results as $row): ?>
        <p>
            <strong>Λίστα:</strong> <?= htmlspecialchars($row['playlist_title']) ?><br>
            <strong>Video:</strong> <?= htmlspecialchars($row['video_title']) ?><br>
            <iframe width="300" height="200" src="https://www.youtube.com/embed/<?= htmlspecialchars($row['youtube_id']) ?>" frameborder="0" allowfullscreen></iframe>
        </p>
        <hr>
    <?php endforeach; ?>
<?php elseif (isset($_GET['q'])): ?>
    <p>Δεν βρέθηκαν αποτελέσματα.</p>
<?php endif; ?>
