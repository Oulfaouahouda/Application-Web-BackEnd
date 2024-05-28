<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase {
    protected $db;

    protected function setUp(): void {
        // Configurer la base de données pour les tests
        $this->db = new PDO('sqlite::memory:'); // Utilisez SQLite en mémoire pour les tests
        $this->db->exec("CREATE TABLE cart (id INTEGER PRIMARY KEY, product_id INTEGER, quantity INTEGER)");

        // Injection de la base de données pour les scripts API
        include_once __DIR__ . '/../../include/db.php';
        $GLOBALS['db'] = $this->db;
    }

    public function testAddToCart() {
        // Simuler une requête POST
        $_POST['product_id'] = 1;
        $_POST['quantity'] = 2;

        // Inclure le fichier add.php
        ob_start();
        include __DIR__ . '/../../api/cart/add.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM cart WHERE product_id = 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($result, 'L\'article n\'a pas été ajouté au panier.');
        $this->assertEquals(2, $result['quantity'], 'La quantité de l\'article est incorrecte.');
    }

    public function testDeleteFromCart() {
        // Ajouter un article au panier pour le supprimer
        $this->db->exec("INSERT INTO cart (product_id, quantity) VALUES (1, 2)");
        $stmt = $this->db->query("SELECT id FROM cart WHERE product_id = 1");
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $item['id'];

        // Inclure le fichier delete.php
        ob_start();
        include __DIR__ . '/../../api/cart/delete.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM cart WHERE id = {$item['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($result, 'L\'article n\'a pas été supprimé du panier.');
    }

    public function testGetCartItems() {
        // Ajouter quelques articles au panier pour les récupérer
        $this->db->exec("INSERT INTO cart (product_id, quantity) VALUES (1, 2)");
        $this->db->exec("INSERT INTO cart (product_id, quantity) VALUES (2, 3)");

        // Inclure le fichier get.php
        ob_start();
        include __DIR__ . '/../../api/cart/get.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $result = json_decode($output, true);

        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(2, $result, 'Il doit y avoir deux articles dans le panier.');
    }

    public function testUpdateCartItem() {
        // Ajouter un article au panier pour le mettre à jour
        $this->db->exec("INSERT INTO cart (product_id, quantity) VALUES (1, 2)");
        $stmt = $this->db->query("SELECT id FROM cart WHERE product_id = 1");
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $item['id'];
        $_POST['quantity'] = 5;

        // Inclure le fichier update.php
        ob_start();
        include __DIR__ . '/../../api/cart/update.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM cart WHERE id = {$item['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals(5, $result['quantity'], 'La quantité de l\'article n\'a pas été mise à jour.');
    }

    protected function tearDown(): void {
        // Nettoyer la base de données
        $this->db = null;
    }
}
