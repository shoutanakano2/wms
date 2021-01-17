-- MySQL dump 10.13  Distrib 5.5.62, for Linux (x86_64)
--
-- Host: localhost    Database: wms
-- ------------------------------------------------------
-- Server version	5.5.62

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `customer_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phonenumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_faxnumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_postalcode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_customer_code_unique` (`customer_code`),
  KEY `customers_user_id_index` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (2,1,'sample','sample','0000000000','0000000000','sample@sample.com','0000000','samplecitysample','2020-09-04 17:35:05','2020-09-15 12:33:09','2020-09-15 12:33:09'),(3,2,'T2','T2','00000000','00000000','a@a.co.jp','7570004','あああああT2','2020-09-13 11:05:24','2020-09-13 11:46:11',NULL),(4,1,'nakano','nakano','1111111111','1111111111','nakano@nakano.com','0000000','nakano','2020-09-15 12:35:57','2020-09-15 12:35:57',NULL),(5,1,'TechAcademy','テックアカデミー','0120-12-3456','0120-98-7654','tech@academy.com','9999999','オンライン学習県プログラミング村PHP','2020-11-01 15:56:59','2020-11-01 16:20:14','2020-11-01 16:20:14'),(6,1,'giants','GIANTS','0312345678','0387654321','giants@gmail.com','1128575','東京都文京区後楽','2021-01-09 20:53:41','2021-01-09 20:53:41',NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `histories`
--

DROP TABLE IF EXISTS `histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `histories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stocks_id` int(10) unsigned NOT NULL,
  `inout` int(11) NOT NULL,
  `date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `change_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `histories_stocks_id_index` (`stocks_id`),
  KEY `histories_customer_id_index` (`customer_id`),
  CONSTRAINT `histories_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `histories_stocks_id_foreign` FOREIGN KEY (`stocks_id`) REFERENCES `stocks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `histories`
--

LOCK TABLES `histories` WRITE;
/*!40000 ALTER TABLE `histories` DISABLE KEYS */;
INSERT INTO `histories` VALUES (8,1,1,'2020-10-11',100,'2020-10-11 18:32:16','2020-10-11 21:36:00',4,'否'),(9,1,2,'2020-10-11',50,'2020-10-11 18:32:31','2020-10-11 21:36:00',4,'否'),(12,4,1,'2020-10-04',50,'2020-10-25 11:20:30','2020-10-25 11:20:30',4,'可'),(13,4,1,'2020-10-04',50,'2020-10-25 11:20:51','2020-10-25 11:20:51',4,'可'),(15,4,1,'2020-10-04',50,'2020-10-25 11:43:46','2020-10-25 11:43:46',4,'可'),(16,4,1,'2020-09-01',100,'2020-10-25 19:46:17','2020-10-25 19:46:17',4,'可'),(17,1,1,'2020-08-01',100,'2020-10-25 19:46:44','2020-10-25 19:46:44',4,'可'),(19,1,1,'2020-09-01',100,'2020-10-25 20:47:14','2020-10-25 20:47:14',4,'可'),(20,5,1,'2020-09-26',100,'2020-10-26 12:37:51','2020-10-26 12:37:51',4,'可'),(21,2,1,'2020-09-01',100,'2020-10-27 12:40:59','2020-10-27 12:40:59',4,'可'),(23,6,1,'2020-11-09',100,'2020-11-01 17:03:32','2020-11-01 17:03:32',4,'可'),(24,1,2,'2021-01-10',50,'2021-01-10 00:16:02','2021-01-10 00:16:02',6,'可'),(25,1,2,'2021-01-09',50,'2021-01-10 00:20:08','2021-01-10 00:20:08',6,'可'),(26,5,1,'2021-01-10',100,'2021-01-10 00:21:24','2021-01-10 00:21:24',6,'可'),(27,1,2,'2021-01-10',50,'2021-01-10 00:34:28','2021-01-10 00:34:28',4,'可'),(28,1,2,'2021-01-10',50,'2021-01-10 00:34:45','2021-01-10 00:34:45',6,'可');
/*!40000 ALTER TABLE `histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sell_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_item_code_unique` (`item_code`),
  KEY `items_user_id_index` (`user_id`),
  CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,1,'cake','cake PHP','2020-09-20 11:59:30','2020-09-20 11:59:30','200','100',NULL),(2,1,'Slim','スリム','2020-09-20 11:59:47','2020-09-20 11:59:47','1000','800',NULL),(3,1,'LARA','LARAVEL','2020-09-22 22:53:20','2020-09-22 22:53:20','50','20',NULL),(4,1,'FUEL','FUEL PHP','2020-09-22 23:14:33','2020-09-22 23:14:33','500','300',NULL),(5,1,'Rails','Ruby　on　Rails','2020-09-22 23:17:05','2020-11-01 15:31:06','1800','1000',NULL),(6,1,'Bootstrap','ブートストラップ','2020-11-01 15:20:14','2020-11-01 15:36:48','150','100','2020-11-01 15:36:48'),(7,1,'CSS','見た目','2020-11-01 17:15:33','2020-11-01 17:15:33','10','5',NULL);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2020_06_20_200747_create_warehouses_table',1),(4,'2020_06_21_205020_drop_foreign_key',1),(5,'2020_06_21_210419_create_items_table',1),(6,'2020_06_22_200836_create_stocks_table',1),(7,'2020_06_24_220059_create_histories_table',1),(8,'2020_06_24_230848_create_foreign_key_table',1),(9,'2020_06_24_233302_warehouses_foreign_key',1),(10,'2020_06_24_233432_items_foreign_key',1),(11,'2020_07_04_201913_histories_foreign_key',1),(12,'2019_02_25_111508_create_samples_table',2),(13,'2020_09_01_195210_create_customers_table',2),(14,'2020_09_02_170506_add_price_to_items_table',3),(18,'2020_09_02_172252_add_customer_id_to_histories_table',4),(19,'2020_09_02_195614_foreign_key_to_histories',5),(20,'2020_09_02_204124_foreign_key_to_customers',6),(21,'2020_09_14_210417_add_column_soft_deletes_items_table',7),(22,'2020_09_14_215613_add_column_soft_deletes_warehouses_table',8),(23,'2020_09_15_122432_add_column_soft_deletes_customers_table',9),(24,'2020_10_11_181447_add_chamge_status_to_histories_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `samples`
--

DROP TABLE IF EXISTS `samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `samples` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `samples`
--

LOCK TABLES `samples` WRITE;
/*!40000 ALTER TABLE `samples` DISABLE KEYS */;
/*!40000 ALTER TABLE `samples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `warehouse_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stocks_item_id_warehouse_id_unique` (`item_id`,`warehouse_id`),
  KEY `stocks_item_id_index` (`item_id`),
  KEY `stocks_warehouse_id_index` (`warehouse_id`),
  CONSTRAINT `stocks_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stocks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES (1,1,1,'2020-09-20 17:49:15','2020-09-20 17:49:15'),(2,2,1,'2020-09-20 17:49:25','2020-09-20 17:49:25'),(3,5,1,'2020-09-24 23:32:44','2020-09-24 23:32:44'),(4,3,1,'2020-09-26 21:24:36','2020-09-26 21:24:36'),(5,4,1,'2020-10-26 12:37:51','2020-10-26 12:37:51'),(6,5,4,'2020-11-01 17:03:32','2020-11-01 17:03:32');
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'nakano','nakano@nakano.com','$2y$10$bzlzdVA.zP/7BB6meFrpCerFDWX9Mpk5HUvZ6EWDnJkJTg8bNMPl2','2bRKt3Qfs6DCeaLg3q0myJCysZhEiFQXDFzO0XgCZttVYMDld6DY8fsfyjUl','2020-07-05 21:38:28','2020-07-05 21:38:28'),(2,'すだCo','sutaruhin@gmail.com','$2y$10$5YegU5Yjn65Go01c2vILHea8WPvnmaI71YbAXknlrX/oDLhawfgp.','nVZY4wHyXC4V4XvZ9NfhBYq09mVDbHEuvhZ9XxDKW3mTeGNDtNnO1GU6zksG','2020-07-19 11:01:36','2020-07-19 11:01:36');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouses`
--

DROP TABLE IF EXISTS `warehouses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `warehouse_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warehouses_warehouse_code_unique` (`warehouse_code`),
  KEY `warehouses_user_id_index` (`user_id`),
  CONSTRAINT `warehouses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouses`
--

LOCK TABLES `warehouses` WRITE;
/*!40000 ALTER TABLE `warehouses` DISABLE KEYS */;
INSERT INTO `warehouses` VALUES (1,1,'PHP','PHP','2020-07-05 21:38:40','2020-07-05 21:38:40',NULL),(2,2,'S1','S1','2020-07-19 11:02:05','2020-07-19 11:02:05',NULL),(3,2,'S2','S2','2020-07-19 11:02:12','2020-07-19 11:02:12',NULL),(4,1,'Ruby','Ruby','2020-08-15 22:26:10','2020-09-14 16:04:05',NULL),(6,1,'Python','パイソン','2020-08-17 16:47:12','2020-09-15 12:18:00','2020-09-15 12:18:00'),(7,1,'Java','ジャバ','2020-10-31 21:50:00','2020-10-31 21:51:03','2020-10-31 21:51:03'),(8,1,'Javascript','ジャバスクリプト2','2020-10-31 21:52:23','2020-11-01 14:20:53','2020-11-01 14:20:53'),(9,1,'C+','Cプラス','2020-11-01 14:54:22','2020-11-01 14:54:32','2020-11-01 14:54:32'),(10,1,'HTML','ハイパーテキストメイクアップラングリッジ','2020-11-01 15:03:48','2020-11-01 15:10:44','2020-11-01 15:10:44'),(11,1,'SWIFT','スイフト','2020-11-13 12:38:23','2020-11-13 12:38:30','2020-11-13 12:38:30');
/*!40000 ALTER TABLE `warehouses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-17 12:14:58
