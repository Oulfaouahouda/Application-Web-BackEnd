<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase {
    protected $db;

    protected function setUp(): void {
        // Configurer la base de données pour les tests
        $this->db = new PDO('sqlite::memory:'); // Utilisez SQLite en mémoire pour les tests
        $this->db->exec("CREATE TABLE products (id INTEGER PRIMARY KEY, name TEXT, price REAL)");

        // Injection de la base de données pour les scripts API
        include_once __DIR__ . '/../../include/db.php';
        $GLOBALS['db'] = $this->db;
    }

    public function testAddProduct() {
        // Simuler une requête POST
        $_POST['name'] = 'Test Product';
        $_POST['price'] = 9.99;

        // Inclure le fichier add.php
        ob_start();
        include __DIR__ . '/../../api/product/add.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM products WHERE name = 'Test Product'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($result, 'Le produit n\'a pas été ajouté.');
        $this->assertEquals(9.99, $result['price'], 'Le prix du produit est incorrect.');
    }

    public function testDeleteProduct() {
        // Ajouter un produit pour le supprimer
        $this->db->exec("INSERT INTO products (name, price) VALUES ('Product to Delete', 19.99)");
        $stmt = $this->db->query("SELECT id FROM products WHERE name = 'Product to Delete'");
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $product['id'];

        // Inclure le fichier delete.php
        ob_start();
        include __DIR__ . '/../../api/product/delete.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM products WHERE id = {$product['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($result, 'Le produit n\'a pas été supprimé.');
    }

    public function testGetProducts() {
        // Ajouter quelques produits pour les récupérer
        $this->db->exec("INSERT INTO products (name, price) VALUES ('Product 1', 10.00)");
        $this->db->exec("INSERT INTO products (name, price) VALUES ('Product 2', 20.00)");

        // Inclure le fichier get.php
        ob_start();
        include __DIR__ . '/../../api/product/get.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $result = json_decode($output, true);

        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(2, $result, 'Il doit y avoir deux produits dans la base de données.');
    }

    public function testGetSingleProduct() {
        // Ajouter un produit pour le récupérer
        $this->db->exec("INSERT INTO products (name, price) VALUES ('Single Product', 30.00)");
        $stmt = $this->db->query("SELECT id FROM products WHERE name = 'Single Product'");
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête GET
        $_GET['id'] = $product['id'];

        // Inclure le fichier getSingleProduct.php
        ob_start();
        include __DIR__ . '/../../api/product/getSingleProduct.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $result = json_decode($output, true);

        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertEquals('Single Product', $result['name'], 'Le nom du produit est incorrect.');
        $this->assertEquals(30.00, $result['price'], 'Le prix du produit est incorrect.');
    }

    public function testUpdateProduct() {
        // Ajouter un produit pour le mettre à jour
        $this->db->exec("INSERT INTO products (name, price) VALUES ('Product to Update', 40.00)");
        $stmt = $this->db->query("SELECT id FROM products WHERE name = 'Product to Update'");
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $product['id'];
        $_POST['name'] = 'Updated Product';
        $_POST['price'] = 49.99;

        // Inclure le fichier update.php
        ob_start();
        include __DIR__ . '/../../api/product/update.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM products WHERE id = {$product['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Updated Product', $result['name'], 'Le nom du produit n\'a pas été mis à jour.');
        $this->assertEquals(49.99, $result['price'], 'Le prix du produit n\'a pas été mis à jour.');
    }

    protected function tearDown(): void {
        // Nettoyer la base de données
        $this->db = null;
    }
}
