<?php

use TestApi\Product;
use TestApi\DBConnection;
use TestApi\Api;
//autoload
spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

$db = new DBConnection();
$prod = new Product($db);
$api = new Api($prod);

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
    if (isset($_GET['id'])) {
        $api->getProduct($_GET['id']);
    } else {
        $api->getAllProducts();
    }
    break;
    case 'PUT':
        if(isset($_REQUEST['id']) && isset($_REQUEST['key']) && isset($_REQUEST['value'])) {
            $api->updateProduct($_REQUEST['id'], $_REQUEST['key'], $_REQUEST['value']);
        } else {
            header("Content-type: application/json");
            http_response_code(500);
            echo json_encode(['error' => 'not all parameters are set']);
        }
    break;
    case 'POST':
        if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['weight']) && isset($_POST['articul']) ) {
            $api->createProduct($_POST['name'], $_POST['description'], $_POST['weight'], $_POST['articul']);
        } else {
            header("Content-type: application/json");
            http_response_code(500);
            echo json_encode(['error' => 'not all parameters are set']);
        }
    break;
    case 'DELETE':
    if (isset($_REQUEST['id'])) {
        if ($_REQUEST['id'] == 0) {
            $api->deleteAllProducts();
        } else {
            $api->deleteProduct($_REQUEST['id']);
        }
    } else {
        header("Content-type: application/json");
        http_response_code(500);
        echo json_encode(['error' => 'product id not set']);
    }
    break;
}
?>