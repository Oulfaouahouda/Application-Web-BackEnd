<?php
include '../../include/db.php';
include '../../include/functions.php';

$conn = connect();
$requette = "SELECT * FROM categorie";
$resultat = $conn->query($requette);
$categories = $resultat->fetchAll();

jsonResponse($categories);
?>
