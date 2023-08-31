<?php
require './database/config.php';

class ProductService
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $stmt = $this->conn->prepare(
            "SELECT prd.name, prd.price, prd.type, prd.stock, img.url AS image_url
            FROM product prd
            LEFT JOIN images img
            ON prd.id = img.productfk"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT id FROM product WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($data)
    {
        $name = $data["name"];
        $price = $data["price"];
        $brand = $data["brand"];
        $type = $data["type"];
        $stock = $data["stock"];

        $stmt = $this->conn->prepare(
            "INSERT INTO product (name, price, brand, type, stock) 
            VALUES (:name, :price, :brand, :type, :stock)"
        );
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':brand', $brand);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':stock', $stock);
        echo $stmt->execute();
    }

    public function putProduct($id, $data)
    {
        $name = $data["name"];
        $price = $data["price"];
        $brand = $data["brand"];
        $type = $data["type"];
        $stock = $data["stock"];
        var_dump($stock);
        $checkProductFk = $this->getProductById($id);
        if ($checkProductFk) {
            $stmt = $this->conn->prepare(
                "UPDATE product 
            SET name = :name, price = :price, brand = :brand, type = :type, stock = :stock
            WHERE id = :id"
            );
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':stock', $stock);
            echo 'produto atualizado';
            return $stmt->execute();
        }
        echo 'produto inexistente';
    }


    public function deleteProduct($data)
    {
        $id = $data["id"];
        $checkProductFk = $this->getProductById($id);
        if ($checkProductFk) {
            $stmt = $this->conn->prepare(
                "DELETE FROM product WHERE id = :id"
            );
            $stmt->bindParam(':id', $id);
            echo json_encode(['message' => 'Produto excluído.']);
            return $stmt->execute();
        }
        echo 'produto inexistente';
    }

    public function addImage($data)
    {
        $url = $data['url'];
        $productfk = $data['product'];

        $checkProductFk = $this->getProductById($productfk);
        if ($checkProductFk) {
            $stmt = $this->conn->prepare(
                "INSERT INTO images (url, productfk) 
                VALUES (:url, :productfk)"
            );
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':productfk', $productfk);
            echo json_encode(['message' => 'Imagem inserida.']);
            return $stmt->execute();
        }

        echo 'produto inexistente';
    }
}

$productService = new ProductService($conn);
