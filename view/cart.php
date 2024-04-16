

<html>
<?php
include_once ('layout/header.php');
include_once ('../database/productDAL.php');
include_once ('../database/connect.php');

// Xử lý xóa giỏ hàng nếu người dùng yêu cầu
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}

// Kiểm tra nếu có sản phẩm được thêm vào giỏ hàng từ trang product_details.php
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Thêm thông tin sản phẩm vào giỏ hàng
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra nếu sản phẩm đã tồn tại trong giỏ hàng
    $product_exists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += 1;
            $product_exists = true;
            break;
        }
    }

    if (!$product_exists) {
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1,
        );
    }
}

// Hiển thị nội dung giỏ hàng (nếu có)
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // kiểu nó mất định dạng foooter lun á anh. bữa em để y này nó vẫn hiện bth huhuhu
    // lý do mà trang cart của em bị trắng tại vì trang đó có nhiêu đây code html à 
    // từ hqua tới giờ em để code y z nó vẫn chạy bth á, mà nãy em chỉnh css cái nghịch hồi cái nó trắng bóc lun
    // ý là cái header nó ko hiện lun á anh chứ ko phải mỗi table này thoi . để em làm anh xem thử
    echo '<table class="list-cart">';// list-cart này nó ko có link tới trang css nào hết v ? call đc ko anh hiccccc ko dc em nhà đang ồn á ê
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Tên sản phẩm</th>';
    echo '<th>Đơn giá</th>';
    echo '<th>Số lượng</th>';
    echo '<th>Số tiền</th>';
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