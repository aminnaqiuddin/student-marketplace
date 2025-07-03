-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: student_marketplace
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
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  KEY `cart_items_product_id_foreign` (`product_id`),
  CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Men\'s Fashion',NULL,NULL),(2,'Women\'s Fashion',NULL,NULL),(3,'Books & Stationery',NULL,NULL),(4,'Laptops & Accessories',NULL,NULL),(5,'Mobile Phones & Gadgets',NULL,NULL),(6,'Sports & Outdoors',NULL,NULL),(7,'Services',NULL,NULL),(8,'Video Games & Consoles',NULL,NULL),(9,'Audio Equipment',NULL,NULL),(10,'Photography',NULL,NULL),(11,'Food & Beverages',NULL,NULL),(12,'Event Tickets',NULL,NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_favorites`
--

DROP TABLE IF EXISTS `ch_favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ch_favorites` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `favorite_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_favorites`
--

LOCK TABLES `ch_favorites` WRITE;
/*!40000 ALTER TABLE `ch_favorites` DISABLE KEYS */;
/*!40000 ALTER TABLE `ch_favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ch_messages`
--

DROP TABLE IF EXISTS `ch_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ch_messages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint NOT NULL,
  `to_id` bigint NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ch_messages`
--

LOCK TABLES `ch_messages` WRITE;
/*!40000 ALTER TABLE `ch_messages` DISABLE KEYS */;
INSERT INTO `ch_messages` VALUES ('806caf13-c5a7-4be5-b650-5d672ba45cc7',4,5,'hello',NULL,1,'2025-06-22 10:11:24','2025-06-22 10:11:48'),('84202c1d-d743-4917-9978-806e61a8bce4',5,4,'hello',NULL,1,'2025-06-22 10:11:53','2025-06-22 10:11:54'),('9d1211f9-4228-443c-9e7e-e7d264c0df75',5,4,'','{\"new_name\":\"1a9e3f1e-4c56-447e-8334-547932e3780e.jpg\",\"old_name\":\"detective cat.jpg\"}',1,'2025-06-22 10:12:02','2025-06-22 10:12:07');
/*!40000 ALTER TABLE `ch_messages` ENABLE KEYS */;
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
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2025_05_12_064943_create_products_table',2),(6,'2025_05_13_201201_create_product_images_table',3),(7,'2016_01_01_000000_add_voyager_user_fields',4),(8,'2016_01_01_000000_create_data_types_table',4),(9,'2016_05_19_173453_create_menu_table',4),(10,'2016_10_21_190000_create_roles_table',4),(11,'2016_10_21_190000_create_settings_table',4),(12,'2016_11_30_135954_create_permission_table',4),(13,'2016_11_30_141208_create_permission_role_table',4),(14,'2016_12_26_201236_data_types__add__server_side',4),(15,'2017_01_13_000000_add_route_to_menu_items_table',4),(16,'2017_01_14_005015_create_translations_table',4),(17,'2017_01_15_000000_make_table_name_nullable_in_permissions_table',4),(18,'2017_03_06_000000_add_controller_to_data_types_table',4),(19,'2017_04_21_000000_add_order_to_data_rows_table',4),(20,'2017_07_05_210000_add_policyname_to_data_types_table',4),(21,'2017_08_05_000000_add_group_to_settings_table',4),(22,'2017_11_26_013050_add_user_role_relationship',4),(23,'2017_11_26_015000_create_user_roles_table',4),(24,'2018_03_11_000000_add_user_settings',4),(25,'2018_03_14_000000_add_details_to_data_types_table',4),(26,'2018_03_16_000000_make_settings_value_nullable',4),(27,'2025_05_27_202906_add_category_and_condition_to_',5),(28,'2025_05_27_202943_add_category_and_condition_to_produ',5),(29,'2025_05_27_203147_add_category_and_condition_to_o',5),(30,'2025_05_27_203200_add_category_and_condition_to_products_table',5),(31,'2025_05_28_024942_create_categories_table',6),(32,'2025_05_28_025136_add_category_id_to_products_table',7),(33,'2025_05_28_025649_add_condition_to_products_table',8),(34,'2025_05_28_142340_create_orders_table',8),(35,'2025_05_28_142355_create_order_items_table',8),(36,'2025_05_28_144155_create_orders_table',9),(37,'2025_05_29_050700_create_cart_items_table',9),(50,'2025_06_14_999999_add_active_status_to_users',10),(51,'2025_06_14_999999_add_avatar_to_users',10),(52,'2025_06_14_999999_add_dark_mode_to_users',10),(53,'2025_06_14_999999_add_messenger_color_to_users',10),(54,'2025_06_14_999999_create_chatify_favorites_table',10),(55,'2025_06_14_999999_create_chatify_messages_table',10),(56,'2025_06_21_123420_add_user_id_to_orders_table',11),(57,'2025_06_21_124251_p',11),(58,'2025_06_21_124307_populate_user_id_in_orders',11),(59,'2025_06_22_122207_create_reviews_table',12),(60,'2025_06_22_124138_add_status_to',13),(61,'2025_06_22_124210_add_status_to_products_table',13),(62,'2025_06_23_104654_add_status_and_stripe_columns_to_orders_table',14),(63,'2025_06_23_114502_add_stripe_fields_to_orders_table',15),(64,'2025_06_23_164433_add_rateable_columns_to_reviews_table',16),(65,'2025_06_23_165748_create_reviews_table',17),(66,'2025_06_23_171745_add_columns_to_reviews_table',18),(67,'2025_06_24_101526_create_notifications_table',19),(68,'2025_06_24_113406_create_product_reports_table',20),(69,'2025_06_24_140820_add_condition_rating_to_products_table',21),(70,'2025_06_25_020334_add_quantity_to_products_table',22),(71,'2025_06_25_053454_make_condition_nullable_in_products_table',23),(72,'2025_06_25_162337_update_users_table_add_role_column',24),(73,'2025_06_25_162606_drop_roles_table',25),(74,'2025_06_25_162739_drop_permission_role_table',25),(75,'2025_06_25_163600_drop_permissions_table',26);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('06839b4e-6484-4e91-8181-06002045ab41','App\\Notifications\\ProductSoldNotification','App\\Models\\User',4,'{\"product_title\":\"Xiaomi 11T 5G\",\"buyer_name\":\"abc\",\"order_id\":28,\"product_id\":3,\"message\":\"Your product \'Xiaomi 11T 5G\' was purchased by abc.\"}',NULL,'2025-06-25 15:07:12','2025-06-25 15:07:12'),('875d32f2-ad9e-4e95-8e5c-d23e8359e724','App\\Notifications\\ProductSoldNotification','App\\Models\\User',4,'{\"product_title\":\"Laptop\",\"buyer_name\":\"aaa\",\"order_id\":29,\"product_id\":1,\"message\":\"Your product \'Laptop\' was purchased by aaa.\"}',NULL,'2025-06-25 15:12:25','2025-06-25 15:12:25'),('d21aa14d-e3c0-4cef-a74f-acfc14dfb9cb','App\\Notifications\\ProductSoldNotification','App\\Models\\User',4,'{\"product_title\":\"Xiaomi 11T 5G\",\"buyer_name\":\"abc\",\"order_id\":25,\"product_id\":3,\"message\":\"Your product \'Xiaomi 11T 5G\' was purchased by abc.\"}','2025-06-24 03:17:35','2025-06-24 03:16:28','2025-06-24 03:17:35'),('e055379c-e9b0-4909-9af5-2077c65d5212','App\\Notifications\\ProductSoldNotification','App\\Models\\User',4,'{\"product_title\":\"Seiko Watch\",\"buyer_name\":\"ali\",\"order_id\":27,\"product_id\":2,\"message\":\"Your product \'Seiko Watch\' was purchased by ali.\"}',NULL,'2025-06-25 07:40:21','2025-06-25 07:40:21');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,3,'Xiaomi 11T 5G',600.00,1,'2025-05-28 07:05:26','2025-05-28 07:05:26'),(2,3,2,'Seiko Watch',1950.00,1,'2025-05-28 22:06:52','2025-05-28 22:06:52'),(3,3,4,'Iphone 8 Plus',680.00,1,'2025-05-28 22:06:52','2025-05-28 22:06:52'),(4,4,2,'Seiko Watch',1950.00,1,'2025-05-28 22:10:28','2025-05-28 22:10:28'),(5,4,4,'Iphone 8 Plus',680.00,1,'2025-05-28 22:10:28','2025-05-28 22:10:28'),(6,5,4,'Iphone 8 Plus',680.00,1,'2025-05-28 22:10:58','2025-05-28 22:10:58'),(7,6,2,'Seiko Watch',1950.00,1,'2025-05-28 23:17:42','2025-05-28 23:17:42'),(8,6,4,'Iphone 8 Plus',680.00,1,'2025-05-28 23:17:42','2025-05-28 23:17:42'),(9,7,2,'Seiko Watch',1950.00,1,'2025-05-28 23:38:27','2025-05-28 23:38:27'),(10,7,4,'Iphone 8 Plus',680.00,1,'2025-05-28 23:38:27','2025-05-28 23:38:27'),(11,8,2,'Seiko Watch',1950.00,1,'2025-05-28 23:39:36','2025-05-28 23:39:36'),(12,8,4,'Iphone 8 Plus',680.00,1,'2025-05-28 23:39:36','2025-05-28 23:39:36'),(13,9,4,'Iphone 8 Plus',680.00,1,'2025-06-10 19:29:27','2025-06-10 19:29:27'),(14,10,4,'Iphone 8 Plus',680.00,1,'2025-06-10 19:34:47','2025-06-10 19:34:47'),(15,12,4,'Iphone 8 Plus',680.00,1,'2025-06-23 04:00:55','2025-06-23 04:00:55'),(16,13,4,'Iphone 8 Plus',680.00,1,'2025-06-23 04:14:17','2025-06-23 04:14:17'),(17,15,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:10:17','2025-06-23 05:10:17'),(18,16,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:10:54','2025-06-23 05:10:54'),(19,17,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:14:03','2025-06-23 05:14:03'),(20,18,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:14:21','2025-06-23 05:14:21'),(21,19,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:20:58','2025-06-23 05:20:58'),(22,20,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:23:09','2025-06-23 05:23:09'),(23,21,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:24:49','2025-06-23 05:24:49'),(24,22,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:28:53','2025-06-23 05:28:53'),(25,23,3,'Xiaomi 11T 5G',600.00,1,'2025-06-23 05:41:29','2025-06-23 05:41:29'),(26,24,4,'Iphone 8 Plus',680.00,1,'2025-06-24 00:40:04','2025-06-24 00:40:04'),(27,25,3,'Xiaomi 11T 5G',600.00,1,'2025-06-24 03:16:00','2025-06-24 03:16:00'),(28,26,1,'Laptop',999.00,1,'2025-06-24 17:54:47','2025-06-24 17:54:47'),(29,27,2,'Seiko Watch',1950.00,1,'2025-06-25 07:39:42','2025-06-25 07:39:42'),(30,28,3,'Xiaomi 11T 5G',600.00,1,'2025-06-25 15:06:18','2025-06-25 15:06:18'),(31,29,1,'Laptop',999.00,1,'2025-06-25 15:12:03','2025-06-25 15:12:03');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `stripe_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_payment_intent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,'pending',NULL,'zul bin abu','zul@gmail.com','Cengal 1, 123',600.00,'2025-05-28 07:05:26','2025-05-28 07:05:26',NULL,NULL),(2,5,'pending',NULL,'zul bin abu','zul@gmail.com','Cengal, 123',2630.00,'2025-05-28 22:04:37','2025-05-28 22:04:37',NULL,NULL),(3,5,'pending',NULL,'zul','zul@gmail.com','Arau',2630.00,'2025-05-28 22:06:52','2025-05-28 22:06:52',NULL,NULL),(4,5,'pending',NULL,'zul','zul@gmail.com','Arau',2630.00,'2025-05-28 22:10:28','2025-05-28 22:10:28',NULL,NULL),(5,5,'pending',NULL,'zul','zul@gmail.com','Arau',680.00,'2025-05-28 22:10:58','2025-05-28 22:10:58',NULL,NULL),(6,5,'pending',NULL,'zul','zul@gmail.com','Arau',2630.00,'2025-05-28 23:17:42','2025-05-28 23:17:42',NULL,NULL),(7,5,'pending',NULL,'zul','zul@gmail.com','Arau',2630.00,'2025-05-28 23:38:27','2025-05-28 23:38:27',NULL,NULL),(8,5,'pending',NULL,'zul','zul@gmail.com','Arau',2630.00,'2025-05-28 23:39:36','2025-05-28 23:39:36',NULL,NULL),(9,5,'pending',NULL,'zul','zul@gmail.com','Arau',680.00,'2025-06-10 19:29:27','2025-06-10 19:29:27',NULL,NULL),(10,5,'pending',NULL,'zul','zul@gmail.com','Arau',680.00,'2025-06-10 19:34:47','2025-06-10 19:34:47',NULL,NULL),(11,5,'pending',NULL,'zul','zul@gmail.com','Arau',680.00,'2025-06-23 03:57:43','2025-06-23 03:57:43',NULL,NULL),(12,5,'pending',NULL,'zul','zul@gmail.com','Arau',680.00,'2025-06-23 04:00:55','2025-06-23 04:00:55',NULL,NULL),(13,5,'pending',NULL,'zul','zul@gmail.com','abc',680.00,'2025-06-23 04:14:17','2025-06-23 04:14:18','cs_test_a1UGX1Uxw3X2VmJmcsH2xe4nrkKDAohfoTij5EklDQ17GpspU4zrUpODG1',NULL),(14,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:07:25','2025-06-23 05:07:25',NULL,NULL),(15,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:10:17','2025-06-23 05:10:17',NULL,NULL),(16,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:10:54','2025-06-23 05:10:54',NULL,NULL),(17,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:14:03','2025-06-23 05:14:03',NULL,NULL),(18,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:14:21','2025-06-23 05:14:21',NULL,NULL),(19,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:20:58','2025-06-23 05:20:58',NULL,NULL),(20,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:23:09','2025-06-23 05:23:09',NULL,NULL),(21,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:24:49','2025-06-23 05:24:50','cs_test_a1Coyrg9uAPTyw677rthEkEla1Au9Ysm6KCfzZl5DP4dHD0skjBrCxI6c8',NULL),(22,5,'pending',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:28:53','2025-06-23 05:28:54','cs_test_a1p9uEjFertfd16QTZTWQAMpy4rVCPJ3cOivJRLAgud0fIjxnOaYptM0jl',NULL),(23,5,'paid',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-23 05:41:29','2025-06-23 05:41:55','cs_test_a1kM8Q3onY3cIhL91ElyoQCLTwTkqqnQYizmADiMk9mXuuC8GLs6bZNZiH','pi_3RdAd7CG8Foj2wNa0m3CHgoU'),(24,5,'paid',NULL,'abc','zul@gmail.com','abc',680.00,'2025-06-24 00:40:04','2025-06-24 00:40:32','cs_test_a1p2XB5oaSim8KHALxn3F9YXw3iuCUDR8v1VLOMurFoatykBZK63Hv7FmB','pi_3RdSP0CG8Foj2wNa0wwfTLqz'),(25,5,'paid',NULL,'abc','zul@gmail.com','abc',600.00,'2025-06-24 03:16:00','2025-06-24 03:16:27','cs_test_a1YipalRX1igr1ULBOFmZNN0V85XwiG3xUsNrzp4WswdytPhtBwQZeT2Ot','pi_3RdUpuCG8Foj2wNa1Wio0Zm4'),(26,5,'pending',NULL,'abc','zul@gmail.com','abc',999.00,'2025-06-24 17:54:47','2025-06-24 17:54:52','cs_test_a1aEiU1BpOORdYXjRDHnEE9039R8T06XGZS5FWVc1QKQc6PnAqoNCMogas',NULL),(27,5,'paid',NULL,'ali','zul@student.uitm.edu.my','arau',1950.00,'2025-06-25 07:39:42','2025-06-25 07:40:20','cs_test_a1wagbJ9pmx7NrMl4MKTUNgFGALuHopJLm6voqoqgVTazeJXw1NbG1VqA3','pi_3RdvQoCG8Foj2wNa0JSaRxck'),(28,5,'paid',NULL,'abc','zul@student.uitm.edu.my','arau',600.00,'2025-06-25 15:06:18','2025-06-25 15:07:12','cs_test_a1QVI1uLSAY8k1j4d2xyRdrZK3V72nUM5QSmaPpozhmaGOVz0ZJAWD0FbL','pi_3Re2PHCG8Foj2wNa1dQk7MAU'),(29,5,'paid',NULL,'aaa','zul@student.uitm.edu.my','aaa',999.00,'2025-06-25 15:12:03','2025-06-25 15:12:25','cs_test_a12lr0vaMY1FG6KHLdGNwvxXfQBFwAhG6XEf5DuFWYCfj5hyPQZP6o3rNg','pi_3Re2ULCG8Foj2wNa0Ji2dbT5');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
INSERT INTO `password_reset_tokens` VALUES ('alili@student.uitm.edu.my','$2y$12$zTOEQebs5vDSvtB0Ztz1p.QXumprKPuhmAzVkmNwUJcOs1zGN6QIK','2025-06-25 12:28:44');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (1,1,'products/LSisZQCBVSGHUFdy9cLUGaRZwyWGxC6AdBZsbKtO.jpg','2025-05-26 22:53:18','2025-05-26 22:53:18'),(2,1,'products/ijFKinU1LZhrFlNXuz96k9MVImC4L5kmOvjdDHx4.jpg','2025-05-26 22:53:18','2025-05-26 22:53:18'),(3,2,'products/SYSq8jkEVmtIOo7FBdCSHhfZk08u1JFub17dD8Ho.jpg','2025-05-27 11:45:40','2025-05-27 11:45:40'),(4,2,'products/qukn64QnnHRwOEXF0xaF4qEVpxnJXdxKsXufuxyk.jpg','2025-05-27 11:45:40','2025-05-27 11:45:40'),(5,2,'products/4oQ8FLUbaMVM1LJILIpTabfQARr0BV6mrDEq06jW.jpg','2025-05-27 11:45:40','2025-05-27 11:45:40'),(6,2,'products/41EHSW4YOXgHYUXs2dV1EZUaZEeNjz1c9iXGngbC.jpg','2025-05-27 11:45:40','2025-05-27 11:45:40'),(7,3,'products/3W8UkiF99dCTtYduou1II6O0eNCf7FdnKkAl3dZj.jpg','2025-05-27 19:44:18','2025-05-27 19:44:18'),(8,3,'products/5fhZAfxicg4EsB5La8ba5xeH2Sm0PkTfpqvJ9o46.jpg','2025-05-27 19:44:18','2025-05-27 19:44:18'),(9,3,'products/fBFGwNIJfU4S6eWYwRiYhG6a6Cekek0sEp3ivfqJ.jpg','2025-05-27 19:44:18','2025-05-27 19:44:18'),(10,3,'products/Z9UrCMP79pJVAp33zL4epbwKwQQokLgfAYhPsHQk.jpg','2025-05-27 19:44:18','2025-05-27 19:44:18'),(11,4,'products/KdohNn4h554mQFOnbyKVIAhQ7xUEGY9TwZnVLwKO.jpg','2025-05-27 20:07:59','2025-05-27 20:07:59'),(12,4,'products/CybrJXxFY50Fq2lz0wMypJGZKXo8unSmPIp9jcsi.jpg','2025-05-27 20:07:59','2025-05-27 20:07:59'),(13,4,'products/Cmm7fwJTytEml2JFbYAYrgL2Krqn8NTwpItLK9ZP.jpg','2025-05-27 20:07:59','2025-05-27 20:07:59'),(14,4,'products/ybDf2ixo902cJmfA5hljFdyqUFDkPT6PKJ4Tcol9.jpg','2025-05-27 20:07:59','2025-05-27 20:07:59'),(23,7,'products/Cm1bm6tfLKBiBjbDjbOGu8etlJhtHfeMzWSuuwsn.jpg','2025-06-24 21:11:35','2025-06-24 21:11:35'),(24,8,'products/J3P23DSIJRoYuTedsnBfOovn2eFXZooZbmOufzyq.jpg','2025-06-24 21:13:14','2025-06-24 21:13:14');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_reports`
--

DROP TABLE IF EXISTS `product_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_reports_user_id_foreign` (`user_id`),
  KEY `product_reports_product_id_foreign` (`product_id`),
  CONSTRAINT `product_reports_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_reports`
--

LOCK TABLES `product_reports` WRITE;
/*!40000 ALTER TABLE `product_reports` DISABLE KEYS */;
INSERT INTO `product_reports` VALUES (1,5,2,'testing','2025-06-24 04:18:50','2025-06-24 04:18:50');
/*!40000 ALTER TABLE `product_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int unsigned DEFAULT NULL,
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_rating` enum('Like New','Very Good','Good','Fair','Heavily Used') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,4,4,'Laptop','Suitable for students',999.00,5,'Used','Very Good','2025-05-26 22:53:18','2025-06-25 15:12:25','sold'),(2,4,1,'Seiko Watch','abcd',1950.00,1,'Brand New',NULL,'2025-05-27 11:45:39','2025-06-25 07:40:20','sold'),(3,4,5,'Xiaomi 11T 5G','256 GB',600.00,1,'Used','Good','2025-05-27 19:44:18','2025-06-25 15:07:12','sold'),(4,4,1,'Iphone 8 Plus','Gold\r\n64 GB',680.00,1,'Used','Good','2025-05-27 20:07:59','2025-06-24 00:40:32','sold'),(7,5,11,'q','qq',11.90,1,'New',NULL,'2025-06-24 21:11:34','2025-06-24 21:11:34','active'),(8,5,12,'aa','aaaaaaa',6.00,NULL,NULL,NULL,'2025-06-24 21:13:14','2025-06-25 13:06:23','active');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,2,3,'Sample review by user ID 2','2025-06-23 09:22:05','2025-06-23 09:22:05'),(2,1,4,5,'Sample review by user ID 4','2025-06-23 09:22:05','2025-06-23 09:22:05'),(3,1,5,3,'Sample review by user ID 5','2025-06-23 09:22:05','2025-06-23 09:22:05'),(4,1,6,3,'Sample review by user ID 6','2025-06-23 09:22:05','2025-06-23 09:22:05'),(5,3,5,4,'abcdefg','2025-06-24 00:08:50','2025-06-24 00:08:50'),(6,1,2,3,'Sample review by user ID 2','2025-06-24 03:12:11','2025-06-24 03:12:11'),(7,1,4,4,'Sample review by user ID 4','2025-06-24 03:12:11','2025-06-24 03:12:11'),(8,1,5,4,'Sample review by user ID 5','2025-06-24 03:12:11','2025-06-24 03:12:11'),(9,1,6,5,'Sample review by user ID 6','2025-06-24 03:12:11','2025-06-24 03:12:11'),(10,2,5,5,'aaaa','2025-06-25 13:47:30','2025-06-25 13:47:30');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
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
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'abu','abu@student.uitm.edu.my','2025-05-13 19:21:14','$2y$12$bkmD1//ofXBiuNWcPP9Zyens3qTBT90Ajlc0v.Q/e7QyXB0T7peMy',NULL,NULL,'2025-05-13 12:39:49','2025-05-13 19:21:14',0,'avatar.png',0,NULL,'user'),(2,'amir','amir@student.uitm.edu.my\r\n','2025-05-13 19:21:14','$2y$12$pH.NEnzYO7yfG0ijVvFv7uc0BdB31jEThYHqw6DpLQiiOkcUih7tm',NULL,NULL,'2025-05-13 12:46:05','2025-05-13 12:46:05',0,'avatar.png',0,NULL,'user'),(4,'ali','ali@student.uitm.edu.my','2025-06-25 02:00:00','$2y$12$gUU0r4dk0cJai4G50v9ku.euXkm3qzP2Wcnnmmp8dzuIe.nLtm4Le',NULL,NULL,'2025-05-21 16:55:09','2025-06-22 10:22:27',0,'avatars/YT0AbPVFbUy96kEPnrf82p2oV7GflHYirDK9HZ1O.jpg',0,NULL,'user'),(5,'Muhd Zul','zul@student.uitm.edu.my','2025-06-25 02:00:00','$2y$12$riXQCabkyPLqUw57/wubwOALkCXd0//8QcXck/NpmPQeLNfJJHgUS',NULL,NULL,'2025-05-27 10:30:36','2025-06-25 13:58:10',0,'avatars/njHy0qKBrCSFwTbkGlZLjD5rzRC6nMxkeAusRghD.jpg',0,NULL,'user'),(6,'admin1','admin1@gmail.com','2025-06-25 02:00:00','$2y$12$aco.tJ8bGj40qSq.bl5vWOtgHQyOP.bhNnTVjEFEVf34S1YsFi4wi',NULL,NULL,'2025-06-10 07:17:42','2025-06-10 07:17:42',0,'avatar.png',0,NULL,'admin'),(7,'abc','abc@student.uitm.edu.my','2025-06-25 02:00:00','$2y$12$qVHM10Y2xzKXvABLv9ZOf.ycfcVeBh19oyY1uSqDmiFIpst845YkG',NULL,NULL,'2025-06-25 05:49:01','2025-06-25 05:49:01',0,'avatar.png',0,NULL,'user'),(8,'alili','alili@student.uitm.edu.my','2025-06-25 06:58:59','$2y$12$Dac9LhPVVjckOIHVQ8oA.uoYpK10MmU4XwL6zdpndoi83etOudSye',NULL,NULL,'2025-06-25 06:58:40','2025-06-25 06:58:59',0,'avatar.png',0,NULL,'user'),(9,'abc','123abc@student.uitm.edu.my',NULL,'$2y$12$ATpPogpaBZEwXg8mOSaCtu16EuZDnIjaQYH/0AjUPTGrPV0jOmOW.',NULL,NULL,'2025-06-25 07:59:21','2025-06-25 07:59:21',0,'avatar.png',0,NULL,'user'),(10,'amin','amin@student.uitm.edu.my',NULL,'$2y$12$PhdJl2bxB5XgsAPWWrJS1.hKHssnNZkh43NMKHHD6nvfFNoEcNgXO',NULL,NULL,'2025-06-25 08:00:47','2025-06-25 08:00:47',0,'avatar.png',0,NULL,'user'),(11,'test','test@student.uitm.edu.my',NULL,'$2y$12$etJuCPRiGn8Gu.LGsMagROhFOw19JYHQhukEABrMQ9Z94loiyOesK',NULL,NULL,'2025-06-25 08:15:53','2025-06-25 08:15:53',0,'avatar.png',0,NULL,'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-03 23:05:56
