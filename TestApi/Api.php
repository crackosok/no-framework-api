<?php
namespace TestApi;

use TestApi\Product;


class Api {
    private $product;
    public function __construct(Product $product) {
        $this->product = $product;
    }

    /**
     * Чтобы не повторять в каждом методе вывод, вынес в отдельный метод
     */
    private function makeResponse($result) {
        header("Content-type: application/json");
        if ($result !== false)
        {
            http_response_code(200);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(500);
        }
    }

    public function getAllProducts() {
        $result = $this->product->getAll();
        $this->makeResponse($result);
    }

    public function getProduct($id) {
        $result = $this->product->getSingle($id);
        $this->makeResponse($result);
    }

    public function deleteAllProducts() {
        $deleted = $this->product->deleteAll();
        $result = [];
        if ($deleted) {
            $result = ['status' => 'OK'];
        } else {
            $result = ['error' => 'cannot delete products'];
        }
        $this->makeResponse($result);
    }

    public function deleteProduct($id = null) {
        if ($id == null) {
            http_response_code(500);
            echo json_encode(['error' => 'product id not set']);
        }
        $deleted = $this->product->deleteSingle($id);
        $result = [];
        if ($deleted) {
            $result = ['status' => 'OK'];
        } else {
            $result = ['error' => 'cannot delete product'];
        }
        $this->makeResponse($result);
    }

    public function updateProduct($id, $key, $value) {
        $updated = $this->product->update($id, $key, $value);
        $result = [];
        if ($updated) {
            $result = ['status' => 'OK'];
        } else {
            $result = ['error' => 'cannot update product'];
        }
        $this->makeResponse($result);
    }

    public function createProduct($name, $description, $weight, $articul) {
        $this->product->name = $name;
        $this->product->description = $description;
        $this->product->weight = $weight;
        $this->product->articul = $articul;
        $queryResult = $this->product->save();
        $result = [];
        if ($queryResult == false) {
            $result = ['error' => 'cannot insert to database'];
        } else {
            $result = ['id' => $queryResult];
        }
        $this->makeResponse($result);
    }
}
?>