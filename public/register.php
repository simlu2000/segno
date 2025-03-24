<?php
session_start();

$username = $_POST['registerUsername'];
$email = $_POST['registerEmail'];
$password = $_POST['registerPassword'];

// Connessione al database
$conn = new mysqli("localhost", "root", "", "segno");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controllo se l'utente esiste già
//uso una query preparata per evitare SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?"); // Preparo la query
$stmt->bind_param("s", $email); // Collego i parametri della query con le variabili PHP che contengono i dati. "s" sta per stringa
$stmt->execute(); // Eseguo la query
$result = $stmt->get_result(); // Ottengo il risultato della query

if ($result->num_rows > 0) { // Se l'utente esiste già
    echo "Utente già registrato";
} else {
    // Hash della password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Inserisco l'utente nel database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword); // sss per tre stringhe

    if ($stmt->execute()) { // Eseguo la query
        echo "Utente registrato con successo";
        $_SESSION["email"] = $email; // Salvo l'email dell'utente nella sessione
        $_SESSION["username"] = $username; // Salvo l'username dell'utente nella sessione
        header("Location: index.php"); // Reindirizzo l'utente alla home page
    } else {
        echo "Errore: " . $stmt->error;
    }
}

$stmt->close(); // Chiudo lo statement
$conn->close(); // Chiudo la connessione al database
?>
