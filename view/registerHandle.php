<?php
/* session_start(); */
include_once ('../database/userDAL.php'); // gọi file userDAL.php vào để sử dụng


// Hàm kiểm tra đăng ký
if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['pass']))
    checkRegister();
function checkRegister()
{
    
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass = $_POST['pass'];
 

    if(!isset($email) && !isset($username) && !isset($password) && !isset($pass)){
        return;
    }
    $results = checkUserLogin($username, $password);
    if($results != null){
        echo "<script>alert('Tài khoản đã tồn tại')</script>";
        
        
    }else{
        if($password != $pass){
            echo "<script>alert('Mật khẩu không trùng khớp')</script>";
            return;
        }else{
            $resultUser = addUser($email, $username, $password);
            if($resultUser == null){
                echo "<script>alert('Đăng ký thất bại')</script>";
            }else{
                //echo "<script>alert('Đăng ký thành công')</script>";
                header("Location: login.php?registerSuccessful=1");
            }
        }
    }

 

}

?>