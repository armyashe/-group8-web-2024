<?php
include_once('../database/connect.php');
include_once('../includes/header.php');



$customer = $conn->prepare("SELECT * FROM `user`");
$customer->execute();
$customer->store_result();
$khachhang = $customer->num_rows;


// tìm kiếm người dùng theo email
if (isset($_POST["search"]) && $_POST["kieuTimKhachHang"] == "email" && isset($_POST["kieuTimKhachHang"])) {
    $search = $_POST['searchTerm'];
    $searchTerm = '%' . $search . '%';

    $customer = $conn->prepare("SELECT * FROM `user` WHERE user_email LIKE ?");
    $customer->bind_param("s", $searchTerm);
    $customer->execute();
    $customer->store_result();
    $khachhang = $customer->num_rows;
}

// tìm kiếm người dùng theo tài khoản
if (isset($_POST["search"]) && $_POST["kieuTimKhachHang"] == "taikhoan" && isset($_POST["kieuTimKhachHang"])) {
    $search = $_POST['searchTerm'];
    $searchTerm = '%' . $search . '%';

    $customer = $conn->prepare("SELECT * FROM `user` WHERE user_name LIKE ?");
    $customer->bind_param("s", $searchTerm);
    $customer->execute();
    $customer->store_result();
    $khachhang = $customer->num_rows;
}
?>
<main>
    <div class="cards_customer">
    <?php
        if(isset($_POST['search'])){
            echo '<h2>Kết quả tìm kiếm cho "'.$search.'"</h2>';
        }
        else{
            echo '<h2>Danh sách người dùng</h2>';
        }
        ?>
        <table class="table-header">
            <tr>
                <th title="Sắp xếp" style="width: 5%">Stt</th>
                <th title="Sắp xếp" style="width: 20%">Email </th>
                <th title="Sắp xếp" style="width: 40%">Tài khoản</th>
                <th title="Sắp xếp" style="width: 15%">Mật khẩu </th>
                <th style="width: 15%">Hành động</th>
            </tr>
        </table>
        <div class="table-content" style="box-shadow: 0 0 10px #989a9b;width:99%">
        <table class="table-outline hideImg">
            <?php
            if ($khachhang > 0) {
                $stt = 1;
                $customer->bind_result($id, $username, $password, $email, $trangthai);

                while ($customer->fetch()) {    
                    echo '<tr data-user="".>';
                    echo '<td style="width: 5%" data-user="'.$stt.'">' . $stt . '</td>';
                    echo '<td style="width: 20%" data-user="'.$email.'" class="email">' . $email . '</td>';
                    echo '<td style="width: 43%"data-user="'.$username.'">' . $username . '</td>';
                    echo '<td style="width: 18%"data-user="'.$password.'"class="pass">' . $password . '</td>';
                    echo '<td style="width: 15%">
                            <div class="tooltip">
                                <form method="post" class="lockForm">
                                    <script>console.log("' . $trangthai . '")</script>
                                    <input type="hidden" name="userName" value="' . $username . '">
                                    <input type="hidden" name="lock" value="' . $trangthai . '" class="lockInput">
                                    <label class="switch">
                                        <button type="submit">
                                            <input type="checkbox" class="lockCheckbox" >
                                            <span class="slider round"></span>
                                        </button>
                                    </label>
                                    <span class="tooltiptext" class="lockStatusText">' . ($trangthai == 'true' ? 'Mở' : 'Khóa') . '</span>
                                </form>
                            </div>
                            <div class="tooltip" >
                                <form class="formDelete" >
                                    <input type="hidden" name="userName" value="' . $username . '">
                                    <input type="hidden" name="delete" value="true">
                                    <button type="submit" style="border:none;background-color:transparent">
                                        <i class="fa fa-remove" style="font-size: 20px;"></i>
                                        <span class="tooltiptext">Xóa</span>
                                    </button>
                                </form>
                            </div>
                            <div class="tooltip">
                                <button type="button" style="border:none;background-color:transparent" class="editUserButton" data-username="' . $username . '" data-email="' . $email . '" data-password="' . $password . '">
                                    <i class="fa fa-wrench" style="font-size: 20px;"></i>
                                    <span class="tooltiptext">Sửa</span>
                                </button>
                            </div>
                        </td>';
                    echo '</tr>';
                    $stt++;
                }
            } else {
                echo "<tr><td colspan='7' style='color:red;font-size:20px'>Không có khách hàng nào trong kết quả tìm kiếm</td></tr>";
            }
            ?>
            </table>
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
        <table class="overlayTable table-outline table-header table-css">
            <tr>
                <th colspan="2">Thêm người dùng</th>
            </tr>
            <form  class="formAdd" >
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
                        <button id="submitButton" type="submit" >THÊM</button>
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
            <form method="post" class="formEdit">
                <tr>
                    <td>Tên : </td>
                    <td><input type="text" class="user_name" name="usernameEdit" id="tenSua" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Email : </td>
                    <td><input type="text" class="user_email"  name="emailEdit" id="emailSua" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td>Mật khẩu : </td>
                    <td><input type="password" class="user_pass" name="passwordEdit" id="matkhauSua" required autocomplete="off"></td>
                </tr>

                <tr>
                    <td colspan="2" class="table-footer">
                        <input type="hidden" name="userNameEdit" value="">
                        <input type="hidden" name="EmailEdit" value="">
                        <input type="hidden" name="PassEdit" value="">
                        <?php echo '<script>console.log("ten thay đổi : ' . $username . '")</script>'; ?>
                        <button id="submitEditButton" type="submit" name="submitEdit" style="font-size:15px;">Sửa</button>
                        <div id="successMessageExit" style="display: none; color: greenyellow;">Sửa người dùng thành công</div>
                        <div id="errorMessageExit" style="display: none; color: red;">Vui lòng điền thông tin cần sửa</div>
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
            document.querySelector('input[name="EmailEdit"]').value = email;
            document.querySelector('input[name="PassEdit"]').value = password;

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


    // hàm khóa/mở tài khoản
    $(".lockForm").submit( function(event) {
        var form = $(this);
        event.preventDefault(); // Prevent default form submission
        // Toggle the value of the hidden input to update the checkbox status
        var lockInput = form.find(".lockInput");
        console.log("trạng thái hiện tại : "+ lockInput.val());

        lockInput.val(lockInput.val() === 'true' ? 'false' : 'true');
        console.log("trạng thái khi ấn nút : "+lockInput.val());

        // Update the checkbox status
        var checkbox = form.find(".lockCheckbox");
        checkbox.prop("checked", lockInput.val() === 'true');
        console.log(checkbox.prop("checked"));

        // Update the tooltip text
        var tooltip = form.find(".lockStatusText");
        tooltip.textContent = (lockInput.val() === 'true' ? 'Mở' : 'Khóa');

        var username = form.find("input[name='userName']").val();
        console.log(username);

        // Show a message based on the checkbox status
        var message = checkbox.prop("checked") ? "Mở khóa tài khoản của " + username + " thành công" : "Khóa tài khoản của " + username + " thành công";    
        alert(message);

        // Send form data to the server using AJAX
        var formData = new FormData(form[0]);
        fetch("../handler/functionHandler.php", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });

    $(document).ready(function() {
    $(".lockForm").each(function() {
        var form = $(this);
        var lockInput = form.find(".lockInput");
        var checkbox = form.find(".lockCheckbox");
        checkbox.prop("checked", lockInput.val() === 'true');
        console.log(checkbox.prop("checked"));
    });
});


    // sửa thông tin người dùng
    $(document).ready(function() {
        $('.formEdit').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

            var tencu = document.querySelector('input[name="userNameEdit"]').value;
            var emailcu = document.querySelector('input[name="EmailEdit"]').value;
            var passwordcu = document.querySelector('input[name="PassEdit"]').value;

            var username = document.querySelector('.user_name').value;
            var email = document.querySelector('.user_email').value;
            var password = document.querySelector('.user_pass').value;
            console.log('ten cu : '+tencu);
            console.log('ten cu : '+emailcu);
            console.log('ten cu : '+passwordcu);
            // Serialize form data
            var formData = $(this).serialize();
            console.log(formData); // In ra dữ liệu biểu mẫu đã được chuỗi hóa vào console của trình duyệt

            // Gửi yêu cầu AJAX
            $.ajax({
                type: 'POST',
                url: '../handler/functionHandler.php', // Thay 'update_user.php' bằng đường dẫn thực tế tới script PHP của bạn
                data:   
                {
                    userNameEdit: tencu,
                    emailEdit: email,
                    passwordEdit: password,
                    usernameEdit: username,

                },
                success: function(response) {
                   
                    console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                    // Xử lý phản hồi thành công
                    if (response.status === 'true') {
                        
                        console.log('ten cu : '+tencu);
                        console.log('ten cu : '+emailcu);
                        console.log('ten cu : '+passwordcu);

                    console.log('ten moi : '+response.name);
                    console.log('email moi : '+response.email);
                    console.log('pass moi : '+response.password);
                    if(tencu === response.name && emailcu === response.email && passwordcu === response.password){
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#errorMessageExit').show();
                        $('#successMessageExit').hide();
                    }
                    else{
                            
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#successMessageExit').show();
                        $('#errorMessageExit').hide();
                        
                        // Cập nhật thông tin người dùng trong bảng
                        $('td[data-username="' + username + '"]').siblings('.td-email').text(email);
                        $('td[data-username="' + username + '"]').siblings('.td-password').text(password);
                        var elementsWithDataUser = $('[data-user="' + response.nameOld + '"]');
                        elementsWithDataUser.parent().find('[data-user="' + response.nameOld + '"]').attr('data-user', response.name);
                        elementsWithDataUser.text(response.name);
                        elementsWithDataUser.parent().find('.email').text(response.email);
                        elementsWithDataUser.parent().find('.pass').text(response.password);
                    }

                    } else {
                        // Xử lý các trường hợp phản hồi khác (ví dụ: thông báo lỗi)
                        $('#successMessageExit').hide();
                        $('#errorMessageExit').show().text(response.message);
                    }
                }
            });
        });
    });

    // thêm người dùng
    $(document).ready(function() {
        $('.formAdd').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

            // Serialize form data
            var formData = $(this).serialize();
            console.log(formData); // In ra dữ liệu biểu mẫu đã được chuỗi hóa vào console của trình duyệt

            // Gửi yêu cầu AJAX
            $.ajax({
                type: 'POST',
                url: '../handler/functionHandler.php', 
                data: formData,
                success: function(response) {
                    console.log(response); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                    console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                    // Xử lý phản hồi thành công
                    if (response.status === 'true') {
                        // Cập nhật hiển thị tin nhắn thành công
                        $('#successMessage').show();
                        $('#errorMessage').hide();
                        console.log(response.email);
                        console.log(response.name);
                        console.log(response.password);
                        // Thêm người dùng mới vào bảng
                        var stt = $('.table-outline').length + 1;
                        var html = '<table class="table-outline hideImg">';
                        html += '<tr data-user="' + stt + '">';
                        html += '<td style="width: 5%" data-user="' + stt + '">' + stt + '</td>';
                        html += '<td style="width: 20%" data-user="' + response.email + '" class="email">' + response.email + '</td>';
                        html += '<td style="width: 43%" data-user="' + response.name + '">' + response.name + '</td>';
                        html += '<td style="width: 18%" data-user="' + response.password + '" class="pass">' + response.password + '</td>';
                        html += '<td style="width: 15%">';
                        html += '<div class="tooltip">';
                        html += '<form method="post" id="lockForm">';
                        html += '<input type="hidden" name="userName" value="' + response.name + '">';
                        html += '<input type="hidden" name="lock" value="true" class="lockInput">';
                        html += '<label class="switch">';
                        html += '<button type="submit">';
                        html += '<input type="checkbox" class="lockCheckbox" checked>';
                        html += '<span class="slider round"></span>';
                        html += '</button>';
                        html += '</label>';
                        html += '<span class="tooltiptext" class="lockStatusText">Mở</span>';
                        html += '</form>';
                        html += '</div>';
                        html += '<div class="tooltip">';
                        html += '<form action="" method="post" onsubmit="return confirmDelete()">';
                        html += '<input type="hidden" name="userName" value="' + response.name + '">';
                        html += '<input type="hidden" name="delete" value="true">';
                        html += '<button type="submit" style="border:none;background-color:transparent">';
                        html += '<i class="fa fa-remove" style="font-size: 20px;"></i>';
                        html += '<span class="tooltiptext">Xóa</span>';
                        html += '</button>';
                        html += '</form>';
                        html += '</div>';
                        html += '<div class="tooltip">';
                        html += '<button type="button" style="border:none;background-color:transparent" class="editUserButton" data-username="' + response.name + '" data-email="' + response.email + '" data-password="' + response.password + '">';
                        html += '<i class="fa fa-wrench" style="font-size: 20px;"></i>';
                        html += '<span class="tooltiptext">Sửa</span>';
                        html += '</button>';
                        html += '</div>';
                        html += '</td>';
                        html += '</tr>';
                        html += '</table>';
                        $('.table-content').append(html);
                    } else {
                        console.log(response);
                        console.log(response.status);
                        // Xử lý các trường hợp phản hồi khác (ví dụ: thông báo lỗi)
                        $('#successMessage').hide();
                        $('#errorMessage').show().text(response.message);
                    }
                }
            });
        });
    }); 

    // xóa tài khoản
    $(document).ready(function() {
        $('.formDelete').submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi gửi mặc định của biểu mẫu

             // Lưu trữ phần tử cha của nút xóa để có thể xóa dòng bảng sau khi xóa người dùng thành công
            var $rowToDelete = $(this).closest('tr');

            // Hiển thị hộp thoại xác nhận
            var result = confirm('Bạn có chắc chắn muốn xóa người dùng này không?');
            if (result) {
                // lấy ra dữ liệu biểu mẫu
                var formData = $(this).serialize();
                console.log(formData); // In ra dữ liệu biểu mẫu đã được chuỗi hóa vào console của trình duyệt

                // Gửi yêu cầu AJAX
                $.ajax({
                    type: 'POST',
                    url: '../handler/functionHandler.php', // Thay 'delete_user.php' bằng đường dẫn thực tế tới script PHP của bạn
                    data: formData,
                    success: function(response) {
                        console.log(response); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                        console.log(response.status); // In ra phản hồi từ máy chủ của bạn trong console của trình duyệt
                        // Xử lý phản hồi thành công
                        if (response.status === 'true') {
                            // Xóa dòng bảng chứa người dùng đã được xóa
                            $rowToDelete.remove();
                            // Hiển thị thông báo thành công
                            alert(response.message);
                        } else {
                            // Xử lý các trường hợp phản hồi khác (ví dụ: thông báo lỗi)
                            alert(response.message);
                        }
                    }
                });
            }
            else {
            // Nếu người dùng hủy, không gửi dữ liệu biểu mẫu
            return false;
        }
        });
    });

</script>