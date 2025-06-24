-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: wisata
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `total_price` int DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,NULL,'A Fahmi Abdillah','buser1916@gmail.com','0881026923408',2,'ewallet',3,7000000,'pending','2025-06-21 08:12:00'),(2,NULL,'A Fahmi Abdillah','adielzbuser1916@gmail.com','0881026923408',7,'transfer',2,24500000,'pending','2025-06-21 08:17:24'),(3,'adielzbuser16@gmail.com','A Fahmi Abdillah','adielzbuser16@gmail.com','0881026923408',8,'transfer',4,28000000,'pending','2025-06-21 08:19:12'),(4,'pajar','Pajar','Pajar@gmail.com','088102692',5,'ewallet',2,17500000,'approved','2025-06-21 08:24:32'),(5,'user','Bonex','adielzbuser1916@gmail.com','0881026923408',9,'transfer',7,4517343,'rejected','2025-06-21 09:11:01'),(6,'user','user','adielzbuser1916@gmail.com','0881026923408',2,'ewallet',5,15700000,'pending','2025-06-21 09:13:27'),(7,'user','user','adielzbuser1916@gmail.com','0881026923408',2,'ewallet',5,15700000,'pending','2025-06-21 09:14:58'),(8,'user','A Fahmi Abdillah','adielzbuser1916@gmail.com','0881026923408',10,'transfer',6,3470000,'rejected','2025-06-21 09:17:08'),(9,'user','A Fahmi Abdillah','adielzbuser1916@gmail.com','0881026923408',10,'transfer',6,3470000,'approved','2025-06-21 09:18:27'),(10,'user','A Fahmi Abdillah','adielzbuser1916@gmail.com','0881026923408',10,'transfer',6,3470000,'rejected','2025-06-21 09:18:59');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Fahmi','adielzbuser1916@gmail.com','DEBUGING','2025-06-21 16:31:32'),(2,'Pajar','pajarpriana77@gmail.com','Test Kontak','2025-06-21 16:32:10');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `destinations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `image_path` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `destinations`
--

LOCK TABLES `destinations` WRITE;
/*!40000 ALTER TABLE `destinations` DISABLE KEYS */;
INSERT INTO `destinations` VALUES (2,'Gunung Rinjani Lombok','Gunung Rinjani adalah gunung yang berlokasi di Pulau Lombok, Nusa Tenggara Barat. Gunung yang merupakan gunung berapi kedua tertinggi di Indonesia dengan ketinggian 3.726 mdpl serta terletak pada lintang 8º25 LS dan 116º28 BT ini merupakan gunung favorit bagi pendaki Indonesia karena keindahan pemandangannya. Gunung ini merupakan bagian dari Taman Nasional Gunung Rinjani yang memiliki luas sekitar 41.330 ha dan diusulkan penambahannya sehingga menjadi 76.000 ha ke arah barat dan timur.','6854f8213de1f_lombok.jpg','Lombok, Nusa Tenggara Barat',3500000),(3,'Gunung Bromo','Gunung Bromo atau dalam bahasa Tengger dieja Brama, juga disebut Kaldera Tengger, adalah sebuah gunung berapi aktif di Jawa Timur, Indonesia. Gunung ini memiliki ketinggian 2.614 meter di atas permukaan laut dan berada dalam empat wilayah kabupaten, yakni Kabupaten Probolinggo, Kabupaten Pasuruan, Kabupaten Lumajang, dan Kabupaten Malang. Gunung Bromo terkenal sebagai objek wisata utama di Jawa Timur.','685533cf09ab4_bromo.jpg','Probolinggo, Jawa Timur',2500000),(4,'Bali Island','Bali, wilayah provinsi Bali juga terdiri dari pulau-pulau yang lebih kecil di sekitarnya, yaitu pulau Nusa Penida, pulau Nusa Lembongan, pulau Nusa Ceningan, Pulau Serangan, dan Pulau Menjangan. Secara geografis, Bali terletak di antara Pulau Jawa dan Pulau Lombok. Mayoritas penduduk Bali adalah pemeluk agama Hindu.[10] Di dunia, Bali terkenal sebagai tujuan pariwisata dengan keunikan berbagai hasil seni-budayanya dan juga mitosnya, khususnya bagi para wisatawan Jepang dan Australia. Bali juga dikenal dengan julukan Pulau Dewata dan Pulau Seribu Pura.','685536bc068bb_bali.jpg','Denpasar, Bali',3000000),(5,'Raja Ampat','Raja Ampat: Surga Petualangan Dunia di Ujung Papua\r\nKeanekaragaman hayati yang melimpah dan pemandangan alamnya menjadikannya sebagai salah satu destinasi wisata bahari terbaik di dunia.','685672b45d4eb_loginhome.jpg','Papua Barat',7850000),(6,'Yogyakarta','Kota Yogyakarta (bahasa Jawa: ꦔꦪꦺꦴꦒꦾꦏꦂꦠ, translit. Ngayogyakarta, pengucapan bahasa Jawa: [kuʈɔ ŋajogjɔˈkart̪ɔ], atau dikenal oleh masyarakat setempat dengan sebutan nama Yogya atau Jogja) adalah ibu kota sekaligus pusat pemerintahan dan perekonomian dari provinsi Daerah Istimewa Yogyakarta, Indonesia. Kota ini adalah kota yang mempertahankan konsep tradisional dan budaya Jawa.','685673516845a_jogja.jpg','Daerah Istimewa Yogyakarta',347000),(7,'Old Town Surabaya','Kota Surabaya (bahasa Jawa: Hanacaraka: ꦏꦸꦛꦯꦸꦫꦨꦪ, Pegon: كوڟا سورابايا, translit. Kuthå Suråbåyå; pengucapan bahasa Jawa: [kuʈɔ surɔˈbɔjɔ]; pelafalan dalam bahasa Indonesia: [suraˈbaja] ⓘ) adalah ibu kota Provinsi Jawa Timur yang menjadi pusat pemerintahan dan perekonomian sekaligus kota terbesar di provinsi tersebut. Surabaya juga merupakan sebuah kota yang terletak di Provinsi Jawa Timur, Indonesia. Surabaya merupakan kota terbesar kedua di Indonesia setelah Jakarta','6856741ea998f_Kota Surabaya.jpeg','Jawa Timur',501927);
/*!40000 ALTER TABLE `destinations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'fahmi','$2y$10$JJoEtBRLHzmdSxoQ9D.Jtum1s.EXFIJD9SzoLZHfWILVG9DEkVTDK','admin','2025-06-09 14:43:17'),(2,'user','$2y$10$/peUQA8obdVvRrHLADa4F.SCwI0Nd3hcabMvp5oyn73TT9NSax2L2','user','2025-06-19 17:52:33'),(3,'Adielz','$2y$10$NKzSuKQ5tCFE.r07cxylLexuaVYmo1j3/0yNqjJY5Zbz7ibxosSqC','user','2025-06-19 18:34:46'),(4,'pajar','$2y$10$kGEk7Fl4l.BvjCVcuNO8ier0XH.ZdgCG3kllAmLQngI.wehp71.Ry','user','2025-06-21 08:24:02'),(5,'admin','$2y$10$ySDPogKuoYI85CI.usk14O0zUwFEUH1ZXwMNTrP4wF6J3te4HmsFC','admin','2025-06-21 09:22:41');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'wisata'
--

--
-- Dumping routines for database 'wisata'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-21 16:43:31
