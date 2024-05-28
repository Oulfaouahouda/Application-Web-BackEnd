<?php
session_start(); // Démarrer la session

include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = md5($data['password']); // Utiliser md5 pour correspondre avec l'ajout d'utilisateur

$conn = connect();
$query = "SELECT * FROM users WHERE email = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$email, $password]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    jsonResponse(['message' => 'Login successful']);
} else {
    http_response_code(401); // Unauthorized
    jsonResponse(['message' => 'Invalid credentials']);
}
?>
