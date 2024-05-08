<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if ($product_id !== null && $quantity !== null) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] === $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing product_id or quantity']);
    }
}
include_once('../database/userDAL.php');
$userAddress = getUserAddress();
echo $userAddress;
