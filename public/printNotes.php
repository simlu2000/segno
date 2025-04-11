<?php
$conn = new mysqli("localhost", "root", "", "segno");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $_SESSION["email"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];

    // Prendo le note dal database
    $stmt = $conn->prepare("SELECT * FROM notes WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div id='note_" . $row['id'] . "'>";
            echo "<div class='note' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin: 10px 0;'>";
            echo "<button class='edit' onclick='editNote(" . $row['id'] . ")'><span class='material-icons'>edit</span></button>";
            echo "<button class='delete' onclick='deleteNote(" . $row['id'] . ")'><span class='material-icons'>delete</span></button>";

            echo "<form class='edit-form' id='form_" . $row['id'] . "' style='display: none; margin-top:10px;' onsubmit='return submitEdit(" . $row['id'] . ")'>";
            echo "<input type='text' name='title' value='" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "' required>";
            echo "<input type='text' name='category' value='" . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . "' required>";
            echo "<textarea name='body' required>" . htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8') . "</textarea>";
            echo "<button type='submit'>Salva</button>";
            echo "<button type='button' onclick='cancelEdit(" . $row['id'] . ")'>Annulla</button>";
            echo "</form>";

            echo "<h2>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . "</h2>";
            echo "<p><strong>Categoria:</strong> " . htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "<p>" . htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8') . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div id='notebox'>";
        echo "<h3 class='errorNote'>Non ci sono note.</h3>";
        echo "</div>";
    }
} else {
    echo "Utente non trovato";
}

?>
<script>
    function deleteNote(noteId) {
        if (confirm("Sei sicuro di voler eliminare questa nota?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteNote.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            //rimuovo nota dal DOM senza ricaricare la pagina
                            const noteBox = document.getElementById("note_" + noteId);
                            if (noteBox) {
                                noteBox.remove();
                            }
                        } else {
                            alert(response.message);
                        }
                    } catch (e) {
                        alert("Errore nel parsing della risposta del server");
                    }
                }
            };

            xhr.send("noteId=" + noteId);
        }
    }

    function editNote(noteId) { //quanndo clicco su edit
    //mostra form di modifica
    document.getElementById("form_" + noteId).style.display = "block";
}

function cancelEdit(noteId) {
    //nasconde form senza salvare
    document.getElementById("form_" + noteId).style.display = "none";
}

function submitEdit(noteId) {
    const form = document.getElementById("form_" + noteId);
    const formData = new FormData(form); //creo un oggetto FormData con i dati del form
    formData.append("noteId", noteId); //aggiungo l'ID della nota

    const xhr = new XMLHttpRequest(); //creo una nuova richiesta
    xhr.open("POST", "editNote.php", true); //invio la richiesta al server

    xhr.onreadystatechange = function() { //quando la richiesta è completata
        //controllo se la richiesta è completata e se il server ha risposto con successo
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert("Nota modificata con successo!");
                    location.reload(); //oppure aggiorno solo il DOM
                } else {
                    alert(response.message);
                }
            } catch (e) {
                alert("Errore nel parsing della risposta del server");
            }
        }
    };

    xhr.send(formData);
    return false; // Evita il submit classico del form
}

</script>

<?php
$stmt->close();
$conn->close();
?>