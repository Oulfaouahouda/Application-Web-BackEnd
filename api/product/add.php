<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$description = $data['description'];
$price = $data['price'];
$category_id = $data['category_id'];

$conn = connect();
$requette = "INSERT INTO product (name, description, price, category_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$name, $description, $price, $category_id]);

if ($result) {
    jsonResponse(['message' => 'Product created successfully']);
} else {
    jsonResponse(['message' => 'Failed to create product'], 500);
}
?>
