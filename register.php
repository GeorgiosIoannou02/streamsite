<?php
require 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash) VALUES (?, ?, ?, ?, ?)");
    try {
        $stmt->execute([
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['username'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);
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