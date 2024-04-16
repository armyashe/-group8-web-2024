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

    //ham lay san pham theo id
/*     function getProductById($id)
    {
        $conn = connect(); //ham connect trong file connectDB.php - ket noi db
        $sql = "select * from sanpham where id = " . $id; //cau lenh sql lay san pham theo id
        $result = $conn->query($sql); //thuc thi cau lenh sql - tra ve ket qua la 1 danh sach cac san pham
        //neu ket qua tra ve la null thi tra ve null
        if ($result->num_rows > 0) {
            // output data of each row
            // while ($row = $result->fetch_assoc()) {
            //     echo "id: " . $row["id"] . " - Name: " . $row["tensanpham"] . " " . $row["loaisanpham"] . "<br>";
            // }
        } else {
            echo "0 results";
        }
        $conn->close(); //dong ket noi db - giup giam tai nguyen
        $row = $result->fetch_assoc(); //lay ra 1 san pham dau tien trong danh sach cac san pham - tra ve 1 mang cac thuoc tinh cua san pham do 
        return $row ;
    } */
    function getProductById($id)
{
    $conn = connect();
    $sql = "SELECT * FROM sanpham WHERE id = " . $id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the first row of the result set as an associative array
        $row = $result->fetch_assoc();
    } else {
        // No product found with the specified ID
        $row = null; // Or handle the error condition appropriately
        echo "0 results";
    }

    // Close the database connection
    $conn->close();

    return $row;
}

?>