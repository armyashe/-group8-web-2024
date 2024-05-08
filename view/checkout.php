<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../css/styleCheckout.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<header>
    <?php
    include_once ('layout/header.php');
    include_once ('../database/connect.php');

    if (isset($_REQUEST['orderIDSuccessful'])) // đăng nhập sai nó vô đây
        echo "<script>alert('Đơn hàng của bạn đã được đặt thành công!!')</script>";
    if (isset($_REQUEST['orderIDFail'])) // đăng nhập sai nó vô đây
        echo "<script>alert('Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại sau.')</script>";

    ?>
</header>

<body>
    <div class="container1">

        <div class="wrapper1">
            <h3 style="text-align:center;">KIỂM TRA LẠI ĐƠN HÀNG</h3>
            <div class="row">
                <table class="list-cart" >
                    <?php    // Kiểm tra nếu có sản phẩm được thêm vào giỏ hàng từ trang product_details.php
                    if (isset($_POST['add_to_cart'])) {
                        $product_id = $_POST['product_id'];
                        $product_name = $_POST['product_name'];
                        $product_price = $_POST['product_price'];

                    }

                    // Hiển thị nội dung giỏ hàng (nếu có)
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

                        echo '<table class="list-cart" style="text-align:center;">';
                        echo '<tr>';
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
                            echo '<td>' . $item['name'] . '</td>';
                            echo '<td>' . $price_formatted . '</td>';
                            echo '<td>' . $item['quantity'] . '</td>';
                            echo '<td>' . $sum_formatted . '</td>';
                            echo '</tr>';

                            $total_items += $item['quantity'];
                            $total_amount += $sum;
                        }

                        echo '<tr>';
                        echo '<td colspan="3" style="font-weight: bold; text-align: right; ">Tổng tiền (' . $total_items . ' sản phẩm):</td>';
                        echo '<td style="font-weight: bold;text-align: center;">' . number_format($total_amount, 0, ",", ".") . 'đ</td>';
                        echo '</tr>';

                        echo '</table>';

                    } else {
                        echo '<p>Không có sản phẩm nào trong giỏ hàng</p>';
                    }
                    ?>
                </table>
            </div>
        </div>
        
        <div class="left-checkout">
            <h3 style="text-align:center;">ĐỊA CHỈ GIAO HÀNG</h3>
            <a href="" style="text-decoration: none;">
            <p style="font-size: 17px; margin: 20px 0;" id="choose-address"><i class="fa-solid fa-location-dot" style="margin-right:10px;"></i>Chọn địa chỉ từ tài khoản</p>
            </a>
            <form action="process_checkout.php" name="frmDangki" method="POST">
                <label for="username">Họ và tên người nhận</label><br>

                <input type="text" name="txtTendangnhap" id="tendangnhap" class="form-control" required autocomplete="off"  placeholder="Nhập họ và tên người nhận">
                <br><label for="phone-number">Số điện thoại</label></br>
                <input type="text" name="txtDienthoai" id="sodienthoai" class="form-control" required autocomplete="off" placeholder="Ví dụ: 0934686xxx">
                <br><label for="address">Địa chỉ nhận hàng</label></br>
                <input type="text" name="txtDiachi" id="diachi" class="form-control" required autocomplete="off" placeholder="Nhập địa chỉ nhận hàng">

                <br><label for="payment">Phương thức thanh toán</label></br>
                <input type="radio" id="radiopayment1" name="radiopayment" value="ATM">
                <label for="radiopayment1">&nbsp;<img src="../IMG/image.png">&nbsp;&nbsp;ATM</label><br>

                <input type="radio" id="radiopayment2" name="radiopayment" value="cash">
                <label for="radiopayment2">Thanh toán bằng tiền mặt</label><br>

                <button type="submit" name="confirm_order" onclick="" >Xác nhận đặt hàng</button>

            </form>
        </div>

        <div class="fixed-buttons-container">
            <div class="back-to-cart">
                <a href="../view/home.php" style="text-decoration: none;">
                    <span>
                        <img src="https://cdn0.fahasa.com/skin/frontend/ma_vanese/fahasa/images/btn_back.svg?q=10354">
                    </span>
                    <span>Trở về trang chủ</span>
                </a>
            </div>

        </div>
    </div>

</body>

</html>
<script>
document.getElementById("choose-address").addEventListener("click", function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // var responseText = xhr.responseText.trim().replace(/<!--[\s\S]*?-->/g, '');
            var responseText = xhr.responseText.replace(/<!--[\s\S]*?-->/g, '');
            responseTextReplace = responseText.trim();
            if(responseText.length > 0){
                document.getElementById("diachi").value = responseText;
            } else {
                alert("Chưa có địa chỉ giao hàng trong tài khoản của bạn");
            }
        }
    };
    xhr.open("GET", "function.php", true);
    xhr.send();
});




</script>
