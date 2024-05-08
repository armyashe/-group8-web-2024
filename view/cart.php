
<?php
include_once ('layout/header.php');
include_once ('../database/connect.php');

// Xử lý xóa giỏ hàng nếu người dùng yêu cầu
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
}

// Kiểm tra nếu có sản phẩm được thêm vào giỏ hàng từ trang product_details.php
// update_cart.php

// Xử lý yêu cầu AJAX và cập nhật giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem có dữ liệu gửi lên từ AJAX không
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    // Thực hiện cập nhật giỏ hàng ở đây
    // Ví dụ: cập nhật giỏ hàng trong session
    if ($product_id !== null && $quantity !== null) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        // Trả về phản hồi (ví dụ: có thể là JSON)
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing product_id or quantity']);
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

    $cart_items = $_SESSION['cart'];
    $cart_count = count($cart_items); // Đếm số lượng sản phẩm trong giỏ hàng
    $i = 0;
    
    while ($i < $cart_count) {
        $item = $cart_items[$i]; // Lấy một sản phẩm từ giỏ hàng
    
        $price_formatted = number_format($item['price'], 0, ",", ".") . "đ";
        $sum = $item['price'] * $item['quantity'];
        $sum_formatted = number_format($sum, 0, ",", ".") . "đ";
    
        // Bắt đầu form mới cho mỗi sản phẩm
        echo "<tr data-product='".$item["id"]."'>";
        echo '<form method="POST">'; 
        echo "<input type='hidden' class='id_product' name='product_id' value='" . $item['id'] . "' >" ;
        echo '<td>' . $item['id'] .'</td>';
        echo '<td>' . $item['name'] .'</td>';
        echo '<td class="gia">' . $price_formatted . '</td>';
        echo "<td class='soluong'>";
        echo "<button type='button' class='quantity-left-minus' data-product-id='".$item["id"]."'><i class='fa fa-minus'></i></button>";
        echo '<input class="form-control input-number" value="'.$item['quantity'].'" name="soluong" data-product-id="'.$item['id'].'">';
        echo '<button type="button" class="quantity-right-plus" data-product-id="'.$item['id'].'"><i class="fa fa-plus"></i></button>';
        echo '</form>';
        echo "</td>";
        echo '<td class="thanhtien">' . $sum_formatted . '</td>';
        
        echo '</tr>';
        // Kết thúc form cho mỗi sản phẩm
    
        $total_items += $item['quantity'];
        $total_amount += $sum;
    
        $i++;
    }
    

    echo '<tr>';
    echo '<td colspan="4">Tổng tiền (' . $total_items . ' sản phẩm):</td>';
    echo '<td>' . number_format($total_amount, 0, ",", ".") . 'đ</td>';
    echo '</tr>';

    echo '</table>';
} else {
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
document.querySelectorAll('.quantity-right-plus, .quantity-left-minus').forEach(button => {
    button.addEventListener('click', () => {
        const productID = button.dataset.productId; // Lấy ID sản phẩm từ thuộc tính data
        const input = document.querySelector(`input[name='soluong'][data-product-id='${productID}']`);
        const currentValue = parseInt(input.value);
        const action = button.classList.contains('quantity-right-plus') ? 'increase' : 'decrease';
        const newValue = action === 'increase' ? currentValue + 1 : Math.max(1, currentValue - 1); // Đảm bảo số lượng không nhỏ hơn 1

        // Gửi dữ liệu qua AJAX
        updateCart(productID, newValue);
    });
});

function updateCart(productID, quantity) {
    // Tạo một đối tượng XMLHttpRequest
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'function.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Xử lý khi nhận được phản hồi từ server
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                window.location.reload();
                
            } else {
                // Xử lý lỗi nếu có
                console.error('Đã xảy ra lỗi:', xhr.status);
            }
        }
    };


    // Gửi yêu cầu POST với dữ liệu sản phẩm và số lượng mới
    xhr.send(`product_id=${productID}&quantity=${quantity}`);
}




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



</script>