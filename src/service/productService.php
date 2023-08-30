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
        $name = $data["name"];
        $price = $data["price"];
        $brand = $data["brand"];
        $type = $data["type"];
        $stock = $data["stock"];

        $stmt = $this->conn->prepare(
            "INSERT INTO product (name, price, brand, type, stock) 
            VALUES (:name, :price, :brand, :type, :stock)"
        );
        var_dump($stmt);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':stock', $stock);
        echo $stmt->execute();
    }

    public function completeTask($id) {
        $stmt = $this->conn->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

$productService = new ProductService($conn);
?>
