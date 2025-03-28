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
    $stmt = $conn->prepare("SELECT catname FROM categories WHERE userId = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // Se ci sono categorie
        echo "<select id='category' name='category' required>";
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['catname'] . "'>" . $row['catname'] . "</option>";
        }
        echo "</select>";
    } else {
        echo "<p class='message-note'>Non ci sono categorie inserite
                                    </p>";
    }
} else {
    echo "Utente non trovato";
}
$stmt->close();
$conn->close();
