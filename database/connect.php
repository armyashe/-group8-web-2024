<?php 
// Kết nối với database cách 1
    $servername = "localhost";
    $database = "showroom_db";
    $username = "root";
    $password = "";



    // Tạo kết nối
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if (!$conn) {
        die(mysqli_connect_error());
    }
    ?>