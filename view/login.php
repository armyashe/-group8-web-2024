<?php

include_once ('../database/userDAL.php');

if(isset($_REQUEST['errorLogin'])){ // đăng nhập sai nó vô đây
    echo "<script> alert('Sai tên đăng nhập hoặc mật khẩu')</script>";
}
if(isset($_REQUEST['lockLogin'])){ // tài khoản bị khóa thì nó vô đây
    echo "<script> alert('Tài khoản của bạn đã bị khóa')</script>";
}
if(isset($_REQUEST['registerSuccessful'])){ // đăng nhập sai nó vô đây
    echo "<script>alert('Đăng ký thành công')</script>";
    
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ĐĂNG NHẬP </title>
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div id="login">
        <h2>ĐĂNG NHẬP</h2>
        <form action="loginHandle.php" method="post">
            <input type="text" name="username" id="usernamereg" placeholder="username" required autocomplete="off" />
            <input type="password" name="password" id="passreg" placeholder="password" required autocomplete="off" />
            <button type="submit" onclick="" style="text-decoration: none;" class="btn-primary-login" >Đăng nhập</button>
           
        </form>
        <div class="register">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
            <p><a href="../index.php">Quay lại trang chủ</a></p>
        </div>
    </div>
    

</body>

</html>
