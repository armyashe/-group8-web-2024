<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$current_url = $_SERVER['REQUEST_URI'];
$queryString = parse_url($current_url, PHP_URL_QUERY);

$order = $conn->prepare("SELECT * FROM `order_detail` WHERE `idOrder` = '$queryString'");
$order->execute();
$order->store_result();
$donhang = $order->num_rows;





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
                        <th title="Sắp xếp" style="width: 20%">Mã đơn hàng</th>
                        <th title="Sắp xếp" style="width: 20%">Sản phẩm </th>
                        <th title="Sắp xếp" style="width: 8%">Số lượng</th>
                        <th title="Sắp xếp" style="width: 15%">Giá</th>
                        <th title="Sắp xếp" style="width: 13%">Xem</th>
                    </tr>
                </table>
                <div class="table-content" style="box-shadow: 0 0 10px #989a9b;width:99.3%">
                    <table class="table-outline hideImg ">
                        <?php
                        if($donhang > 0){
                            $order->bind_result($id_donhang,$id_sanpham,$soluong,$gia, $ghichu);
                            
                            while($order->fetch()){
                                echo '<tr>';
                                echo '<td style="width: 27%">'.$id_donhang.'</td>';
                                echo '<td style="width: 26%">';
                                $product = $conn->prepare("SELECT * FROM `sanpham` WHERE `id` = '$id_sanpham'");
                                $product->execute();
                                $product->store_result();
                                $product->bind_result($id, $tensanpham, $loaisanpham, $gia, $quantity, $mota , $hinhanh, $hinhanh2, $hinhanh3, $hinhanh4);
                                $product->fetch();

                                echo $tensanpham;
                                echo '</td>';
                                echo '<td style="width: 10%">'.$soluong.'</td>';
                                echo '<td style="width: 21%">'.number_format($gia, 0, ',', '.').'đ</td>';
                                echo '<td><button class="see-button" type="button" data-idOrder="'.$id_donhang.'" data-idProduct="'.$id_sanpham.'" data-nameProduct="'.$tensanpham.'" data-price="'.$gia.'" data-quantity="'.$soluong.'" data-img="'.$hinhanh.'" data-describe="'.$mota.'">Xem</button></td>';
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
            <div id="khungXemDonHang" class="overlay">
                
            <span class="close" onclick="closeOverlay()">&times;</span>
            <table class="overlayTable table-outline table-content table-header table-css">
                <tr>
                    <th colspan="2">Chi Tiết Đơn Hàng</th>
                </tr>
                <tr>
                    <td>Hình :</td>
                    <td>
                        <img src="" id="anhDaiDienSanPham" style="width:20%;" ><br>
                    </td>
                </tr>
                <tr>
                    <td>Mã đơn hàng : </td>
                    <td><input type="text"  id="idOder" required autocomplete="off" ></td>
                </tr>
                <tr>
                    <td>Mã sản phẩm : </td>
                    <td><input type="text"  id="idProduct" required autocomplete="off" ></td>
                </tr>
                <tr>
                    <td>Tên sản phẩm : </td>
                    <td><input type="text" id="nameProduct" required autocomplete="off" ><td>
                </tr>
                <tr>
                    <td>Số lượng :</td>
                    <td><input type="text" id="quantity" required autocomplete="off"></td>
                </tr>
                
                <tr>
                    <td>Giá :</td>
                    <td><input name="price_edit" type="text" id="gia"></td>
                </tr>
                <tr>
                    <th colspan="2">Thông số kĩ thuật</th>
                </tr>
                <tr>
                    <td>Mô tả :</td>
                    <td ><textarea  style="width: 80%; height: 7rem; box-sizing: border-box;" id="mota"></textarea></td>
                </tr>
            </table>
        </div>
</main>
<script>
    function closeOverlay() {
        document.getElementById('khungXemDonHang').style.transform = 'scale(0)';
    }

    document.querySelectorAll('.see-button').forEach(button => {
    button.addEventListener('click', function() {
        const idOrder = this.getAttribute('data-idOrder');
        const idProduct = this.getAttribute('data-idProduct');
        const nameProduct = this.getAttribute('data-nameProduct');
        const price = this.getAttribute('data-price');
        const quantity = this.getAttribute('data-quantity');
        const img = this.getAttribute('data-img');
        const describe = this.getAttribute('data-describe');




        document.getElementById('khungXemDonHang').style.transform = 'scale(1)';
        document.getElementById('idOder').value = idOrder;
        document.getElementById('idProduct').value = idProduct;
        document.getElementById('nameProduct').value = nameProduct;
        document.getElementById('quantity').value = quantity;
        document.getElementById('anhDaiDienSanPham').src = '../../IMG/' + img;
        document.getElementById('mota').value = describe;
        document.getElementById('gia').value = price;


    });
    });



</script>