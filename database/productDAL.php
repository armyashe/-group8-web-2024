<?php
    include 'connectDB.php';

    function getProductById($id)
{
    $conn = connect();
    $sql = "SELECT * FROM sanpham WHERE id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row of the result set as an associative array
        $row = $result->fetch_assoc();
    } else {
        // No product found with the specified ID
        $row = null; // Or handle the error condition appropriately
        echo "0 results";
    }

    // Close the database connection
    $conn->close();

    return $row;
}

?>