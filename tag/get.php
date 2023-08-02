<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

// Handle the GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include "../connection.php";

    $query = "SELECT * FROM tags";
    $result = mysqli_query($connection, $query);

    $articles = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $article = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description']
        );

        $articles[] = $article;
    }

    echo json_encode($articles);

    mysqli_close($connection);
}
?>