<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product details</title>
    <link rel="stylesheet" href="../css/product_details.css">
    <?php

    include_once ('../database/connect.php');
    include_once ('../database/productDAL.php');
    include_once ('layout/header.php'); 
    


    // Check if product ID is provided in the request
    if (!isset($_REQUEST['idProduct'])) {
        // chuyen huong nguoi dung den trang loi - redirect user to error page
        header("Location: error.php");
        exit;
    }
    

    // Get product details by ID
    $id = $_REQUEST['idProduct'];
    $detail = getProductById($id);

    // Function to add item to cart
    function addToCart($productId, $productName, $productPrice)
    {
        /* unset($_SESSION['cart']);
          return; */

        $id = $_REQUEST['idProduct'];  
        $detail = getProductById($id);

        $soluong = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

        // khoi tao gio hang neu chua co
        // ham isset kiem tra xem bien da dinh nghia co gia tri hay chua
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $flag = 0; // 0 is can be found, 1 is can found
        // Add item to cart array
    
        for ($i = 0; $i < count($_SESSION['cart']); $i++) {
            if ($_SESSION['cart'][$i]['id'] == $productId ) {
                if($soluong <= $detail['soluong'] && (($_SESSION['cart'][$i]['quantity'] + $soluong) <= $detail['soluong']))
                {
                    $flag = 1;
                    $_SESSION['cart'][$i]['quantity'] += $soluong;
                }
                else {
                    echo "<script>alert('Số lượng sản phẩm không đủ')</script>";
                    return;
                }
            }
            else if ($_SESSION['cart'][$i]['id'] == $productId && $soluong > $detail['soluong']) {
                echo "<script>alert('Số lượng sản phẩm không đủ')</script>";
                return;
            }
        }

        if($soluong > $detail['soluong'])
        {
            echo "<script>alert('Số lượng sản phẩm không đủ')</script>";
            return;
        }

        if ($flag == 0) {
            $_SESSION['cart'][] = array(
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $soluong,
            );
        } else {
            foreach ($_SESSION['cart'] as $item) {
                if ($item['id'] == $productId) {
                    $item['quantity'] += $soluong;
                    break;
                }
            }

        }
        echo "<script>alert('Thêm vào giỏ hàng thành công')</script>";

    }

    // Format product price
    $price_formatted = number_format($detail['gia'], 0, ",", ".") . "đ";

    // Check if 'add_to_cart' form is submitted
    if (isset($_POST['add_to_cart'])) {
        // Check if 'add_to_cart' form is submitted
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        // Add item to cart
        addToCart($product_id, $product_name, $product_price);
    }
/*     if (isset($_SESSION['cart']))
        echo count($_SESSION['cart']); */

    ?>

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
                    <?php 
                        $mota = $detail['mota'];
                        $danh_sach_dong = explode(".", $mota); // Tách chuỗi thành mảng dựa vào dấu chấm
                        foreach ($danh_sach_dong as $dong) {
                            echo $dong . "<br>";
                    }
                ?>

                </div>

                <div class="price"><?php echo $price_formatted; ?></div>
                <!-- Form to add product to cart -->
                <form method="post">
                <div class="quantity">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1">
                    <p><?php echo $detail['soluong']; ?> hàng có sẵn</p>
                </div>

                <div class="content_1">

                    
                        <input type="hidden" name="product_id" value="<?php echo $detail['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $detail['tensanpham']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $detail['gia']; ?>">
                        <?php
                            if(isset($_SESSION['user']['user_name']))
                            {
                                echo '<button class="button" type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>';
                            }
                            else
                            {
                                echo '<button class="button" onclick="showPaymentAlert(event)">Thêm vào giỏ hàng</button>';
                            }
                        ?>

                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer>

</html>
