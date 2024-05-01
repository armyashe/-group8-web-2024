<?php
include_once ('../database/connect.php');

// trạng thái khóa/mở khóa tài khoản
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["lock"]))
{
    $userName = $_POST["userName"];
    $newLockStatus = $_POST["lock"]; // Lấy giá trị của checkbox (true/false)
    // echo '<script>alert("'.$newLockStatus.'")</script>';
    // echo '<script>alert("'.$userName.'")</script>';
    // Cập nhật trạng thái của người dùng trong cơ sở dữ liệu
    $updateQuery = "UPDATE user SET trangthai = '$newLockStatus' WHERE user_name = '$userName'";
    $updateStmt = $conn->prepare($updateQuery);
    // $updateStmt->bind_param("ss", $newLockStatus, $userName);
    $updateStmt->execute();

    if($newLockStatus == 'true')
    {
        echo json_encode(array(
            "status" => "true",
            "message" => "Mở khóa tài khoản của $userName thành công")
        );
        exit();
    }
    else
    {
        echo json_encode(array(
            "status" => "false",
            "message" => "Khóa tài khoản của $userName thành công")
        );
        exit();
    }
}   
// sửa thông tin người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userNameEdit"])) {
    header('Content-Type: application/json');

    $userNameEdit = $_POST["userNameEdit"];
    $email = $_POST["emailEdit"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Validate email address
    $name = $_POST["usernameEdit"];
    $name = htmlspecialchars($_POST['usernameEdit'], ENT_QUOTES, 'UTF-8');
    $password = $_POST["passwordEdit"];
    $password = htmlspecialchars($_POST['passwordEdit'], ENT_QUOTES, 'UTF-8');

    // cập nhật thông tin người dùng
    $update_user = "UPDATE user SET user_email = '$email', user_name = '$name', password = '$password' WHERE user_name = '$userNameEdit'";
    $updateStmt = $conn->prepare($update_user);
    if ($updateStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "nameOld" => $userNameEdit)
        );
        exit();
    }
    else {
        echo json_encode(array(
            "status" => "false",
            "message" => "Cập nhật thông tin thất bại")
        );
        exit();
    }
}

// thêm người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"])) {
    header('Content-Type: application/json');   

    

    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // kiểm tra địa chỉ email có hợp lệ ko
    $name = $_POST["username"];
    $name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST["password"];
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
    
    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $select_user = "SELECT * FROM user WHERE user_name = ? AND password = ?";
    $select_user_stmt = $conn->prepare($select_user);
    $select_user_stmt->bind_param("ss", $name, $password);
    $select_user_stmt->execute();
    $select_user_result = $select_user_stmt->get_result();
   

    if ($select_user_result->num_rows > 0) {
        $select_user_result->close();
        echo json_encode(array(
            "status" => "false",
            "message" => "Tài khoản đã tồn tại"
        ));
        exit();
    } 
    else {
        $select_user_result->close();
        
        $trangthai = 'true';
        $id = uniqid();
        $insert_user = "INSERT INTO `user`(`id`,`user_name`, `password`, `user_email`,`trangthai`) VALUES ('$id','$name','$password','$email','$trangthai')";
        $insert = $conn->prepare($insert_user);
    
        if ($insert->execute()) {
            echo json_encode(array(
                "status" => "true",
                "name" => $name,
                "email" => $email,
                "password" => $password)
            );
            exit();
        } else {
            echo json_encode(array(
                "status" => "false")
            );
            exit();
        }
    }
}

// xóa tài khoản
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["delete"])) {
    header('Content-Type: application/json'); 
    $value = $_POST["delete"];
    $userName = $_POST["userName"];

    // Delete order details
    $deleteProductDetailQuery = "DELETE FROM order_detail WHERE idOrder IN (SELECT idOrder FROM orders WHERE idOrder = (SELECT id FROM user WHERE user_name = ?))";
    $deleteProductDetailStmt = $conn->prepare($deleteProductDetailQuery);
    $deleteProductDetailStmt->bind_param("s", $userName);
    $deleteProductDetailStmt->execute();

    // Delete orders
    $deleteOrderQuery = "DELETE FROM orders WHERE idUser = (SELECT id FROM user WHERE user_name = ?)";
    $deleteOrderStmt = $conn->prepare($deleteOrderQuery);
    $deleteOrderStmt->bind_param("s", $userName);
    $deleteOrderStmt->execute();

    // Delete user
    $deleteUserQuery = "DELETE FROM user WHERE user_name = '$userName'";
    $deleteStmt = $conn->prepare($deleteUserQuery);
    $deleteStmt->execute();
    if ($deleteStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "message" => "Xóa tài khoản $userName thành công")
        );
        exit();
    } else {
        echo json_encode(array(
            "status" => "false",
            "message" => "Xóa tài khoản $userName thất bại")
        );
        exit();
    }
}

