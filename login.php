<?php

$config = require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    if ($password === $config['PASSWORD']) { 
        echo json_encode(array('token' => $config['TOKEN']));
        exit;
    }

    echo json_encode(array('error' => 'Invalid password'));
    exit;
}
