-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: zaxcellphone
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('zaxcellphone-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1793842914),('zaxcellphone-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1793842914;',1793842914);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_pesanan`
--

DROP TABLE IF EXISTS `detail_pesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_pesanan` (
  `id_detail` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pesanan` bigint unsigned NOT NULL,
  `id_produk` bigint unsigned NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `jumlah` int unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `detail_pesanan_id_pesanan_foreign` (`id_pesanan`),
  KEY `detail_pesanan_id_produk_foreign` (`id_produk`),
  CONSTRAINT `detail_pesanan_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE,
  CONSTRAINT `detail_pesanan_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_pesanan`
--

LOCK TABLES `detail_pesanan` WRITE;
/*!40000 ALTER TABLE `detail_pesanan` DISABLE KEYS */;
INSERT INTO `detail_pesanan` VALUES (1,1,44,1600000.00,1,'2026-11-04 22:18:22','2026-11-04 22:18:22'),(2,2,43,1300000.00,1,'2026-11-04 22:24:17','2026-11-04 22:24:17');
/*!40000 ALTER TABLE `detail_pesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_04_092659_create_produk_table',1),(5,'2026_11_04_092702_create_pembeli_table',1),(6,'2026_11_04_092704_create_pesanan_table',1),(7,'2026_11_04_092706_create_detail_pesanan_table',1),(8,'2026_11_04_092708_create_pembayaran_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id_pembayaran` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pesanan` bigint unsigned NOT NULL,
  `order_id_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `waktu_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembayaran`),
  UNIQUE KEY `pembayaran_order_id_gateway_unique` (`order_id_gateway`),
  KEY `pembayaran_id_pesanan_foreign` (`id_pesanan`),
  CONSTRAINT `pembayaran_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran`
--

LOCK TABLES `pembayaran` WRITE;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
INSERT INTO `pembayaran` VALUES (1,1,'ZAX-1-AB8BQQ','simulasi',1600000.00,'success','2026-11-05 05:18:39','2026-11-04 22:18:23','2026-11-04 22:18:39'),(2,2,'ZAX-2-P6GFDU','simulasi',1300000.00,'success','2026-11-05 05:24:25','2026-11-04 22:24:17','2026-11-04 22:24:25');
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembeli`
--

DROP TABLE IF EXISTS `pembeli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembeli` (
  `id_pembeli` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pembeli`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembeli`
--

LOCK TABLES `pembeli` WRITE;
/*!40000 ALTER TABLE `pembeli` DISABLE KEYS */;
INSERT INTO `pembeli` VALUES (1,'Ms. Zaria Towne PhD','087168237581','122 Walsh Lodge Apt. 338\nPort Ashlymouth, ME 59585-8866','2026-11-04 17:40:46','2026-11-04 17:40:46'),(2,'Tremaine Ratke','081869149614','22414 Hansen Valley\nEast Jacyntheberg, NH 37762-5707','2026-11-04 17:40:46','2026-11-04 17:40:46'),(3,'Kaci Metz','089019627468','6091 Wilkinson Cove\nThoratown, WA 98955','2026-11-04 17:40:46','2026-11-04 17:40:46'),(4,'Prof. Quentin Lesch DVM','081152442518','21573 Caitlyn Ramp\nWest Brandichester, MA 10083-8311','2026-11-04 17:40:46','2026-11-04 17:40:46'),(5,'Margaret Konopelski','089542732221','10477 Josiah Flat Suite 765\nPort Gus, OK 76902-9834','2026-11-04 17:40:46','2026-11-04 17:40:46'),(6,'ass','0989','ash','2026-11-04 22:18:22','2026-11-04 22:18:22'),(7,'duta','00999999','mana aja','2026-11-04 22:24:17','2026-11-04 22:24:17');
/*!40000 ALTER TABLE `pembeli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesanan`
--

DROP TABLE IF EXISTS `pesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesanan` (
  `id_pesanan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pembeli` bigint unsigned NOT NULL,
  `id_admin` bigint unsigned DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `status_pesanan` enum('Menunggu Pembayaran','Dibayar','Diproses','Dikirim','Selesai','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Pembayaran',
  `batas_bayar` datetime NOT NULL,
  `nomor_resi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_pesanan`),
  KEY `pesanan_id_pembeli_foreign` (`id_pembeli`),
  KEY `pesanan_id_admin_foreign` (`id_admin`),
  CONSTRAINT `pesanan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pesanan_id_pembeli_foreign` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`id_pembeli`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesanan`
--

LOCK TABLES `pesanan` WRITE;
/*!40000 ALTER TABLE `pesanan` DISABLE KEYS */;
INSERT INTO `pesanan` VALUES (1,6,NULL,1600000.00,'Dibayar','2026-11-05 05:48:22',NULL,'2026-11-04 22:18:22','2026-11-04 22:18:39'),(2,7,NULL,1300000.00,'Dibayar','2026-11-05 05:54:17',NULL,'2026-11-04 22:24:17','2026-11-04 22:24:25');
/*!40000 ALTER TABLE `pesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produk` (
  `id_produk` bigint unsigned NOT NULL AUTO_INCREMENT,
  `merek` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesifikasi` text COLLATE utf8mb4_unicode_ci,
  `warna` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelengkapan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `stok` int unsigned NOT NULL DEFAULT '1',
  `status` enum('Tersedia','Ditahan','Terjual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Tersedia',
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produk`
--

LOCK TABLES `produk` WRITE;
/*!40000 ALTER TABLE `produk` DISABLE KEYS */;
INSERT INTO `produk` VALUES (10,'iPhone','12 Pro','64GB/4GB RAM','Hijau','Mulus 95%','Unit saja',6800000.00,1,'Tersedia',NULL,'2026-11-04 17:40:46','2026-11-04 17:40:46'),(11,'Realme','10','128GB/4GB RAM','Hitam','Mulus 99%','Unit saja',2900000.00,1,'Tersedia',NULL,'2026-11-04 17:40:46','2026-11-04 17:40:46'),(15,'Realme','10','256GB/8GB RAM','Biru','Normal','Unit + charger',6800000.00,1,'Tersedia',NULL,'2026-11-04 17:40:46','2026-11-04 17:40:46'),(19,'Xiaomi','Poco X5','128GB/4GB RAM','Gold','Ada baret halus','Fullset (dus + charger)',4900000.00,1,'Tersedia',NULL,'2026-11-04 17:40:46','2026-11-04 17:40:46'),(20,'Vivo','V27','128GB/6GB RAM','Putih','Normal','Fullset (dus + charger)',7300000.00,1,'Tersedia',NULL,'2026-11-04 17:40:46','2026-11-04 17:40:46'),(25,'INFINIX','HOT 40 PRO','8GB/256GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1900000.00,1,'Tersedia','produk-massal/CbqMycfnd58P6RD3lIhp1frvlzlViifOuVTVrGe7.png','2026-11-04 17:48:37','2026-11-04 18:13:59'),(26,'INFINIX','HOT 60 PRO','8GB/256GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',2400000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(27,'INFINIX','HOT 60I','8GB/256GB','navi','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1950000.00,1,'Tersedia','produk-massal/gNMiUaQjF7wHRNf0IBVLZw6Kdl3Qafb1wkDBpfYd.png','2026-11-04 17:48:37','2026-11-04 18:36:29'),(28,'INFINIX','SMART 10','4GB/128GB','pink','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1400000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(29,'INFINIX','SMART 10','4GB/128GB','abu','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1400000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(30,'INFINIX','SMART 20','4GB/64GB','silver','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1400000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(31,'INFINIX','SMART 20','4GB/64GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1400000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(32,'INFINIX','SMART 9','4GB/64GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1200000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(33,'INFINIX','SMART 9','4GB/128GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1200000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(34,'ITEL','A100CS','3GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1150000.00,1,'Tersedia','produk-massal/feP2um29SEQfQqBPW1CUZJ84jM4fDhnpgHfq9qnY.png','2026-11-04 17:48:37','2026-11-04 18:36:29'),(35,'ITEL','A100C','3GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1150000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(36,'ITEL','A100C','4GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1250000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(37,'ITEL','A100C','4GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1250000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(38,'ITEL','A50','4GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1250000.00,1,'Tersedia','produk-massal/yaMfnEcAMepoA70vAhdfDHXMLwzSSrKsAsNYUISR.png','2026-11-04 17:48:37','2026-11-04 18:36:29'),(39,'ITEL','A60S','4GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',850000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(40,'ITEL','CITY100','8GB/128GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1500000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(41,'OPPO','A16','3GB/32GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',850000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(42,'OPPO','A16E','3GB/32GB','putih','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',700000.00,1,'Tersedia',NULL,'2026-11-04 17:48:37','2026-11-04 17:48:37'),(43,'OPPO','A3X','4GB/64GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1300000.00,1,'Terjual','produk-massal/m9XW2L9MkxWOO9rDIZsHSHYhTQqnWcMpqqhbKSkC.png','2026-11-04 17:48:37','2026-11-04 22:24:25'),(44,'OPPO','A3X','6GB/128GB','hitam','second','Semua unit batangan / HP only, tanpa cas dan tanpa dus.',1600000.00,1,'Terjual',NULL,'2026-11-04 17:48:37','2026-11-04 22:18:39');
/*!40000 ALTER TABLE `produk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('LFEdPxr55f2wv0Xx2j4CtPkrk2Ia7NieQOhfhOpl',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJKTEczSDd0c2lLVEZDRlNHVTdQaGlsTDdMR3RtZDJrdml3VFZiTVpYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxXC9wZXNhbmFuXC8yXC9rb25maXJtYXNpIiwicm91dGUiOiJwZXNhbmFuLmtvbmZpcm1hc2kifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1793856265),('nsPWCDLsdtFk73uiDWN0xwXwSS9Ikd7QXRoZUtq9',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJocVRzZFhxSFdNcGRkVVZ3VlkzbXJRSURkZTRLeVR4T3BsWVNXNWNBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC8/aGFyZ2FfbWF4PSZoYXJnYV9taW49Jm1lcmVrPVhpYW9taSZxPSIsInJvdXRlIjoia2F0YWxvZy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1793856034),('SLhcN4Iu2LLcOKwqRjLRs9hObrBIHTuP7hQlLy5K',NULL,'127.0.0.1','curl/8.21.0','eyJfdG9rZW4iOiJXZ1JuUklDSm5mMW5icEw5d3VSTEdvYW9qSHgwU2NqV045MUN3Q09TIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxIiwicm91dGUiOiJrYXRhbG9nLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1793855086);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Zaxcellphone','admin@zaxcellphone.test','2026-11-04 17:40:45','$2y$12$H/FI3.KBTcZszqzuyWtQa.wL222WSuZPSlpJbspLx8VHrIGxcpRjy','iE09KTJE6dgpc5R4Xns7mQCqmyIti3jLFHvFSbBsBOfkahlnh6ITmrtg4ugl','2026-11-04 17:40:46','2026-11-04 17:40:46');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'zaxcellphone'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-05 12:37:50
