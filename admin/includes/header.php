<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../templates/css/admin.css">
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    echo '<script>console.log("'.$current_page.'")</script>';
    if ($current_page == 'index.php') {
        echo '<script>';
        echo 'document.title = "Bảng điều khiển - Admin";';
        echo '</script>';
    } elseif ($current_page == 'customer.php') {
        echo '<script>';
        echo 'document.title = "Người dùng - Admin";';
        echo '</script>';
    } elseif ($current_page == 'order.php') {
        echo '<script>';
        echo 'document.title = "Đơn hàng - Admin";';
        echo '</script>';
    } elseif ($current_page == 'product.php') {
        echo '<script>';
        echo 'document.title = "Sản phẩm - Admin";';
        echo '</script>';
    } elseif ($current_page == 'thongke.php') {
        echo '<script>';
        echo 'document.title = "Thống kê - Admin";';
        echo '</script>';
    }
    ?>
</head>
<body>
<input type="checkbox" id="nav-toggle" style="display: none;">
    <div class="sidebar">
        <div class="sidebar-brand" style="padding-left: 1.5rem;">
            <h2><span style="color:rgb(185,140,84);">INTERDIOR</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul> 
                <li>
                    <a href="../view/index.php" <?php if($current_page == 'index.php') echo 'class="active"'; ?>>
                        <span class="las la-igloo"></span>
                        <span>Bảng điều khiển</span>
                    </a>
                </li>
                <li>
                    <a href="../view/customer.php" <?php if($current_page == 'customer.php') echo 'class="active"'; ?>>
                        <span class="las la-users"></span>
                        <span>Người dùng</span>
                    </a>
                </li>
                <li>
                    <a href="../view/order.php" <?php if($current_page == 'order.php') echo 'class="active"'; ?>>
                        <span class="las la-clipboard-list"></span>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li>
                    <a href="../view/product.php" <?php if($current_page == 'product.php') echo 'class="active"'; ?>>
                        <span class="las la-shopping-bag"></span>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="../view/thongke.php" <?php if($current_page == 'thongke.php') echo 'class="active"'; ?>>
                        <span class="fa fa-bar-chart" aria-hidden="true"></span>
                        <span>Thống kê</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                <?php 
                    if ($current_page == 'index.php') {
                        echo 'Bảng điều khiển';
                    } elseif ($current_page == 'customer.php') {
                        echo 'Người dùng';
                    } elseif ($current_page == 'order.php') {
                        echo 'Đơn hàng';
                    } elseif ($current_page == 'product.php') {
                        echo 'Sản phẩm';
                    } elseif ($current_page == 'thongke.php') {
                        echo 'Thống kê';
                    }
                ?>
            </h2>


            <!-- <div class="search-wrapper">
                <input type="search" placeholder="Nhập tên sản phẩm">
                <a href=""><span class="las la-search"></span></a>
            </div> -->

            <div class="dropdown">
                <span>
                    <div class="user-wrapper">
                        <img src="../templates/img/AD1.jpg" width="40px" height="40px" alt="">Thanh
                    </div>

                </span>
            </div>
        </header>