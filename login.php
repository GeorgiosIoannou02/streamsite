<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: profile.php");
        exit;
    } else {
        echo "Λάθος στοιχεία!";
    }
}
?>

<form method="POST">
    <input name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Κωδικός" required><br>
    <button type="submit">Σύνδεση</button>
</form>