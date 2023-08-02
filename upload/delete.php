<?php

$config = require_once '../config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Get the file name from the request data
$fileName = $_POST['fileName'];

// Specify the path to the files directory
$filesDirectory = $_SERVER['DOCUMENT_ROOT'] . $config['DIR'] . '/files/';

// Construct the file path
$filePath = $filesDirectory . $fileName;
$filePath = iconv('UTF-8', 'CP1251', $filePath);

print_r($_REQUEST);

// Check if the file exists
if (file_exists($filePath)) {
    // Attempt to delete the file
    if (unlink($filePath)) {
        // File deletion successful
        echo json_encode(array('message' => 'File deleted successfully'));

        include "../connection.php";
        
        // Delete the article from the database
        $name = mysqli_real_escape_string($connection, $fileName);
    
        $query = "DELETE FROM gallery WHERE `name` = '$name'";

        echo $query;
    
        if (mysqli_query($connection, $query)) {
            // Article deleted successfully
            echo json_encode(array('success' => true));
        } else {
            // Error occurred while deleting the article
            echo json_encode(array('success' => false));
        }
    
        mysqli_close($connection);
    } else {
        // File deletion failed
        echo json_encode(array('error' => 'Unable to delete the file'));
    }
} else {
    // File does not exist
    echo json_encode(array('error' => 'File not found'));
}
?>