-- Active: 1715164480286@@127.0.0.1@3306@showroom_db
-- Active: 1698821848605@@127.0.0.1@3306@showroom
-- Cấu trúc bảng cho bảng `khachhang`

CREATE DATABASE showroom_db CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci;
USE showroom_db;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 05:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `showroom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `idOrder` varchar(255) NOT NULL,
  `idUser` varchar(255) NOT NULL,
  `nameCustomer` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `order_date` varchar(255) NOT NULL,
  `total_amount` int(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `payment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`idOrder`, `idUser`, `nameCustomer`, `phone_number`, `address`, `order_date`, `total_amount`, `status`, `payment`) VALUES
('6630a057d0a27', '6630a0067a35a', 'Triệu lộ tư', '09575832121', '273 Đ. An Dương Vương, Phường 3, Quận 5, Thành phố Hồ Chí Minh 700000', '2024-04-30 09:40:07', 799000, 'confirm', 'ATM'),
('6630a17e2cc58', '6630a10b6e7ab', 'Park Jihoon', '09782368882', '105 Bà Huyện Thanh Quan, Võ Thị Sáu, Quận 3, Thành phố Hồ Chí Minh', '2024-04-30 09:45:02', 750000, 'active', 'ATM'),
('663ce171a6d4c', '6630a256651bd', 'Thiên Hân', '0937297098', '4 Đ. Tôn Đức Thắng, Bến Nghé, Quận 1, Thành phố Hồ Chí Minh', '2024-05-09 16:45:05', 6540000, 'active', 'cash'),
('663ce2963c094', '6630a256651bd', 'huong ne', '0937297098', '4 Đ. Tôn Đức Thắng, Bến Nghé, Quận 1, Thành phố Hồ Chí Minh', '2024-05-09 16:49:58', 6980000, 'active', 'ATM');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `idOrder` varchar(255) NOT NULL,
  `idProduct` int(10) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `price` int(10) NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`idOrder`, `idProduct`, `quantity`, `price`, `note`) VALUES
('6630a057d0a27', 1, 1, 799000, 'Chất liệu:Gỗ công nghiệp chống ẩm'),
('6630a17e2cc58', 9, 1, 750000, 'Công dụng:Soi mặt, trang trí decor treo tường'),
('663ce171a6d4c', 15, 1, 6090000, 'delivered'),
('663ce171a6d4c', 14, 1, 450000, 'delivered'),
('663ce2963c094', 8, 1, 2250000, 'delivered'),
('663ce2963c094', 24, 3, 1360000, 'delivered'),
('663ce2963c094', 13, 1, 650000, 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(10) NOT NULL,
  `tensanpham` varchar(100) NOT NULL,
  `loaisanpham` varchar(100) NOT NULL,
  `gia` int(10) NOT NULL,
  `soluong` int(10) NOT NULL,
  `mota` text NOT NULL,
  `hinhanh` varchar(100) NOT NULL,
  `hinh2` varchar(100) NOT NULL,
  `hinh3` varchar(100) NOT NULL,
  `hinh4` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `tensanpham`, `loaisanpham`, `gia`, `soluong`, `mota`, `hinhanh`, `hinh2`, `hinh3`, `hinh4`) VALUES
