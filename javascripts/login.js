const btn = document.querySelector('.btn-primary-login');
const inputname = document.querySelector('.username');
const inputemail = document.querySelector('.email');
const inputpass = document.querySelector('.password');
const confirmPass = document.querySelector('.pass');
const inputusernamereg = document.querySelector('#usernamereg');
const inputpassreg = document.querySelector('#passreg');


setTimeout(() => {
    checkCurrentUser();
}, 1);

function equalUser(u1, u2) {
    return (u1.username.toLowerCase() == u2.username.toLowerCase() && u1.pass == u2.pass);
}
// Hàm get set cho người dùng hiện tại đã đăng nhập
function getCurrentUser() {
    return JSON.parse(window.localStorage.getItem('CurrentUser'));// Lấy dữ liệu từ localstorage
}

function setCurrentUser(u) {
    window.localStorage.setItem('CurrentUser', JSON.stringify(u));
}

function login() {
    var username = document.getElementById('usernamereg').value;
    var pass = document.getElementById('passreg').value;
    console.log(username)
    var user = new User(username, pass);
    // Updated to pass an empty email
    console.log(pass)
    var listUser = getListUser();
    console.log(listUser)
    console.log(user)
    var check = false;
    var checkAdmin = false;
    var adminInfo = [{
        "username": "admin",
        "pass": "abcd"
    }];
    // Kiểm tra trùng admin
    for (var ad of adminInfo) {
        if (user.username == ad.username && user.pass == ad.pass) {
            alert('Xin chào admin');
            checkAdmin = true;
            window.localStorage.setItem('admin', true);
            window.location.href = "admin.html";
        } 
        else if (user.username == ad.username) {
            alert('Vui lòng kiểm tra lại username hoặc password !!!');
        }
    }
    for (var u of listUser) {
        if (equalUser(user, u)) {
            setCurrentUser(u);
            check = true;

        }
    }
    console.log(check)
    console.log(checkAdmin)
    if (checkAdmin) {
        alert('Đăng nhập thành công admin');
        window.location.href = "admin.html";
    }
    if (check ) {
        window.location.href = "sanpham.html"
        alert('Đăng nhập thành công');

    } else if (check == false && checkAdmin == false) {
        alert('Vui lòng đăng nhập lại');
        inputpassreg.focus();
    }
}
function getuser() {
    var username = inputname.value;
    var email = inputemail.value;
    var pass = inputpass.value;
    var confirmPassword = confirmPass.value;
    if (username === "") {
        alert("Vui lòng nhập username!");
        return false;
    }
    if (pass === "" || pass.length < 8) {
        alert("Vui lòng nhập lại pass ( ít nhất 8 kí tự )!");
        return false;
    }
    if (pass !== confirmPassword) {
        alert("Mật khẩu và mật khẩu nhập lại không khớp!");
        return false;
    }
    if (email === "") {
        alert("Vui lòng nhập email!");
        return false;
    }

    var user = new User(username, pass, email);
    var listUser = getListUser();
    for (var u of listUser) {
        if (user.username === u.username) {
            alert("Tên đã có người đăng nhập");
            return false;
        }
    }

    listUser.push(user);

    window.localStorage.setItem('ListUser', JSON.stringify(listUser));
    window.location.href = "login.html"
    alert("Đăng kí thành công vui lòng đăng nhập")
}
// Hàm get set cho danh sách người dùng
var list = getListUser();
console.log(list);
function getCurrentUser() {
    return JSON.parse(window.localStorage.getItem('CurrentUser'));
}

function setCurrentUser(u) {
    window.localStorage.setItem('CurrentUser', JSON.stringify(u));
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

function getListUser() {
    var data = JSON.parse(window.localStorage.getItem('ListUser')) || []
    var l = [];
    for (var d of data) {
        l.push(d);
    }
    return l;
}

function setListUser(l) {
    window.localStorage.setItem('ListUser', JSON.stringify(l));
}

function User(username, pass, email, products, donhang) {
    this.username = username || '';
    this.pass = pass || '';
    this.email = email || '';
    this.products = products || [];
    this.donhang = donhang || [];
}

function checkCurrentUser() {
    var user = getCurrentUser();
    console.log(user);
    if (user) {
        document.getElementsByClassName('cart-number')[0].innerHTML = getTongSoLuongSanPhamTrongGioHang(user);
        document.querySelector('.login a').innerHTML = `<i class="fa fa-user"></i> ${user.username}`;
        document.querySelector('.login').href = "giohang.html";
    }
}
// tính tổng số lượng các sản phẩm của user u truyền vào
function getTongSoLuongSanPhamTrongGioHang(user) {
    var soluong = 0;
    for (var p of user.products) {
        soluong += p.soluong;
    }
    return soluong;
}
function logout() {
    
    // Xóa người dùng hiện tại từ localStorage.
    window.localStorage.removeItem('CurrentUser');

    // Chuyển hướng về trang đăng nhập.
    window.location.href = "sanpham.html";
}

// ... Các hàm và đối tượng khác ...

// Sự kiện cho nút đăng xuất.
const logoutButton = document.getElementById('logoutButton');
if (logoutButton) {
    logoutButton.addEventListener('click', function () {
        logout();
    });
}
// Localstorage cho dssp: 'ListProducts
function setListProducts(newList) {
    window.localStorage.setItem('ListProducts', JSON.stringify(newList));
}

function getListProducts() {
    return JSON.parse(window.localStorage.getItem('ListProducts'));
}
function getListAdmin() {
    return JSON.parse(window.localStorage.getItem('ListAdmin'));
}

function setListAdmin(l) {
    window.localStorage.setItem('ListAdmin', JSON.stringify(l));
}