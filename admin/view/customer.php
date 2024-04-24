<?php
include_once('../controller/database.php');
include_once('../includes/header.php');

$customer = $conn->prepare("SELECT * FROM `user`");
$customer->execute();
$customer->store_result();
$khachhang = $customer->num_rows;

// Thêm người dùng
if(isset($_POST["submit"]))
{
    $email = $_POST["email"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // kiểm tra địa chỉ email có hợp lệ ko
    $name = $_POST["username"];
    $name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'); 
    $password = $_POST["password"];
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
    $select_user = $conn ->prepare("SELECT * FROM `user` WHERE user_name = ? AND password = ?");
    $select_user ->execute([$name, $password]);
    $select_user->store_result();

    if($select_user->num_rows >0)
    {
        echo '<script>alert("Tài khoản đã tồn tại")</script>';
    }
    else
    {
        $trangthai = 'true';
        $insert_user = $conn ->prepare("INSERT INTO `user`(`user_name`, `password`, `user_email`,`trangthai`) VALUES (?,?,?,?)");
        $insert_user ->execute([$email, $name, $password, $trangthai]);
        echo '<script>alert("Thêm người dùng thành công")</script>';
    }
}

// sửa thông tin người dùng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitEdit"])) {
    
    $userNameEdit = $_POST["userNameEdit"];
    $email = $_POST["emailEdit"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Validate email address
    $name = $_POST["usernameEdit"];
    $name = htmlspecialchars($_POST['usernameEdit'], ENT_QUOTES, 'UTF-8'); 
    $password = $_POST["passwordEdit"];
    $password = htmlspecialchars($_POST['passwordEdit'], ENT_QUOTES, 'UTF-8');

    // cập nhật thông tin người dùng
    $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $update_user = $conn->prepare("UPDATE khachhang SET email = ?, username = ?, password = ? WHERE username = ?");
    $update_user->bind_param("ssss", $email, $name, $password, $userNameEdit); // s là kiểu dữ liệu của biến (string)
    if ($update_user->execute()) {
        echo '<script>alert("Sửa người dùng '.$userNameEdit.' thành công")</script>';
    }
}

// Xử lý khóa/mở khóa tài khoản
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["lock"]))
{
    $userName = $_POST["userName"];
    $newLockStatus = $_POST["lock"]; // Lấy giá trị của checkbox (true/false)
    
    // Cập nhật trạng thái của người dùng trong cơ sở dữ liệu
    $updateQuery = "UPDATE khachhang SET trangthai = ? WHERE username = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $newLockStatus, $userName);
    if($updateStmt->execute()) 
    {
        if($newLockStatus == 'true') {
            echo '<script>alert("Mở khóa tài khoản của '.$userName.' thành công")</script>';
        } else {
            echo '<script>alert("Khóa tài khoản của '.$userName.' thành công")</script>';
        }
    }

}

// xóa tài khoản
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userName"]) && isset($_POST["delete"]))
{
    $value = $_POST["delete"];
    $userName = $_POST["userName"];

    // Delete order details
    $deleteProductDetailQuery = "DELETE FROM chitietdonhang WHERE iddonhang IN (SELECT id FROM donhang WHERE idkhachhang = (SELECT id FROM khachhang WHERE username = ?))";
    $deleteProductDetailStmt = $conn->prepare($deleteProductDetailQuery);
    $deleteProductDetailStmt->bind_param("s", $userName);
    $deleteProductDetailStmt->execute();

    // Delete orders
    $deleteOrderQuery = "DELETE FROM donhang WHERE idkhachhang = (SELECT id FROM khachhang WHERE username = ?)";
    $deleteOrderStmt = $conn->prepare($deleteOrderQuery);
    $deleteOrderStmt->bind_param("s", $userName);
    $deleteOrderStmt->execute();

    // Delete user
    $deleteUserQuery = "DELETE FROM khachhang WHERE username = ?";
    $deleteStmt = $conn->prepare($deleteUserQuery);
    $deleteStmt->bind_param("s", $userName);
    if($deleteStmt->execute()) 
    {
        echo '<script>alert("Xóa tài khoản của '.$userName.' thành công")</script>';
    }   
}

