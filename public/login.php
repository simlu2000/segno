<?php
session_start();

$email = $_POST['loginEmail'];
$password = $_POST['loginPassword'];

// Connessione al database
$conn = new mysqli("localhost", "root", "", "segno");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se l'utente esiste
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Ottieni i dati dell'utente come array associativo 

    // Verifica password nel db corripsponda a quella inserita
    if (password_verify($password, $user['password'])) { //se true
        $_SESSION["email"] = $user['email'];
        $_SESSION["username"] = $user['username'];
        header("Location: notes.php");
    } else {
        echo "Password errata";
    }
} else {
    echo "Utente non registrato";
}

$stmt->close();
$conn->close();
?>
