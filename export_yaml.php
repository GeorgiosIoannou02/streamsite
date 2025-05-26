<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user = $pdo->query("SELECT * FROM users WHERE id = " . $_SESSION['user_id'])->fetch();
$anon_id = hash('sha256', $user['id'] . $user['username']);
$playlists = $pdo->prepare("SELECT * FROM playlists WHERE user_id = ?");
$playlists->execute([$user['id']]);
header('Content-Type: text/yaml');
header('Content-Disposition: attachment; filename="export.yaml"');
echo "user: {$anon_id}\nplaylists:\n";
foreach ($playlists as $pl) {
    echo "  - title: \"{$pl['title']}\"\n    private: " . ($pl['is_private'] ? "true" : "false") . "\n    created_at: \"{$pl['created_at']}\"\n    videos:\n";
    $vstmt = $pdo->prepare("SELECT * FROM playlist_items WHERE playlist_id = ?");
    $vstmt->execute([$pl['id']]);
    foreach ($vstmt as $v) {
        echo "      - title: \"{$v['title']}\"\n        youtube_id: \"{$v['youtube_id']}\"\n        added_at: \"{$v['added_at']}\"\n";
    }
}
?>