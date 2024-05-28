<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];
$full_name = $data['full_name'];
$email = $data['email'];
$country = $data['country'];
$city = $data['city'];

$conn = connect();
$requette = "UPDATE users SET full_name = ?, email = ?, country = ?, city = ? WHERE id = ?";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$full_name, $email, $country, $city, $id]);

if ($result) {
    jsonResponse(['message' => 'User updated successfully']);
} else {
    jsonResponse(['message' => 'Failed to update user'], 500);
}
?>