// tìm kiếm người dùng theo stt
if(isset($_POST["search"]) && $_POST["kieuTimKhachHang"] == "id" && isset($_POST["kieuTimKhachHang"]))
{
    $search = $_POST['searchTerm'];

    $customer = $conn->prepare("SELECT * FROM `khachhang` WHERE id = ?");
    $customer->bind_param("i", $search);
    $customer->execute();
    $customer->store_result();
    $khachhang = $customer->num_rows;
}

// tìm kiếm người dùng theo email
if(isset($_POST["search"]) && $_POST["kieuTimKhachHang"] == "email" && isset($_POST["kieuTimKhachHang"]))
{
    $search = $_POST['searchTerm'];
    $searchTerm = '%' . $search . '%';

    $customer = $conn->prepare("SELECT * FROM `khachhang` WHERE email LIKE ?");
    $customer->bind_param("s", $searchTerm);
    $customer->execute();
    $customer->store_result();
    $khachhang = $customer->num_rows;
}

// tìm kiếm người dùng theo tài khoản
if(isset($_POST["search"]) && $_POST["kieuTimKhachHang"] == "taikhoan" && isset($_POST["kieuTimKhachHang"]))
{
    $search = $_POST['searchTerm'];
    $searchTerm = '%' . $search . '%';

    $customer = $conn->prepare("SELECT * FROM `khachhang` WHERE username LIKE ?");
    $customer->bind_param("s", $searchTerm);
    $customer->execute();
    $customer->store_result();
    $khachhang = $customer->num_rows;
}

?>

