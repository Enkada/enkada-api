<?php 

$config = require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || $_POST['token'] != $config['TOKEN']) { 
        echo json_encode(array('invalid_token' => true));
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $token = $data['token'];

    if (!isset($token) || $token != $config['TOKEN']) { 
        echo json_encode(array('invalid_token' => true));
        exit;
    }
}

$connection = mysqli_connect('127.0.0.1', $config['DB_USER'], $config['DB_PASSWORD'], $config['DB_NAME']); 
mysqli_query($connection, "SET NAMES 'utf8mb4'");

?>