<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$customer = $conn->prepare("SELECT `id` FROM `user`");
$customer->execute();
$customer->store_result();
$khachhang = $customer->num_rows;



$order = $conn->prepare("SELECT `idOrder` FROM `orders`");
$order->execute();
$order->store_result();
$donhang = $order->num_rows;


// nếu có đơn hàng thì tính cập nhật tổng tiền của tất cả các đơn hàng
if($order->num_rows > 0){
    $order_amount = $conn->prepare("SELECT `total_amount` FROM `orders`");
    $order_amount->execute();
    $order_amount->store_result();
    $order_amount->bind_result($tongtien);
    $total = 0;
    while($order_amount->fetch()){
        $total += $tongtien;
    }
}
else{
    $total = 0;
}



$product = $conn->prepare("SELECT `id` FROM `sanpham`");
$product->execute();
$product->store_result();
$sanpham = $product->num_rows;






?>
<main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo $khachhang ?></h1>
                        <span>Khách hàng</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo $donhang ?></h1>
                        <span>Đơn hàng</span>
                    </div>
                    <div>
                        <span class="las la-clipboard-list"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo $sanpham ?></h1>
                        <span>Sản phẩm</span>
                    </div>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo number_format($total, 0, '', '.'); ?>₫</h1>
                        <span>Doanh thu</span>
                    </div>
                    <div>
                        <span class="lab la-google-wallet"></span>
                    </div>
                </div>
            </div>

            <div class="recent-gird">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>ĐƠN HÀNG</h3>
                            <a href="order.php" style="color: rgb(248, 244, 244);"><button>Xem tất cả <span class="las la-arrow-right"></a></span></button>
                        </div>

                        <div class="card-body">
                            <div class="card">
                                <table class="table-header">
                                    <th title="Sắp xếp" style="width: 5%">Stt</i></th>
                                    <th title="Sắp xếp" style="width: 9%">Khách</i></th>
                                    <th title="Sắp xếp" style="width: 24%">Sản phẩm</i></th>
                                    <th title="Sắp xếp" style="width: 20%">Trạng thái</i></th>
                                </table>
                            </div>
                            <div class="table-content" style="box-shadow: 1px 1px 1px rgba(48, 47, 47, 0.2);">
                                <?php
                                $limit = 3;
                                $printed = 0; // Biến đếm số lượng đơn hàng đã được in ra
                                if($donhang > 0)
                                {
                                    
                                    $stt = 1;
                                    $order->bind_result($id);

                                    while($order->fetch() && $printed < $limit){

                                        $user = $conn->prepare("SELECT `nameCustomer` FROM `orders` WHERE `idOrder` = ?");
                                        $user->bind_param("s", $id);
                                        $user->execute();
                                        $user->store_result();
                                        $user->bind_result($username);
                                        $user->fetch();
                                echo '
                                <table class="table-outline hideImg" style="margin-top: 20px;">
                                    <th style="width: 4%">'.$stt.'</th>
                                    <th title="Sắp xếp" style="width: 5%">' . $username. '</th>';

                                $product = $conn->prepare("SELECT `idProduct`, `quantity` FROM `order_detail` WHERE `idOrder` = ?");
                                $product->bind_param("s", $id);
                                $product->execute();
                                $product->store_result();
                                $product->bind_result($id_sanpham, $soluong);
                                while($product->fetch()){
                                    $product_name = $conn->prepare("SELECT `tensanpham` FROM `sanpham` WHERE `id` = ?");
                                    $product_name->bind_param("i", $id_sanpham);
                                    $product_name->execute();
                                    $product_name->store_result();
                                    $product_name->bind_result($tensanpham);
                                    $product_name->fetch();
                                    echo '<th title="Xem chi tiết" style="width: 20%"> <a href="../../view/product_detail.php?id=1" style="color: blue;">'.$tensanpham.'</a> </th>';
                                }
                                $order_status = $conn->prepare("SELECT `status` FROM `orders` WHERE `idOrder` = ?");
                                $order_status->bind_param("s", $id);
                                $order_status->execute();
                                $order_status->store_result();
                                $order_status->bind_result($trangthai);

                                // Khởi tạo biến $trangthaiText
                                $trangthaiText = '';

                                if($order_status->fetch()) {
                                    if($trangthai == 'active') {
                                        $trangthaiText = 'Đã xác nhận';
                                    }  
                                }
                                echo '<th title="Sắp xếp" style="width: 15%">'.$trangthaiText.'</th> 
                                </table>';
                                $stt++;
                                $printed++;
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="customers">
                    <div class="card">
                        <div class="card-header">
                            <h3>Khách hàng mới</h3>
                            <a href="customer.php" style="color: rgb(250, 247, 247);"><button>Xem tất cả<span class="las la-arrow-right"></span></a>

                                </span></button>
                        </div>

                        <div class="card-body">
                            <div class="customer">
                                <div class="info">
                                    <img src="../templates/img/feedback1.png" width="40px" height="40px" alt="">
                                    <div>
                                        <h4>Ms Lộ Tư</h4>
                                        <small>Diễn viên</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>


                            <div class="customer">
                                <div class="info">
                                    <img src="../templates/img/Park-Jihoon.jpeg" width="40px" height="40px" alt="">
                                    <div>
                                        <h4>Park Jihoon</h4>
                                        <small>CEO Alibaba</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>

                            <div class="customer">
                                <div class="info">
                                    <img src="../templates/img/feedback2.png" width="40px" height="40px" alt="">
                                    <div>
                                        <h4>Thiên Hân</h4>
                                        <small>Tiktoker</small>
                                    </div>
                                </div>
                                <div class="contact">
                                    <span class="las la-user-circle"></span>
                                    <span class="las la-comment"></span>
                                    <span class="las la-phone"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>