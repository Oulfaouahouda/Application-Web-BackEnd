<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$cart_id = $data['cart_id']; // L'identifiant de l'élément du panier à supprimer

$conn = connect();
$query = "DELETE FROM cart WHERE id = ?";
$stmt = $conn->prepare($query);
$result = $stmt->execute([$cart_id]);

if ($result) {
    jsonResponse(['message' => 'Product removed from cart successfully']);
} else {
    jsonResponse(['message' => 'Failed to remove product from cart'], 500);
}
?>
