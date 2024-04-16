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

    // Function to create an order in the database
function createOrder($userID, $userName, $phoneNumber, $address, $cartItems) {
    global $conn; // Sử dụng biến kết nối đã được khai báo ở file connect.php

    // Xử lý các giá trị để tránh SQL injection
    $userName = mysqli_real_escape_string($conn, $userName);
    $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
    $address = mysqli_real_escape_string($conn, $address);

    // Tạo câu truy vấn SQL để chèn dữ liệu vào bảng đơn hàng
    $sql = "INSERT INTO orders (user_id, user_name, phone_number, address) 
            VALUES ('$userID', '$userName', '$phoneNumber', '$address')";

    // Thực thi truy vấn và kiểm tra kết quả
    if ($conn->query($sql) === TRUE) {
        $orderID = $conn->insert_id; // Lấy ID của đơn hàng vừa được thêm vào

        // Thêm các mặt hàng của đơn hàng vào bảng chi tiết đơn hàng
        foreach ($cartItems as $item) {
            $productID = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            // Tạo câu truy vấn để thêm chi tiết đơn hàng
            $sqlDetail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                          VALUES ('$orderID', '$productID', '$quantity', '$price')";

            // Thực thi câu truy vấn
            $conn->query($sqlDetail);
        }

        return $orderID; // Trả về ID của đơn hàng đã được tạo thành công
    } else {
        // Nếu có lỗi xảy ra trong quá trình thêm đơn hàng
        echo "Error: " . $sql . "<br>" . $conn->error;
        return false;
    }
}


    ?>