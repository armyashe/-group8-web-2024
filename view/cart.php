

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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if(isset($_POST['product_id']) && isset($_POST['soluong']))
    {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['soluong'];
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] = $quantity;
                $product_exists = true;
                break;
            }
        }

    }


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
    echo '</tr>';

    $total_items = 0;
    $total_amount = 0;

    foreach ($_SESSION['cart'] as $item) {
        $price_formatted = number_format($item['price'], 0, ",", ".") . "đ";
        $sum = $item['price'] * $item['quantity'];
        $sum_formatted = number_format($sum, 0, ",", ".") . "đ";

        echo '<form method="post">';
        echo '<tr>';
        echo "<input type='hidden' name='product_id' value='" . $item['id'] . "'>" . "</input>";
        echo '<td>' . $item['id'] . '</td>';
        echo '<td>' . $item['name'] . '</td>';
        echo '<td>' . $price_formatted . '</td>';
        echo "<td class='soluong'>";
        echo "<button type='submit' class='quantity-left-minus'><i class='fa fa-minus'></i></button>";
        echo "<input class='form-control input-number' value='{$item['quantity']}' name='soluong'>";
        echo "<button type='submit' class='quantity-right-plus'><i class='fa fa-plus'></i></button>";
        echo "</td>";
        echo '<td>' . $sum_formatted . '</td>';
        

       // echo'<td>'.date("Y-m-d H:i:sa",$item['date']) .'</td>';

        echo '</tr>';

        $total_items += $item['quantity'];
        $total_amount += $sum;
        echo '</form>';
    }

    echo '<tr>';
    echo '<td colspan="4">Tổng tiền (' . $total_items . ' sản phẩm):</td>';
    echo '<td>' . number_format($total_amount, 0, ",", ".") . 'đ</td>';
    echo '</tr>';

    echo '</table>';


} 
else {
    echo '<h1 style=color:red;margin-top:2%;>Giỏ hàng của bạn đang trống !!!</h1>';
}
?>
 <head>
        <title>Giỏ hàng</title>
        <link rel="stylesheet" href="../css/styleGH.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- <link rel="stylesheet" href="../templates/js/bootstrap.min.js"> -->
        <script src="../javascripts/search.js"></script>
 </head>


    <div class="body">
        <div class="row">
            <table class="list-cart">
                <!-- Bảng hiển thị danh sách sản phẩm trong giỏ hàng (nếu có) -->
            </table>

        </div>
        <?php
        if ((isset($_SESSION['cart']) && !empty($_SESSION['cart'])))
        {
            echo '<div id="button-container">
            <!-- Nút chức năng -->
            <button class="btn btn-primary" onclick="confirmPayment()">Thanh toán</button>        
            <button class="btn btn-danger" onclick="confirmDelete()">Xóa giỏ hàng</button></a>
            <p><a href="home.php" class="btn btn-primary">Tiếp tục mua hàng</a></p>
        </div>';
        }
        
        ?>
    </div>
<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer> 
</body>
</html>
<script>
    // Sự kiện click nút tăng số lượng
document.querySelectorAll('.quantity-right-plus').forEach(button => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('input');
        const currentValue = parseInt(input.value);
        input.value = currentValue + 1;
        console.log('Số lượng sau khi tăng:', input.value);
        updateCart(); // Cập nhật giỏ hàng sau khi thay đổi số lượng
    });
});

// Sự kiện click nút giảm số lượng
document.querySelectorAll('.quantity-left-minus').forEach(button => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('input');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
            console.log('Số lượng sau khi giảm:', input.value);
            updateCart(); // Cập nhật giỏ hàng sau khi thay đổi số lượng
        }
    });
});

// Hàm xác nhận thanh toán
function confirmPayment() {
    var result = confirm('Bạn có chắc chắn muốn thanh toán giỏ hàng không?');
    if (result) {
        // Nếu người dùng đồng ý, gửi dữ liệu form
        window.location.href = 'checkout.php';
    } else {
        // Nếu người dùng hủy, không gửi dữ liệu form
        return false;
    }
}

// Hàm xác nhận xóa tất cả sản phẩm khỏi giỏ hàng
function confirmDelete() {
    var result = confirm('Bạn có chắc chắn muốn xóa hết sản phẩm khỏi giỏ hàng không?');
    if (result) {
        // Nếu người dùng đồng ý, gửi dữ liệu form
        window.location.href = 'cart.php?clear=true';
        alert('Đã xóa giỏ hàng thành công!');
    } else {
        // Nếu người dùng hủy, không gửi dữ liệu form
        return false;
    }
}

// Hàm cập nhật giỏ hàng
function updateCart() {
    let totalPrice = 0; 
    // Lấy danh sách sản phẩm trong giỏ hàng
    const products = document.querySelectorAll('.list-cart tbody tr');
    products.forEach(product => {
        const soluong = parseInt(product.querySelector('.soluong input').value);
        const gia = parseInt(product.querySelector('td:nth-child(3)').textContent.replace(/\D/g, ''));
        if (!isNaN(soluong) && !isNaN(gia)) {
            const thanh_tien = soluong * gia;

            // Cập nhật giá trị mới cho sản phẩm trong bảng giỏ hàng
            product.querySelector('td:nth-child(5)').textContent = numberWithCommas(thanh_tien) + ' ₫';
            totalPrice += thanh_tien; 
            console.log('Tổng giá trị:', totalPrice);
        }
    });

    // Cập nhật tổng giá trị của giỏ hàng
    const totalElement = document.querySelector('.list-cart tbody tr:last-child td:nth-child(2)');
    if (totalElement) {
        totalElement.textContent = numberWithCommas(totalPrice) + ' ₫';
    }
}

</script>