<?php
include '../../include/db.php';
include '../../include/functions.php';

$conn = connect();
$requette = "SELECT * FROM users";
$resultat = $conn->query($requette);
$users = $resultat->fetchAll();

jsonResponse($users);
?>
