

<html>
<?php
include_once ('layout/header.php');
include_once ('../database/connect.php');
include_once ('../database/orderDAL.php');

$idUser = $_SESSION['user']['id']; // lấy id user từ session
$donhang = getOrder($idUser); // lấy thông tin đơn hàng

echo '<script>console.log('.json_encode($donhang).')</script> ';
echo '<script>console.log('.json_encode($idUser).')</script> ';
echo '<script>';
echo 'document.title = "LỊCH SỬ MUA HÀNG";';
echo '</script>';
?>
 <head>
        <link rel="stylesheet" href="../css/history.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../javascripts/search.js"></script>
 </head>

 <main style="margin-top:4%;">
        <aside>
            <?php echo '<span><i class="fa fa-user"></i>'. $_SESSION['user']['user_name'].' </span>'?>
            <a class="active" href="#" class="link"><i class='bx bxs-receipt'></i>Lịch sử mua hàng</a>
            <a href="cart.php" style="cursor: pointer"><i class="fa fa-shopping-cart"></i>Giỏ hàng</a>
        </aside>
        <section>
            <?php
            if($donhang != null)
            {
                foreach($donhang as $dh)
                {
                    // Lấy thông tin chi tiết đơn hàng
                    $orderDetails = getOrderDetail($dh['idOrder']);

                    if($orderDetails != null)
                    {
                        foreach($orderDetails as $item)
                        {
                            // lấy thông tin sản phẩm từ bảng products
                            $product = getProduct($item['idProduct']);
                            foreach($product as $item_product)
                            {
                                echo '<div class="product">';
                                echo '<img src="../IMG/'.$item_product['hinhanh'].'" alt="">';
                                echo '<div class="info">';
                                echo '<p class="name">'.$item_product['tensanpham'].'</p>';
                                echo '<p>Giá : '.number_format($item['price'], 0, ",", ".") .'₫</p>';
                                echo '</div>';
                                echo '<div class="confirm"><i class="bx bxs-truck"></i></div>';
                                echo '<div style="margin-top: 40px;">Số lượng : '.$item['quantity'].'</div>';
                                echo '</div>';
                            }
                        }
                    }   
                }
            }
            else
            {
                echo '<h1>Chưa có đơn hàng nào</h1>';
            } 
            ?>
        </section>
    </main>

<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer> 
</body>
</html>