<?php

include "../connection.php";

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

$directory = $_SERVER['DOCUMENT_ROOT'] . $config['DIR'] . '/files/';
$files = array();

if (is_dir($directory)) {
    if ($handle = opendir($directory)) {
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                $encodedFile = mb_convert_encoding($file, 'UTF-8', 'CP1251');
                $files[] = $encodedFile;
            }
        }
        closedir($handle);
    }
}


$query = "SELECT * FROM gallery ORDER BY date DESC";
$result = mysqli_query($connection, $query);

$gallery = array();
while ($row = mysqli_fetch_assoc($result)) {

    $gallery[] = $row;
}

echo json_encode(array('files' => $files, 'gallery' => $gallery));

mysqli_close($connection);
?>