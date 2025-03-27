<?php
session_start();
$email = $_SESSION["email"];
$username = $_SESSION["username"];
$category = $_POST['category'];

// Connessione al database
$conn = new mysqli("localhost", "root", "", "segno");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controllo se l'utente esiste già
//uso una query preparata per evitare SQL injection
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?"); // Preparo la query
$stmt->bind_param("s", $email); // Collego i parametri della query con le variabili PHP che contengono i dati. "s" sta per stringa
$stmt->execute(); // Eseguo la query
$result = $stmt->get_result(); // Ottengo il risultato della query

if ($result->num_rows > 0) { // Se l'utente esiste già
    //se utente esiste già, prendo id e inserisco la nota nel database
    $row = $result->fetch_assoc();
    $userId = $row['id'];

    // Inserisco la nota nel database
    $stmt = $conn->prepare("INSERT INTO categories(catname,userId) VALUES ('$category', '$userId')");
    $stmt->execute(); // Eseguo la query
    $result = $stmt->get_result(); // Ottengo il risultato della query
    $_SESSION["message"] = "Categoria aggiunta con successo";
    header("Location: notes.php"); 
} else {
    echo "Utente non trovato";
}

$stmt->close(); // Chiudo lo statement
$conn->close(); // Chiudo la connessione al database
?>
