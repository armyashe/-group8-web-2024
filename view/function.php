<?php
session_start();
// Xử lý yêu cầu AJAX và cập nhật giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra xem có dữ liệu gửi lên từ AJAX không
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    // Thực hiện cập nhật giỏ hàng ở đây
    // Ví dụ: cập nhật giỏ hàng trong session
    if ($product_id !== null && $quantity !== null) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        // Trả về phản hồi (ví dụ: có thể là JSON)
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing product_id or quantity']);
    }
}
?>