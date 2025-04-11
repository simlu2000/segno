<?php
session_start();
$conn = new mysqli("localhost", "root", "", "segno");
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Errore connessione DB."]));
}

$noteId = $_POST['noteId'];
$title = $_POST['title'];
$category = $_POST['category'];
$body = $_POST['body'];

$stmt = $conn->prepare("UPDATE notes SET title = ?, category = ?, body = ? WHERE id = ?");
$stmt->bind_param("sssi", $title, $category, $body, $noteId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Errore aggiornamento nota."]);
}

$stmt->close();
$conn->close();
?>
