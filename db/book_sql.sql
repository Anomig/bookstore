-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumpen data van tabel bookstore.categories: ~3 rows (ongeveer)
INSERT INTO `categories` (`id`, `name`) VALUES
	(1, 'Fictie'),
	(2, 'Non-Fictie'),
	(3, 'Koken');

-- Dumpen data van tabel bookstore.orders: ~0 rows (ongeveer)

-- Dumpen data van tabel bookstore.order_items: ~0 rows (ongeveer)

-- Dumpen data van tabel bookstore.products: ~5 rows (ongeveer)
INSERT INTO `products` (`id`, `title`, `author`, `description`, `price`, `image_url`, `type`, `category_id`) VALUES
	(1, 'De Avonturen van Tom Poes', 'Martijn de Vries', 'Een spannend avontuur over Tom Poes.', 16, 'images/tom-poes.jpg', 'fysiek boek', 1),
	(2, 'De Avonturen van Tom Poes', 'Martijn de Vries', 'Een spannend avontuur over Tom Poes.', 16, 'images/tom-poes.jpg', 'fysiek boek', 1),
	(3, 'De Digitale Revolutie', 'Sarah de Leeuw', 'Een ebook over de impact van technologie.', 10, 'images/digitale-revolutie.jpg', 'ebook', 2),
	(4, 'De Kracht van Geluid', 'Anna Janssen', 'Ontdek de wereld van audioboeken.', 20, 'images/kracht-van-geluid.jpg', 'audioboek', 3),
	(5, 'The raven', 'Edgar Allen Poe', 'short story', 20, 'raven.jpg', 'fysiek boek', 1);

-- Dumpen data van tabel bookstore.product_options: ~0 rows (ongeveer)

-- Dumpen data van tabel bookstore.users: ~2 rows (ongeveer)
INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`, `role`) VALUES
	(3, 'Ad', 'Min', '@mind.com', '$2y$10$UZPLWoqsNDcPhbTPWId1x.0DceFywUYaUCNpFCpV0L.yQkrC9qzwm', 'admin'),
	(4, 'Naomi', 'Goyvaerts', 'n@omi.com', '$2y$10$l9AUDa7pjThRqWq0srmDM.gz8iv7gdW4.gbErNPx43g7238.wCNQ.', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
