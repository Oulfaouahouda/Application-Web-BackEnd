<?php
// Fonction pour récupérer les détails d'un produit par son ID
function getProductById($productId) {
    $conn = connect();
    
    // Préparez la requête SQL pour récupérer les détails du produit par son ID
    $sql = "SELECT * FROM product WHERE id = :id";

    // Préparez la requête pour exécution
    $stmt = $conn->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':id', $productId);

    // Exécutez la requête
    $stmt->execute();

    // Récupérez le résultat sous forme de tableau associatif
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retournez les détails du produit
    return $product;
}

function jsonResponse($data, $status = 200) {
    header("Content-Type: application/json");
    http_response_code($status);
    echo json_encode($data);
    exit;
}
?>
