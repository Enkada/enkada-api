<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../connection.php";

    $query = sprintf("UPDATE gallery SET `title` = '%s', `description` = '%s', `date` = '%s' WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['description']),
        mysqli_real_escape_string($connection, $_POST['date']),
        mysqli_real_escape_string($connection, $_POST['id'])
    );

    echo $query;

    if (mysqli_query($connection, $query)) { 
        echo json_encode(array('success' => true));
    }
    else {
        // Error occurred while executing the query
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
