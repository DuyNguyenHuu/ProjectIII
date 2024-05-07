-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 07, 2024 lúc 02:45 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlydoanhnghiep`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `ID` varchar(11) NOT NULL,
  `ACCOUNT` text NOT NULL,
  `PASSWORD` text NOT NULL,
  `NAME` text DEFAULT NULL,
  `ADDRESS` text DEFAULT NULL,
  `CONTACT` text DEFAULT NULL,
  `ROLE` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`ID`, `ACCOUNT`, `PASSWORD`, `NAME`, `ADDRESS`, `CONTACT`, `ROLE`) VALUES
('CHUNGNH', 'chung@gmail.com', 'Duyyl220302', 'Nguyễn Hữu Chung', 'Yên Lạc, Vĩnh Phúc', '0826321476', b'0'),
('DOANNH', 'doan@gmail.com', 'Duyyl220302', 'Nguyễn Hữu Đoàn', 'Vĩnh Phúc', '0977163046', b'0'),
('DUYNH', 'duy@gmail.com', 'Duyyl220302', 'Nguyễn Hữu Duy', 'Yên Đồng, Yên Lạc, Vĩnh Phúc', '0985963473', b'1'),
('THANGNH', 'thang@gmail.com', 'Duyyl220302', 'Nguyễn Hữu Thắng', 'Yên Đồng, Yên Lạc', '0987531222', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `TENKH` text NOT NULL,
  `DIACHI` text NOT NULL,
  `SODIENTHOAI` text NOT NULL,
  `MASP` varchar(11) NOT NULL,
  `NGAY` date NOT NULL,
  `NGUOIQL` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`ID`, `TENKH`, `DIACHI`, `SODIENTHOAI`, `MASP`, `NGAY`, `NGUOIQL`) VALUES
(46, 'Nguyễn Thị Nhàn', 'Vinh Phuc', '0985963473', 'SH160i', '2024-03-22', 'thang@gmail.com'),
(47, 'Nguyễn Thị Nhàn', 'Vinh Phuc', '0985963473', 'SH350i', '2024-03-08', 'thang@gmail.com'),
(48, 'Nguyễn Thị Nhàn', 'Vinh Phuc', '0985963473', 'Vario 160', '2024-03-20', 'thang@gmail.com'),
(49, 'Nguyễn Hữu Việt', 'Hai Phong', '0985963473', 'SH160i', '2022-03-21', 'thang@gmail.com'),
(50, 'Nguyễn Hữu Việt', 'Hai Phong', '0985963473', 'SH350i', '2024-03-08', 'thang@gmail.com'),
(51, 'Nguyễn Thị Thái An', 'Yên Lạc, Vĩnh Phúc', '0985963473', 'SH160i', '2022-03-11', 'thang@gmail.com'),
(52, 'Nguyễn Thị Thái An', 'Yên Lạc, Vĩnh Phúc', '0985963473', 'SH350i', '2024-03-11', 'thang@gmail.com'),
(53, 'Nguyễn Thị Thông', 'Vĩnh Phúc', '0395102973', 'SH125', '2024-03-11', 'thang@gmail.com'),
(54, 'Nguyễn Hữu Đăng', 'Hà Nội', '0395102973', 'CLUB125', '2022-03-13', 'thang@gmail.com'),
(55, 'Nguyễn Hữu Đăng', 'Hà Nội', '0395102973', 'LEAD125', '2024-03-13', 'thang@gmail.com'),
(56, 'Nguyễn Thị Trinh', 'Ngũ Kiên', '0985963473', 'LEAD125', '2024-03-25', 'thang@gmail.com'),
(57, 'Nguyễn Thị Trinh', 'Ngũ Kiên', '0985963473', 'SH125', '2024-03-13', 'thang@gmail.com'),
(58, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'BLADE2023', '2024-03-26', 'chung@gmail.com'),
(59, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'CLUB125', '2024-03-26', 'chung@gmail.com'),
(60, 'Vũ Thị Bích Diệp', 'Bắc Ninh', '0856987263', 'LEAD125', '2022-01-15', 'chung@gmail.com'),
(61, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'SH160i', '2024-03-26', 'chung@gmail.com'),
(62, 'Nguyễn Minh Nghĩa', 'Hòa Bình', '0856987263', 'BLADE2023', '2022-11-10', 'chung@gmail.com'),
(63, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'CLUB125', '2024-03-26', 'chung@gmail.com'),
(64, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'LEAD125', '2024-03-26', 'chung@gmail.com'),
(65, 'Phạm Xuân Bách', 'Hà Nội', '0856987263', 'SH160i', '2021-05-02', 'chung@gmail.com'),
(66, 'Lê Thế Dũng', 'Hải Dương', '0789685354', 'LEAD125', '2020-07-30', 'chung@gmail.com'),
(67, 'Mai Tiến Thành', 'Hải Dương', '0789685354', 'SH350i', '2024-03-26', 'chung@gmail.com'),
(68, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'CBR150R', '2022-11-26', 'chung@gmail.com'),
(69, 'Nguyễn Đức Huy', 'Hải Phòng', '0875695423', 'LEAD125', '2022-12-26', 'chung@gmail.com'),
(70, 'Phan Duy', 'Hải Phòng', '0875695423', 'SH160i', '2022-05-29', 'chung@gmail.com'),
(71, 'Bùi Anh Tuấn', 'Vĩnh Phúc', '0875695423', 'CBR150R', '0000-00-00', 'chung@gmail.com'),
(72, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'LEAD125', '2024-03-26', 'chung@gmail.com'),
(73, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'SH160i', '2024-03-26', 'chung@gmail.com'),
(74, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'CBR150R', '2024-03-26', 'chung@gmail.com'),
(75, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'LEAD125', '2024-03-26', 'chung@gmail.com'),
(76, 'Lại Quốc Trung', 'Quảng Ninh', '0875695423', 'SH160i', '2024-03-26', 'chung@gmail.com'),
(77, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'ALPHA110', '2024-03-26', 'doan@gmail.com'),
(78, 'Cao Quốc Dũng', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'BLADE2023', '2024-08-08', 'doan@gmail.com'),
(79, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'CBR150R', '2024-03-26', 'doan@gmail.com'),
(80, 'Trần Thái Linh', 'Hà Nội', '0852697456', 'CLUB125', '2022-09-30', 'doan@gmail.com'),
(81, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'LEAD125', '2024-03-26', 'doan@gmail.com'),
(82, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'SH125', '2024-03-26', 'doan@gmail.com'),
(83, 'Nguyễn Ánh Linh', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'SH160i', '2022-07-30', 'doan@gmail.com'),
(84, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'SH350i', '2024-03-26', 'doan@gmail.com'),
(85, 'Đậu Thị Như Khánh', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'Vario 160', '2022-06-06', 'doan@gmail.com'),
(86, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'WAVERSX', '2024-03-26', 'doan@gmail.com'),
(87, 'Nguyễn Văn Chiến', 'Minh Tân, Yên Lạc, Vĩnh Phúc ', '0852697456', 'X2024', '2024-03-26', 'doan@gmail.com'),
(88, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'ALPHA110', '2024-03-26', 'doan@gmail.com'),
(89, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'BLADE2023', '2024-03-26', 'doan@gmail.com'),
(90, 'Nguyễn Tiến Dũng', 'Cao Bằng', '0356748547', 'CBR150R', '2022-11-13', 'doan@gmail.com'),
(91, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'CLUB125', '2024-03-26', 'doan@gmail.com'),
(92, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'LEAD125', '2024-03-26', 'doan@gmail.com'),
(93, 'Nguyễn Quang Hải', 'Hà Nội', '0356748547', 'SH125', '2023-11-20', 'doan@gmail.com'),
(94, 'Lê Đức Anh', 'Bắc Giang', '0356748547', 'SH160i', '2023-04-30', 'doan@gmail.com'),
(95, 'Phùng Thanh Độ', 'Cao Bằng', '0356748547', 'SH350i', '2022-04-01', 'doan@gmail.com'),
(96, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'Vario 160', '2024-03-26', 'doan@gmail.com'),
(97, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'WAVERSX', '2024-03-26', 'doan@gmail.com'),
(98, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'X2024', '2024-03-26', 'doan@gmail.com'),
(99, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'ALPHA110', '2024-03-26', 'doan@gmail.com'),
(100, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'BLADE2023', '2024-03-26', 'doan@gmail.com'),
(101, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'CBR150R', '2024-03-26', 'doan@gmail.com'),
(102, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'CLUB125', '2024-03-26', 'doan@gmail.com'),
(103, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'LEAD125', '2024-03-26', 'doan@gmail.com'),
(104, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'SH125', '2024-03-26', 'doan@gmail.com'),
(105, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'SH160i', '2024-03-26', 'doan@gmail.com'),
(106, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'SH350i', '2024-03-26', 'doan@gmail.com'),
(107, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'Vario 160', '2024-03-26', 'doan@gmail.com'),
(108, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'WAVERSX', '2024-03-26', 'doan@gmail.com'),
(109, 'Bùi Thức Nam', 'Hà Nội', '0356748547', 'X2024', '2024-03-26', 'doan@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `MASP` varchar(11) NOT NULL,
  `TENSP` text NOT NULL,
  `GIASP` int(11) NOT NULL,
  `THONGTINSP` text DEFAULT NULL,
  `SOLUONG` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`MASP`, `TENSP`, `GIASP`, `THONGTINSP`, `SOLUONG`) VALUES
('ALPHA110', 'Wave Alpha 110', 18000000, '', 2),
('BLADE2023', 'Blade 2023', 19000000, '', 46),
('CBR150R', 'Honda CBR150R', 72300000, '', 23),
('CLUB125', 'Super Club 125', 86000000, '', 43),
('LEAD125', 'Honda Lead 125', 40000000, '', 17),
('SH125', 'Sh mode ', 57132000, '', 99),
('SH160i', 'Honda SH160i', 74000000, '', 5),
('SH350i', 'Honda SH350i', 150990000, '', 5),
('Vario 160', 'Vario 160', 51990000, '', 23),
('WAVERSX', 'Wave RSX', 22000000, '', 56),
('X2024', 'Winner X 2024', 46000000, '', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `MANV` varchar(11) NOT NULL,
  `TENNV` text NOT NULL,
  `DIACHI` text NOT NULL,
  `SODIENTHOAI` text NOT NULL,
  `EMAIL` text NOT NULL,
  `PASSWORD` text NOT NULL,
  `NGUOIQL` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`MANV`, `TENNV`, `DIACHI`, `SODIENTHOAI`, `EMAIL`, `PASSWORD`, `NGUOIQL`) VALUES
('ANHKT', 'Kim Tuấn Anh', 'Kim Ngọc, Yên Lạc, Vĩnh Phúc', '0986254965', 'anhkt@gmail.com', '1', 'doan@gmail.com'),
('ANHLT', 'Lê Tuấn ANh', 'Yên Phương, Yên Lạc, Vĩnh Phúc', '0785658853', 'anhlt@gmail.com', '1', 'doan@gmail.com'),
('ANHNT', 'Nguyễn Tuấn Anh', 'Đại Tự, Yên Lạc, Vĩnh Phúc', '0987563356', 'anhnt@gmail.com', '1', 'doan@gmail.com'),
('ANTT', 'Nguyễn Thị Thái An', 'Yên Lạc, Vĩnh Phúc', '0985963473', 'an@gmail.com', '1', 'thang@gmail.com'),
('BPX', 'Phạm Xuân Bách', 'Hà Nội', '0985963473', 'bach@gmail.com', '1', 'thang@gmail.com'),
('DUNGTT', 'Trần Thế Dũng', 'Nguyệt Đức, Yên Lạc, Vĩnh Phúc', '0456258963', 'dungtt@gmail.com', '1', 'chung@gmail.com'),
('DUONGND', 'Nguyễn Tùng Dương', 'Hải Dương', '0976456258', 'duongnd@gmail.com', '1', 'thang@gmail.com'),
('DUONGNH', 'Nguyễn Hữu Dương', 'Yên Lạc', '0985963473', 'duong@gmail.com', '1234', 'thang@gmail.com'),
('DUYNH', 'Nguyễn Hữu Duy', 'Yên Lạc, Vĩnh Phúc', '0985963473', 'duy@gmail.com', '1', 'thang@gmail.com'),
('HIEUNK', 'Nguyễn Khắc Hiếu', 'Yên Đồng, Yên Lạc, Vĩnh Phúc', '0563478523', 'hieunk@gmail.com', '1', 'chung@gmail.com'),
('HUYND', 'Nguyễn Đình Huy', 'Đại Tự, Yên Lạc, Vĩnh Phúc', '0856982245', 'huynd@gmail.com', '1', 'chung@gmail.com'),
('KHANHPD', 'Phạm Duy Khánh', 'Tam Hồng, Yên Lạc, Vĩnh Phúc', '0856942567', 'khanhpd@gmail.com', '1', 'chung@gmail.com'),
('KHANHPG', 'Phạm Gia Khánh', 'Tuyên Quang', '0986735125', 'khanh@gmail.com', '1', 'thang@gmail.com'),
('KIMTTM', 'Trần Thị Mã Kim', 'Nguyệt Đức, Yên Lạc, Vĩnh ', '0986523146', 'kimttm@gmail.com', '1', 'doan@gmail.com'),
('MAINTP', 'Nguyễn Thị Phương Mai', 'Hải Dương', '0355698745', 'maintp@gmail.com', '1', 'doan@gmail.com'),
('NAMTH', 'Trần Hải Nam', 'Tề Lỗ, Yên Lạc, Vĩnh Phúc', '0563147896', 'namth@gmail.com', '1', 'chung@gmail.com'),
('NAMTX', 'Trần Xuân Nam', 'Vĩnh Tường', '0985963473', 'nam@gmail.com', '1', 'thang@gmail.com'),
('QUYNH', 'Nguyễn Huy Quý', 'Bình Xuyên, Vĩnh Phúc', '0785698523', 'quynh@gmail.com', '1', 'doan@gmail.com'),
('TANND', 'Nguyễn Duy Tân', 'Bình Xuyên, Vĩnh Phúc', '0453256985', 'tannd@gmail.com', '1', 'chung@gmail.com'),
('THULTX', 'Lê Thị Xuân Thu', 'Đại Tự, Yên Lạc, Vĩnh Phúc', '0469258753', 'thultx@gmail.com', '1', 'chung@gmail.com'),
('TNT', 'Nguyễn Thị Tăng', 'Yên Đồng', '0985963473', 'tang@gmail.com', '1', 'thang@gmail.com'),
('TRANGDTT', 'Đậu Thị Thu Trang', 'Yên Lạc, Vĩnh Phúc', '0856325632', 'trangdtt@gmail.com', '1', 'doan@gmail.com'),
('TUYENNV', 'Nguyễn Văn Tuyển', 'Bình Xuyên, Vĩnh Phúc', '0458963593', 'tuyennv@gmail.com', '1', 'chung@gmail.com'),
('VIETNH', 'Nguyễn Hữu Việt', 'Hải Phòng', '0985963473', 'viet@gmail.com', '1', 'thang@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `MASP` (`MASP`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`MASP`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`MANV`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `MASP` FOREIGN KEY (`MASP`) REFERENCES `product` (`MASP`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
