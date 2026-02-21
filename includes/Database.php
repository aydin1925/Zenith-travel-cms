<?php

class Database {

private $host = "localhost";
private $db_name = "zenith_db";
private $username = "root";
private $password = "";

// bağlantı nesnesi oluşturuyorum
public $conn;

// bağlantı fonksiyonu
public function connect() {

    $this->conn = null;

    try{

        // veritabanı bağlantısı yapıyorum
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";

        // pdo nesnesi oluşturuyorum
        $this->conn = new PDO($dsn, $this->username, $this->password);

        // hata modunu açıyorum
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // verilerin varsayılan olarak diziye çevrilmesini sağlıyorum
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }

    return $this->conn;

}

}