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
    <div class="box">
            <div class="col">
                        <?php
                            foreach ($order as $item) {
                                $item['order_date'] = date('d-m-Y', strtotime($item['order_date']));
                                echo '<p class="title"><i class="bi bi-calender-fill"></i> ' . $item['order_date'] . '</p>';
                            }
                            foreach ($orderDetails as $item) {
                                $product = getProduct($item['idProduct']);
                                foreach ($product as $item_product) {
                                    echo '<img src="../IMG/' . $item_product['hinhanh'] . '" alt="" class="image">';
                                }
                            }
                            foreach ($orderDetails as $item) {
                                $product = getProduct($item['idProduct']);
                                foreach ($product as $item_product) {
                                    echo '<h3 class="name">' . $item_product['tensanpham'] .' </h3>';
                                }
                            }
                            foreach ($order as $item) {
                                echo '<p class="grand-total">Total amount payable : <span>' . number_format($item['total_amount'], 0, ",", ".") . '₫</span></p>';
                            }

                        
                        ?>
                </div>
    </div>
    <div class="box">
        <div class="col">
                        <?php
                        foreach ($user as $item) {
                            echo '<p class="user"><i class="bx bxs-user-check"></i>' . $item['nameCustomer'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-phone"></i> ' . $item['phone_number'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-map"></i> ' . $item['address'] . '</p>';
                            echo '<p class="user"><i class="bx bxs-envelope"></i> ' . $item['user_email'] . '</p>';
                        }
                        echo '<p class="title">Trạng thái</p>';
                        foreach ($order as $item) {
                            echo '<p class="status" style="color:';
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