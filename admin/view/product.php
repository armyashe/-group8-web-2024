<?php
include_once ('../database/connect.php');
include_once('../includes/header.php');

$product = $conn->prepare("SELECT * FROM `sanpham`");
$product->execute();
$product->store_result();
$sanpham = $product->num_rows;







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
                    $product->bind_result($id, $tensanpham, $loaisanpham, $gia,$soluong,$mota,$hinhanh,$hinhanh2,$hinhanh3,$hinhanh4);
                    while($product->fetch()){
                        echo '<tr>';
                        echo '<td style="width: 5%">'.$stt.'</td>';
                        echo '<td style="width: 12%">'.$id.'</td>';
                        echo '<td style="width: 40%">';
                        echo '<a title="Xem chi tiết" target="_blank" href="../../view/product_detail.php?id=' . $id . '" style="margin-left: 2%;">'.$tensanpham.'</a>';
                        echo '<img class="product-image" src="../../IMG/'.$hinhanh.'"></img>';
                        echo '</td>';
                        echo '<td style="width: 15%">'.number_format($gia, 0, ',', '.').'₫</td>';
                        echo '<td style="width: 15%">';
                        echo'<div class="tooltip">
                                <button type="button" style="border:none;background-color:transparent" class="editUserButton" data-id="'.$id.'" data-name="'.$tensanpham.'" data-price="'.$gia.'" data-type="'.$loaisanpham.'"data-describe="'.$mota.'" data-img="'.$hinhanh.'">
                                    <i class="fa fa-wrench" style="font-size: 20px;margin: 0 15px;"></i>
                                    <span class="tooltiptext">Sửa</span>
                                </button>
                            </div>';
                        echo '<div class="tooltip" >
                                <form class="formDeteleProduct">
                                    <input type="hidden" name="tensanpham" value="'.$tensanpham.'">
                                    <input type="hidden" name="deleteproduct" value="true">
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
                <form class="formAdd" enctype="multipart/form-data"> 
                <tr>
                    <td>Mã sản phẩm:</td>
                    <td><input type="text" class="id_add" name="id_add" id="maspThem" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Tên sản phẩm:</td>
                    <td><input type="text" class="name_add" name="name_add" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Hình:</td>
                    <td>
                        <img src="" id="anhDaiDienSanPhamThem" style="width:20%;" ><br>
                        <input type="file" name="img_add" class="hinhDaiDienThem">
                    </td>
                </tr>
                <tr>
                    <td>Giá tiền:</td>
                    <td><input class="input_price" type="text" name="price_add" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Loại sản phẩm:</td>
                    <td><input type="text" class="product_type" name="type_add" required autocomplete="off"></td>
                </tr>
                <tr>
                    <th colspan="2">Thông số kĩ thuật</th>
                </tr>
                <tr>
                    <td>Mô tả :</td>
                    <td><textarea class="describe_input" name="describeAdd" style="width: 80%; height: 7rem; box-sizing: border-box;" required autocomplete="off"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" class="table-footer"> 
                        <button type="submit" >Thêm</button>
                        <div id="successMessage" style="display: none; color: greenyellow;">Thêm sản phẩm thành công</div>
                        <div id="errorMessage" style="display: none; color: red;">Vui lòng điền đầy đủ thông tin</div>
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
                <form method="post" class="formEdit" enctype="multipart/form-data">
                <tr>
                    <td>Mã sản phẩm: </td>
                    <td><input type="text" class="id_product" name="id_product" id="maspSua" required autocomplete="off" ></td>
                </tr>
                <tr>
                    <td>Tên sản phẩm: </td>
                    <td><input type="text" class="name_product" name="name_product" id="tenSua" required autocomplete="off" ><td>
                </tr>
                <tr>
                    <td>Hình:</td>
                    <td>
                        <img src="" id="anhDaiDienSanPhamSua" style="width:20%;" ><br>
                        <input type="file" name="img_product" class="hinhDaiDienSua">
                    </td>
                </tr>
                <tr>
                    <td>Giá tiền:</td>
                    <td><input class="price_input" name="price_edit" type="text" id="giaSua"></td>
                </tr>
                <tr>
                    <td>Loại sản phẩm:</td>
                    <td><input type="text" class="product_Type" name="product_type" required autocomplete="off" id="loaiSua"></td>
                </tr>
                <tr>
                    <th colspan="2">Thông số kĩ thuật</th>
                </tr>
                <tr>
                    <td>Mô tả :</td>
                    <td ><textarea class="input_describe" name="describe" style="width: 80%; height: 7rem; box-sizing: border-box;" id="motaSua"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" class="table-footer"> 
                        <input type="hidden" name="productName" value="">
                        <input type="hidden" name="productId" value="">
                        <input type="hidden" name="productPrice" value="">
                        <input type="hidden" name="productType" value="">
                        <input type="hidden" name="productDescribe" value="">
                        <input type="hidden" name="productImg" value="">
                        <button type="submit" name="submitEdit">Sửa</button> 
                        <div id="successMessageExit" style="display: none; color: greenyellow;">Sửa sản phẩm thành công</div>
                        <div id="errorMessageExit" style="display: none; color: red;">Vui lòng điền thông tin cần sửa</div>
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
        const describe = this.getAttribute('data-describe');
        const img = this.getAttribute('data-img');

        // Cập nhật giá trị của input hidden name="productName"
        document.querySelector('input[name="productName"]').value = name;
        document.querySelector('input[name="productId"]').value = id;
        document.querySelector('input[name="productPrice"]').value = price;
        document.querySelector('input[name="productType"]').value = type;
        document.querySelector('input[name="productDescribe"]').value =describe;
        document.querySelector('input[name="productImg"]').value = img; 


        document.getElementById('khungSuaSanPham').style.transform = 'scale(1)';
        document.getElementById('maspSua').value = id;
        document.getElementById('tenSua').value = name;
        document.getElementById('giaSua').value = price;
        document.getElementById('loaiSua').value = type;
        document.getElementById('motaSua').value = describe;
        document.getElementById('anhDaiDienSanPhamSua').src = '../../IMG/' + img;
    });
    });

    function closeOverlay2() {
        document.getElementById('khungSuaSanPham').style.transform = 'scale(0)';
    }

    // sửa thông tin sản phẩm
    $(document).ready(function() {
        $('.formEdit').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

            var idProduct = document.querySelector('.id_product').value;
            var nameProduct = document.querySelector('.name_product').value;
            var priceProduct = document.querySelector('.price_input').value;
            var type = document.querySelector('.product_Type').value;
            var Describe = document.querySelector('.input_describe').value;
            var imgProduct = document.querySelector('.hinhDaiDienSua').files[0];

            var formData = new FormData();
            formData.append('id_product', idProduct);
            formData.append('name_product', nameProduct);
            formData.append('price_edit', priceProduct);
            formData.append('product_type', type);
            formData.append('describe', Describe);
            formData.append('img_product', imgProduct);


            var tencu = document.querySelector('input[name="productName"]').value;
            var idcu = document.querySelector('input[name="productId"]').value;
            var pricecu = document.querySelector('input[name="productPrice"]').value;
            var loaicu = document.querySelector('input[name="productType"]').value;
            var describecu = document.querySelector('input[name="productDescribe"]').value;
            var imgcu = document.querySelector('input[name="productImg"]').value;
            console.log("gia cu : "+pricecu);
            console.log("ten cu : "+tencu);
            console.log("id cu : "+idcu);
            console.log("loai cu : "+loaicu);
            console.log("describe cu : "+describecu);
            console.log("img cu : "+imgcu);

            
            console.log(formData);
            // Gửi yêu cầu AJAX
            $.ajax({
                type: 'POST',
                url: '../handler/functionHandler.php', // Thay 'update_user.php' bằng đường dẫn thực tế tới script PHP của bạn
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                   
                    console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                    // Xử lý phản hồi thành công
                    if (response.status === 'true') {
                        console.log("gia moi : "+response.price);
                        console.log("ten moi : "+response.name_product);
                        console.log("id moi : "+response.id);
                        console.log("loai moi : "+response.loaisanpham);
                        console.log("describe moi : "+response.mota);
                        console.log("img moi : "+response.hinhanh);
                        console.log("gia cu : "+pricecu);
                        console.log("ten cu : "+tencu);
                        console.log("id cu : "+idcu);
                        console.log("loai cu : "+loaicu);
                        console.log("describe cu : "+describecu);
                        console.log("img cu : "+imgcu);

                    if(idcu === response.id && tencu === response.name_product && pricecu === response.price && loaicu === response.loaisanpham && describecu === response.mota && imgcu === response.hinhanh){
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#errorMessageExit').show();
                        $('#successMessageExit').hide();
                    }
                    else{
                            
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#successMessageExit').show();
                        $('#errorMessageExit').hide();
                        

                        // Cập nhật thông tin sản phẩm trên bảng
                        document.querySelectorAll('.table-outline tr').forEach(row => {
                            // Tìm hàng có ID sản phẩm tương ứng
                            if (row.children[1] && row.children[1].textContent === idProduct) {
                                // Cập nhật thông tin
                                row.children[1].textContent = idProduct;
                                console.log(imgcu);
                                console.log(response.hinhanh);
                                if(row.children[2] &&  response.hinhanh !== "undefined")
                                {
                                    console.log(response.hinhanh);
                                    row.children[2].children[0].innerHTML = '<a title="Xem chi tiết" target="_blank" href="../../view/product_detail.php?id=' + idProduct + '" style="margin-left: 2%;">' + nameProduct + '</a>';
                                    row.children[2].children[1].src = '../../IMG/' + response.hinhanh;
                                    console.log(row.children[2].children[1]);
                                }
                                else if(row.children[2] && response.hinhanh === "undefined"){
                                    console.log(imgcu);
                                    console.log(response.hinhanh);
                                    row.children[2].children[0].innerHTML = '<a title="Xem chi tiết" target="_blank" href="../../view/product_detail.php?id=' + idProduct + '" style="margin-left: 2%;">' + nameProduct + '</a>';
                                    row.children[2].children[1].src = '../../IMG/' + imgcu;
                                    console.log(row.children[2].children[1]);
                                }
                                row.children[3].textContent = formatPrice(priceProduct) + '₫';

                            }
                        });


                        
                        



                    }

                    } else {
                        // Xử lý các trường hợp phản hồi khác (ví dụ: thông báo lỗi)
                        $('#successMessageExit').hide();
                        $('#errorMessageExit').show().text(response.message);
                        alert(response.message);
                    }
                }
            });
        });
    });


    // thêm sản phẩm
    $(document).ready(function() {
        $('.formAdd').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

            var idProductAdd = document.querySelector('.id_add').value;
            var nameProductAdd = document.querySelector('.name_add').value;
            var priceProductAdd = document.querySelector('.input_price').value;
            var typeAdd = document.querySelector('.product_type').value;
            var DescribeAdd = document.querySelector('.input_describe').value;
            var imgProductAdd = document.querySelector('.hinhDaiDienThem').files[0];

            var formData = new FormData();
            formData.append('id_add', idProductAdd);
            formData.append('name_add', nameProductAdd);
            formData.append('price_add', priceProductAdd);
            formData.append('type_add', typeAdd);
            formData.append('describeAdd', DescribeAdd);
            formData.append('img_add', imgProductAdd);

            console.log(formData);
            // Gửi yêu cầu AJAX
            $.ajax({
                type: 'POST',
                url: '../handler/functionHandler.php', // Thay 'update_user.php' bằng đường dẫn thực tế tới script PHP của bạn
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                    // Xử lý phản hồi thành công
                    if (response.status === 'true') {
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#successMessage').show();
                        $('#errorMessage').hide();
                        // Thêm sản phẩm mới vào bảng
                        var table = document.querySelector('.table-outline');
                        var newRow = table.insertRow(table.rows.length);
                        console.log(response.hinhanh);
                        newRow.innerHTML = `
                            <td style="width: 5%">${table.rows.length - 2}</td>
                            <td style="width: 12%">${response.id}</td>
                            <td style="width: 40%">
                                <a title="Xem chi tiết" target="_blank" href="../../view/product_detail.php?id= '${response.id}'" style="margin-left: 2%;">${response.name_product}</a>
                                <img class="product-image" src="../../IMG/${response.hinhanh}"></img>
                            </td>
                            <td style="width: 15%">${formatPrice(response.price)}₫</td>
                            <td style="width: 15%">
                                <div class="tooltip">
                                    <button type="button" style="border:none;background-color:transparent" class="editUserButton" data-id="${response.id}" data-name="${response.name}" data-price="${response.price}" data-type="${response.loaisanpham}">
                                        <i class="fa fa-wrench" style="font-size: 20px;margin: 0 15px;"></i>
                                        <span class="tooltiptext">Sửa</span>
                                    </button>
                                </div>
                                <div class="tooltip">
                                    <form action="" method="post" onsubmit="return confirmDelete()">
                                        <input type="hidden" name="tensanpham" value="${response.name}">
                                        <input type="hidden" name="delete" value="true">
                                        <button type="submit" style="border:none;background-color:transparent">
                                            <i class="fa fa-trash" style="font-size: 20px;"></i>
                                            <span class="tooltiptext">Xóa</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        `;
                    } else {
                        // Xử lý các trường hợp phản hồi khác (ví dụ: thông báo lỗi)
                        $('#successMessage').hide();
                        $('#errorMessage').show().text(response.message);
                        alert(response.message);
                    }

                }
            });
        });
    });

    // xóa sản phẩm
    $(document).ready(function() {
        $('.formDeteleProduct').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

            var $rowToDelete = $(this).closest('tr');

            var result = confirm('Bạn có chắc chắn muốn xóa người dùng này không?');
            if (result) {
                var formData = $(this).serialize();
                console.log(formData);

                console.log(formData);
                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    url: '../handler/functionHandler.php', // Thay 'update_user.php' bằng đường dẫn thực tế tới script PHP của bạn
                    data: formData,
                    success: function(response) {
                        console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                        // Xử lý phản hồi thành công
                        if (response.status === 'true') {
                            
                            // Xóa sản phẩm khỏi bảng
                            $rowToDelete.remove();
                            // Cập nhật hiển thị tin nhắn xóa thành công
                            alert(response.message);

                        } else {
                            alert(response.message);
                        }
                    }
                });
            } else {
                // Nếu người dùng không xác nhận xóa, không thực hiện các thao tác xóa
                return;
            }
            
        });
    });

    function formatPrice(price) {
    if (price !== undefined && price !== null) {
        // Nếu price không phải là undefined hoặc null, thực hiện định dạng giá cả
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    } else {
        // Nếu price là undefined hoặc null, trả về chuỗi rỗng
        return "";
    }
}

</script>