<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    // Διαγραφή χρήστη και όλων των σχετικών δεδομένων
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    session_destroy();
    echo "Ο λογαριασμός σου διαγράφηκε. <a href='register.php'>Εγγραφή</a>";
    exit;
}
?>

<h2>Διαγραφή λογαριασμού</h2>
<p>Είσαι σίγουρος/η ότι θέλεις να διαγράψεις τον λογαριασμό σου; Αυτή η ενέργεια είναι μη αναστρέψιμη.</p>

<form method="POST">
    <input type="hidden" name="confirm" value="1">
    <button type="submit">Ναι, διαγραφή</button>
</form>
<br>
<a href="profile.php">Ακύρωση</a>
