<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// Handle the GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query the database to fetch all articles
    include "../connection.php";

    $query = "SELECT * FROM articles WHERE is_hidden = 0 ORDER BY date DESC";
    $result = mysqli_query($connection, $query);

    $articles = array();
    while ($row = mysqli_fetch_assoc($result)) {
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

        $articles[] = $article;
    }

    echo json_encode($articles);

    mysqli_close($connection);
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Query the database to fetch all articles
    include "../connection.php";

    $query = "SELECT * FROM articles ORDER BY date DESC";
    $result = mysqli_query($connection, $query);

    $articles = array();
    while ($row = mysqli_fetch_assoc($result)) {
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

        $articles[] = $article;
    }

    echo json_encode($articles);

    mysqli_close($connection);
}
?>