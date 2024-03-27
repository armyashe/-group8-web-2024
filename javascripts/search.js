
// Hàm này dùng để hiển thị thông báo khi người dùng chưa đăng nhập để xem giỏ hàng
function showLoginAlert() {
    alert("Vui lòng đăng nhập để xem giỏ hàng");
    // Chuyển hướng người dùng đến trang đăng nhập
    window.location.href = "../view/login.php";
  }
  
  // Hàm này dùng để hiển thị thông báo khi người dùng chưa đăng nhập để xem lịch sử mua hàng
  function showLoginAlertHistory() {
    alert("Vui lòng đăng nhập để xem lịch sử mua hàng");
    // Chuyển hướng người dùng đến trang đăng nhập
    window.location.href = "../view/login.php";
  }
  
  
  // hàm để gửi form lên server
  function submitForm() {
    document.getElementById("filter-form").submit();
  }
  
  // Hàm kiểm tra nút radio nào được chọn dựa trên url
  window.onload = function () // khi trang được load
  {
    var urlParams = new URLSearchParams(window.location.search); // lấy các tham số trên url (URLSearchParams dùng để lấy tham số trên url và window.location.search để lấy url hiện tại của trang lấy từ ký tự ? trở đi)
    var priceParam = urlParams.get('price');// lấy tham số price trên url
    if (priceParam) {
      document.getElementById('price1').checked = priceParam === '0-500000';
      document.getElementById('price2').checked = priceParam === '500000-1000000';
      document.getElementById('price3').checked = priceParam === '1000000-5000000';
      document.getElementById('price4').checked = priceParam === '5000000-7000000';
    }
  };
  