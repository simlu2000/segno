<?php
session_start();

if (isset($_POST['noteId'])) {
    $noteId = $_POST['noteId'];
    
    // Connessione al database
    $conn = new mysqli("localhost", "root", "", "segno");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verifica se l'utente è loggato
    if (isset($_SESSION['email'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $_SESSION["email"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            // Elimina la nota solo se appartiene all'utente loggato
            $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND userId = ?");
            $stmt->bind_param("ii", $noteId, $userId);
            if ($stmt->execute()) {
                echo "Nota eliminata con successo.";
            } else {
                echo "Errore nell'eliminazione della nota.";
            }
        } else {
            echo "Utente non trovato.";
        }
    } else {
        echo "Utente non loggato.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID nota mancante.";
}
?>
