<?php

$config = require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || $_POST['token'] != $config['TOKEN']) { 
        echo json_encode(array('invalid_token' => true));
        exit;
    }
}

?>