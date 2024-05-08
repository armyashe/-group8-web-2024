<?php
// Include các tệp cần thiết
include_once ('../database/connect.php');
include_once('../includes/header.php');

// Lấy ra năm trong cơ sở dữ liệu
$year_query = $conn->prepare("SELECT DISTINCT YEAR(`order_date`) FROM `orders`");
$year_query->execute();
$year_query->store_result();
$year_query->bind_result($nam);
$years = [];
while($year_query->fetch()) {
    $years[] = $nam;
}

// Nếu người dùng chưa chọn năm, mặc định sẽ hiển thị năm hiện tại của select box
if (!isset($_POST['year'])) {
    $selectedYear = date('Y');
} else {
    $selectedYear = $_POST['year'];
}

// lấy ra tổng tiền đơn hàng của từng tháng
$tongtien = [];
for ($thang = 1; $thang <= 12; $thang++) {
    $order = $conn->prepare("SELECT SUM(`total_amount`) FROM `orders` WHERE MONTH(`order_date`) = ? AND YEAR(`order_date`) = ?");
    $order->bind_param("ii", $thang, $selectedYear);
    $order->execute();
    $order->store_result();
    $order->bind_result($tong);
    $order->fetch();
    $tongtien[] = $tong;
}





?>


<div class="main">
    <div class="home">
        <div id="myChart1"></div>
        <form id="yearForm" action="" method="post">
            <div class="select-container">
                <label for="yearDropdown">Chọn năm:</label>
                <select id="yearDropdown" name="year">
                    <?php foreach ($years as $year) { ?>
                        <option value="<?php echo $year; ?>" <?php if ($selectedYear == $year) echo 'selected'; ?>>
                            <?php echo $year; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="custom-button">Gửi</button>
        </form>
    </div>
</div>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Khởi tạo dữ liệu
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tháng');
        data.addColumn('number', 'Tổng tiền');
        data.addColumn({type: 'string', role: 'style'}); // Thêm cột cho màu sắc

        // Thêm dữ liệu vào DataTable
        data.addRows([
            <?php
            $thang_labels = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            for ($i = 0; $i < 12; $i++) {
                echo "['" . $thang_labels[$i] . "', " . $tongtien[$i] . ", '#0084FF'],";
            }
            ?>
        ]);

        // Thiết lập tùy chọn của biểu đồ
        var options = {
            title: 'Thống kê doanh thu theo tháng',
            width: 800,
            height: 600,
            bar: {groupWidth: "95%"},
            legend: { position: "none" }
        };

        // Vẽ biểu đồ cột
        var chart = new google.visualization.ColumnChart(document.getElementById('myChart1'));
        chart.draw(data, options);
    }
</script>
