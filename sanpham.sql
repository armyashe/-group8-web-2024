-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 05, 2024 lúc 01:05 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(10) NOT NULL,
  `tensanpham` varchar(100) NOT NULL,
  `loaisanpham` varchar(100) NOT NULL,
  `gia` int(10) NOT NULL,
  `soluong` int(10) NOT NULL,
  `mota` text NOT NULL,
  `hinhanh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`id`, `tensanpham`, `loaisanpham`, `gia`, `soluong`, `mota`, `hinhanh`) VALUES
(1, 'Bàn Trang Điểm TC22', 'makeup_table', 799000, 10, 'Chất liệu : Gỗ công nghiệp chống ẩm . Kích thước : 100x120x80cm. Viền : Kim loại.Màu sắc : Trắng, Đen, màu tùy chọn', 'Ban_trang_diem_TC22.jpg'),
(2, 'Bàn Trang Điểm TC56', 'makeup_table', 1199000, 5, 'Gỗ công nghiệp chống ẩm MDF,120x40x75cm, 160x40x75cm,Kim loại,Trắng, Đen, màu tuỳ chọn', 'Ban_Trang_diem_TC56.jpg'),
(3, 'Bàn Trang Điểm TC17', 'makeup_table', 1399000, 6, 'Gỗ công nghiệp chống ẩm 100x120x80cm, Kim loại,Trắng, Đen, màu tùy chọn', 'Ban_trang_diem_TC17.jpg'),
(4, 'Bàn Trang Điểm TC23', 'makeup_table', 399000, 7, 'Gỗ công nghiệp chống ẩm, 100x120x80cm, Kim loại,Trắng, Đen, màu tùy chọn', 'Ban_trang_diem_TC23.jpg'),
(5, 'Bàn Trang Điểm TC10', 'makeup_table', 799000, 8, 'Gỗ công nghiệp chống ẩm, 100x120x80cm, Kim loại,Trắng, Đen, màu tùy chọn', 'Ban_trang_diem_TC10.jpg'),
(6, 'Bàn Trang Điểm BTD01', 'makeup_table', 4199000, 9, 'Gỗ công nghiệp chống ẩm, 120x40x75cm, 160x40x75cm, kim loại/Da/Nỉ/Gỗ,Cam/Xanh/Ghi/Trắng,Phù hợp cho các không gian', 'Ban_trang_diem_BTD01.jpg'),
(7, 'Bàn Trang Điểm BTD09', 'makeup_table', 4399000, 10, '(80-100-120 - 140 - 160 - 180)cm,kim loại/Da/Nỉ/Gỗ,Cam/Xanh/Ghi/Trắng,Phù hợp cho các không gian', 'Ban_trang_điem_BTD09.jpg'),
(8, 'Bàn Trang Điểm BTD05', 'makeup_table', 2250000, 4, 'Kính/Gỗ,(80-100-120 - 140 - 160 - 180)cm,kim loại/Da/Nỉ/Gỗ,Cam/Xanh/Ghi/Trắng,Phù hợp cho các không gian', 'Ban_trang_diem_BTD05.jpg'),
(9, 'Gương trang trí treo tường GTT03', 'mirror', 750000, 5, 'Soi mặt, trang trí decor treo tường,gồm khung gương, mặt gương, dây treo, đinh vít ,Gỗ công nghiệp chống ẩm MDF,30x30x4CM,Vàng, Đen,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT03.jpg'),
(10, 'Gương trang trí treo tường GTT04', 'mirror', 740000, 4, 'Soi mặt, trang trí decor treo tường,gồm khung gương, mặt gương, dây treo, đinh vít ,Gỗ công nghiệp chống ẩm MDF,54x47cm,Vàng, Đen,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT04.jpg'),
(11, 'Gương trang trí treo tường GTT17 D50', 'mirror', 1090000, 3, 'Soi mặt, trang trí decor treo tường,gồm khung gương, mặt gương, dây treo, đinh vít ,54cm,Vàng, Đen,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT17_D50.jpg'),
(12, 'Gương trang trí treo tường GTT17 D40', 'mirror', 1500000, 5, 'Soi mặt, trang trí decor treo tường,gồm khung gương, mặt gương, dây treo, đinh vít ,40CM,Vàng, Đen,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT17_D40.jpg'),
(13, 'Gương trang trí treo tường GTT10', 'mirror', 650000, 5, 'Soi mặt, trang trí decor treo tường,gồm mặt gương khoan lỗ, đinh vít,60x90cm,Trắng,Vàng,Đen, cổ điển,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT10.jpg'),
(14, 'Gương trang trí treo tường GTT07 D60', 'mirror', 450000, 2, 'Soi mặt, trang trí decor treo tường,gồm mặt gương khoan lỗ, đinh vít,60x90cm,Trắng,Vàng,Đen, cổ điển,Gương Việt Nhật hoặc Bỉ dày 5mm  <br> Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT07_D60.jpg'),
(15, 'Bàn trà vuông mặt kính BT07', 'tea_table', 6090000, 4, 'Kim loại sơn từ tính / Đá,70x70x45x45CM  /60x60x38CM,Vàng/Đen/Trắng,Trắng / Đen ', 'Ban_tra_BT07.jpg'),
(16, 'Bàn trà hộp chữ nhật mặt kính BT18', 'tea_table', 4599000, 6, 'Gỗ/Kim loại/Kính,100x42x50cm,Trắng,Trắng/Đen, Khung viền gỗ có hộc đựng đồ', 'Ban_tra_BT18.jpg'),
(17, 'Bàn trà mặt đá chân mạ PVD có hộc chứa đồ BT21', 'tea_table', 5799000, 3, 'Đá/Kim loại/Kính,135x70x48cm,Màu đen, chân mạ PVD vàng,Trắng / Đen, Khung chân kim loại sơn từ tính', 'Ban_tra_BT21.jpg'),
(18, 'Bàn trà Tab BPT10', 'tea_table', 2899000, 5, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay, Đá/Kim loại, 50x65cm, Đen / Vàng, Trắng / Đen, Khung chân kim loại sơn từ tính', 'Ban_Tab_BPT10.jpg'),
(19, 'Bàn trà 2 tầng mặt gỗ BT23', 'tea_table', 2500000, 5, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay, Gỗ/Kim loại, 80x45cm, Màu tự nhiên/ Sơn nâu đậm, Nâu nhạt, Khung chân kim loại sơn từ tính', 'Ban_tra_BT23.jpg'),
(20, 'Bàn trà Tab BPT08', 'tea_table', 2000000, 4, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay, Gỗ/Kim loại, 50x55cm, Màu tự nhiên/ Sơn nâu đậm, Nâu nhạt, Khung chân kim loại sơn từ tính', 'Ban_Tab_BPT08.jpg'),
(21, 'Bàn trà 2 mặt kính viền mạ PVD BT25', 'tea_table', 5300000, 4, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay, Kính/Kim loại, (120 - 50)x45cm\", Đen/ Đen mờ, Khung chân kim loại sơn từ tính', 'Ban_tra_BT25.png'),
(22, 'Đèn cây DC04', 'tree_lights', 1400000, 5, ' 220V, LED, Kim loại, 180cm, Hiện đại, Công tắc ở dây đoạn thân đèn', 'Den_cay_DC04.jpg'),
(23, 'Đèn cây DC07', 'tree_lights', 490000, 3, ' 220V, LED, Kim loại sơn từ tính,  tối đa 182 CM - có thế thay đổi, đường kính chân đèn: 28CM,  Hiện đại đa dụng, Đen,  Công tắc núm xoay thay đổi độ sáng < br>  Tiện ích:  Làm việc, giải trí, đọc sách...', 'Den_cay_DC07.jpg'),
(24, 'Đèn cây DC10', 'tree_lights', 1360000, 5, ' 220V, LED, Kim loại, 175cm, Hiện đại, độc đáo, decor, Công tắc ở dây đoạn thân đèn', 'Den_cay_DC10.jpg'),
(25, 'Đèn cây DC12', 'tree_lights', 989000, 7, ' 220V, LED, Kim loại, 190  cm, Độc đáo, decor,  Công tắc dây  <br>  Khu vực sử dụng :  Phòng khách, phòng làm việc, phòng ngủ,...', 'Den_cay_DC12.jpg'),
(26, 'Đèn cây DC13', 'tree_lights', 1090000, 6, ' 220V, LED, Kim loại, 175cm, Hiện đại, độc đáo, decor, Công tắc ở dây đoạn thân đèn', 'Den_cay_DC13.jpg'),
(27, 'Đèn cây DC15', 'tree_lights', 999000, 9, '220V, LED, Kim loại, 180CM, từ chụp đèn đến thân : 64cm, đường kính chân 27cm, đường kính chụp đèn 34cm, Thiết kế dạng vòm tiện lợi để đọc sách ', 'Den_cay_DC15.png'),
(28, 'Đèn cây DC20', 'tree_lights', 450000, 5, ' 220V, LED, Kim Loại, 182cm, Hiện đại, độc đáo, Công tắc dây <br> Tiện ích: Có sạc không dây và ở cắm USB riêng', 'Den_cay_DC20.png'),
(29, 'Đèn cây DC21', 'tree_lights', 580000, 7, ' 220V, LED, Kim loại, 180cm, Hiện đại, độc đáo, decor, Công tắc ở dây đoạn thân đèn', 'Den_cay_DC21.png'),
(30, 'ban tien', 'bantrangdiem', 2222222, 0, '', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
