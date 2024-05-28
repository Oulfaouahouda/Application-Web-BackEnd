<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase {
    protected $db;

    protected function setUp(): void {
        // Configurer la base de données pour les tests
        $this->db = new PDO('sqlite::memory:'); // Utilisez SQLite en mémoire pour les tests
        $this->db->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, email TEXT)");

        // Injection de la base de données pour les scripts API
        include_once __DIR__ . '/../../include/db.php';
        $GLOBALS['db'] = $this->db;
    }

    public function testAddUser() {
        // Simuler une requête POST
        $_POST['name'] = 'Test User';
        $_POST['email'] = 'testuser@example.com';

        // Inclure le fichier add.php
        ob_start();
        include __DIR__ . '/../../api/users/add.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM users WHERE email = 'testuser@example.com'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($result, 'L\'utilisateur n\'a pas été ajouté.');
        $this->assertEquals('Test User', $result['name'], 'Le nom de l\'utilisateur est incorrect.');
    }

    public function testDeleteUser() {
        // Ajouter un utilisateur pour le supprimer
        $this->db->exec("INSERT INTO users (name, email) VALUES ('User to Delete', 'deleteuser@example.com')");
        $stmt = $this->db->query("SELECT id FROM users WHERE email = 'deleteuser@example.com'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $user['id'];

        // Inclure le fichier delete.php
        ob_start();
        include __DIR__ . '/../../api/users/delete.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM users WHERE id = {$user['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($result, 'L\'utilisateur n\'a pas été supprimé.');
    }

    public function testGetUsers() {
        // Ajouter quelques utilisateurs pour les récupérer
        $this->db->exec("INSERT INTO users (name, email) VALUES ('User 1', 'user1@example.com')");
        $this->db->exec("INSERT INTO users (name, email) VALUES ('User 2', 'user2@example.com')");

        // Inclure le fichier get.php
        ob_start();
        include __DIR__ . '/../../api/users/get.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $result = json_decode($output, true);

        $this->assertIsArray($result, 'Le résultat doit être un tableau.');
        $this->assertCount(2, $result, 'Il doit y avoir deux utilisateurs dans la base de données.');
    }

    public function testUpdateUser() {
        // Ajouter un utilisateur pour le mettre à jour
        $this->db->exec("INSERT INTO users (name, email) VALUES ('User to Update', 'updateuser@example.com')");
        $stmt = $this->db->query("SELECT id FROM users WHERE email = 'updateuser@example.com'");
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simuler une requête POST
        $_POST['id'] = $user['id'];
        $_POST['name'] = 'Updated User';
        $_POST['email'] = 'updateduser@example.com';

        // Inclure le fichier update.php
        ob_start();
        include __DIR__ . '/../../api/users/update.php';
        $output = ob_get_clean();

        // Vérifier le résultat
        $stmt = $this->db->query("SELECT * FROM users WHERE id = {$user['id']}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Updated User', $result['name'], 'Le nom de l\'utilisateur n\'a pas été mis à jour.');
        $this->assertEquals('updateduser@example.com', $result['email'], 'L\'email de l\'utilisateur n\'a pas été mis à jour.');
    }

    protected function tearDown(): void {
        // Nettoyer la base de données
        $this->db = null;
    }
}
