<?php
// Enable CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../connection.php";

    $articleId = $_GET['id']; // Get the article ID from the URL parameters

    $query = sprintf("UPDATE articles SET title = '%s', title_ru = '%s', content = '%s', content_ru = '%s', date = '%s', is_hidden = %s, tags = '%s' WHERE id = %s", 
        mysqli_real_escape_string($connection, $_POST['title']),
        mysqli_real_escape_string($connection, $_POST['title_ru']),
        mysqli_real_escape_string($connection, $_POST['content']),
        mysqli_real_escape_string($connection, $_POST['content_ru']),
        mysqli_real_escape_string($connection, $_POST['date']),
        isset($_POST['is_hidden']) && $_POST['is_hidden'] === 'true' ? 1 : 0,
        mysqli_real_escape_string($connection, $_POST['tags']),
        $articleId
    );

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
