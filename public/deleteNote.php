<?php
session_start();
header("Content-Type: application/json");

if (isset($_POST['noteId'])) {
    $noteId = intval($_POST['noteId']);

    $conn = new mysqli("localhost", "root", "", "segno");
    if ($conn->connect_error) {
        echo json_encode(["success" => false, "message" => "Errore di connessione al database"]);
        exit();
    }

    if (isset($_SESSION['email'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $_SESSION["email"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            // Eliminazione della nota
            $stmt = $conn->prepare("DELETE FROM notes WHERE id = ? AND userId = ?");
            $stmt->bind_param("ii", $noteId, $userId);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Nota eliminata con successo"]);
            } else {
                echo json_encode(["success" => false, "message" => "Errore nell'eliminazione della nota"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Utente non trovato"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Utente non loggato"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "ID nota mancante"]);
}
?>
