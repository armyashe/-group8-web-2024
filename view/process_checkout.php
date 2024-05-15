<?php





/*
// Xử lý thông tin đặt hàng khi người dùng gửi biểu mẫu thanh toán
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    // Kiểm tra giỏ hàng có sản phẩm hay không
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $userName = $_POST['txtTendangnhap'];
        $phoneNumber = $_POST['txtDienthoai'];
        $address = $_POST['txtDiachi'];
        $cartItems = $_SESSION['cart'];

        // Thêm đơn hàng vào cơ sở dữ liệu và nhận idOrder
        $orderID = insertOrder($userName, $phoneNumber, $address, $cartItems);

        if ($orderID) {
            unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đã đặt hàng thành công
            header("Location: historyOrder.php?orderIDSuccessful=$orderID");
        } else {
            header("Location: checkout.php?orderIDFail");
            exit; // Dừng việc thực thi mã và chuyển hướng trang
        }
    } else {
        // Nếu giỏ hàng trống, thông báo cho người dùng và hiển thị tin nhắn
        echo '<p>Giỏ hàng của bạn đang trống. Vui lòng chọn sản phẩm trước khi thanh toán.</p>';
    }
}*/
session_start();
include_once('../database/orderDAL.php');
include_once('../database/userDAL.php'); // File kết nối đến cơ sở dữ liệu
include_once('../database/connectDB.php'); // File kết nối đến cơ sở dữ liệu


// Xử lý thông tin đặt hàng khi người dùng gửi biểu mẫu thanh toán
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    // Kiểm tra giỏ hàng có sản phẩm hay không
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $userName = $_POST['txtTendangnhap'];
        $phoneNumber = $_POST['txtDienthoai'];
        $address = $_POST['txtDiachi'];
        
        if(!isset($_POST['radiopayment'])){
            echo '<script>alert("Vui lòng chọn phương thức thanh toán")</script>';
            echo '<script>window.location.href="checkout.php"</script>';
        }
        else{
            $payment = $_POST['radiopayment'];
        }
        $cartItems = $_SESSION['cart'];

        $userID= $_SESSION['user']['id'];
   
        // Thêm đơn hàng vào cơ sở dữ liệu và nhận idOrder
        $orderID = insertOrder($userID, $userName,$phoneNumber, $address, $payment,$cartItems);

        
        if ($orderID) {
            unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đã đặt hàng thành công
            header("Location: historyOrder.php?orderIDSuccessful=$orderID");
        } else {
            header("Location: checkout.php?orderIDFail");
            exit; // Dừng việc thực thi mã và chuyển hướng trang
        }
    } else {
        // Nếu giỏ hàng trống, thông báo cho người dùng và hiển thị tin nhắn
        echo '<p>Giỏ hàng của bạn đang trống. Vui lòng chọn sản phẩm trước khi thanh toán.</p>';
    }
}


?>