<main>
    <div class="cards_customer">
        <table class="table-header">
            <tr>
                <th title="Sắp xếp" style="width: 5%">Stt</th>
                <th title="Sắp xếp" style="width: 20%">Email </th>
                <th title="Sắp xếp" style="width: 40%">Tài khoản</th>
                <th title="Sắp xếp" style="width: 15%">Mật khẩu </th>
                <th style="width: 15%">Hành động</th>
            </tr>
        </table>
        <div class="table-content" style="box-shadow: 0 0 10px #989a9b;width:99.3%">
            <?php
            if($khachhang > 0){
                $stt = 1;
                $customer->bind_result($id, $username, $email, $password , $trangthai);

                while($customer->fetch()){
                    $password = '**********';   
                    echo '<table class="table-outline hideImg">';
                    echo '<tr>';
                    echo '<td style="width: 5%">'.$stt.'</td>';
                    echo '<td style="width: 20%">'.$email.'</td>';
                    echo '<td style="width: 43%">'.$username.'</td>';
                    echo '<td style="width: 18%">'.$password.'</td>';
                    echo '<td style="width: 15%">
                            <div class="tooltip">
                                <form action="" method="post">
                                    <script>console.log("'.$trangthai.'")</script>
                                    <input type="hidden" name="userName" value="'. $username .'">
                                    <input type="hidden" name="lock" value="'. ($trangthai == 'true' ? 'false' : 'true') .'" class="lockInput">
                                    <label class="switch">
                                        <input type="checkbox" onclick="this.form.submit()" '. ($trangthai == 'true' ? 'checked' : '') .' class="lockCheckbox">
                                        <span class="slider round"></span>
                                    </label>
                                    <span class="tooltiptext" id="lockStatusText">'. ($trangthai == 'true' ? 'Mở' : 'Khóa') .'</span>
                                </form>
                            </div>
                            <div class="tooltip" >
                                <form action="" method="post" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="userName" value="'. $username .'">
                                    <input type="hidden" name="delete" value="true">
                                    <button type="submit" style="border:none;background-color:transparent">
                                        <i class="fa fa-remove" style="font-size: 20px;"></i>
                                        <span class="tooltiptext">Xóa</span>
                                    </button>
                                </form>
                            </div>
                            <div class="tooltip">
                                <button type="button" style="border:none;background-color:transparent" class="editUserButton" data-username="'.$username.'" data-email="'.$email.'" data-password="'.$password.'">
                                    <i class="fa fa-wrench" style="font-size: 20px;"></i>
                                    <span class="tooltiptext">Sửa</span>
                                </button>
                            </div>
                        </td>';
                    echo '</tr>';
                    echo '</table>';
                    $stt++;
                }
            }else{
                echo '<tr><td colspan="7">Không có khách hàng nào trong kết quả tìm kiếm</td></tr>';
            }
            ?>
        </div>
    </div>
    <div class="table-footer">
        <button id="addUserButton">
            <i class="fa fa-plus-square"></i>
            Thêm người dùng
        </button>
        <div class="timtheokhach" style="margin-top:2%;">
            <form action="" method="post">
                <select name="kieuTimKhachHang">
                    <option value="id">Tìm theo stt</option>
                    <option value="email">Tìm theo email</option>
                    <option value="taikhoan">Tìm theo tài khoản</option>
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
                <th colspan="2">Thêm người dùng</th>
            </tr>
            <form action="" method="post" id="userForm">
                <tr>
                    <td>Tên : </td>
                    <td><input type="text" name="username" id="tenThem" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Email : </td>
                    <td><input type="text" name="email" id="emailThem" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Mật khẩu : </td>
                    <td><input type="password" name="password" id="matkhauThem" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td colspan="2" class="table-footer">
                        <input type="hidden" name="userName" value="<?php echo  $username ?>">
                        <button id="submitButton" type="submit" name="submit">THÊM</button>
                        <div id="successMessage" style="display: none; color: greenyellow;">Thêm người dùng thành công</div>
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
                        <th colspan="2">Sửa người dùng</th>
                    </tr>
                    <form action="" method="post">
                        <tr>
                            <td>Tên : </td>
                            <td><input type="text" name="usernameEdit" id="tenSua" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Email : </td>
                            <td><input type="text" name="emailEdit" id="emailSua" required autocomplete="off"></td>
                        </tr>
                        <tr>
                            <td>Mật khẩu : </td>
                            <td><input type="password" name="passwordEdit" id="matkhauSua" required autocomplete="off"></td>
                        </tr>
                    
                        <tr>
                            <td colspan="2" class="table-footer">
                                <input type="hidden" name="userNameEdit" value="">
                                <?php echo '<script>console.log("ten thay đổi : '.$username.'")</script>';?>
                                <button id="submitEditButton" type="submit" name="submitEdit" style="font-size:15px;">Sửa</button>
                                <div id="successMessageExit" style="display: none; color: greenyellow;">Sửa người dùng thành công</div>
                                <div id="errorMessageExit" style="display: none; color: red;">Vui lòng điền đầy đủ thông tin
                                </div>
                            </td>
                        </tr>
                    </form>
                </table>
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
        const username = this.getAttribute('data-username');
        const email = this.getAttribute('data-email');
        const password = this.getAttribute('data-password');

        // Cập nhật giá trị của input hidden name="userNameEdit"
        document.querySelector('input[name="userNameEdit"]').value = username;

        document.getElementById('khungSuaSanPham').style.transform = 'scale(1)';
        document.getElementById('tenSua').value = username;
        document.getElementById('emailSua').value = email;
        document.getElementById('matkhauSua').value = password;
    });
    });

    function closeOverlay2() {
        document.getElementById('khungSuaSanPham').style.transform = 'scale(0)';
    }

    document.getElementById('submitButton').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var emailValue = document.getElementById('emailThem').value;
        var usernameValue = document.getElementById('tenThem').value;
        var passwordValue = document.getElementById('matkhauThem').value;

        if (emailValue && usernameValue && passwordValue) {
            // If all fields are filled
            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
            this.submit();
        } else {
            // If any field is empty
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('successMessage').style.display = 'none';
        }
    });
    document.getElementById('submitEditButton').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var emailValue = document.getElementById('emailSua').value;
        var usernameValue = document.getElementById('tenSua').value;
        var passwordValue = document.getElementById('matkhauSua').value;

        if (emailValue && usernameValue && passwordValue) {
            // If all fields are filled
            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
            this.submit();
        } else {
            // If any field is empty
            document.getElementById('errorMessage').style.display = 'block';
            document.getElementById('successMessage').style.display = 'none';
        }
    });

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
