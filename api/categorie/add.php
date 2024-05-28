<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$description = $data['description'];
$date_creation = date("Y-m-d");

$conn = connect();
$requette = "INSERT INTO categorie (name, description, date_creation) VALUES (?, ?, ?)";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$name, $description, $date_creation]);

if ($result) {
    jsonResponse(['message' => 'Category created successfully']);
} else {
    jsonResponse(['message' => 'Failed to create category'], 500);
}
?>
