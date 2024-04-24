<?php
    session_start();//start session

    // Check if user is logged in using the session variable - kiểm tra xem người dùng đã đăng nhập bằng biến session không
    if(isset($_GET['logout'])) {
        session_destroy(); // xóa session - người dùng đăng xuất khỏi hệ thống
        unset($_SESSION['user']); //  go bien session username
        header('location: ../view/home.php'); // chuyển hướng người dùng đến trang chủ - redirect to the home page
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
    <script src="../javascripts/search.js"></script>
</head>

    <div class="background">
        <a href="../view/home.php"><img src="../IMG/logo2.jpg" alt=""></a>
        <div class="menu">
            <a href="home.php?keyword=Bàn+trà+">Bàn Trà</a>
            <a href="home.php?keyword=Gương">Gương</a>
            <a href="home.php?keyword=Bàn+trang+điểm">Bàn trang điểm</a>
            <a href="home.php?keyword=Đèn+cây">Đèn cây</a>
            <div class="login">
            <?php
                if (isset($_SESSION['user'])) {
                echo '<a href="" style="margin-top: 6px;"><i class="fa fa-user"></i>' . $_SESSION['user']['user_name'] . '</a>';
                } 
                else {
                echo '<a href="../view/login.php"><i class="fa fa-user"></i>Đăng nhập</a>';
                }
            ?>
                <div class="member hide">
                    <?php
                        if(isset($_SESSION['user'])) {
                            echo '<a href="../view/historyOrder.php">Lịch sử mua hàng</a>';
                        }
                        else 
                        {
                            echo '<a href="javascript:void(0);" onclick="showLoginAlertHistory()">Lịch sử mua hàng</a>';
                        }
                    ?>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <a href="?logout=true" id="logoutButton">Đăng xuất</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php
                if (isset($_SESSION['user'])) {
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
    
