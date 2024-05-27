<?php

    session_start();

// 1. Recuperation des données du formulaire

$id = $_POST['idc'];
$name = $_POST['name'];
$description = $_POST['description'];
$date_modification = date("Y-m-d"); // "2023-05-05"

// 2. Chaine de connexion 

include "../../include/functions.php"; 
$conn = connect();

// 3. Creation de la requette d'execution

$requette = "UPDATE categorie SET name='$name', description='$description', date_modification='$date_modification' WHERE id='$id'";

// 3- Execution de la requette
$resultat = $conn->query($requette);

if ($resultat) { 
    header('location:list.php?modif=ok');
}







?> 
