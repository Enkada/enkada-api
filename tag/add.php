<?php

// Enable CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../connection.php";

    $query = sprintf("INSERT INTO tags(`name`, `description`) VALUES ('%s', '%s')", 
        mysqli_real_escape_string($connection, $_POST['name']),
        mysqli_real_escape_string($connection, $_POST['description'])
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
else {
    echo "need POST";
}


?>