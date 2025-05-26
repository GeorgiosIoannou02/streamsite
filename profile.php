<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
echo "Καλώς ήρθες, χρήστη #" . $_SESSION['user_id'];
?>
<br><a href="logout.php">Αποσύνδεση</a>
<br><a href="view_playlists.php">Οι λίστες μου</a>
<br><a href="delete_account.php" style="color:red;">Διαγραφή λογαριασμού</a>