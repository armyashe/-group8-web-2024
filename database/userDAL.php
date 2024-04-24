<?php
include 'connectDB.php';

include_once ('../view/registerHandle.php');


# cái connectDB vs connect khác nhau gì dị. ko phải nó giống nhau hả. em tưởng có file connect ròi
# khác nhau cách tổ chức thôi 
# connect của em là import file là nó auto chạy
# còn connectDB của anh chỉ khi kêu hàm connect nó mới chạy
# hiểu ko ?oke

# này anh sẽ viết hàm lấy sản phẩm theo id của anh  
# chỉ bí kíp cho nè heheh. canh lề nhấn tổ hợp phím alt+shift+f 


/* function checkUserLogin($username, $password)
{
    $conn = connect();
    $sql = "select * from user where user_name = '" . $username . "' and password = '" . $password . "'";
    $result = $conn->query($sql);
    if ($result == null)
        return null;
    if ($result->num_rows > 0) {
        // output data of each row
        // while ($row = $result->fetch_assoc()) {
        //     echo "id: " . $row["id"] . " - Name: " . $row["tensanpham"] . " " . $row["loaisanpham"] . "<br>";
        // }
    } else {
        return null;

    }
    $conn->close();
    $row = $result->fetch_assoc();
    return $row;
} */
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

function addUser($email, $username, $password)
{
    $conn = connect(); // Kết nối đến CSDL

    $sql = "INSERT INTO `user` (`id`, `user_name`, `password`,`user_email`) VALUES ('" . uniqid() . "','" . $email . "','" . $username . "','" . $password . "') ";


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


?>