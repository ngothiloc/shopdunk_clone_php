-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th5 27, 2025 lúc 02:46 AM
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
-- Cơ sở dữ liệu: `web_cuoiki`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(3, 'iphone', 'danh mục bán các điện thoại iphone', 'active', '2025-04-23 15:58:00'),
(4, 'ipad', 'danh mục bán các sản phẩm ipad', 'active', '2025-04-23 15:58:16'),
(5, 'Watch', 'danh mục bán watch', 'active', '2025-04-23 15:59:13'),
(6, 'Macbook', 'danh mục bán macbook', 'active', '2025-04-23 15:59:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `gender`, `birthdate`, `address`, `status`, `created_at`, `username`, `password`) VALUES
(1, 'Ngô Tiến Lộc', 'sendongthap@gmail.com', '0123012', 'male', '2004-10-12', 'Gia Lâm - Hà Nội', 'active', '2025-04-23 18:45:01', 'user1', '123123'),
(2, 'Ngô Tiến Lộc', 'dasd1@gmail.com', '123123', 'male', '0000-00-00', 'Ngô Tiến Lộc', 'active', '2025-04-23 18:45:42', 'user2', '123456'),
(3, '123', '123@gmail.com', '123', 'male', '2025-04-16', '123', 'active', '2025-04-25 07:24:11', '123', '123'),
(4, 'Macbook', 'loc@gmail.com', NULL, NULL, NULL, NULL, 'active', '2025-04-25 07:28:27', 'loc123', '123123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Apple ra mắt iPhone 15 với cổng USB-C', 'Sau nhiều năm sử dụng cổng Lightning độc quyền, Apple cuối cùng đã ra mắt dòng iPhone 15 với cổng kết nối USB-C nhằm tuân thủ quy định mới của Liên minh châu Âu. Việc chuyển đổi này không chỉ giúp người dùng dễ dàng chia sẻ sạc với các thiết bị khác mà còn tăng tốc độ truyền dữ liệu và sạc nhanh hơn. Ngoài ra, iPhone 15 còn được trang bị chip A17 Bionic mạnh mẽ, camera nâng cấp hỗ trợ quay phim 4K và tính năng Dynamic Island được cải thiện rõ rệt.', '../uploads/news/68095a8a598ff.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:24:26'),
(4, 'iPhone 16 có mấy màu? ', 'Apple luôn biết cách làm hài lòng người dùng bằng những thiết kế tinh tế và bảng màu thời thượng. iPhone 16 series tiếp tục gây ấn tượng với những lựa chọn màu sắc đa dạng, phù hợp với mọi cá tính. Apple luôn biết cách làm hài lòng người dùng bằng những thiết kế tinh tế và bảng màu thời thượng. iPhone 16 series tiếp tục gây ấn tượng với những lựa chọn màu sắc đa dạng, phù hợp với mọi cá tính. ', '../uploads/news/68095ab3e9325.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:25:07'),
(5, 'So sánh iPhone 16 Pro Max và iPhone 15 Pro Max', 'Tuy về ngoại hình, iPhone 16 Pro Max mới không có quá nhiều thay đổi đáng kể nào so với iPhone 15 Pro Max. Tuy nhiên, những thay đổi trên iPhone 16 Pro Max đủ để khiến đây trở thành phiên bản iPhone mạnh mẽ nhất mà Apple từng sở hữu. Tuy về ngoại hình, iPhone 16 Pro Max mới không có quá nhiều thay đổi đáng kể nào so với iPhone 15 Pro Max. Tuy nhiên, những thay đổi trên iPhone 16 Pro Max đủ để khiến đây trở thành phiên bản iPhone mạnh mẽ nhất mà Apple từng sở hữu. ', '../uploads/news/68095b0b7bda7.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:26:35'),
(6, 'So sánh iPhone 16 Pro Max và iPhone 15 Pro Max', 'Tuy về ngoại hình, iPhone 16 Pro Max mới không có quá nhiều thay đổi đáng kể nào so với iPhone 15 Pro Max. Tuy nhiên, những thay đổi trên iPhone 16 Pro Max đủ để khiến đây trở thành phiên bản iPhone mạnh mẽ nhất mà Apple từng sở hữu. Tuy về ngoại hình, iPhone 16 Pro Max mới không có quá nhiều thay đổi đáng kể nào so với iPhone 15 Pro Max. Tuy nhiên, những thay đổi trên iPhone 16 Pro Max đủ để khiến đây trở thành phiên bản iPhone mạnh mẽ nhất mà Apple từng sở hữu. ', '../uploads/news/68095b1db3127.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:26:53'),
(7, 'MacBook Air M2 vs iPad Pro M2', 'Giữa MacBook Air M2 vs iPad Pro M2, nhiều người ngay lập tức chọn mua iPad Pro M2 vì nghĩ chiếc iPad này thay thế được laptop. Họ cho rằng mua iPad Pro M2 kèm bút và bàn phím sẽ có lợi hơn vì ba sản phẩm cộng lại mới có mức giá xấp xỉ MacBook Air M2. Giữa MacBook Air M2 vs iPad Pro M2, nhiều người ngay lập tức chọn mua iPad Pro M2 vì nghĩ chiếc iPad này thay thế được laptop. Họ cho rằng mua iPad Pro M2 kèm bút và bàn phím sẽ có lợi hơn vì ba sản phẩm cộng lại mới có mức giá xấp xỉ MacBook Air M2.', '../uploads/news/68095b31f118d.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:27:13'),
(8, 'A18 Pro: Chip iPhone 16 mạnh nhất 2024 có gì?', 'A18 Pro là chip được sử dụng trên iPhone 16 Pro và iPhone 16 Pro Max. Chip được cải tiến vượt trội về đồ họa, GPU, băng thông bộ nhớ đưa trải nghiệm chơi game, làm việc và giải trí hình ảnh đồ hoạt chất lượng cao lên một tầng cao mới. A18 Pro là chip được sử dụng trên iPhone 16 Pro và iPhone 16 Pro Max. Chip được cải tiến vượt trội về đồ họa, GPU, băng thông bộ nhớ đưa trải nghiệm chơi game, làm việc và giải trí hình ảnh đồ hoạt chất lượng cao lên một tầng cao mới. ', '../uploads/news/68095b4b877ed.jpeg', 'inactive', '2025-04-23 18:41:13', '2025-04-23 21:27:39'),
(9, 'Sạc iPhone 16 và iPhone 16 Pro Max', 'iPhone 16 nói chung và iPhone 16 Pro Max nói riêng đều được Apple cải thiện tốc độ sạc. Sạc iPhone 16 đều có tốc độ sạc nhanh hơn, thời gian sử dụng pin dài hơn. Vì thế, iPhone 16 được xem như phiên bản di động có sạc và thời lượng pin tốt nhất của Apple từ trước đến giờ. iPhone 16 nói chung và iPhone 16 Pro Max nói riêng đều được Apple cải thiện tốc độ sạc. Sạc iPhone 16 đều có tốc độ sạc nhanh hơn, thời gian sử dụng pin dài hơn. Vì thế, iPhone 16 được xem như phiên bản di động có sạc và thời lượng pin tốt nhất của Apple từ trước đến giờ. ', '../uploads/news/68095b606ede9.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:28:00'),
(10, 'Top 5 ứng dụng làm việc hiệu quả trên iPad', 'Bạn có đang biết cách tận dụng tối đa iPad của mình để làm việc hiệu quả hơn? Với sự hỗ trợ của những ứng dụng thông minh, việc quản lý công việc, tập trung và ra quyết định chưa bao giờ dễ dàng đến thế. Hãy cùng ShopDunk khám phá ngay những ứng dụng làm việc hiệu quả, tối ưu năng suất trên iPad giúp bạn chinh phục thành công!', '../uploads/news/68095b794cf53.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:28:25'),
(11, 'Dùng iPad như thế nào để nâng cao hiệu quả học tập?', 'Có trong tay chiếc iPad xịn xò mà chưa biết sử dụng thế nào để tăng hiệu quả học tập? ShopDunk gợi ý cho bạn một vài bí kíp cực hữu ích, lưu lại ngay nhé! Có trong tay chiếc iPad xịn xò mà chưa biết sử dụng thế nào để tăng hiệu quả học tập? ShopDunk gợi ý cho bạn một vài bí kíp cực hữu ích, lưu lại ngay nhé!', '../uploads/news/68095b90c054b.jpeg', 'active', '2025-04-23 18:41:13', '2025-04-23 21:28:48'),
(12, '02 Cách giảm đến 128GB bộ nhớ trên iPhone', 'Sau một thời gian sử dụng, để tránh các sự cố không mong muốn như mất dữ liệu hay lộ thông tin cá nhân, người dùng nên “thanh lọc” máy để giải phóng dung lượng và cải thiện hiệu suất máy nhanh hơn, mượt hơn. Hãy cùng ShopDunk khám phá những bí kíp bảo mật iPhone dưới đây để bạn an tâm tận hưởng nhé. Sau một thời gian sử dụng, để tránh các sự cố không mong muốn như mất dữ liệu hay lộ thông tin cá nhân, người dùng nên “thanh lọc” máy để giải phóng dung lượng và cải thiện hiệu suất máy nhanh hơn, mượt hơn. Hãy cùng ShopDunk khám phá những bí kíp bảo mật iPhone dưới đây để bạn an tâm tận hưởng nhé.', '../uploads/news/68095ba4d5ae4.png', 'active', '2025-04-23 18:41:13', '2025-04-23 21:29:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `note` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','shipping','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `gender`, `fullname`, `phone`, `address`, `note`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 21, 'male', 'Ngô Tiến Lộc', '01230123', '123', '', 8990000.00, 'completed', '2025-04-24 14:04:43', '2025-04-25 07:08:09'),
(2, 1, 21, 'male', 'Ngô Tiến Lộc', '01230123', '123', '', 8990000.00, 'completed', '2025-04-24 14:06:22', '2025-04-25 07:08:36'),
(3, 1, 31, 'male', 'Ngô Tiến Lộc', '0123012', 'Gia Lâm - Hà Nội', '', 14990000.00, 'cancelled', '2025-04-25 06:54:41', '2025-04-25 06:58:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `quantity`, `description`, `image`, `status`, `created_at`) VALUES
(2, 'Macbook air m2', 6, 20000000.00, 12, 'sản phẩm macbook air m2', '../uploads/products/68094b7562410.png', 'active', '2025-04-23 16:12:55'),
(3, 'Macbook pro 2021 (14inch)', 6, 25000000.00, 10, 'Sản phẩm macbook pro 2021. Màn hình 14 inch với chip prom1', '../uploads/products/68094c2f5a05a.jpeg', 'active', '2025-04-23 16:58:56'),
(14, 'iPhone 14', 3, 19990000.00, 10, 'iPhone 14 128GB', '../uploads/products/680958094fdd6.webp', 'active', '2025-04-23 17:04:09'),
(15, 'iPhone 14 Pro', 3, 24990000.00, 10, 'iPhone 14 Pro 128GB', '../uploads/products/680958006815e.webp', 'active', '2025-04-23 17:04:09'),
(16, 'iPhone 13', 3, 17990000.00, 15, 'iPhone 13 128GB', '../uploads/products/6809581590ada.jpeg', 'active', '2025-04-23 17:04:09'),
(17, 'iPhone 12', 3, 14990000.00, 20, 'iPhone 12 64GB', '../uploads/products/6809581d34771.png', 'active', '2025-04-23 17:04:09'),
(18, 'iPhone 11', 3, 10990000.00, 30, 'iPhone 11 64GB', '../uploads/products/6809582449ef2.png', 'active', '2025-04-23 17:04:09'),
(19, 'iPhone SE', 3, 8990000.00, 12, 'iPhone SE 64GB', '../uploads/products/6809582d34692.webp', 'active', '2025-04-23 17:04:09'),
(20, 'iPhone XR', 3, 9990000.00, 8, 'iPhone XR 64GB', '../uploads/products/6809583636d0a.png', 'active', '2025-04-23 17:04:09'),
(21, 'iPhone X', 3, 8990000.00, 8, 'iPhone X 64GB', '../uploads/products/6809583d9700e.jpeg', 'active', '2025-04-23 17:04:09'),
(25, 'iPad Pro 12.9', 4, 29990000.00, 8, 'iPad Pro 12.9 inch M2', '../uploads/products/680958750622a.jpeg', 'active', '2025-04-23 17:04:09'),
(26, 'iPad Air 5', 4, 16990000.00, 15, 'iPad Air 5 M1 10.9 inch', '../uploads/products/6809588366f2a.webp', 'active', '2025-04-23 17:04:09'),
(27, 'iPad Gen 10', 4, 10990000.00, 20, 'iPad thế hệ thứ 10', '../uploads/products/6809588c8310d.jpeg', 'active', '2025-04-23 17:04:09'),
(28, 'iPad Gen 9', 4, 7990000.00, 25, 'iPad thế hệ thứ 9', '../uploads/products/6809589534023.webp', 'active', '2025-04-23 17:04:09'),
(29, 'iPad Mini 6', 4, 13990000.00, 18, 'iPad Mini 6 8.3 inch', '../uploads/products/6809589f05da9.webp', 'active', '2025-04-23 17:04:09'),
(31, 'iPad Air 4', 4, 14990000.00, 12, 'iPad Air 4 10.9 inch', '../uploads/products/680958b40f071.webp', 'active', '2025-04-23 17:04:09'),
(32, 'iPad Mini 5', 4, 9990000.00, 14, 'iPad Mini 5 7.9 inch', '../uploads/products/680958da60262.jpeg', 'active', '2025-04-23 17:04:09'),
(33, 'iPad Gen 8', 4, 6990000.00, 15, 'iPad thế hệ thứ 8', '../uploads/products/680958fc9efdd.jpeg', 'active', '2025-04-23 17:04:09'),
(34, 'Apple Watch Series 8', 5, 10990000.00, 12, 'Apple Watch S8 GPS 41mm', '../uploads/products/680959088042d.png', 'active', '2025-04-23 17:04:09'),
(35, 'Apple Watch Ultra', 5, 19990000.00, 8, 'Apple Watch Ultra 49mm', '../uploads/products/6809591361db3.png', 'active', '2025-04-23 17:04:09'),
(36, 'Apple Watch SE 2022', 5, 7490000.00, 15, 'Apple Watch SE 2022 GPS 40mm', '../uploads/products/6809591c9f917.webp', 'active', '2025-04-23 17:04:09'),
(37, 'Apple Watch Series 7', 5, 9990000.00, 10, 'Apple Watch S7 45mm', '../uploads/products/68095926dbd25.webp', 'active', '2025-04-23 17:04:09'),
(38, 'Apple Watch Series 6', 5, 8990000.00, 8, 'Apple Watch S6 GPS', '../uploads/products/6809593121788.webp', 'active', '2025-04-23 17:04:09'),
(39, 'Apple Watch Series 5', 5, 7990000.00, 10, 'Apple Watch S5 GPS', '../uploads/products/6809593f88425.webp', 'active', '2025-04-23 17:04:09'),
(40, 'Apple Watch Series 4', 5, 6990000.00, 11, 'Apple Watch S4 GPS', '../uploads/products/68095957a7456.png', 'active', '2025-04-23 17:04:09'),
(41, 'Apple Watch SE 1st Gen', 5, 6490000.00, 13, 'Apple Watch SE Gen 1', '../uploads/products/680959776d117.webp', 'active', '2025-04-23 17:04:09'),
(42, 'Apple Watch Nike', 5, 8490000.00, 9, 'Apple Watch Nike Edition', '../uploads/products/6809598a59815.webp', 'active', '2025-04-23 17:04:09'),
(44, 'MacBook Air M1 2020', 6, 24990000.00, 10, 'MacBook Air sử dụng chip M1 với hiệu năng mạnh mẽ và tiết kiệm pin.', '../uploads/products/680959a1e5845.webp', 'active', '2025-04-23 17:05:28'),
(45, 'MacBook Pro M1 2021', 6, 32990000.00, 8, 'MacBook Pro với màn hình Retina và hiệu năng vượt trội.', '../uploads/products/680959b5befb3.webp', 'inactive', '2025-04-23 17:05:28'),
(46, 'MacBook Pro M2 2022', 6, 37990000.00, 6, 'MacBook Pro sử dụng chip M2 mới nhất từ Apple.', '../uploads/products/680959c5af0d4.webp', 'active', '2025-04-23 17:05:28'),
(47, 'MacBook Air M2 2022', 6, 27990000.00, 12, 'Thiết kế mới mỏng nhẹ, hiệu năng cao với chip M2.', '../uploads/products/680959ce9f13c.png', 'active', '2025-04-23 17:05:28'),
(48, 'MacBook Pro 16-inch M1 Pro', 6, 54990000.00, 4, 'Màn hình lớn, chip M1 Pro dành cho dân chuyên nghiệp.', '../uploads/products/680959d91e698.png', 'active', '2025-04-23 17:05:28'),
(49, 'MacBook Pro 14-inch M1 Max', 6, 62990000.00, 3, 'Hiệu năng tối đa với M1 Max, lý tưởng cho đồ họa.', '../uploads/products/680959e7e3b1e.jpeg', 'active', '2025-04-23 17:05:28'),
(53, 'MacBook Pro Touch Bar', 6, 25990000.00, 6, 'Thanh Touch Bar tiện lợi, thiết kế cao cấp.', '../uploads/products/68094b5b4bec6.png', 'active', '2025-04-23 17:05:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
