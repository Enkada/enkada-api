<?php

$config = require_once '../config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$targetDirectory = $config['DIR'] . '/files/';

//print_r($_FILES['file']);
//print_r($_POST);
///return;


if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES['file']['tmp_name'];
    if (getimagesize($tempFile)) {
        $newFileName = floor(microtime(true) * 1000) . ".jpg"; 
    }
    else {
        $newFileName = $_FILES['file']['name']; 
    }
    
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . $targetDirectory . $newFileName;

    // Set proper encoding for the file name
    $targetFile = iconv('UTF-8', 'CP1251', $targetFile);     

    if (getimagesize($tempFile) && ($_POST["optimize"] === "true")) {
        // The file is an image
        resizeImage($tempFile, $targetFile);
        echo 'File uploaded and resized successfully.';        
    } else {
        if (move_uploaded_file($tempFile, $targetFile)) {
            echo 'File uploaded successfully.';
        } else {
            echo 'Error uploading file.';
        }
    }

    if ($_POST["mode"] === "gallery") {
        include "../connection.php";

        $query = sprintf("INSERT INTO gallery(`name`, `title`, `description`, `date`, `size`, `original_name`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", 
            mysqli_real_escape_string($connection, $newFileName),
            mysqli_real_escape_string($connection, $_POST['title']),
            mysqli_real_escape_string($connection, $_POST['description']),
            mysqli_real_escape_string($connection, $_POST['date']),
            mysqli_real_escape_string($connection, $_FILES['file']['size']),
            mysqli_real_escape_string($connection, $_FILES['file']['name'])
        );

        if (mysqli_query($connection, $query)) { 
            echo json_encode(array('success' => true, 'inserted' => mysqli_insert_id($connection)));
        }
        else {
            // Error occurred while executing the query
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_close($connection);
    }
    else if ($_POST["mode"] === "child") {
        include "../connection.php";

        $query = sprintf("INSERT INTO gallery(`name`, `size`, `original_name`, `parent`) VALUES ('%s', '%s', '%s', '%s')", 
            mysqli_real_escape_string($connection, $newFileName),
            mysqli_real_escape_string($connection, $_FILES['file']['size']),
            mysqli_real_escape_string($connection, $_FILES['file']['name']),
            mysqli_real_escape_string($connection, $_POST['parent'])
        );

        if (mysqli_query($connection, $query)) { 
            echo json_encode(array('success' => true, 'inserted' => mysqli_insert_id($connection)));
        }
        else {
            // Error occurred while executing the query
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_close($connection);
    }
    
} else {
    echo 'Error: ' . $_FILES['file']['error'];
}

function resizeImage($sourceImagePath, $destinationImagePath) {
    // Load the source image

    $info = getimagesize($sourceImagePath);

    if ($info['mime'] == 'image/jpeg') 
        $sourceImage = imagecreatefromjpeg($sourceImagePath);

    elseif ($info['mime'] == 'image/gif') 
        $sourceImage = imagecreatefromgif($sourceImagePath);

    elseif ($info['mime'] == 'image/png') 
        $sourceImage = imagecreatefrompng($sourceImagePath);

    if (!$sourceImage) {
        die("Failed to load the source image.");
    }

    // // Get the original dimensions
    // $originalWidth = imagesx($sourceImage);
    // $originalHeight = imagesy($sourceImage);

    // // Determine the new dimensions
    // $newWidth = $originalWidth;
    // $newHeight = $originalHeight;
    
    // if ($originalWidth > 1920 || $originalHeight > 1920) {
    //     $aspectRatio = $originalWidth / $originalHeight;
        
    //     if ($originalWidth > $originalHeight) {
    //         // Resize based on width
    //         $newWidth = 1920;
    //         $newHeight = 1920 / $aspectRatio;
    //     } else {
    //         // Resize based on height
    //         $newHeight = 1920;
    //         $newWidth = 1920 * $aspectRatio;
    //     }
    // }

    // // Create a new image with the new dimensions
    // $destinationImage = imagecreatetruecolor($newWidth, $newHeight);
    // if (!$destinationImage) {
    //     die("Failed to create the new image.");
    // }

    // // Perform the image resize
    // imagecopyresampled(
    //     $destinationImage,  // Destination image resource
    //     $sourceImage,       // Source image resource
    //     0,                  // Destination x-coordinate
    //     0,                  // Destination y-coordinate
    //     0,                  // Source x-coordinate
    //     0,                  // Source y-coordinate
    //     $newWidth,          // Destination width
    //     $newHeight,         // Destination height
    //     $originalWidth,     // Source width
    //     $originalHeight     // Source height
    // );

    // Save the resized image to a file
    //imagejpeg($destinationImage, $destinationImagePath, 90);
    imagejpeg($sourceImage, $destinationImagePath, 70); // Change 85 to the desired image quality (0-100)

    // Clean up
    //imagedestroy($sourceImage);
    //imagedestroy($destinationImage);
}
?>