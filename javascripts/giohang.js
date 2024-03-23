// get data từ localstorage
list_products = getListProducts() || list_products;
adminInfo = getListAdmin() || {};
var user = getCurrentUser();

listcart(user) ;
function listcart(user) {
	var list = document.querySelector(".list-cart");
	if (!user) {
		alert('Bạn cần đăng nhập để mua hàng !');
		return;
	}
	else if (user.products.length === 0) {
		alert('Không có sản phẩm nào trong giỏ hàng !');
	}
	var s = `
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh đại diện</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>`;
	console.log("user:", user);
	console.log("user.products:", user.products);
	console.log("list_products:", list_products);

	var totalPrice = 0;
	for (var i = 0; i < user.products.length; i++) {
		var soluongSp = user.products[i].soluong;
		var masp = user.products[i].masp;
		var p = timKiemTheoMa(list_products, masp);
		console.log("p:", p);
		var price = p.price;
		var thoigian = new Date(user.products[i].date).toLocaleString();
		var thanhtien = stringToNum(price) * soluongSp;
		s += `
            <tr>
                <td>` + (i + 1) + `</td>
                <td> <img src="${p && p.img ? p.img : ''}"></td>
                <td>
				<a target="_blank" href="chitietsanpham.html?${p && p.name ? p.name.split(' ').join('-') : ''}" title="Xem chi tiết">${p && p.name ? p.name : ''}
                </td>
                <td class="soluong">
					<button onclick="giamSoLuong('` + masp + `')"><i class="fa fa-minus"></i></button>
					<input size="1" onchange="capNhatSoLuongFromInput(this, '` + masp + `')" value="` + soluongSp + `">
					<button  onclick="tangSoLuong('` + masp + `')"><i class="fa fa-plus"></i></button>
				</td>
                <td>` + price + ` ₫</td>
                <td class="alignRight">` + numToString(thanhtien) + ` ₫</td>
				<td style="text-align: center" >` + thoigian + `</td>
                <td class="noPadding"> <i class="fa fa-trash" onclick="xoaSanPhamTrongGioHang(` + i + `)"></i> </td>
            </tr>`;
		// Chú ý nháy cho đúng ở giamsoluong, tangsoluong
		totalPrice += thanhtien;
	}
	console.log("totalPrice:", totalPrice);
	s += `
			<tr style="font-weight:bold; text-align:center">
				<td colspan="4">TỔNG TIỀN: </td>
				<td class="alignRight">` + numToString(totalPrice) + ` ₫</td>
				<td class="thanhtoan" onclick="thanhToan()"> Thanh Toán </td>
				<td class="xoaHet" onclick="xoaHet()"> Xóa hết </td>
			</tr>
		</tbody>
	`;
	list.innerHTML = s;
}
function timKiemTheoMa(list, masp) {
    for (var l of list) {
        if (l.masp == masp) return l;
    }
}
function xoaSanPhamTrongGioHang(i) {
	if (window.confirm('Xác nhận hủy mua')) {
		user.products.splice(i, 1);
		capNhatMoiThu();
	}
}

function thanhToan() {
	var c_user = getCurrentUser();
	if (c_user.off) {
		alert('Tài khoản của bạn hiện đang bị khóa nên không thể mua hàng!');
		addAlertBox('Tài khoản của bạn đã bị khóa bởi Admin.', '#aa0000', '#fff', 10000);
		return;
	}

	if (!user.products.length) {
		addAlertBox('Không có mặt hàng nào cần thanh toán !!', '#ffb400', '#fff', 2000);
		return;
	}
	if (window.confirm('Thanh toán giỏ hàng ?')) {
		user.donhang.push({
			"sp": user.products,
			"ngaymua": new Date(),
			"tinhTrang": 'Đang chờ xử lý'
		});
		user.products = [];
		capNhatMoiThu();
		addAlertBox('Các sản phẩm đã được gửi vào đơn hàng và chờ xử lý.', '#17c671', '#fff', 4000);
	}
}

function xoaHet() {
	if (user.products.length) {
		if (window.confirm('Bạn có chắc chắn muốn xóa hết sản phẩm trong giỏ !!')) {
			user.products = [];
			capNhatMoiThu();
		}
	}
}

// Cập nhật số lượng lúc nhập số lượng vào input
function capNhatSoLuongFromInput(inp, masp) {
	var soLuongMoi = Number(inp.value);
	if (!soLuongMoi || soLuongMoi <= 0) soLuongMoi = 1;

	for (var p of user.products) {
		if (p.masp === masp) {
			p.soluong = soLuongMoi;
		}
	}

	capNhatMoiThu();
}

function tangSoLuong(masp) {
    console.log("Đã gọi hàm tangSoLuong với mã sản phẩm:", masp);
    for (var p of user.products) {
        if (p.masp === masp) {
            p.soluong++;
            break; // Dừng vòng lặp sau khi tăng số lượng
        }
    }
    capNhatMoiThu();
}

function giamSoLuong(masp) {
    for (var p of user.products) {
        if (p.masp === masp) {
            if (p.soluong > 1) {
                p.soluong--;
            } else {
                return;
            }
            break; // Dừng vòng lặp sau khi giảm số lượng
        }
    }
    capNhatMoiThu();
}


function capNhatMoiThu() { // Mọi thứ

	
	// cập nhật danh sách sản phẩm trong localstorage
	setCurrentUser(user);
	updateListUser(user);

	// cập nhật danh sách sản phẩm ở table
	listcart(user);

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
// ==================== Những hàm khác ===================== 
function numToString(num, char) {
    return num.toLocaleString().split(',').join(char || '.');
}

function stringToNum(str, char) {
    return Number(str.split(char || '.').join(''));
}
// Sau khi chỉnh sửa 1 user 'u' thì cần hàm này để cập nhật lại vào ListUser
function updateListUser(u, newData) {
	var list = getListUser();
	for (var i = 0; i < list.length; i++) {
		if (equalUser(u, list[i])) {
			list[i] = (newData ? newData : u);
		}
	}
	setListUser(list);
}

// Localstorage cho dssp: 'ListProducts
function setListProducts(newList) {
    window.localStorage.setItem('ListProducts', JSON.stringify(newList));
}

function getListProducts() {
    return JSON.parse(window.localStorage.getItem('ListProducts'));
}