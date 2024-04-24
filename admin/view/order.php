<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$order = $conn->prepare("SELECT * FROM `orders`");
$order->execute();
$order->store_result();
$donhang = $order->num_rows;


if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $trangthai = $_POST['trangthai'];
    $update = $conn->prepare("UPDATE `orders` SET `status` = ? WHERE `idOrder` = ?");
    $update->bind_param("ss", $trangthai, $id);
    $update->execute();
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST['delete'])){

    $username = $_POST['username'];

    // Delete product details
    
    $deleteProductDetailQuery = "DELETE FROM order_detail WHERE idOrder IN (SELECT idOrder FROM orders WHERE idUser = (SELECT id FROM user WHERE user_name = ?))";
    $deleteProductDetailStmt = $conn->prepare($deleteProductDetailQuery);
    $deleteProductDetailStmt->bind_param("s", $username);
    $deleteProductDetailStmt->execute();

    // Delete orders
    $deleteOrderQuery = "DELETE FROM orders WHERE idUser = (SELECT id FROM user WHERE user_name = ?)";
    $deleteOrderStmt = $conn->prepare($deleteOrderQuery);
    $deleteOrderStmt->bind_param("s", $username);
    $deleteOrderStmt->execute();

    // Delete user
    $deleteUserQuery = "DELETE FROM user WHERE user_name = ?";
    $deleteStmt = $conn->prepare($deleteUserQuery);
    $deleteStmt->bind_param("s", $username);
    if($deleteStmt->execute()) 
    {
        echo '<script>alert("Xóa đơn hàng của khách hàng '.$username.' thành công")</script>';
    }   
}

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
    $order = $conn->prepare("SELECT * FROM `orders` WHERE `status` = ?");
    $order->bind_param("i", $search);
    $order->execute();
    $order->store_result();
    $donhang = $order->num_rows;
}
?>
<main>
            <div class="cards_customer">
                <table class="table-header">
                    <tr>
                        <!-- Theo độ rộng của table content -->
                        <th title="Sắp xếp" style="width: 5%">Mã</th>
                        <th title="Sắp xếp" style="width: 8%">Khách </th>
                        <th title="Sắp xếp" style="width: 20%">Sản phẩm </th>
                        <th title="Sắp xếp" style="width: 15%">Tổng tiền </th>
                        <th title="Sắp xếp" style="width: 20%">Địa chỉ </th>
                        <th title="Sắp xếp" style="width: 10%">Ngày giờ </th>
                        <th title="Sắp xếp" style="width: 13%">Trạng thái</th>
                    </tr>
                </table>
                <div class="table-content" style="box-shadow: 0 0 10px #989a9b;width:99.3%">
                    <table class="table-outline hideImg ">
                        <?php
                        if($donhang > 0){
                            $order->bind_result($id, $id_khachhang,$tenkhachhang,$phone,$diachi, $ngaygio, $tongtien, $trangthai,$thanhtoan);
                            
                            while($order->fetch()){
                                echo '<tr>';
                                echo '<td style="width: 5%">'.$id.'</td>';
                                echo '<td style="width: 8%">'.$tenkhachhang.'</td>';
                                echo '<td style="width: 20%">';
                                $product = $conn->prepare("SELECT `idProduct`, `quantity` FROM `order_detail` WHERE `idOrder` = ?");
                                $product->bind_param("i", $id);
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
                                    echo $tensanpham.' [ '.$soluong.' ]'.'<br>';
                                }
                                echo '</td>';
                                echo '<td style="width: 15%">'.number_format($tongtien, 0, ',', '.').'đ</td>';
                                echo '<td style="width: 20%">'.$diachi.'</td>';
                                echo '<td style="width: 11%">'.$ngaygio.'</td>';
                                if($trangthai == 'active')
                                {
                                    $trangthaiText = 'Chờ xác nhận';
                                    $nextStatus = 'confirm'; // Trạng thái tiếp theo là "Đã xác nhận"

                                } 
                                else if($trangthai != 'active')
                                {
                                    $trangthaiText = 'Đã xác nhận';
                                    $nextStatus = 'active'; // Không cho phép quay lại trạng thái "Chờ xác nhận"
                                }  
                                if($trangthai == 'active') {
                                    echo '<form action="" method="post">';
                                    echo '<input type="hidden" name="id" value="'.$id.'">';
                                    echo '<input type="hidden" name="trangthai" value="'.($trangthaiText == 'Chờ xác nhận' ? 'active' : 'confirm').'">';
                                    $buttonClass = $trangthai == 'Chờ xác nhận' ? '' : 'confirmed-button';
                                    echo '<td style="width: 13%;">
                                    <button class="button_edit" type="submit" name="submit">' . $trangthaiText . '</button>
                                    <input type="hidden" name="username" value="'.$username.'">
                                    <button type="submit" class="delete_edit" name="delete" onclick="submitFormAndReload()" id="submitForm">Xoá</button>
                                    </td>';
                                    echo '</form>';
                                } else {
                                    echo '<td style="width: 13%"><button class="confirmed-button" type="button" disabled>' . $trangthaiText . '</button></td>';
                                }
                                echo '</tr>';
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
</main>
<script>
    function submitFormAndReload() {
        document.getElementById('submitForm').click();
        location.reload();
    }
</script>