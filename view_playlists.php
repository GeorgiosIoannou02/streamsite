<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$stmt = $pdo->prepare("SELECT * FROM playlists WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$playlists = $stmt->fetchAll();

foreach ($playlists as $pl) {
    echo "<h2>" . htmlspecialchars($pl['title']) . "</h2>";
    $videos = $pdo->prepare("SELECT * FROM playlist_items WHERE playlist_id = ?");
    $videos->execute([$pl['id']]);
    foreach ($videos as $v) {
        echo "<p><strong>" . htmlspecialchars($v['title']) . "</strong><br>";
        echo "<iframe width='300' height='200' src='https://www.youtube.com/embed/" . htmlspecialchars($v['youtube_id']) . "' frameborder='0' allowfullscreen></iframe></p>";
    }
}
?>
<a href='create_playlist.php'>+ Δημιουργία νέας λίστας</a><br>
<a href='add_video.php'>+ Προσθήκη Video</a><br>
<a href='profile.php'>↩ Επιστροφή στο προφίλ</a>
