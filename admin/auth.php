<?php

// oturumu başlatıyorum
session_start();

// ihtiyaç olan dosyaları çağırıyorum
require_once '../includes/Database.php';

// gerekli nesneleri oluşturuyorum
$database = new Database();
$db = $database->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // sorgu metnini hazırlıyorum
    $query = "SELECT * FROM Users WHERE username = :username";
    
    // hazırlık
    $statement = $db->prepare($query);

    // çalıştırıp hata var mı diye deniyorum
    try {

        if($statement->execute([':username' => $username])) {

            // user verisini atıyorum
            $user = $statement->fetch();

            if($user) {
                if(password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: dashboard.php");
                    exit;
                }
                else {
                    header("Location: login.php?error=kullanici_bulunamadi");
                    exit;
                }
            }
            else{
                header("Location: login.php?error=kullanici_bulunamadi");
                exit;
            }
        }
    }
    catch(PDOException $e) {
        echo "Giriş hatası: " . $e->getMessage();
    }
}