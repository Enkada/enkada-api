<?php

// Enable CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../connection.php";

    $query = sprintf("INSERT INTO articles(title, title_ru, content, content_ru, date, is_hidden, tags) VALUES ('%s', '%s', '%s', '%s', '%s', %s, '%s')", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['title_ru']),
        mysqli_real_escape_string($connection, $_POST['content']),
        mysqli_real_escape_string($connection, $_POST['content_ru']),
        mysqli_real_escape_string($connection, $_POST['date']),
        isset($_POST['is_hidden']) && $_POST['is_hidden'] === 'true' ? 1 : 0,
        mysqli_real_escape_string($connection, $_POST['tags'])
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