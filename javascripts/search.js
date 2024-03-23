// get data từ localstorage
list_products = getListProducts() || list_products;
const categories = [...new Set(list_products.map((item) => { return item }))] // khai báo mảng với tên là categories sẽ là danh sách mục duy nhất từ mảng list_

// dùng để tìm kiếm các sản phẩm trên thanh tìm kiếm 
document.getElementById('menu-search').addEventListener('keyup', (e) => { // nhập từ tìm kiếm trên thanh tìm kiếm thì nó sẽ lọc danh sách dựa trên giá trị tìm kiếm . Sau đó nó sẽ hiện thị sản phẩm theo giá trị tìm kiếm trên trang hiện tại
    const searchData = e.target.value.toLowerCase();// sử dụng để so sánh không phân biệt chữ hoa và chữ thường.
    filteredData = categories.filter((item) => {
        return (
            item.name.toLowerCase().includes(searchData) 
        );
    });
    displayProductsOnPage(currentPage)
});
// hàm này dùng để tìm kiếm hai phần lọc theo giá và lọc theo sản phẩm 
function getprice() {
    const selectedInputprice = document.querySelector('input[name="price"]:checked');
    const selectedInput = document.querySelector('input[name="company"]:checked');

    var searchDatacompany;
    var searchData;
    if (selectedInput && selectedInputprice) { // nếu cùng ấn vào ô trong lọc theo giá và lọc theo sản phẩm thì sẽ hiển thị sản phẩm theo cái mình muốn tìm  vd : nhấn vào 0 đến 500đ và bàn trang điểm thì sẽ hiện ra sản phẩm bàn trang điểm có giá từ 0 đến 500đ
        searchDatacompany = selectedInput.value.toLowerCase();
        searchData = selectedInputprice.value.toLowerCase();
        filteredData = categories.filter((item) => {
            return (
                item.listprice && item.listprice.toLowerCase().includes(searchData) && item.company && item.company.toLowerCase().includes(searchDatacompany)
            )

        });
        console.log(filteredData);
        displayItem(filteredData);
    } else
        if (selectedInput) { // nếu ấn vào ô trong lọc theo sản phẩm thì ra những sản phẩm mình chọn vd chọn bàn trà thì chỉ hiện ra những sản phẩm bàn trà
            currentPage = 1;
            searchDatacompany = selectedInput.value.toLowerCase();
            filteredData = categories.filter((item) => {
                return (
                    item.company && item.company.toLowerCase().includes(searchDatacompany)
                )
            });
            displayProductsOnPage(currentPage)
        } else
            if (selectedInputprice) { //nếu ấn vào ô trong lọc theo giá thì ra những sản phẩm mình chọn vd chọn giá từ 5 triêu tới 7 triệu thì chỉ hiện ra những sản phẩm có giá từ 5 triêu tới 7 triệu
                currentPage = 1;
                searchData = selectedInputprice.value.toLowerCase();
                filteredData = categories.filter((item) => {
                    return (
                        item.listprice && item.listprice.toLowerCase().includes(searchData)
                    )
                });
                console.log(filteredData)
                displayProductsOnPage(currentPage)
            }
            if (filteredData.length === 0) {
                // Nếu không có sản phẩm phù hợp, hiển thị thông báo
                document.getElementById('root').innerHTML = "<p>Không có sản phẩm phù hợp</p>";
            } else {
                // Nếu có sản phẩm, hiển thị sản phẩm
                displayItem(filteredData);
            }
}

// dùng html trong js ( là mình làm html trong js thì giảm thời gian của những trang html giống nhau ) vd khung sản phẩm tầm 30 sản phẩm nếu làm bthuong thì sẽ làm 30 thẻ div nhưng dùng html trong js thì 1 thẻ div sẽ tạo 30 khung giống nhau
console.log(categories);
const displayItem = (items) => {
    document.getElementById('root').innerHTML = items.map((item) => {

        var { img, name, price, company, masp } = item;
        console.log(item);
        var chitietSp = 'chitietsanpham.html?' + masp;


        return (
            `<div class='box'>
            <a href="` + chitietSp + `">
                <div class='img-box'>
                    <img class='images' src=${img}></img>
                </div> 
                <div class='bottom'>
                    <h2>${name}</h2>
                    <h2>${price}đ</h2>
                    
                </div>
            </a>
            <button onclick="themVaoGioHang('${item.masp}')">Thêm vào giỏ hàng</button>
            </div>`
        )
    }).join('')
};

// lọc danh sách sản phẩm dựa trên một danh mục được chỉ định (list_products) và sau đó hiển thị các sản phẩm đã được lọc lên trang hiện tại.
function filterProducts(category) {
    filteredData = list_products.filter((item) => {
        return item.category.toLowerCase() === category.toLowerCase();
    });
    displayProductsOnPage(currentPage)//Sau khi danh sách đã được lọc, hàm gọi displayProductsOnPage(currentPage)  để hiển thị các sản phẩm đã lọc lên trang hiện tại.
}

// Your other functions and code...

// chuyển trang

const itemsPerPage = 9;
let currentPage = 1;
var filteredData = categories;
displayProductsOnPage(currentPage);

function displayProductsOnPage(pageNumber) {
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const productsToDisplay = filteredData.slice(startIndex, endIndex);
    console.log(productsToDisplay)
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
    console.log(currentPage);

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

// Khởi tạo các nút phân trang
updatePaginationButtons();

function User(email, username,pass, products, donhang) {
    this.username = username || '';
	this.pass = pass || '';
	this.email = email || '';
    this.products = products || [];
	this.donhang = donhang || [];
}
// Localstorage cho dssp: 'ListProducts
function setListProducts(newList) {
    window.localStorage.setItem('ListProducts', JSON.stringify(newList));
}

function getListProducts() {
    return JSON.parse(window.localStorage.getItem('ListProducts'));
}
function animateCartNumber() {
    // Hiệu ứng cho icon giỏ hàng
    var cn = document.getElementsByClassName('cart-number')[0];
    cn.style.transform = 'scale(2)';
    cn.style.backgroundColor = 'rgba(255, 0, 0, 0.8)';
    cn.style.color = 'white';
    setTimeout(function () {
        cn.style.transform = 'scale(1)';
        cn.style.backgroundColor = 'transparent';
        cn.style.color = 'red';
    }, 1200);
}
// ================ Cart Number + Thêm vào Giỏ hàng ======================
function themVaoGioHang(masp, namesp) {
	var user = getCurrentUser();
	if (!user) {
		alert('Bạn cần đăng nhập để mua hàng !');
		return;
	}
	if (user.off) {
		alert('Tài khoản của bạn hiện đang bị khóa nên không thể mua hàng!');
		//addAlertBox('Tài khoản của bạn đã bị khóa bởi Admin.', '#aa0000', '#fff', 10000);
		return;
	}
	var t = new Date();
	var daCoSanPham = false;;

	for (var i = 0; i < user.products.length; i++) { // check trùng sản phẩm
		if (user.products[i].ma == masp) {
			user.products[i].soluong++;
			daCoSanPham = true;
			break;
		}
	}

	if (!daCoSanPham) { // nếu không trùng thì mới thêm sản phẩm vào user.products
		user.products.push({
			"ma": masp,
			"soluong": 1,
			"date": t
		});
	}
	animateCartNumber();
}