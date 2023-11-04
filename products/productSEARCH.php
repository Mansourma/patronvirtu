<?php
require_once 'connection.php';

if (isset($_GET['search'])) {
    $searchValue = $_GET['search'];
    $searchValue = mysqli_real_escape_string($conn, $searchValue);

    $sql = "SELECT * FROM products WHERE product_name LIKE '%$searchValue%'";
    $result = $conn->query($sql);

    $resultsArray = array();

    while ($row = $result->fetch_assoc()) {
        $resultsArray[] = $row;
    }

    echo json_encode($resultsArray);
}
?>
