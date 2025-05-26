<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ανάκτηση στοιχείων χρήστη
$user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$_SESSION['user_id']]);
$user = $user_stmt->fetch();
$anon_id = hash('sha256', $user['id'] . $user['username']);

// Ανάκτηση λιστών
$playlists_stmt = $pdo->prepare("SELECT * FROM playlists WHERE user_id = ?");
$playlists_stmt->execute([$user['id']]);
$playlists = $playlists_stmt->fetchAll();

header('Content-Type: text/yaml');
header('Content-Disposition: attachment; filename="export.yaml"');

echo "user: {$anon_id}\n";
echo "playlists:\n";

foreach ($playlists as $pl) {
    echo "  - title: \"{$pl['title']}\"\n";
    echo "    private: " . ($pl['is_private'] ? "true" : "false") . "\n";
    echo "    created_at: \"{$pl['created_at']}\"\n";
    echo "    videos:\n";

    $videos_stmt = $pdo->prepare("SELECT * FROM playlist_items WHERE playlist_id = ?");
    $videos_stmt->execute([$pl['id']]);
    $videos = $videos_stmt->fetchAll();

    foreach ($videos as $v) {
        echo "      - title: \"{$v['title']}\"\n";
        echo "        youtube_id: \"{$v['youtube_id']}\"\n";
        echo "        added_at: \"{$v['added_at']}\"\n";
    }
}
?>
