<?php
include_once ('layout/header.php');
include_once ('../database/productDAL.php');
include_once ('../database/connect.php');

if(isset($_REQUEST['orderIDSuccessful'])){
    echo '<h1 h1 style=color:red;margin-top:2%;>Đơn hàng của bạn đã được đặt thành công. Mã đơn hàng của bạn là: '.$_REQUEST['orderIDSuccessful'].'</h1>';
    unset($_SESSION['cart']);

}