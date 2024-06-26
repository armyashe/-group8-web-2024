<?php
include 'connectDB.php';

include_once ('../view/registerHandle.php');


function checkUserLogin($username, $password)
{
    $conn = connect(); // Hàm connect() phải được định nghĩa để kết nối vào CSDL

    // Sử dụng prepared statement để ngăn chặn SQL Injection
    $sql = "SELECT * FROM user WHERE user_name = ? AND password = ?";
    $stmt = $conn->prepare($sql); // Chuẩn bị câu truy vấn - prepare statement dùng để ngăn chặn SQL Injection
    $stmt->bind_param("ss", $username, $password); // Bind dữ liệu vào câu truy vấn - bind_param dùng để ngăn chặn SQL Injection
    $stmt->execute(); // Thực thi câu truy vấn

    $result = $stmt->get_result(); // Lấy kết quả trả về từ câu truy vấn

    if ($result->num_rows > 0) {
        // Truy vấn thành công, lấy dữ liệu người dùng
        $row = $result->fetch_assoc(); // Lấy dữ liệu người dùng
        $conn->close(); // Đóng kết nối sau khi sử dụng

        return $row; // Trả về dữ liệu người dùng
    } else {
        // Không tìm thấy người dùng, đóng kết nối và trả về null
        $conn->close(); // Đóng kết nối sau khi sử dụng
        return null;// Trả về null nếu không tìm thấy người dùng
    }
}

function addUser($email, $username, $password,$trangthai,$diaChi)
{
    $conn = connect(); // Kết nối đến CSDL

    $sql = "INSERT INTO `user` (`id`, `user_name`, `password`,`user_email`,`trangthai`,`diachi`) VALUES ('" . uniqid() . "','" . $email . "','" . $username . "','" . $password . "','" . $trangthai . "','" . $diaChi . "') ";


    echo $sql;

    if ($conn->query($sql) === TRUE) {
        // Thêm người dùng thành công
        $conn->close();
        return true;
    } else {
   
        // Thêm người dùng thất bại
        $conn->close();
        return null;
    }
}

function getUserId($username) {
    $conn = connect();

    $sql = "SELECT id FROM user WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $row['id'];
    } else {
        $stmt->close();
        $conn->close();
        return null;
    }
}

function getUserAddress()
{
    $conn = connect();
    $sql = "SELECT * FROM user WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['user']['user_name']);
    $stmt->execute();
    $result = $stmt->get_result();
    $address = $result->fetch_assoc()['diachi'];
    $stmt->close();
    $conn->close();
    return $address;
}

