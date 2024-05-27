<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data['user_id']; // L'identifiant de l'utilisateur dont le panier doit être récupéré

$conn = connect();
$query = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

jsonResponse(['cart_items' => $cart_items]);
?>
