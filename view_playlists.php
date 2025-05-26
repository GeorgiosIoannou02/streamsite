<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM playlists WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
foreach ($stmt as $pl) {
    echo "<h3>" . htmlspecialchars($pl['title']) . "</h3>";
    $vstmt = $pdo->prepare("SELECT * FROM playlist_items WHERE playlist_id = ?");
    $vstmt->execute([$pl['id']]);
    foreach ($vstmt as $v) {
        echo "<p><b>" . htmlspecialchars($v['title']) . "</b><br><iframe width='300' height='200' src='https://www.youtube.com/embed/" . htmlspecialchars($v['youtube_id']) . "' allowfullscreen></iframe></p>";
    }
}
?>
<a href='create_playlist.php'>+ Δημιουργία Λίστας</a><br>
<a href='add_video.php'>+ Προσθήκη Video</a><br>
<a href='search_playlists.php'>Αναζήτηση</a><br>
<a href='export_yaml.php'>Εξαγωγή YAML</a>