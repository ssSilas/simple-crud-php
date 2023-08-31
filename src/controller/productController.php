<?php
require './src/service/productService.php';

class ProductController
{
    private $productService;

    public function __construct($productService)
    {
        $this->productService = $productService;
    }

    public function getAllProducts()
    {
        $products = $this->productService->getAllProducts();
        header('Content-Type: application/json');
        $response = array(
            'data' => $products
        );

        echo json_encode($response);
    }

    public function addTask($data)
    {
        if ($data) {
            $this->productService->addProduct($data);
            echo json_encode(['message' => 'Tarefa adicionada com sucesso.']);
        } else {
            echo json_encode(['message' => 'Erro ao adicionar tarefa.']);
        }
    }

    public function addImage($data)
    {
        $this->productService->addImage($data);
    }

    public function deleteProduct($id)
    {
        $this->productService->deleteProduct($id);
    }

    public function putProduct($id, $data)
    {
        $this->productService->putProduct($id, $data);
    }
}

$productController = new ProductController($productService);
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

//ROUTES

//PRODUCT
if ($requestMethod === 'GET' && $requestUri == '/product') {
    return $productController->getAllProducts();
}

if ($requestMethod === 'POST' && $requestUri == '/product') {
    $data = json_decode(file_get_contents('php://input'), true);
    return $productController->addTask($data);
}

if ($requestMethod === 'PUT' && preg_match('/\/product/', $requestUri)) {
    $id = $_GET['id'] ?? null;
    $data = json_decode(file_get_contents('php://input'), true);
    return $productController->putProduct($id, $data);
}

if ($requestMethod === 'DELETE' && preg_match('/\/product/', $requestUri)) {
    $id = $_GET['id'] ?? null;
    return $productController->deleteProduct($id);
}

//PRODUCT/IMAGE
if ($requestMethod === 'POST' && $requestUri == '/product/image') {
    $data = json_decode(file_get_contents('php://input'), true);
    return $productController->addImage($data);
} else {
    echo json_encode(['message' => 'Rota inexistente']);
}
