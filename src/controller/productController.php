<?php
require './src/service/productService.php';

class ProductController {
    private $productService;

    public function __construct($productService) {
        $this->productService = $productService;
    }

    public function getProduct() {
        $products = $this->productService->getProduct();
        header('Content-Type: application/json');
        $response = array(
            'data' => $products
        );

        echo json_encode($response);
    }

    public function addTask($data) {
        $title = $data;
        if ($title) {
            $this->productService->addProduct($data);
            echo json_encode(['message' => 'Tarefa adicionada com sucesso.']);
        } else {
            echo json_encode(['message' => 'Erro ao adicionar tarefa.']);
        }
    }

    // public function completeTask($data) {
    //     $id = $data['id'];
    //     if ($id) {
    //         $this->productService->completeTask($id);
    //         echo json_encode(['message' => 'Tarefa marcada como concluída.']);
    //     } else {
    //         echo json_encode(['message' => 'Erro ao marcar tarefa como concluída.']);
    //     }
    // }
}

$productController = new ProductController($productService);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    return $productController->getProduct();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
//     return $productController->addTask($data);
// } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
//     $data = json_decode(file_get_contents('php://input'), true);
//     return $productController->completeTask($data);
}
?>
