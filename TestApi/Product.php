<?php
namespace TestApi;

use \TestApi\DBConnection;
use \PDO;

class Product {
    private $pdo;

    public $name;
    public $description;
    public $weight;
    public $articul;

    public function __construct(\TestApi\DBConnection $dbconn) {
        $this->pdo = $dbconn->getConnection();
    }

    public function getAll() {
        $queryString = "SELECT * FROM products";
        return $this->pdo->query($queryString)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingle($id) {
        $queryString = "SELECT * FROM products WHERE id=$id";
        return $this->pdo->query($queryString)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAll() {
        $queryString = "DELETE FROM products";
        return $this->pdo->query($queryString);
    }

    public function deleteSingle($id) {
        $queryString = "DELETE FROM products WHERE id=$id";
        return $this->pdo->query($queryString);
    }

    public function update($id, $key, $value) {
        $queryString = "UPDATE products set $key = $value WHERE id = $id";
        return $this->pdo->query($queryString);
    }

    public function save() {
        $params = array('name' => $this->name, 'description' => $this->description, 'weight' => $this->weight, 'articul' => $this->articul);
        $queryString = "INSERT INTO products(name,description,weight,articul) VALUES(:name, :description, :weight, :articul)";
        $pr = $this->pdo->prepare($queryString);
        $saved = $pr->execute($params);
        if ($saved) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }
    }
}