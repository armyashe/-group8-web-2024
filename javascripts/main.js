var index = 0;
var imgs = ["./IMG/background.jpg", "./IMG/background_1.jpg", "./IMG/background_2.jpg", "./IMG/background_3.jpg"]; // mảng ảnh
var imgElement = document.getElementById('img');

// tải ảnh background.jpg lên trước ( nhiều để giảm độ trễ khi người ta xem trang web )
function preloadImage(url) {
  var img = new Image();
  img.src = url;
}

// hàm thay đổi ảnh 
function changeImge() {
  imgElement.style.backgroundImage = "url(" + imgs[index] + ")";
  index++;
  if (index == imgs.length) index = 0;
}

// Tiền tải tất cả hình ảnh trước
for (var i = 0; i < imgs.length; i++) {
  preloadImage(imgs[i]);
}

// Hiển thị hình đầu tiên ngay khi trang được tải
changeImge();

// Sử dụng setInterval để chuyển đổi sau mỗi khoảng thời gian
setInterval(changeImge, 2000);


var words = document.querySelectorAll('.word');
var currentIndex = 0;

// hàm này dùng để chỉnh hiệu ứng chữ xuất hiện
function animateWord() {
  words[currentIndex].style.animation = 'animate 3s';
  currentIndex++;

  if (currentIndex >= words.length) {
    currentIndex = 0; // Quay lại từ đầu nếu đã hiển thị hết
  }
}

// Hiển thị chữ đầu tiên ngay khi trang được tải
words[0].style.animation = 'animate 3s';

setInterval(animateWord, 3000); // Đổi từng thẻ word sau mỗi 3 giây

// hàm này dùng để hiệu ứng khi kéo xuống ảnh từ từ xuất hiện
function reveal() {
  var reveals = document.querySelectorAll(".reveal");

  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 150;

    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add("active");
    } else {
      reveals[i].classList.remove("active");
    }
  }
}
window.addEventListener("scroll", reveal);