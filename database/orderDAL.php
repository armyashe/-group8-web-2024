<?php


include 'connectDB.php';
include_once 'userDAL.php';
// echo '<pre>';
// print_r($_SESSION['cart']);
// echo '</pre>';
function insertOrder($user_id, $name, $phone, $address, $payment, $cart)
{
    $conn = connect(); // Database connection

    $order_id = uniqid(); 
    $total_amount = 0;

    // Calculate total amount from cart items
    foreach ($cart as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    $status = 'active';
    $order_date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO orders (idOrder, idUser, nameCustomer, phone_number, address, order_date, total_amount, status, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ssssssiss", $order_id, $user_id, $name, $phone, $address, $order_date, $total_amount, $status, $payment);
    $stmt->execute();

    // Insert order details for each item in the cart
    foreach ($cart as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $note = 'delivered'; // Example note

        insertOrderDetails($order_id, $product_id, $quantity, $price, $note);
    }

    $stmt->close();
    $conn->close();

    return $order_id;
}

function insertOrderDetails($order_id, $product_id, $quantity, $price, $note)
{
    $conn = connect(); // Kết nối tới cơ sở dữ liệu

    // Thêm chi tiết đơn hàng vào bảng 'order_details'
    $sql = "INSERT INTO order_detail (idOrder, idProduct, quantity, price, note) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $order_id, $product_id, $quantity, $price, $note);
    $stmt->execute();
    $stmt->close();

    $conn->close(); // Đóng kết nối cơ sở dữ liệu
} 

// lay thong tin don hang tu idOrder
function getOrderItems($order_id) {
    $conn = connect();
    $sql = "SELECT * FROM orders WHERE idOrder = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $items;
}

// lấy thông tin đơn hàng từ idUser
function getOrder($idUser)
{
    $conn = connect();
    $sql = "SELECT * FROM orders WHERE idUser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $orders;
}

//lấy thông tin chi tiết đơn hàng từ idOrder
function getOrderDetail($idOrder)
{
    $conn = connect();
    $sql = "SELECT * FROM order_detail WHERE idOrder = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idOrder);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $orderDetails;
}

// lấy sản phẩm từ idProduct
function getProduct($idProduct)
{
    $conn = connect();
    $sql = "SELECT * FROM sanpham WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idProduct);
    $stmt->execute();
    $result = $stmt->get_result();
    $productID = [];
    while ($row = $result->fetch_assoc()) {
        $productID[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $productID;
}

// lấy thông tin chi tiết đơn hàng từ idOrder
function getOrderDetailId($idOrder)
{
    $conn = connect();
    $sql = "SELECT * FROM order_detail WHERE idOrder = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idOrder);
    $stmt->execute();
    $result = $stmt->get_result();
    $orderDetails = [];
    while ($row = $result->fetch_assoc()) {
        $orderDetails[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $orderDetails;
}
// lấy thông tin đon hàng từ idOrder
function getOrderById($idOrder)
{
    $conn = connect();
    $sql = "SELECT * FROM orders WHERE idOrder = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idOrder);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = [];
    while ($row = $result->fetch_assoc()) {
        $order[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $order;
}
// lấy email người dùng từ bảng order
function getEmail($idOrder)
{
    $conn = connect();
    $sql = "SELECT user.user_email,orders.nameCustomer,orders.phone_number,orders.address,orders.status FROM orders INNER JOIN user ON user.id = orders.idUser WHERE idOrder = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $idOrder);
    $stmt->execute();
    $result = $stmt->get_result();
    $email = [];
    while ($row = $result->fetch_assoc()) {
        $email[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $email;
}


?>
