<?php
session_start();
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$full_name = $data['full_name'];
$email = $data['email'];
$password = md5($data['password']); // Encrypt the password
$country = $data['country'];
$city = $data['city'];

$conn = connect();
$query = "INSERT INTO users (full_name, email, password, country, city) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$result = $stmt->execute([$full_name, $email, $password, $country, $city]);

if ($result) {
    jsonResponse(['message' => 'User created successfully']);
} else {
    http_response_code(500);
    jsonResponse(['message' => 'Failed to create user']);
}

function jsonResponse($data, $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
}
?>
