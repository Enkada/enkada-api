<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle the DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    include "../connection.php";

    // Delete the article from the database
    $articleId = mysqli_real_escape_string($connection, $data['id']);

    $query = "DELETE FROM articles WHERE id = '$articleId'";

    if (mysqli_query($connection, $query)) {
        // Article deleted successfully
        echo json_encode(array('success' => true));
    } else {
        // Error occurred while deleting the article
        echo json_encode(array('success' => false));
    }

    mysqli_close($connection);
}
?>