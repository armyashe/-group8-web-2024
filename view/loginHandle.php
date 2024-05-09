<?php
session_start();
include_once ('../database/userDAL.php'); // gọi file userDAL.php vào để sử dụng

// Hàm kiểm tra đăng nhập
if (isset($_POST['username']) && isset($_POST['password']))
    checkLogin();
function checkLogin()
{
    // Kiểm tra xem người dùng đã nhập thông tin đăng nhập chưa
    if (!isset($_POST['username']) && !isset($_POST['password']))
        return; // Nếu chưa thì không làm gì cả
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    $results = checkUserLogin($user_name, $password);
    if ($results == null) {
        // Sau khi xuất thông báo, thực hiện chuyển hướng
        header("Location: login.php?errorLogin=1");// nó chuyển đi lun ( thêm 1 biến đánh dấu là có lỗi đăng nhập) 

    }
    else if ($results !== null && $results['trangthai'] == 'false') {
        // Sau khi xuất thông báo, thực hiện chuyển hướng
        header("Location: login.php?lockLogin=1");// nó chuyển đi lun ( thêm 1 biến đánh dấu là có lỗi đăng nhập)
        
    }else  if ($user_name == "admin" && $password == "123") {
        // Chuyển hướng người dùng đến trang chính sau khi đăng nhập thành công
        echo "<script> alert('Đăng nhập thành công')</script>";
        echo "<script> window.location.href = '../admin/view/index.php'</script>";
    }
   
    else {
        $_SESSION['user'] = $results;// Lưu thông tin người dùng vào session
        // Chuyển hướng người dùng đến trang chính sau khi đăng nhập thành công
        echo "<script> alert('Đăng nhập thành công')</script>";
        echo "<script> window.location.href = 'home.php'</script>";
        

    }

}

?>