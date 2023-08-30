<?php
require './database/config.php';

class ProductService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getProduct() {
        $stmt = $this->conn->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($data) {
        $stmt = $this->conn->prepare("INSERT INTO tasks (data) VALUES (:data)");
        $stmt->bindParam(':data', $data);
        return $stmt->execute();
    }

    public function completeTask($id) {
        $stmt = $this->conn->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

$productService = new ProductService($conn);
?>
