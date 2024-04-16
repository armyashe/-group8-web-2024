<?php 
include_once ('../database/userDAL.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ĐĂNG KÝ</title>
    <link rel="stylesheet" href="../css/styleLogin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div id="login">
        <h2>ĐĂNG KÝ</h2>
        <form action="registerHandle.php" method="post">
            <input type="email" name="email" placeholder="enter email"  class="email" required autocomplete="off" />
            <input type="text" name="username" placeholder="enter username" class="username" required autocomplete="off" />
            <input type="password" name="password" placeholder="enter password" class="password" required autocomplete="off" />
            <input type="password" name="pass" placeholder="enter password again" class="pass form-control" required autocomplete="off" />
            <button type="submit" class="btn-primary">Đăng kí</button>
        </form>
        <div class="register">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
        </div>
    </div>
    
</body>

</html>