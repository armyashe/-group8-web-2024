<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$order = $conn->prepare("SELECT * FROM `orders`");
$order->execute();
$order->store_result();
$donhang = $order->num_rows;





// tìm kiếm ngày giờ đơn hàng
if(isset($_POST['fromDate']) && isset($_POST['toDate'])){
    $fromDate = $_POST['fromDate'];
    $toDate = $_POST['toDate'];

    // Chuyển định dạng ngày từ yyyy-mm-dd sang yyyy-mm-dd HH:mm:ss để phù hợp với cú pháp của SQL
    $fromDate = date("Y-m-d 00:00:00", strtotime($fromDate));
    $toDate = date("Y-m-d 23:59:59", strtotime($toDate));

    $order = $conn->prepare("SELECT * FROM `orders` WHERE `order_date` BETWEEN ? AND ?");
    $order->bind_param("ss", $fromDate, $toDate);
    $order->execute();
    $order->store_result();
    $donhang = $order->num_rows;
} 

// Tìm kiếm theo địa điểm giao hàng
if(isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'diachi' && isset($_POST['search'])){
    $search = $_POST['searchTerm'];
    
    $searchTerm = '%' . $search . '%';
    
    $order = $conn->prepare("SELECT * FROM `orders` WHERE `address` LIKE ?");
    $order->bind_param("s", $searchTerm);
    $order->execute();
    $order->store_result();
    $donhang = $order->num_rows;
}

// Tìm kiếm theo tên khách hàng
if(isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'khachhang' && isset($_POST['search'])){
    $search = $_POST['searchTerm'];
    
    $searchTerm = '%' . $search . '%';
    
    $order = $conn->prepare("SELECT * FROM `orders` WHERE `nameCustomer` LIKE ?");
    $order->bind_param("s", $searchTerm);
    $order->execute();
    $order->store_result();
    $donhang = $order->num_rows;
}

