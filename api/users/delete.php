<?php
include '../../include/db.php';
include '../../include/functions.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$conn = connect();
$requette = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($requette);
$result = $stmt->execute([$id]);

if ($result) {
    jsonResponse(['message' => 'User deleted successfully']);
} else {
    jsonResponse(['message' => 'Failed to delete user'], 500);
}
?>
