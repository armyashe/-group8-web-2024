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
        <form >
            <input type="text" name="username" id="usernamereg" placeholder="username" required autocomplete="off" />
            <input type="password" name="password" id="passreg" placeholder="password" required autocomplete="off" />
            <button type="submit" onclick="login()" style="text-decoration: none;" class="btn-primary-login" >Đăng nhập</button>
        </form>
        <div class="register">
            <p>Chưa có tài khoản? <a href="register.html">Đăng ký ngay</a></p>
            <p><a href="../index.php">Quay lại trang chủ</a></p>
        </div>
    </div>
    <script src="javascripts/login.js"></script>

</body>

</html>