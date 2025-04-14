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

    if (isset($_GET["search"])) {
        $searchTerm = "%" . $_GET["search"] . "%"; // . per concatenare le stringhe. % per like 
        $stmt = $conn->prepare("SELECT * FROM notes WHERE userId = ? AND (title LIKE ? OR body LIKE ? OR category LIKE ?)");
        $stmt->bind_param("isss", $userId, $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
    } else { //altrimenti se non ce parola cercata prendo tutto dalla tabella
        $stmt = $conn->prepare("SELECT * FROM notes WHERE userId = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    if ($result->num_rows > 0) {
        if (isset($_GET["search"])) {
            echo "<p class='search-result'>Risultati per: " . htmlspecialchars($_GET["search"], ENT_QUOTES, 'UTF-8') . "<button style='font-size: 24px; width:10px; height:50px; background: none; border: none; color: #f44336; cursor: pointer;' title='Cancella ricerca' onclick='reloadNotes()'>&times;</button></p>";
        }

        while ($row = $result->fetch_assoc()) {
            echo "<div id='note_" . $row['id'] . "'>";
            echo "<div class='note' style='border: 1px solid #ccc; border-radius: 8px; padding: 10px; margin: 10px 0;'>";
            echo "<button class='edit' onclick='editNote(" . $row['id'] . ")'><span class='material-icons'>edit</span></button>";
            echo "<button class='delete' onclick='deleteNote(" . $row['id'] . ")'><span class='material-icons'>delete</span></button>";

            /*form modifica nota*/
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
            const xhr = new XMLHttpRequest(); //creo oggetto XMLHttpRequest per inviare la richiesta al server
            // Configuro la richiesta HTTP: metodo POST e URL del file PHP che gestisce l'eliminazione
            xhr.open("POST", "deleteNote.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); //imposto l'header della richiesta per indicare il tipo di contenuto
            
            // Definisco cosa fare quando cambia lo stato della richiesta
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

    // Funzione per inviare i dati di modifica di una nota al server
    function submitEdit(noteId) {
        // Seleziono il form specifico legato all'ID della nota
        const form = document.getElementById("form_" + noteId);

        // Creo un oggetto FormData con i dati inseriti nel form della singola nota
        // FormData è un oggetto che permette di costruire un insieme di coppie chiave/valore
        const formData = new FormData(form);

        // Aggiungo anche l'ID della nota tra i dati da inviare
        formData.append("noteId", noteId);

        // Creo un oggetto XMLHttpRequest per inviare i dati al server
        const xhr = new XMLHttpRequest();

        // Configuro la richiesta HTTP: metodo POST e URL del file PHP che gestisce la modifica
        xhr.open("POST", "editNote.php", true);

        // Definisco cosa fare quando cambia lo stato della richiesta
        xhr.onreadystatechange = function() {
            // Verifico che la richiesta sia completata (readyState 4) e che il server abbia risposto correttamente (status 200)
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    // Provo a convertire la risposta del server da JSON a oggetto JS
                    const response = JSON.parse(xhr.responseText);

                    // Se il server ha confermato la modifica con successo
                    if (response.success) {
                        alert("Nota modificata con successo!");
                        // Ricarico la pagina per mostrare i cambiamenti (oppure potrei aggiornare il DOM dinamicamente)
                        location.reload();
                    } else {
                        // Se il server ha restituito un errore, mostro il messaggio
                        alert(response.message);
                    }
                } catch (e) {
                    // Se c'è un errore nel parsing della risposta JSON, avviso l'utente
                    alert("Errore nel parsing della risposta del server");
                }
            }
        };

        // Invio i dati del form al server
        xhr.send(formData);

        // Impedisco l'invio classico del form (che ricaricherebbe la pagina)
        return false;
    }


    function reloadNotes() {
        window.location.href = "notes.php";
    }
</script>

<?php
$stmt->close();
$conn->close();
?>