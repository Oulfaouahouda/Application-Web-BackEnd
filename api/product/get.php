<?php
include '../../include/db.php';
include '../../include/functions.php';

$conn = connect();
$requette = "SELECT * FROM product";
$resultat = $conn->query($requette);
$products = $resultat->fetchAll();

jsonResponse($products);
?>
