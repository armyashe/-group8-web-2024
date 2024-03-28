<?php
    session_start();

    if(isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: ../view/home.php');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng nội thất</title>
    <link rel="stylesheet" href="../css/style1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../templates/js/bootstrap.min.js">
    <script src="../javascripts/search.js"></script>
</head>
<body>
    <div class="background">
        <a href=""><img src="../IMG/logo2.jpg" alt=""></a>
        <div class="menu">
            <a href="../view/home.php">Bàn Trà</a>
            <a href="">Gương</a>
            <a href="">Bàn trang điểm</a>
            <a href="">Đèn cây</a>
            <div class="login">
            <?php
                if (isset($_SESSION['username'])) {
                echo '<a href="" style="margin-top: 6px;">' . $_SESSION['username'] . '</a>';
                } 
                else {
                echo '<a href="../view/login.php"><i class="fa fa-user"></i>Đăng nhập</a>';
                }
            ?>
                <div class="member hide">
                    <?php
                        if(isset($_SESSION['username'])) {
                            echo '<a href="">Lịch sử đơn hàng</a>';
                        }
                        else 
                        {
                            echo '<a href="javascript:void(0);" onclick="showLoginAlertHistory()">Lịch sử đơn hàng</a>';
                        }
                    ?>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <a href="?logout=true" id="logoutButton">Đăng xuất</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="../view/cart.php"><i class="fa fa-shopping-cart"></i><span>Giỏ hàng</span>
                    <span class="cart-number"></span></a>';
                } 
                else {
                    // Sử dụng javascript:void(0); trong thuộc tính href của thẻ <a> để tránh trình duyệt chuyển hướng đến một URL không hợp lệ.
                    echo '<a href="javascript:void(0);" onclick="showLoginAlert()"><i class="fa fa-shopping-cart"></i><span>Giỏ hàng</span> 
                    <span class="cart-number"></span></a>';
                }
            ?>
        </div>
    </div>
    <hr style="border: 2px solid black;">
    
