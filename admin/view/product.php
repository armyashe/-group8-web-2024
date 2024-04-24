<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$product = $conn->prepare("SELECT * FROM `sanpham`");
$product->execute();
$product->store_result();
$sanpham = $product->num_rows;


// thêm sản phẩm
if(isset($_POST['submit'])){

    $id_product = $_POST['id_product'];
    $name_product = $_POST['name_product'];
    $price = $_POST['price'];
    $loaisanpham = $_POST['product_type'];
    $insert = $conn->prepare("INSERT INTO `sanpham`(`id`, `tensanpham`, `loaisanpham`, `gia`) VALUES (?, ?, ?, ?)");
    $insert->bind_param("issi", $id_product, $name_product, $loaisanpham, $price);
    $insert->execute();
    $insert->close();
}

// xóa sản phẩm
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tensanpham"]) && isset($_POST["delete"])){

    $name_product = $_POST['tensanpham'];
    $delete = $conn->prepare("DELETE FROM `sanpham` WHERE  tensanpham = ?");
    $delete->bind_param("s", $_POST['tensanpham']);
    if($delete->execute()){
        echo '<script>alert("Xóa sản phẩm '.$name_product .' thành công")</script>';
    }
}

// sửa sản phẩm
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitEdit'])){
    $productName = $_POST['productName'];
    $id_product = $_POST['id_product'];
    $name_product = $_POST['name_product'];
    $price = $_POST['price'];
    $loaisanpham = $_POST['product_type'];

    $insert = $conn->prepare("UPDATE sanpham SET id= ? , tensanpham = ?, loaisanpham = ?, gia = ? WHERE tensanpham=?");
    $insert->bind_param("issis",$id_product, $name_product, $loaisanpham, $price, $productName);
    if($insert->execute()){
        echo '<script>alert("Sửa sản phẩm '.$productName .' thành công")</script>';
    }
}

// tìm kiếm sản phẩm theo mã
if(isset($_POST['search']) && $_POST['kieuTimSanPham'] == 'ma' && isset($_POST['kieuTimSanPham'])){
    $search = $_POST['searchTerm'];

    $product = $conn->prepare("SELECT * FROM `sanpham` WHERE id = ?");
    $product->bind_param("i", $search);
    $product->execute();
    $product->store_result();
    $sanpham = $product->num_rows;
}

