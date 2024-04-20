

<html>
<?php
include_once ('layout/header.php');
include_once ('../database/productDAL.php');
include_once ('../database/connect.php');

if(isset($_REQUEST['orderIDSuccessful'])){
    echo '<p>Đơn hàng của bạn đã được đặt thành công. Mã đơn hàng của bạn là: '.$_REQUEST['orderIDSuccessful'].'</p>';
    unset($_SESSION['cart']);

}




// Hiển thị nội dung giỏ hàng (nếu có)
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    echo '<table class="list-cart">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Tên sản phẩm</th>';
    echo '<th>Đơn giá</th>';
    echo '<th>Số lượng</th>';
    echo '<th>Số tiền</th>';
    echo '<th>Ngày thêm</th>';
    echo '<th>Trạng thái</th>';
    //echo '<th>Ngày thêm</th>';
    echo '</tr>';

    $total_items = 0;
    $total_amount = 0;

    foreach ($_SESSION['cart'] as $item) {
        $price_formatted = number_format($item['price'], 0, ",", ".") . "đ";
        $sum = $item['price'] * $item['quantity'];
        $sum_formatted = number_format($sum, 0, ",", ".") . "đ";

        echo '<tr>';
        echo '<td>' . $item['id'] . '</td>';
        echo '<td>' . $item['name'] . '</td>';
        echo '<td>' . $price_formatted . '</td>';
        echo '<td>' . $item['quantity'] . '</td>';
        echo '<td>' . $sum_formatted . '</td>';
        

       // echo'<td>'.date("Y-m-d H:i:sa",$item['date']) .'</td>';

        echo '</tr>';

        $total_items += $item['quantity'];
        $total_amount += $sum;
    }

    echo '<tr>';
    echo '<td colspan="4">Tổng tiền (' . $total_items . ' sản phẩm):</td>';
    echo '<td>' . number_format($total_amount, 0, ",", ".") . 'đ</td>';
    
    echo '</tr>';

    echo '</table>';


} else {
    echo '<p>Giỏ hàng của bạn đang trống.</p>';
}
?>
 <head>
        <title>Giỏ hàng</title>
        <link rel="stylesheet" href="../css/styleGH.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../templates/js/bootstrap.min.js">
        <script src="../javascripts/search.js"></script>
 </head>


    <div class="body">
        <div class="row">
            <table class="list-cart">
                <!-- Bảng hiển thị danh sách sản phẩm trong giỏ hàng (nếu có) -->
            </table>

        </div>

        <div id="button-container">
            <!-- Nút chức năng -->
            <button class="btn btn-primary"><a href="checkout.php" >Thanh toán</a></button>        
            <button class="btn btn-danger"><a href="cart.php?clear" >Xóa giỏ hàng</a></button>
            <p><a href="home.php" class="btn btn-primary">Tiếp tục mua hàng</a></p>
    </div>

    </div>
<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer> 
</body>
</html>