<?php

$_password = 'apple';
$_token = hash("md5", $_password . "123");

return array(
    'DIR' => '/api',
    'DB_USER' => 'root',
    'DB_PASSWORD' => '',
    'DB_NAME' => 'enkada',
    'PASSWORD' => $_password,
    'TOKEN' => $_token,
);

?>