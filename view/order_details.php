<?php
include_once ('layout/header.php');

include_once ('../database/connect.php');
include_once ('../database/orderDAL.php');
$current_url = $_SERVER['REQUEST_URI'];
$queryString = parse_url($current_url, PHP_URL_QUERY);

$order = getOrderById($queryString);
echo '<script>console.log('.json_encode($order).')</script> ';
$orderDetails = getOrderDetailId($queryString);
echo '<script>console.log('.json_encode($orderDetails).')</script> ';
$user = getEmail($queryString);

?>
<head>
    <link rel="stylesheet" href="../css/styleOrderDetail.css">
</head>
<div class="box-header">
    <h1>Chi tiết đơn hàng</h1>
</div>
<div class="box-container">
<?php
foreach ($orderDetails as $item) {
    $product = getProduct($item['idProduct']);
    $tongtien = 0;
    $sumOrder = 0;
    foreach ($product as $item_product) {
        $tongtien += $item_product['gia'] * $item['quantity'];
        $sumOrder += $tongtien;
        echo '<script>console.log('.$tongtien.')</script> ';
        echo '<div class="box">';
        echo '<div class="col">';
        foreach ($order as $itemOrder) {
            $order_date = date('d-m-Y', strtotime($itemOrder['order_date']));
        }
        echo '<p class="title"><i class="bi bi-calendar-fill"></i> ' . $order_date . '</p>';
        echo '<img src="../IMG/' . $item_product['hinhanh'] . '" alt="" class="image">';
        echo '<h3 class="name">' . $item_product['tensanpham'] .' </h3>';
        echo '<p class="quantity">Số lượng : ' . $item['quantity'] . '</p>';
        echo '<p class="price_product">Đơn giá : ' . number_format($item_product['gia'], 0, ",", ".") . '₫</p>';
        echo '<p class="grand-total">Thành tiền :  <span>  ' .  number_format($tongtien, 0, ",", ".") . '₫</span></p>';
        echo '</div>';
        echo '</div>';
    }
}
?>

    <div class="box">
        <div class="col" style="width: 94%;">
                        <?php
                        foreach ($user as $item) {
                            echo '<p class="user"><i class="bx bxs-user-check"></i>' . $item['nameCustomer'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-phone"></i> ' . $item['phone_number'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-map"></i> ' . $item['address'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-envelope"></i> ' . $item['user_email'] . '</p>';
                        }
                        foreach ($order as $item) {
                            if ($item['payment'] == 'cod') {
                                echo '<h4 style: " font-weight:bold;">Phương thức thanh toán:</h4>Thanh toán khi nhận hàng';
                            } else {
                                echo '<h4 style=" font-weight: bold;">Phương thức thanh toán: </h4>Thanh toán qua thẻ';
                            }
                        }
                        echo '<p class="total" style=" font-size:20px; font-weight: bold;">Tổng tiền : <span>' . number_format($sumOrder, 0, ",", ".") . '₫</span></p>';
                        echo '<p style=" font-size:20px; font-weight: bold;">Trạng thái</p>';
                        foreach ($order as $item) {
                            echo '<p class="status" style="color: ';
                            if ($item['status'] == 'active') {
                                echo 'red';
                            } else {
                                echo 'green';
                            }
                            echo '">';
                            if ($item['status'] == 'active') {
                                echo 'Chờ xác nhận';
                            } else {
                                echo 'Đã xác nhận';
                            }
                            echo '</p>';
                        }
                        
                        ?>
        </div>
    </div>
</div>

<?php
include_once ('layout/footer.php');
?>