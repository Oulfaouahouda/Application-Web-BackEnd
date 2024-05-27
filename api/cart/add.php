<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id'];
$product_id = $data['product_id'];
$quantity = $data['quantity'];

$conn = connect();
$query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$result = $stmt->execute([$user_id, $product_id, $quantity]);

if ($result) {
    jsonResponse(['message' => 'Product added to cart successfully']);
} else {
    jsonResponse(['message' => 'Failed to add product to cart'], 500);
}
?>
