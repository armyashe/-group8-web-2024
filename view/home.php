<html>
<header>
    <?php

    include_once ('../database/connect.php');
    include_once ('layout/header.php');
    if(isset($_REQUEST['loginSuccessful'])) // đăng nhập sai nó vô đây
        echo "<script> alert('Đăng nhập thành công')</script>"
    
   
    ?>


</header>

<body>
    <h1 style="margin-top: 3rem;">Sắm đồ trang trí phòng ở đây nè!</h1>
    <div class="body">
        <div class="left">
            <div class="search">
                <div class="list">
                    <form method="GET" action="" style="display: flex;">
                        <input type="text" id="menu-search" placeholder="Nhập từ cần tìm kiếm" name="keyword">
                        <button id="search-btn"><i class='bx bx-search'
                                style="color: white;margin: 4px 0 0 2px;"></i></button>
                    </form>
                    <ul class="menu-list">
                        <li class="menu-item"><a href="?keyword=Đèn+cây">Đèn cây</a></li>
                        <li class="menu-item"><a href="?keyword=Bàn+trà+">Bàn Trà</a></li>
                        <li class="menu-item"><a href="?keyword=Gương">Gương</a></li>
                        <li class="menu-item"><a href="?keyword=Bàn+trang+điểm">Bàn Trang Điểm</a></li>
                    </ul>
                </div>

            </div>
            <div class="price">
                <h2 style="margin-top: 30px;">Lọc giá sản phẩm</h2>
                <form id="filter-form" method="POST" action="">
                    <section name="price" class="list-price">
                        <input type="radio" name="price" value="0-500000" id="price1"> 0đ — 500.000đ
                        <br><input type="radio" name="price" value="500000-1000000" id="price2"> 500.000đ — 1.000.000đ
                        <br><input type="radio" name="price" value="1000000-5000000" id="price3"> 1.000.000đ —
                        5.000.000đ
                        <br><input type="radio" name="price" value="5000000-7000000" id="price4"> 5.000.000đ —
                        7.000.000đ
                    </section>
            </div>
            <div class="list-product">
                <h2 style="margin-top: 30px;">Lọc theo loại sản phẩm</h2>
                <section name="company" id="list-company">
                    <input type="radio" name="company" value="tea_table"> Bàn Trà
                    <br><input type="radio" name="company" value="mirror"> Gương
                    <br><input type="radio" name="company" value="makeup_table"> Bàn trang điểm
                    <br><input type="radio" name="company" value="tree_lights"> Đèn cây
                </section>
            </div>

            <div class="result_print">
                <button type="submit">Xem kết quả tìm kiếm</button>
            </div>
            </form>
        </div>
        <div class="right">
            <div id="root">
                <?php
                // Hàm để lấy danh sách sản phẩm đã lọc
                function getFilteredProducts($conn, $keyword = null, $priceRange = null, $category = null)
                {
                    $sql = "SELECT * FROM sanpham WHERE 1=1";
                    $params = array();

                    // Lọc theo từ khóa
                    if ($keyword !== null) {
                        $sql .= " AND tensanpham LIKE ?";
                        $params[] = "%$keyword%";
                    }

                    // Lọc theo khoảng giá
                    if ($priceRange !== null) {
                        // Tách giá trị min và max từ chuỗi giá
                        list($minPrice, $maxPrice) = explode("-", $priceRange);

                        // Thêm điều kiện vào câu lệnh SQL để lọc sản phẩm theo giá
                        $sql .= " AND gia >= ? AND gia <= ?";

                        // Thêm giá trị min và max vào mảng tham số
                        $params[] = (int) $minPrice; // Đảm bảo chuyển giá trị sang kiểu số nguyên
                        $params[] = (int) $maxPrice; // Đảm bảo chuyển giá trị sang kiểu số nguyên
                    }


                    if ($category !== null) {
                        // Xây dựng điều kiện cho loại sản phẩm
                        $sql .= " AND loaisanpham LIKE ? ";
                        $params[] = "%$category%";
                    }


                    // Prepare the SQL statement
                    $stmt = $conn->prepare($sql);

                    // Check if there are any parameters
                    if (!empty($params)) {
                        // If there are parameters, create the types string
                        $types = str_repeat("s", count($params));

                        // Bind the parameters and execute the statement
                        $stmt->bind_param($types, ...$params);
                    }

                    // Execute the statement
                    $stmt->execute();


                    // Return the result
                    return $stmt->get_result();

                }

                // Lọc sản phẩm dựa trên lựa chọn của người dùng
                if (isset($_GET['keyword'])) {
                    $keyword = $_GET['keyword'];
                } else {
                    $keyword = null;
                }

                if (isset($_POST['price'])) {
                    $priceRange = $_POST['price'];
                } else {
                    $priceRange = null;
                }

                if (isset($_POST['company'])) {
                    $category = $_POST['company'];
                } else {
                    $category = null;
                }

                // Lấy danh sách sản phẩm đã lọc
                $result = getFilteredProducts($conn, $keyword, $priceRange, $category);

                var_dump($result);

                $page = isset($_GET['page']) ? intval($_GET['page']) : 1;



                ?>

            </div>
        </div>

    </div>
    <div class="pagination">
        <button id="prevPage">Trước</button>
        <button id="nextPage">Sau</button>
    </div>

    <script>
        const itemsPerPage = 9;
        let currentPage = <?php echo $page; ?>;
        console.log(currentPage);
        var filteredData = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;
        console.log(filteredData);
        displayProductsOnPage(currentPage);

        function displayProductsOnPage(pageNumber) {
            const startIndex = (pageNumber - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const productsToDisplay = filteredData.slice(startIndex, endIndex);
            if (productsToDisplay.length > 0) {
                // Nếu có sản phẩm để hiển thị, thì hiển thị sản phẩm
                displayItem(productsToDisplay);
            } else {
                // Nếu không có sản phẩm, hiển thị thông báo "Không có sản phẩm"
                document.getElementById('root').innerHTML = "<p>Không có sản phẩm</p>";
            }
            updatePaginationButtons();
        }


        // xử lý nút trước
        document.getElementById('nextPage').addEventListener('click', () => {
            if (filteredData && currentPage * itemsPerPage < filteredData.length) {
                currentPage++;
                displayProductsOnPage(currentPage);
                updatePaginationButtons();
            }
        });

        //xử lý nút sau
        document.getElementById('prevPage').addEventListener('click', () => {
            if (filteredData && currentPage > 1) {
                currentPage--;
                displayProductsOnPage(currentPage);
                updatePaginationButtons();
            }
        });

        // Hàm cập nhật trạng thái của nút phân trang
        function updatePaginationButtons() {
            // Cập nhật trạng thái của nút "prevPage" và "nextPage"
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');

            if (currentPage === 1) {
                // Tắt "prevPage" nếu ở trang đầu tiên
                prevPageButton.disabled = true;
            } else {
                // Bật "prevPage" nếu không có trên trang đầu tiên
                prevPageButton.disabled = false;
            }

            if (!filteredData || currentPage * itemsPerPage >= filteredData.length) {
                // Tắt "nextPage" nếu không có dữ liệu tìm kiếm hoặc nếu ở trang cuối cùng
                nextPageButton.disabled = true;
            } else {
                // Bật "nextPage" nếu có nhiều dữ liệu hơn để hiển thị
                nextPageButton.disabled = false;
            }
        }

        // Hàm hiển thị sản phẩm
        function displayItem(products) {
            const root = document.getElementById('root');
            root.innerHTML = products.map(product => {
                return `
        <div class='box'>
        <a href='http://localhost/web-24/view/product_details.php?idProduct=${product.id}'>
                <div class='img-box'>
                    <img class='images' src="../IMG/${product.hinhanh}">
                </div>
                </a>
                <div class='bottom'>
                <!-- mỗi sản phẩm có id thì mình truyền id vào đây  -->
                
                    <h2><a href='http://localhost/web-24/view/product_details.php?idProduct=${product.id}'>${product.tensanpham}</a></h2>

                    <h2>${product.gia.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}đ</h2>
                </div>
            </a>
           
        </div>
        `;
            }).join('')
        };

        function updateTotal() {
            // Check if any price input is selected
            const priceSelected = Array.from(priceInputs).some(input => input.checked);

            // Check if any company input is selected
            const companySelected = Array.from(companyInputs).some(input => input.checked);

            // If neither price nor company input is selected, hide the total
            if (!priceSelected && !companySelected) {
                document.querySelector('.total-reloading').style.display = 'none';
                return; // Exit the function early
            }

            // Calculate the total number of products based on the filtered data
            const totalProducts = filteredData.length;

            // Update the total displayed on the button
            document.querySelector('.total-reloading').textContent = totalProducts;
            document.querySelector('.total-reloading').style.display = 'inline'; // Show the total
        }

        // Event listeners for radio inputs
        const priceInputs = document.querySelectorAll('input[name="price"]');
        const companyInputs = document.querySelectorAll('input[name="company"]');

        // Add event listener for price inputs
        priceInputs.forEach(input => {
            input.addEventListener('click', () => {
                updateTotal();
            });
        });

        // Add event listener for company inputs
        companyInputs.forEach(input => {
            input.addEventListener('click', () => {
                updateTotal();
            });
        });

        // Call the updateTotal function initially to set the initial total
        updateTotal();
    </script>

</body>
<footer>
    <?php include_once ('layout/footer.php'); ?>
</footer>

</html>