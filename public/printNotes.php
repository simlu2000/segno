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
            echo "<button class='edit' onclick='editNote(" . $row['id'] . ")'>
            <span class='material-icons'>edit</span></button>";
            echo "<button class='delete' onclick='deleteNote(" . $row['id'] . ")'>
            <span class='material-icons'>delete</span>
          </button>";
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
</script>

<?php
$stmt->close();
$conn->close();
?>