(1, 'Bàn Trang Điểm TC22', 'makeup_table', 799000, 10, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:100x120x80cm.Viền:Kim loại.Màu:Trắng, Đen', 'Ban_trang_diem_TC22.jpg', 'screenshot_1699523625.png', 'screenshot_1699523705.png', 'screenshot_1699523720.png'),
(2, 'Bàn Trang Điểm TC56', 'makeup_table', 1199000, 5, 'Chất liệu:Gỗ công nghiệp chống ẩm MDF.Kích thước:120x40x75cm, 160x40x75cm.Viền:Kim loại.Màu:Trắng, Đen', 'Ban_Trang_Điem_TC56.jpg', 'screenshot_1699524101.png', 'screenshot_1699524125.png', 'screenshot_1699524159.png'),
(3, 'Bàn Trang Điểm TC17', 'makeup_table', 1399000, 6, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:100x120x80cm.Viền:Kim loại.Màu:Trắng, Đen', 'Ban_trang_diem_TC17.jpg', 'screenshot_1699523961.png', 'screenshot_1699523981.png', 'screenshot_1699523989.png'),
(4, 'Bàn Trang Điểm TC23', 'makeup_table', 399000, 7, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:100x120x80cm.Viền:Kim loại.Màu:Trắng, Đen', 'Ban_trang_diem_TC23.jpg', 'screenshot_1699523740.png', 'screenshot_1699524058.png', 'screenshot_1699524073.png'),
(5, 'Bàn Trang Điểm TC10', 'makeup_table', 799000, 8, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:100x120x80cm.Viền:Kim loại.Màu:Trắng, Đen', 'Ban_trang_diem_TC10.jpg', 'Ban_trang_diem_TC10.jpg', 'screenshot_1699523457.png', 'screenshot_1699523497.png'),
(6, 'Bàn Trang Điểm BTD01', 'makeup_table', 4199000, 9, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:120x40x75cm, 160x40x75cm.Viền:kim loại.Màu:Cam,Xanh', 'Ban_trang_diem_BTD01.jpg', 'screenshot_1699523273.png', 'screenshot_1699523288.png', 'screenshot_1699523296.png'),
(7, 'Bàn Trang Điểm BTD09', 'makeup_table', 4399000, 10, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:120x40x75cm, 160x40x75cm.Viền:kim loại.Màu:Cam,Xanh', 'Ban_trang_điem_BTD09.jpg', 'Ban_trang_điem_BTD09.jpg', 'bid09.jpg', 'bid09.jpg'),
(8, 'Bàn Trang Điểm BTD05', 'makeup_table', 2250000, 4, 'Chất liệu:Gỗ công nghiệp chống ẩm.Kích thước:120x40x75cm, 160x40x75cm.Viền:kim loại.Màu:Cam,Xanh', 'Ban_trang_diem_BTD05.jpg', 'Ban_trang_diem_BTD05.jpg', 'Ban_trang_diem_BTD05(1).jpg', 'Ban_trang_diem_BTD05(2).jpg'),
(9, 'Gương trang trí treo tường GTT03', 'mirror', 750000, 5, 'Công dụng:Soi mặt, trang trí decor treo tường.Chất liệu:Gỗ công nghiệp chống ẩm MDF.Kích thước:30x30x4CM.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT03.jpg', 'screenshot_1699525417.png', 'screenshot_1699525425.png', 'screenshot_1699525434.png'),
(10, 'Gương trang trí treo tường GTT04', 'mirror', 740000, 4, 'Công dụng:Soi mặt, trang trí decor treo tường.Chất liệu:Gỗ công nghiệp chống ẩm MDF.Kích thước:54x47cm.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT04.jpg', 'screenshot_1699525491.png', 'screenshot_1699525513.png', 'screenshot_1699525522.png'),
(11, 'Gương trang trí treo tường GTT17 D50', 'mirror', 1090000, 3, 'Công dụng:Soi mặt, trang trí decor treo tường.Chất liệu:Gỗ công nghiệp chống ẩm MDF.Kích thước:54x47cm.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT17_D50.jpg', 'screenshot_1699526107.png', 'screenshot_1699526101.png', 'screenshot_1699526115.png'),
(12, 'Gương trang trí treo tường GTT17 D40', 'mirror', 1500000, 5, 'Công dụng:Soi mặt, trang trí decor treo tường.Chất liệu:Gỗ công nghiệp chống ẩm MDF.Kích thước:54x47cm.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT17_D40.jpg', 'Guong_trang_tri_GTT17_D40.jpgg', 'screenshot_1699526218.png', 'screenshot_1699526239.png'),
(13, 'Gương trang trí treo tường GTT10', 'mirror', 650000, 5, 'Công dụng:Soi mặt, trang trí decor treo tường.Kích thước:60x90cm.Màu:Trắng,Vàng,Đen.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT10.jpg', 'screenshot_1699525847.png', 'screenshot_1699525855.png', 'screenshot_1699525881.png'),
(14, 'Gương trang trí treo tường GTT07 D60', 'mirror', 450000, 2, 'Công dụng:Soi mặt, trang trí decor treo tường.Kích thước:60x90cm.Màu:Trắng,Vàng,Đen.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Guong_trang_tri_GTT07_D60.jpg', 'screenshot_1699525973.png', 'screenshot_1699526033.png', 'Guong_trang_tri_GTT07_D60.jpg'),
(15, 'Bàn trà vuông mặt kính BT07', 'tea_table', 6090000, 4, 'Chất liệu:Kim loại sơn từ tính /Đá.Kích thước:70x70x45x45CM /60x60x38CM.Màu:Vàng/Đen/Trắng.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Ban_tra_BT07.jpg', 'screenshot_1699522883.png', 'screenshot_1699522900.png', 'screenshot_1699522909.png'),
(16, 'Bàn trà hộp chữ nhật mặt kính BT18', 'tea_table', 4599000, 6, 'Chất liệu:Gỗ/Kim loại/Kính.Kích thước:100x42x50cm.Màu:Trắng,Trắng/Đen.Khung viền gỗ có hộc đựng đồ', 'Ban_tra_BT18.jpg', 'screenshot_1699522769.png', 'screenshot_1699522787.png', 'screenshot_1699522798.png'),
(17, 'Bàn trà mặt đá chân mạ PVD có hộc chứa đồ BT21', 'tea_table', 5799000, 3, 'Chất liệu:Đá/Kim loại/Kính.Kích thước:135x70x48cm.Màu đen, chân mạ PVD vàng.Khung chân kim loại sơn từ tính', 'Ban_tra_BT21.jpg', 'screenshot_1699523001.png', 'screenshot_1699523019.png', 'screenshot_1699523029.png'),
(18, 'Bàn trà Tab BPT10', 'tea_table', 2899000, 5, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay.Chất liệu:Đá/Kim loại.Kích thước:50x65cm.Khung chân kim loại sơn từ tính', 'Ban_Tab_BPT10.jpg', 'screenshot_1699522324.png', 'screenshot_1699522363.png', 'screenshot_1699522384.png'),
(19, 'Bàn trà 2 tầng mặt gỗ BT23', 'tea_table', 2500000, 5, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay.Chất liệu:Gỗ/Kim loại.Kích thước:80x45cm.Khung chân kim loại sơn từ tính', 'Ban_tra_BT23.jpg', 'screenshot_1699523100.png', 'screenshot_1699523117.png', 'screenshot_1699523125.png'),
(20, 'Bàn trà Tab BPT08', 'tea_table', 2000000, 4, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay.Chất liệu:Gỗ/Kim loại.Kích thước:50x55cm.Khung chân kim loại sơn từ tính', 'Ban_Tab_BPT08.jpg', 'Ban_Tab_BPT08.jpg', 'screenshot_1699522481.png', 'screenshot_1699522447.png'),
(21, 'Bàn trà 2 mặt kính viền mạ PVD BT25', 'tea_table', 5300000, 4, 'Đây là mẫu bàn tab cao cấp được rất nhiều công trình sang trọng lựa chọn hiện nay.Chất liệu:Kính/Kim loại.Kích thước:50x55cm.Khung chân kim loại sơn từ tính', 'Ban_tra_BT25.jpg', 'screenshot_1699523194.png', 'screenshot_1699523207.png', 'screenshot_1699523214.png'),
(22, 'Đèn cây DC04', 'tree_lights', 1400000, 5, 'Công suất: 220V, đèn LED.Kích thước:Kim loại, 180cm.Hiện đại, Công tắc ở dây đoạn thân đèn.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Den_cay_DC04.jpg', 'screenshot_1699524346.png', 'screenshot_1699524354.png', 'screenshot_1699524362.png'),
(23, 'Đèn cây DC07', 'tree_lights', 490000, 3, ' Công suất:220V,đèn LED.Kích thước: Kim loại sơn từ tính,tối đa 182 CM .Đường kính chân đèn: 28CM.Hiện đại đa dụng,Công tắc núm xoay thay đổi độ sáng', 'Den_cay_DC07.jpg', 'screenshot_1699524426.png', 'screenshot_1699524406.png', 'screenshot_1699524419.png'),
(24, 'Đèn cây DC10', 'tree_lights', 1360000, 5, ' Công suất:220V,đèn LED.Kích thước: Kim loại, 175cm.Hiện đại, độc đáo, decor, Công tắc ở dây đoạn thân đèn.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Den_cay_DC10.jpg', 'screenshot_1699524553.png', 'screenshot_1699524567.png', 'screenshot_1699524575.png'),
(25, 'Đèn cây DC12', 'tree_lights', 989000, 7, ' Công suất:220V,đèn LED.Kích thước: Kim loại, 190cm.Độc đáo, decor,Công tắc dây.Khu vực sử dụng :  Phòng khách, phòng làm việc, phòng ngủ,...', 'Den_cay_DC12.jpg', 'screenshot_1699524682.png', 'screenshot_1699524641.png', 'screenshot_1699524674.png'),
(26, 'Đèn cây DC13', 'tree_lights', 1090000, 6, ' Công suất:220V,đèn LED.Kích thước:Kim loại, 175cm. Hiện đại, độc đáo, decor, Công tắc ở dây đoạn thân đèn.Hàng đóng kiện chắc chắn, vận chuyển toàn quốc', 'Den_cay_DC13.jpg', 'screenshot_1699524983.png', 'screenshot_1699524973.png', 'screenshot_1699525003.png'),
(27, 'Đèn cây DC15', 'tree_lights', 999000, 9, 'Công suất:220V,đèn LED.Kích thước:Kim loại, 180CM.Từ chụp đèn đến thân : 64cm, đường kính chân 27cm, đường kính chụp đèn 34cm.Thiết kế dạng vòm tiện lợi để đọc sách ', 'Den_cay_DC15.jpg', 'screenshot_1699524756.png', 'screenshot_1699524773.png', 'screenshot_1699524779.png'),
(28, 'Đèn cây DC20', 'tree_lights', 450000, 5, ' Công suất:220V,đèn LED.Kích thước: Kim Loại, 182cm.Hiện đại, độc đáo, Công tắc dây.Tiện ích: Có sạc không dây và ở cắm USB riêng', 'Den_cay_DC20.jpg', 'Den_cay_DC20.jpg', 'screenshot_1699524885.png', 'screenshot_1699524878.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `trangthai` varchar(255) NOT NULL,
  `diachi` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `user_email`, `trangthai`, `diachi`) VALUES
('123admin', 'admin', '123', 'admin123@gmail.com', 'true', '85 Đ. An Dương Vương, Phường 3, Quận 5, Thành phố Hồ Chí Mi'),
('6630a0067a35a', 'lotu', 'lotu123', 'lotu123@gmail.com', 'true', '273 Đ. An Dương Vương, Phường 3, Quận 5, Thành phố Hồ Chí Mi'),
('6630a10b6e7ab', 'Jihoon', 'Jihoon123', 'Jihoon123@gmail.com', 'true', '105 Bà Huyện Thanh Quan, Võ Thị Sáu, Quận 3, Thành phố Hồ Ch'),
('6630a256651bd', 'thienhan', 'thienhan123', 'thienhan123@gmail.com', 'true', '4 Đ. Tôn Đức Thắng, Bến Nghé, Quận 1, Thành phố Hồ Chí Minh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrder`),
  ADD KEY `idUser` (`idUser`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD KEY `idOrder` (`idOrder`),
  ADD KEY `idProduct` (`idProduct`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`idOrder`) REFERENCES `orders` (`idOrder`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`idProduct`) REFERENCES `sanpham` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
