<?php
include_once ('layout/header.php');
include_once ('../database/productDAL.php');

include_once ('../database/connect.php');
include_once ('../database/productDAL.php');

if (!isset($_REQUEST['idProduct'])) {
    // Nếu không có idProduct được cung cấp,có thể chuyển hướng người dùng hoặc hiển thị một thông báo lỗi.
    header("Location: error.php");
    exit;
}

$id = $_REQUEST['idProduct'];
$detail = getProductById($id);
// Định dạng giá sản phẩm dưới dạng "700.000đ"
// detail['gia'] gia can dinh dang - 0 so se duoc lam tron den so nguyen gan nhat - "," la dau thap phan - "." la dau cach hang nghin
$price_formatted = number_format($detail['gia'], 0, ",", ".") . "đ";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product details</title>
    <link rel="stylesheet" href="../css/product_details.css">
    <!-- Add your CSS styles here -->
</head>

<body>
    <div class="container">
        <div class="top">
            <div class="picture">
                <!-- Thay đổi src của ảnh sản phẩm để hiển thị từ URL trong cơ sở dữ liệu -->

            
                <img src="../IMG/<?php echo $detail['hinhanh']; ?>" alt="Product Image" id="productImage">

                <figure class="picture-small">
                    <!-- Đảm bảo các ảnh nhỏ của sản phẩm cũng được hiển thị từ URL trong cơ sở dữ liệu -->
                    <img src="../IMG/<?php echo $detail['hinh2']; ?>" alt="Thumbnail Image 1">
                    <img src="../IMG/<?php echo $detail['hinh3']; ?>" alt="Thumbnail Image 2">
                    <img src="../IMG/<?php echo $detail['hinh4']; ?>" alt="Thumbnail Image 3">
                </figure>
            </div>
            <div class="content">
                <!-- Hiển thị thông tin sản phẩm từ cơ sở dữ liệu -->
                <h2 class="name">
                    <?php echo $detail['tensanpham']; ?>
                </h2>
                <h3 class="masp" style="display: none;">
                    <?php echo $detail['id']; ?>
                </h3>
                <div class="info">
                    <?php echo $detail['mota']; ?>
                    <br><?php echo $detail['mota2']; ?>
                    <br><?php echo $detail['mota3']; ?>
                    <br><?php echo $detail['mota4']; ?>

                </div>
                <div class="price">
                    <?php echo $price_formatted; ?>
                </div>
                <br>Availability: Còn hàng
                <div class="button" onclick="them()"><a href="giohang.html">Thêm vào giỏ hàng</a></div>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php
    include_once ('layout/footer.php');
    ?>
</footer>

</html>