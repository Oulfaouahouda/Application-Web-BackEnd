<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CategorieTest extends TestCase {
    protected $db;

    protected function setUp(): void {
        // Configurer la base de données pour les tests
        $this->db = new PDO('sqlite::memory:'); // Utilisez SQLite en mémoire pour les tests
        $this->db->exec("CREATE TABLE categories (id INTEGER PRIMARY KEY, name TEXT)");

        // Injection de la base de données pour les scripts API
        include_once __DIR__ . '/../../include/db.php';
        $GLOBALS['db'] = $this->db;
    }

    public function testAddCategorie() {
        // Simuler une requête POST
        $_POST['name'] = 'Test Category';

        // Inclure le fichier add.php
        ob_start();
        include __DIR__ . '/../../api/categorie/add.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM categories WHERE name = 'Test Category'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($result, 'La catégorie n\'a pas été ajoutée.');
    }

    public function testDeleteCategorie() {
        // Ajouter une catégorie pour la supprimer
        $this->db->exec("INSERT INTO categories (name) VALUES ('Category to Delete')");
        $stmt = $this->db->query("SELECT id FROM categories WHERE name = 'Category to Delete'");
        $categorie = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $categorie['id'];

        // Inclure le fichier delete.php
        ob_start();
        include __DIR__ . '/../../api/categorie/delete.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM categories WHERE id = {$categorie['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($result, 'La catégorie n\'a pas été supprimée.');
    }

    public function testGetCategories() {
        // Ajouter quelques catégories pour les récupérer
        $this->db->exec("INSERT INTO categories (name) VALUES ('Category 1')");
        $this->db->exec("INSERT INTO categories (name) VALUES ('Category 2')");

        // Inclure le fichier get.php
        ob_start();
        include __DIR__ . '/../../api/categorie/get.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $result = json_decode($output, true);

        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(2, $result, 'Il doit y avoir deux catégories dans la base de données.');
    }

    public function testUpdateCategorie() {
        // Ajouter une catégorie pour la mettre à jour
        $this->db->exec("INSERT INTO categories (name) VALUES ('Category to Update')");
        $stmt = $this->db->query("SELECT id FROM categories WHERE name = 'Category to Update'");
        $categorie = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $categorie['id'];
        $_POST['name'] = 'Updated Category';

        // Inclure le fichier update.php
        ob_start();
        include __DIR__ . '/../../api/categorie/update.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM categories WHERE id = {$categorie['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Updated Category', $result['name'], 'Le nom de la catégorie n\'a pas été mis à jour.');
    }

    protected function tearDown(): void {
        // Nettoyer la base de données
        $this->db = null;
    }
}
