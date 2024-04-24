<!-- <?php
/* session_start(); */
include_once ('../database/userDAL.php'); // gọi file userDAL.php vào để sử dụng


// Hàm kiểm tra đăng ký
if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])&& isset($_POST['pass']))
    checkRegister();
function checkRegister()
{
    
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pass = $_POST['pass'];
 

    if(!isset($email) && !isset($username) && !isset($password) && !isset($pass)){
        return;
    }

/*     echo 'email: '.$email.'<br>';
    echo 'username: '.$username.'<br>';
    echo 'password: '.$password.'<br>';
    echo 'pass: '.$pass.'<br>'; */

    $conn = connect(); // Hàm connect() phải được định nghĩa để kết nối vào CSDL

    // Sử dụng prepared statement để ngăn chặn SQL Injection
    $sql = "SELECT * FROM user WHERE user_name = ? ";
    $stmt = $conn->prepare($sql); // Chuẩn bị câu truy vấn - prepare statement dùng để ngăn chặn SQL Injection
    $stmt->bind_param("s", $username); // Bind dữ liệu vào câu truy vấn - bind_param dùng để ngăn chặn SQL Injection
    $stmt->execute(); // Thực thi câu truy vấn

    $result = $stmt->get_result(); // Lấy kết quả trả về từ câu truy vấn

    if($result ->num_rows > 0){
        // echo "<script>alert('Tài khoản đã tồn tại')</script>";
        header("Location: register.php?registerFail=1");
        
    }else{
        if($password != $pass){

            header("Location: register.php?registerFail_pass=1&email=$email&username=$username");
            
        }else{
            $resultUser = addUser($username, $password,$email);
            if($resultUser){
                header("Location: login.php?registerSuccessful=1");

            }else{
                //echo "<script>alert('Đăng ký thành công')</script>";
                echo "<script>alert('Đăng ký thất bại')</script>";

            }
        }
    }



}

?> -->