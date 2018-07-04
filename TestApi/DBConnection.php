<?php
namespace TestApi;
use \PDO;

class DBConnection {
    private $host = 'localhost';
    private $db = 'test-api';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8';
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->pass);
    }

    public function getConnection() {
        return $this->pdo;
    }

}
?>