// tìm kiếm sản phẩm theo tên
if(isset($_POST['search']) && $_POST['kieuTimSanPham'] == 'ten' && isset($_POST['kieuTimSanPham'])){
    $search = $_POST['searchTerm'];
    $searchTerm = '%'.$search.'%';

    $product = $conn->prepare("SELECT * FROM `sanpham` WHERE tensanpham LIKE ?");
    $product->bind_param("s", $searchTerm);
    $product->execute();
    $product->store_result();
    $sanpham = $product->num_rows;
}
?>
<main>
    <div class="cards_customer">
        <table class="table-header">
            <tr>
                <!-- Theo độ rộng của table content -->
                <th title="Sắp xếp" style="width: 5%">Stt </th>
                <th title="Sắp xếp" style="width: 12%">Mã </th>
                <th title="Sắp xếp" style="width: 40%">Tên </th>
                <th title="Sắp xếp" style="width: 15%">Giá </th>
                <th style="width: 15%">Hành động</th>
            </tr>
        </table>
        <div class="table-content" style="width: 99.3%;box-shadow: 1px 1px 1px rgba(48, 47, 47, 0.2);">
            <table class="table-outline hideImg">
                <?php
                if($sanpham > 0){
                    $stt = 1;
                    $product->bind_result($id, $tensanpham, $loaisanpham, $gia,$soluong,$mota,$mota2,$mota3,$mota4,$hinhanh,$hinhanh2,$hinhanh3,$hinhanh4);
                    while($product->fetch()){
                        echo '<tr>';
                        echo '<td style="width: 5%">'.$stt.'</td>';
                        echo '<td style="width: 12%">'.$id.'</td>';
                        echo '<td style="width: 40%">';
                        echo '<a title="Xem chi tiết" target="_blank" href="../../view/product_detail.php?id=' . $id . '" style="margin-left: 2%;">'.$tensanpham.'</a>';
                        echo '<img src="../../IMG/'.$hinhanh.'"></img>';
                        echo '</td>';
                        echo '<td style="width: 15%">'.number_format($gia, 0, ',', '.').'₫</td>';
                        echo '<td style="width: 15%">';
                        echo'<div class="tooltip">
                                <button type="button" style="border:none;background-color:transparent" class="editUserButton" data-id="'.$id.'" data-name="'.$tensanpham.'" data-price="'.$gia.'" data-type="'.$loaisanpham.'">
                                    <i class="fa fa-wrench" style="font-size: 20px;margin: 0 15px;"></i>
                                    <span class="tooltiptext">Sửa</span>
                                </button>
                            </div>';
                        echo '<div class="tooltip" >
                                <form action="" method="post" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="tensanpham" value="'.$tensanpham.'">
                                    <input type="hidden" name="delete" value="true">
                                    <button type="submit" style="border:none;background-color:transparent">
                                        <i class="fa fa-trash" style="font-size: 20px;"></i>
                                        <span class="tooltiptext">Xóa</span>
                                    </button>
                                </form>
                            </div>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                        $stt++;
                    }
                }
                else{
                    echo '<tr>';
                    echo '<td colspan="7">Không có sản phẩm nào trong kết quả tìm kiếm</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
        </div>
        <div class="table-footer">
            <button id="addUserButton">
                <i class="fa fa-plus-square"></i>
                    Thêm sản phẩm
            </button>
            <div class="timtheosanpham" style="margin-top:2%;">
                <form action="" method="post">
                    <select name="kieuTimSanPham">
                        <option value="ma">Tìm theo mã</option>
                        <option value="ten">Tìm theo tên</option>
                    </select>
                    <input type="text" placeholder="Tìm kiếm..." name="searchTerm" autocomplete="off">
                    <button style="margin-left: 4px;" type="submit" name="search">
                        <i class="fa fa-search"></i>Tìm
                    </button>
                </form>
            </div>
        </div>
        <div id="khungThemSanPham" class="overlay">
            <span class="close" onclick="closeOverlay1()">&times;</span>
            <table class="overlayTable table-outline table-content table-header table-css">
                <tr>
                    <th colspan="2">Thêm Sản Phẩm</th>
                </tr>
                <form action="" method="post">
                <tr>
                    <td>Mã sản phẩm:</td>
                    <td><input type="text" name="id_product" id="maspThem" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Tên sản phẩm:</td>
                    <td><input type="text" name="name_product" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Hình:</td>
                    <td>
                        <img class="hinhDaiDien" id="anhDaiDienSanPhamThem" src="">
                        <input type="file" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td>Giá tiền:</td>
                    <td><input class="inputPrice" type="text" name="price" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Loại sản phẩm:</td>
                    <td><input type="text" name="product_type" required autocomplete="off"></td>
                </tr>
                <tr>
                    <th colspan="2">Thông số kĩ thuật</th>
                </tr>
                <tr>
                    <td>Chất liệu :</td>
                    <td><input class="inputChatLieu" type="text" ></td>
                </tr>
                <tr>
                    <td>Kích thước :</td>
                    <td><input class="inputSize" type="text" ></td>
                </tr>
                <tr>
                    <td>Khung viền :</td>
                    <td><input class="inputBorderColor" type="text" ></td>
                </tr>
                <tr>
                    <td>Màu :</td>
                    <td><input class="inputColor" type="text" ></td>
                </tr>
                <tr>
                    <td>Khác :</td>
                    <td><input class="inputMore" type="text" ></td>
                </tr>
                <tr>
                    <td>Chiều dài :</td>
                    <td><input class="inputHeight" type="text" ></td>
                </tr>
                <tr>
                    <td>Chiều rộng :</td>
                    <td><input class="inputWidth" type="text" ></td>
                </tr>
                <tr>
                    <td colspan="2" class="table-footer"> 
                        <button type="submit" name="submit">Thêm</button>
                    </td>
                </tr>
                </form>
            </table>
        </div>
        <div id="khungSuaSanPham" class="overlay">
            <span class="close" onclick="closeOverlay2()">&times;</span>
            <table class="overlayTable table-outline table-content table-header table-css">
                <tr>
                    <th colspan="2">Sửa Sản Phẩm</th>
                </tr>
                <form action="" method="post">
                <tr>
                    <td>Mã sản phẩm: </td>
                    <td><input type="text" name="id_product" id="maspSua" required autocomplete="off" ></td>
                </tr>
                <tr>
                    <td>Tên sản phẩm: </td>
                    <td><input type="text" name="name_product" id="tenSua" required autocomplete="off" ><td>
                </tr>
                <tr>
                    <td>Hình:</td>
                    <td>
                        <img class="hinhDaiDien" id="anhDaiDienSanPhamThem" src="">
                        <input type="file" accept="image/*" >
                    </td>
                </tr>
                <tr>
                    <td>Giá tiền:</td>
                    <td><input class="inputPrice" name="price" type="text" id="giaSua"></td>
                </tr>
                <tr>
                    <td>Loại sản phẩm:</td>
                    <td><input type="text" name="product_type" required autocomplete="off" id="loaiSua"></td>
                </tr>
                <tr>
                    <th colspan="2">Thông số kĩ thuật</th>
                </tr>
                <tr>
                    <td>Chất liệu : .</td>
                    <td><input class="inputChatLieu" type="text" ></td>
                </tr>
                <tr>
                    <td>Kích thước : </td>
                    <td><input class="inputSize" type="text" ></td>
                </tr>
                <tr>
                    <td>Khung viền : </td>
                    <td><input class="inputBorderColor" type="text" ></td>
                </tr>
                <tr>
                    <td>Màu : </td>
                    <td><input class="inputColor" type="text" ></td>
                </tr>
                <tr>
                    <td>Khác : </td>
                    <td><input class="inputMore" type="text" ></td>
                </tr>
                <tr>
                    <td>Chiều dài : </td>
                    <td><input class="inputHeight" type="text" ></td>
                </tr>
                <tr>
                    <td>Chiều rộng : </td>
                    <td><input class="inputWidth" type="text" ></td>
                </tr>
                <tr>
                    <td colspan="2" class="table-footer"> 
                        <input type="hidden" name="productName" value="">
                        <button type="submit" name="submitEdit">Sửa</button> 
                    </td>
                </tr>
                </form>
            </table>
        </div>
            </div>
</main>
<script>
    document.getElementById('addUserButton').addEventListener('click', function() {
        document.getElementById('khungThemSanPham').style.transform = 'scale(1)';
    });

    function closeOverlay1() {
        document.getElementById('khungThemSanPham').style.transform = 'scale(0)';
    }

    document.querySelectorAll('.editUserButton').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const price = this.getAttribute('data-price');
        const type = this.getAttribute('data-type');

        // Cập nhật giá trị của input hidden name="productName"
        document.querySelector('input[name="productName"]').value = name;

        document.getElementById('khungSuaSanPham').style.transform = 'scale(1)';
        document.getElementById('maspSua').value = id;
        document.getElementById('tenSua').value = name;
        document.getElementById('giaSua').value = price;
        document.getElementById('loaiSua').value = type;
    });
    });

    function closeOverlay2() {
        document.getElementById('khungSuaSanPham').style.transform = 'scale(0)';
    }

    // Hàm xác nhận xóa tất cả sản phẩm khỏi giỏ hàng
    function confirmDelete() {
        var result = confirm('Bạn có chắc chắn muốn xóa người dùng này không?');
        if (result) {
            // Nếu người dùng đồng ý, gửi dữ liệu form
            return true;
        } else {
            // Nếu người dùng hủy, không gửi dữ liệu form
            return false;
        }
    }
</script>