<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$full_name = $data['full_name'];
$email = $data['email'];
$password = md5($data['password']);
$country = $data['country'];
$city = $data['city'];

$conn = connect();
$requette = "INSERT INTO users (full_name, email, password, country, city) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$full_name, $email, $password, $country, $city]);

if ($result) {
    jsonResponse(['message' => 'User created successfully']);
} else {
    jsonResponse(['message' => 'Failed to create user'], 500);
}
?>
