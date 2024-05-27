<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$cart_id = $data['cart_id']; // L'identifiant de l'élément du panier à mettre à jour
$new_quantity = $data['quantity']; // La nouvelle quantité du produit dans le panier

$conn = connect();
$query = "UPDATE cart SET quantity = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$result = $stmt->execute([$new_quantity, $cart_id]);

if ($result) {
    jsonResponse(['message' => 'Cart item quantity updated successfully']);
} else {
    jsonResponse(['message' => 'Failed to update cart item quantity'], 500);
}
?>
