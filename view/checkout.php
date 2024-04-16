<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/styleCheckout.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../templates/js/bootstrap.min.js">

</head>
<header>
    <?php
     include_once ('layout/header.php'); 
        include_once ('../database/connect.php');

    // Xử lý thông tin khi người dùng gửi biểu mẫu thanh toán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin người dùng từ biểu mẫu
    $userName = $_POST['txtTendangnhap'];
    $phoneNumber = $_POST['txtDienthoai'];
    $address = $_POST['txtDiachi'];

    // Kiểm tra và xử lý đơn hàng nếu có sản phẩm trong giỏ hàng
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Lưu thông tin đơn hàng vào cơ sở dữ liệu
        $userID = $_SESSION['user_id']; // Lấy ID của người dùng từ phiên đăng nhập
        $cartItems = $_SESSION['cart']; // Lấy danh sách sản phẩm trong giỏ hàng

        // Thực hiện thêm đơn hàng vào cơ sở dữ liệu
        $orderID = createOrder($userID, $userName, $phoneNumber, $address, $cartItems);

        if ($orderID) {
            // Đơn hàng được tạo thành công, có thể xử lý thanh toán ở đây
            // Ví dụ: chuyển hướng người dùng đến trang thanh toán thực tế (ví dụ: cổng thanh toán của bên thứ ba)
            // Sau khi thanh toán thành công, có thể xóa giỏ hàng và hiển thị thông báo cho người dùng
            unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đã thanh toán
            echo '<p>Đơn hàng của bạn đã được đặt thành công.</p>';
        } else {
            echo '<p>Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.</p>';
        }
    } else {
        echo '<p>Giỏ hàng của bạn đang trống. Vui lòng chọn sản phẩm trước khi thanh toán.</p>';
    }
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
</header>

<body>
    <div class="container">
        <div class="row">
            <table class="list-cart">
                <!-- Bảng hiển thị danh sách sản phẩm trong giỏ hàng (nếu có) -->
            </table>

        </div>
        <h1>Thông tin đặt hàng</h1>
        <form action="process_checkout.php" name="frmDangki" method="POST">
            <div class="form-group">
                <label for="username">Họ và tên:</label>
                <input type="textbox" name="txtTendangnhap" id="tendangnhap" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="phone-number">Số điện thoại</label>
                <input type="textbox" name="txtDienthoai" id="sodienthoai" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="textbox" name="txtDiachi" id="diachi" class="form-control" required>
            </div>
            <button type="submit" name="btnTaotaikhoan" onclick="">Xác nhận đặt hàng</button>
        </form>
    </div>
</body>
<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer>

</html>