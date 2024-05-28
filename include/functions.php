<?php

function connect() {
  // 1- Connexion avec la BD
  $servername = "localhost";
  $DBuser = "root";
  $DBpassword = "";
  $DBname = "e-commerce";

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBuser, $DBpassword);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }

    return $conn;
}

function getAllCategories() {
    
    // 1- Connexion avec la BD / Appel fonction connect
    $conn = connect();
    
    // 2- Creation de la requette
    $requette = "SELECT * FROM categorie";
    
    // 3- Execution de la requette
    $resultat = $conn->query($requette);
    
    // 4- Resultat de la requette
    $categorie = $resultat->fetchAll();
    
    //var_dump($categorie);
    

    return $categorie;
}

function getAllProducts() {
    
    // 1- Connexion avec la BD / Appel fonction connect
    $conn = connect();
    
    // 2- Creation de la requette
    $requette = "SELECT * FROM product";
    
    // 3- Execution de la requette
    $resultat = $conn->query($requette);
    
    // 4- Resultat de la requette
    $product = $resultat->fetchAll();
    
    //var_dump($product);
    

    return $product;
}

function searchProduct($keywords) {
  // 1- Connexion avec la BD / Appel fonction connect
  $conn = connect();
      // 2- Creation de la requette
  $requette = "SELECT * FROM product WHERE name LIKE '%$keywords%' ";
    
  // 3- Execution de la requette
  $resultat = $conn->query($requette);
  
  // 4- Resultat de la requette
  $product = $resultat->fetchAll();
  
  //var_dump($product);
  return $product;

}

function getProductById($id) {
      $conn = connect();

      $requette = "SELECT * FROM product WHERE id=$id";

      $resultat = $conn->query($requette);

      $product = $resultat->fetch(); //fetch c pour ramener un seul element de la bd contrairement à fetchAll

      return $product;
}

function AddVisiteur($data){
      $conn = connect();
      $passwordHash = md5($data['password']);
      $requette = "INSERT INTO visiteur(full_name,email,password,country,city) VALUES('".$data['full_name']."','".$data['email']."','".$passwordHash."','".$data['country']."','".$data['city']."')";

      $resultat = $conn->query($requette); 

      if ($resultat) {
        return true;
      }
      else {
        return false; 
      }
}

function ConnectVisiteur($data){
    $conn = connect();

    $email = $data['email'];
    $password = md5($data['password']);
    $requette = "SELECT * FROM visiteur WHERE email='$email' AND password='$password'";

    $resultat = $conn->query($requette);

    $user = $resultat->fetch(); //fetch c pour ramener un seul element de la bd contrairement à fetchAll

    return $user;
}

function ConnectAdmin($data) {
  
    $conn = connect();
    $email = $data['email'];
    $password = md5($data['password']);
    $requette = "SELECT * FROM administrateur WHERE email='$email' AND password='$password'";

    $resultat = $conn->query($requette);

    $user = $resultat->fetch(); //fetch c pour ramener un seul element de la bd contrairement à fetchAll

    return $user;
}
?>

<?php
function jsonResponse($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
