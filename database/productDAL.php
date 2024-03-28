<?php
include 'connectDB.php';



# cái connectDB vs connect khác nhau gì dị. ko phải nó giống nhau hả. em tưởng có file connect ròi
# khác nhau cách tổ chức thôi 
# connect của em là import file là nó auto chạy
# còn connectDB của anh chỉ khi kêu hàm connect nó mới chạy
# hiểu ko ?oke

# này anh sẽ viết hàm lấy sản phẩm theo id của anh  
# chỉ bí kíp cho nè heheh. canh lề nhấn tổ hợp phím alt+shift+f 
# ok em bth anh code intel ko à 

function getProductById($id)
{
    $conn = connect();
    $sql = "select * from sanpham where id = " . $id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        // while ($row = $result->fetch_assoc()) {
        //     echo "id: " . $row["id"] . " - Name: " . $row["tensanpham"] . " " . $row["loaisanpham"] . "<br>";
        // }
    } else {
        echo "0 results";
    }
    $conn->close();
    $row = $result->fetch_assoc();
    return $row ;
}


?>