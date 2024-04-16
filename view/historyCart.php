<?php

include_once('layout/header.php'); // File header của trang
include_once('../database/connect.php'); // File kết nối đến cơ sở dữ liệu

include_once('../database/userDAL.php'); // File thao tác với người dùng

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

// Include file footer của trang
include_once('layout/footer.php'); 
?>