// Tìm kiếm theo trạng thái
if(isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'trangThai' && isset($_POST['search'])){
    $search = $_POST['searchTerm'];

    $searchTerm = '%' . $search . '%';
    $order = $conn->prepare("SELECT * FROM `orders` WHERE `status` LIKE ?");
    $order->bind_param("s", $searchTerm);
    $order->execute();
    $order->store_result();
    $donhang = $order->num_rows;
}
?>
<main>
            <div class="cards_customer">
                <?php
                    if(isset($_POST['search']) && isset($_POST['kieuTimDonHang']) ){
                        echo '<h2>Kết quả tìm kiếm cho "'.$search.'"</h2>';
                    }
                    else if(isset($_POST['fromDate']) && isset($_POST['toDate'])){
                        $fromDate = date("d-m-Y", strtotime($fromDate));
                        $toDate = date("d-m-Y", strtotime($toDate));
                        echo '<h2>Danh sách đơn hàng từ '.$fromDate.' đến '.$toDate.'</h2>';
                    }
                    else{
                        echo '<h2>Danh sách đơn hàng</h2>';
                    }
                    ?>
                <table class="table-header">
                    <tr>
                        <!-- Theo độ rộng của table content -->
                        <th title="Sắp xếp" style="width: 5%">Stt</th>
                        <th title="Sắp xếp" style="width: 8%">Khách </th>
                        <th title="Sắp xếp" style="width: 20%">Sản phẩm </th>
                        <th title="Sắp xếp" style="width: 15%">Tổng tiền </th>
                        <th title="Sắp xếp" style="width: 20%">Địa chỉ </th>
                        <th title="Sắp xếp" style="width: 10%">Ngày giờ </th>
                        <th title="Sắp xếp" style="width: 13%">Trạng thái</th>
                        <th title="Sắp xếp" style="width: 13%">Xem</th>
                    </tr>
                </table>
                <div class="table-content" style="box-shadow: 0 0 10px #989a9b;width:99.3%">
                    <table class="table-outline hideImg ">
                        <?php
                        if($donhang > 0){
                            $stt = 1;
                            $order->bind_result($id, $id_khachhang,$tenkhachhang,$phone,$diachi, $ngaygio, $tongtien, $trangthai,$thanhtoan);
                            
                            while($order->fetch()){
                                echo '<tr>';
                                echo '<td style="width: 5%">'.$stt.'</td>';
                                echo '<td style="width: 8%">'.$tenkhachhang.'</td>';
                                echo '<td style="width: 21%">';
                                $product = $conn->prepare("SELECT `idProduct`, `quantity` FROM `order_detail` WHERE `idOrder` = ?");
                                $product->bind_param("s", $id);
                                $product->execute();
                                $product->store_result();
                                $product->bind_result($id_sanpham, $soluong);
                                while($product->fetch()){
                                    $product_name = $conn->prepare("SELECT `tensanpham`,`hinhanh` FROM `sanpham` WHERE `id` = ?");
                                    $product_name->bind_param("i", $id_sanpham);
                                    $product_name->execute();
                                    $product_name->store_result();
                                    $product_name->bind_result($tensanpham,$hinhanh);
                                    $product_name->fetch();
                                    echo $tensanpham.' [ '.$soluong.' ]'.'<br>';
                                }
                                echo '</td>';
                                echo '<td style="width: 15%">'.number_format($tongtien, 0, ',', '.').'đ</td>';
                                echo '<td style="width: 20%">'.$diachi.'</td>';
                                $ngaygio = date("d-m-Y H:i:s", strtotime($ngaygio));
                                echo '<td style="width: 11%">'.$ngaygio.'</td>';
                                if($trangthai == 'active'){
                                    $trangthaiText = 'Chờ xác nhận';
                                    $nextStatus = 'confirm';
                                } else {
                                    $trangthaiText = 'Đã giao';
                                    $nextStatus = 'active';
                                }
                                if($trangthai == 'active') {
                                    echo '<form method="post" class="statusChange">';
                                    echo '<input type="hidden" class="id_order" name="idOrder" value="'.$id.'">';
                                    echo '<input type="hidden" class="status_order" name="status" value="'.($trangthai == 'active' ? 'confirm' : 'active').'">';
                                    $buttonClass = $trangthai == 'Chờ xác nhận' ? '' : 'confirmed-button';
                                    echo '<td style="width: 13%;">
                                    <button class="button_edit" type="submit" name="submitChange">' .$trangthaiText. '</button>
                                    </form>
                                    <form class="delete_order">
                                    <input type="hidden" class="id_order" name="idOrder" value="'.$id.'">
                                    <input type="hidden" class="deleteOrder" name="delete" value="true">
                                    <button type="submit" class="delete_edit" id="submitForm">Xoá</button>
                                    </form>
                                    </td>';
                                } else {
                                    echo '<td style="width: 13%"><button class="confirmed-button" type="button" disabled>' . $trangthaiText . '</button></td>';
                                }
                                echo '<td><a href="order_detail.php?'.$id.'" style="text-decoration: none;"><button class="see-button" type="button">Xem</button><a></td>';
                                echo '</tr>';
                                $stt++;
                            }
                        }
                        else {
                            // Hiển thị thông báo nếu không có đơn hàng nào trong khoảng thời gian được chọn
                            echo "<tr><td colspan='7' style='color:red;font-size:20px'>Không có đơn hàng nào trong kết quả tìm kiếm</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="table-footer">
                <div class="timTheoNgay">
                    <form action="" method="post">
                        Từ ngày: <input type="date" id="fromDate" name="fromDate">
                        Đến ngày: <input type="date" id="toDate" name="toDate">

                        <button type="submit">
                            <i class="fa fa-search"></i>Tìm
                        </button>
                    </form>
                    
                </div>
                <div class="timtheodon" style="margin-top: 2%;">
                    <form action="" method="post">
                        <select name="kieuTimDonHang">
                            <option value="diachi">Tìm theo địa điểm giao hàng</option>
                            <option value="khachhang">Tìm theo tên khách hàng</option>
                            <option value="trangThai">Tìm theo trạng thái</option>
                        </select>
                        <input type="text" placeholder="Tìm kiếm..." name="searchTerm" autocomplete="off">
                        <button style="margin-left: 4px;" type="submit" name="search">
                            <i class="fa fa-search"></i>Tìm
                        </button>
                    </form>
                    
                </div>

            </div>
            
        </div>
</main>
<script>


    $(document).ready(function() {
    $('.statusChange').submit(function(e) {
        e.preventDefault();

        var result = confirm('Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng?');
        if (result) {

        var orderId = document.querySelector('.id_order').value;
        var nextStatus = document.querySelector('.status_order').value;
        var formData = $(this).serialize();
        console.log(formData);
        
        console.log(orderId);
        console.log(nextStatus);

        $.ajax({
            type: 'POST',
            url: '../handler/functionHandler.php', 
            data: {
                idOrder: orderId,
                status: nextStatus
            },
            success: function(response) {
                console.log(response);
                console.log(response.status);
                // Xử lý phản hồi từ máy chủ (nếu cần)
                if (response.status === 'true') {
                    alert('Cập nhật trạng thái đơn hàng thành công.');

                    location.reload();
                } else {
                    // Xử lý lỗi (nếu cần)
                    alert('Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.');
                }
            }
        });
    } else {
        return false;
    }
    });
});

    $(document).ready(function() {
    $('.delete_order').submit(function(e) {
        e.preventDefault();

        var result = confirm('Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng?');
        if (result) {
        var orderId = document.querySelector('.id_order').value;
        console.log(orderId);
        var deleteOrder = $('.deleteOrder').val();
        console.log(deleteOrder);
        var $rowToDelete = $(this).closest('tr');

        $.ajax({
            type: 'POST',
            url: '../handler/functionHandler.php', 
            data: {
                idOrder: orderId,
                delete: deleteOrder
            },
            success: function(response) {
                console.log(response);
                console.log(response.status);
                // Xử lý phản hồi từ máy chủ (nếu cần)
                if (response.status === 'true') {
                    alert('Xóa đơn hàng thành công.');
                    $rowToDelete.remove();
                } else {
                    // Xử lý lỗi (nếu cần)
                    alert('Có lỗi xảy ra khi xóa đơn hàng.');
                }
            }
        });
    } else {
        return false;
    }
    });
});

</script>