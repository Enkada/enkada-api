<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// Handle the GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve the article ID from the query parameters
    $articleId = $_GET['id'];

    // Query the database to fetch the article data for the given ID
    include "../connection.php";
    $articleId = mysqli_real_escape_string($connection, $articleId);

    $query = "SELECT * FROM articles WHERE id = '$articleId'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Article found, return the data
        $article = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'title_ru' => $row['title_ru'],
            'content' => $row['content'],
            'content_ru' => $row['content_ru'],
            'date' => $row['date'],
            'tags' => $row['tags'],
            'is_hidden' => $row['is_hidden']
        );

        echo json_encode($article);
    } else {
        // Article not found
        echo json_encode(array('error' => 'Article not found'));
    }

    mysqli_close($connection);
}
?>