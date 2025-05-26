<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    session_destroy();
    echo "Ο λογαριασμός διαγράφηκε. <a href='register.php'>Εγγραφή</a>";
    exit;
}
?>
<form method="POST">
    <p>Είστε σίγουρος;</p>
    <input type="hidden" name="confirm" value="1">
    <button type="submit">Ναι, διαγραφή</button>
</form>