// chuyển trạng thái đơn hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idOrder"]) && isset($_POST["status"])){
    header('Content-Type: application/json');
    $idOrder = $_POST["idOrder"];
    $status = $_POST["status"];
    $updateOrderQuery = "UPDATE orders SET status = '$status' WHERE idOrder = '$idOrder'";
    $updateOrderStmt = $conn->prepare($updateOrderQuery);
    if ($updateOrderStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "message" => "Chuyển trạng thái đơn hàng thành công")
        );
        exit();
    } else {
        echo json_encode(array(
            "status" => "false",
            "message" => "Chuyển trạng thái đơn hàng thất bại")
        );
        exit();
    }
}


// xóa đơn hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idOrder"]) && isset($_POST["delete"])){
    header('Content-Type: application/json');
    $idOrder = $_POST["idOrder"];
    $deleteOrderDetailQuery = "DELETE FROM order_detail WHERE idOrder = '$idOrder'";
    $deleteOrderDetailStmt = $conn->prepare($deleteOrderDetailQuery);
    $deleteOrderDetailStmt->execute();
    $deleteOrderQuery = "DELETE FROM orders WHERE idOrder = '$idOrder'";
    $deleteOrderStmt = $conn->prepare($deleteOrderQuery);
    if ($deleteOrderStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "message" => "Xóa đơn hàng thành công")
        );
        exit();
    } else {
        echo json_encode(array(
            "status" => "false",
            "message" => "Xóa đơn hàng thất bại")
        );
        exit();
    }
}


// sửa sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_product']) && isset($_POST['name_product']) && isset($_POST['price_edit']) && isset($_POST['product_type']) && isset($_POST['describe'])){
    header('Content-Type: application/json');
    
    
    $id = $_POST['id_product'];
    $name = $_POST['name_product'];
    $price_product = $_POST['price_edit'];
    $loaisanpham = $_POST['product_type'];
    $mota = $_POST['describe'];
    
    
    if (isset($_FILES["img_product"]) && $_FILES["img_product"]["error"] == 0) {
        $target_dir = "../../IMG/";
        $target_file = $target_dir . basename($_FILES["img_product"]["name"]);
    
        if(move_uploaded_file($_FILES["img_product"]["tmp_name"], $target_file)) {
            $img_product = $_FILES["img_product"]["name"];
        }
    }
    else{
        $select_product = "SELECT * FROM sanpham WHERE id = '$id'";
        $selectStmt = $conn->prepare($select_product);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();
        $img_product = $row['hinhanh'];
    }
    
    $update_product = "UPDATE sanpham SET tensanpham = '$name', gia = '$price_product', loaisanpham = '$loaisanpham' , mota = '$mota' , hinhanh = '$img_product' WHERE id = '$id'";
    $updateStmt = $conn->prepare($update_product);

    if ($updateStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "id" => $id,
            "name_product" => $name,
            "price" => $price_product,
            "loaisanpham" => $loaisanpham,
            "mota" => $mota,
            "hinhanh" => $img_product,
            "message" => "Sửa sản phẩm thành công")
        );
        exit();
    } else {
        echo json_encode(array(
            "status" => "false",
            )
        );
        exit();
    }
}

// thêm sản phẩm
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_add']) && isset($_POST['name_add']) && isset($_POST['price_add']) && isset($_POST['type_add']) && isset($_POST['describeAdd'])){
    header('Content-Type: application/json');
    $id_product = $_POST['id_add'];
    $name_product = $_POST['name_add'];
    $price = $_POST['price_add'];
    $loaisanpham = $_POST['type_add'];
    $mota = $_POST['describeAdd'];

    
    
    if (isset($_FILES["img_add"]) && $_FILES["img_add"]["error"] == 0) {
        $target_dir = "../../IMG/";
        $target_file = $target_dir . basename($_FILES["img_add"]["name"]);
        
        if(move_uploaded_file($_FILES["img_add"]["tmp_name"], $target_file)) {
            $img_addProduct = $_FILES["img_add"]["name"];
        }
    }
    
    else
    {
        $img_addProduct = "default.png";
    }
    
    $insert_product = "INSERT INTO sanpham (id, tensanpham, gia, loaisanpham, mota, hinhanh) VALUES ('$id_product', '$name_product', '$price', '$loaisanpham','$mota','$img_addProduct')";
    $insertStmt = $conn->prepare($insert_product);
    if ($insertStmt->execute()) {
        echo json_encode(array(
            "status" => "true",
            "id" => $id_product,
            "name_product" => $name_product,
            "price" => $price,
            "loaisanpham" => $loaisanpham,
            "mota" => $mota,
            "hinhanh" => $img_addProduct,
            "message" => "Thêm sản phẩm thành công")
        );
        exit();
    } else {
        echo json_encode(array(
            "status" => "false",
            "message" => "Thêm sản phẩm thất bại")
        );
        exit();
    }
}

?>