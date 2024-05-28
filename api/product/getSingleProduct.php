<?php
include_once '../../include/db.php';
include_once '../../include/functions.php';

// Vérifiez si l'ID du produit est passé dans l'URL
if (isset($_GET['id'])) {
    // Récupérez l'ID du produit depuis l'URL
    $productId = $_GET['id'];

    // Utilisez la fonction pour récupérer les détails du produit en fonction de son ID
    $product = getProductById($productId);

    // Vérifiez si le produit existe
    if ($product) {
        // Retournez les détails du produit au format JSON
        jsonResponse($product);
    } else {
        // Si aucun produit correspondant n'est trouvé, renvoyez une erreur au format JSON
        jsonResponse(array('error' => 'Product not found'), 404);
    }
} else {
    // Si aucun ID de produit n'est passé dans l'URL, renvoyez une erreur au format JSON
    jsonResponse(array('error' => 'Product ID not specified'), 400);
}
?>
