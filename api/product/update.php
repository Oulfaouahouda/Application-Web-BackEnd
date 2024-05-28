<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$name = $data['name'];
$description = $data['description'];
$price = $data['price'];
$category_id = $data['category_id'];

$conn = connect();
$requette = "UPDATE product SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$name, $description, $price, $category_id, $id]);

if ($result) {
    jsonResponse(['message' => 'Product updated successfully']);
} else {
    jsonResponse(['message' => 'Failed to update product'], 500);
}
?>
