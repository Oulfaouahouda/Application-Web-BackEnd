<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$name = $data['name'];
$description = $data['description'];

$conn = connect();
$requette = "UPDATE categorie SET name = ?, description = ? WHERE id = ?";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$name, $description, $id]);

if ($result) {
    jsonResponse(['message' => 'Category updated successfully']);
} else {
    jsonResponse(['message' => 'Failed to update category'], 500);
}
?>
