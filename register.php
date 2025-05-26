<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash)
                           VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([$first, $last, $username, $email, $password]);
        echo "Επιτυχής εγγραφή! <a href='login.php'>Σύνδεση</a>";
    } catch (PDOException $e) {
        echo "Σφάλμα: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <input name="first_name" placeholder="Όνομα" required><br>
    <input name="last_name" placeholder="Επώνυμο" required><br>
    <input name="username" placeholder="Username" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Κωδικός" required><br>
    <button type="submit">Εγγραφή</button>
</form>