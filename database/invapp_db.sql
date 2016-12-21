-- MySQL dump 10.13  Distrib 5.6.24, for Linux (x86_64)
--
-- Host: localhost    Database: invapp_db
-- ------------------------------------------------------
-- Server version	5.6.24

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
-- Current Database: `invapp_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `invapp_db` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_520_ci */;

USE `invapp_db`;

--
-- Table structure for table `appsetting`
--

DROP TABLE IF EXISTS `appsetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appsetting` (
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ext_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appsetting`
--

LOCK TABLES `appsetting` WRITE;
/*!40000 ALTER TABLE `appsetting` DISABLE KEYS */;
INSERT INTO `appsetting` VALUES ('alamat','Jl. Cikini Raya No. 71',''),('alamat_2','Cikini - Menteng, Jakarta Pusat 10330',''),('bulan_terakhir','12',''),('cat_invoice','',''),('cat_kwitansi','',''),('email','info@aksaratravelindo.com',''),('fax','(+62) 8 1213 66 8111',''),('inv_catatan_1','CATATAN',''),('inv_catatan_2','Pembayaran melalui transfer hanya ditujukan ke rekening di bawah ini:',''),('inv_catatan_3','PT. AKSARA TRAVELINDO INTERNUSA',''),('inv_catatan_4','- Bank Central Asia cabang Sentral Cikini, No. Rekening: 8780-234-823',''),('inv_catatan_5','- Bank Mandiri cabang Taman Ismail Marzuki, No. Rekening: 123-000-715-7623',''),('inv_catatan_6','',''),('inv_catatan_7','Pembayaran dengan menggunakan Cek / Bilyet Giro dianggap lunas jika sudah diuangkan ',''),('inv_height_of_row','5',''),('inv_hotel_counter','9',''),('inv_hotel_prefix','INV/HTL',''),('inv_lain_counter','8',''),('inv_lain_maxlen_keterangan','180',''),('inv_lain_prefix','INV',''),('inv_maxlen_data_kustomer','41',''),('inv_maxlen_dicetak_oleh','22',''),('inv_maxlen_durasi','25',''),('inv_maxlen_harga','',''),('inv_maxlen_kode_pemesanan','16',''),('inv_maxlen_maskapai','20',''),('inv_maxlen_nomor_tiket','20',''),('inv_maxlen_penumpang','20',''),('inv_maxlen_rute','20',''),('inv_maxlen_titel','',''),('inv_tiket_counter','9',''),('inv_tiket_prefix','INV/TKT',''),('inv_widht_header_separator','1',''),('inv_width_harga','27',''),('inv_width_kode_pemesanan','20',''),('inv_width_maskapai','30',''),('inv_width_nama','35',''),('inv_width_no','10',''),('inv_width_nomor_tiket','30',''),('inv_width_rute','30',''),('inv_width_titel','5',''),('kabupaten','Jakarta Pusat',''),('kecamatan','Cikini - Menteng',''),('kodepos','10330',''),('kwitansi_kota','JAKARTA',''),('logo','logo_perusahaan.png',''),('nama_perusahaan','PT. AKSARA TRAVELINDO INTERNUSA',''),('provinsi','',''),('sidebar_collapse','0',''),('telp','(+62) 8 1213 66 8000',''),('telp_2','(+62) 8 1213 66 8002',''),('website','www.aksaratravelindo.com','');
/*!40000 ALTER TABLE `appsetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel`
--

LOCK TABLES `hotel` WRITE;
/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_hotel`
--

DROP TABLE IF EXISTS `invoice_hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `inv_num` varchar(50) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `tgl_cetak` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `terbilang` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `kantor` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_hotel`
--

LOCK TABLES `invoice_hotel` WRITE;
/*!40000 ALTER TABLE `invoice_hotel` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_hotel_data_pemesanan`
--

DROP TABLE IF EXISTS `invoice_hotel_data_pemesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_hotel_data_pemesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `invoice_hotel_id` int(11) DEFAULT NULL,
  `kode_pemesanan` varchar(60) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `hotel` varchar(155) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_invoice_hotel_data_pemesanan_invoice_hotel` (`invoice_hotel_id`),
  CONSTRAINT `FK_invoice_hotel_data_pemesanan_invoice_hotel` FOREIGN KEY (`invoice_hotel_id`) REFERENCES `invoice_hotel` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_hotel_data_pemesanan`
--

LOCK TABLES `invoice_hotel_data_pemesanan` WRITE;
/*!40000 ALTER TABLE `invoice_hotel_data_pemesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_hotel_data_pemesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_hotel_data_tamu`
--

DROP TABLE IF EXISTS `invoice_hotel_data_tamu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_hotel_data_tamu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `invoice_hotel_data_pemesanan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `titel` enum('mr','mrs','ms') COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nomor_voucher` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_invoice_hotel_data_tamu_invoice_hotel_data_pemesanan` (`invoice_hotel_data_pemesanan_id`),
  CONSTRAINT `FK_invoice_hotel_data_tamu_invoice_hotel_data_pemesanan` FOREIGN KEY (`invoice_hotel_data_pemesanan_id`) REFERENCES `invoice_hotel_data_pemesanan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_hotel_data_tamu`
--

LOCK TABLES `invoice_hotel_data_tamu` WRITE;
/*!40000 ALTER TABLE `invoice_hotel_data_tamu` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_hotel_data_tamu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_lain`
--

DROP TABLE IF EXISTS `invoice_lain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_lain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `inv_num` varchar(50) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `tgl_cetak` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `terbilang` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `kantor` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_lain`
--

LOCK TABLES `invoice_lain` WRITE;
/*!40000 ALTER TABLE `invoice_lain` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_lain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_lain_detail`
--

DROP TABLE IF EXISTS `invoice_lain_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_lain_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `invoice_lain_id` int(11) DEFAULT NULL,
  `keterangan` varchar(500) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `harga_satuan` decimal(15,2) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total_harga` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_invoice_lain_detail_invoice_lain` (`invoice_lain_id`),
  CONSTRAINT `FK_invoice_lain_detail_invoice_lain` FOREIGN KEY (`invoice_lain_id`) REFERENCES `invoice_lain` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_lain_detail`
--

LOCK TABLES `invoice_lain_detail` WRITE;
/*!40000 ALTER TABLE `invoice_lain_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_lain_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_tiket`
--

DROP TABLE IF EXISTS `invoice_tiket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_tiket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `inv_num` varchar(50) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `tgl_cetak` date DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `total` decimal(15,2) DEFAULT NULL,
  `terbilang` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `kantor` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_tiket`
--

LOCK TABLES `invoice_tiket` WRITE;
/*!40000 ALTER TABLE `invoice_tiket` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_tiket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_tiket_data_pemesanan`
--

DROP TABLE IF EXISTS `invoice_tiket_data_pemesanan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_tiket_data_pemesanan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `invoice_tiket_id` int(11) DEFAULT NULL,
  `kode_pemesanan` varchar(60) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `maskapai_id` int(11) DEFAULT NULL,
  `maskapai` varchar(60) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `pergi` varchar(60) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `pulang` varchar(60) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__invoice_tiket` (`invoice_tiket_id`),
  KEY `FK_invoice_tiket_data_pemesanan_maskapai` (`maskapai_id`),
  CONSTRAINT `FK__invoice_tiket` FOREIGN KEY (`invoice_tiket_id`) REFERENCES `invoice_tiket` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_tiket_data_pemesanan`
--

LOCK TABLES `invoice_tiket_data_pemesanan` WRITE;
/*!40000 ALTER TABLE `invoice_tiket_data_pemesanan` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_tiket_data_pemesanan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_tiket_data_penumpang`
--

DROP TABLE IF EXISTS `invoice_tiket_data_penumpang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice_tiket_data_penumpang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `invoice_tiket_data_pemesanan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `titel` enum('mr','mrs','ms') COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `nomor_tiket` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_invoice_tiket_penumpang_invoice_tiket_data_pemesanan` (`invoice_tiket_data_pemesanan_id`),
  CONSTRAINT `FK_invoice_tiket_penumpang_invoice_tiket_data_pemesanan` FOREIGN KEY (`invoice_tiket_data_pemesanan_id`) REFERENCES `invoice_tiket_data_pemesanan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_tiket_data_penumpang`
--

LOCK TABLES `invoice_tiket_data_penumpang` WRITE;
/*!40000 ALTER TABLE `invoice_tiket_data_penumpang` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice_tiket_data_penumpang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maskapai`
--

DROP TABLE IF EXISTS `maskapai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maskapai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nama` varchar(255) COLLATE utf8_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maskapai`
--

LOCK TABLES `maskapai` WRITE;
/*!40000 ALTER TABLE `maskapai` DISABLE KEYS */;
/*!40000 ALTER TABLE `maskapai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class_request` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `href` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,NULL,'Beranda','home','home',1,'fa fa-home'),(6,NULL,'Invoice & Kwitansi','invoice*','#',2,'fa fa-newspaper-o'),(31,NULL,'Pengaturan','setting*','#',6,'fa fa-cogs'),(34,31,'Pengguna','setting/user*','setting/user',1,NULL),(35,6,'Tiket Pesawat','invoice/tiket*','invoice/tiket',1,NULL),(36,6,'Reservasi Hotel','invoice/hotel*','invoice/hotel',2,NULL),(37,6,'Invoice Lain','invoice/invoice-lain*','invoice/invoice-lain',3,NULL),(38,31,'Sistem','setting/system*','setting/system',2,NULL),(39,NULL,'Rekapitulasi','rekap*','#',3,'fa fa-table'),(40,39,'Data Tiket','rekap/tiket*','rekap/tiket',1,NULL),(41,39,'Data Hotel','rekap/hotel*','rekap/hotel',2,NULL),(42,39,'Data Invoice Lain','rekap/lain*','rekap/lain',3,NULL),(43,6,'Kwitansi Lain','kwitansi*','kwitansi',4,NULL),(44,NULL,'Profil','profile*','profile',5,'fa fa-user'),(45,NULL,'Laporan Finansial','#','#',4,'fa fa-money');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__roles` (`role_id`),
  KEY `FK__permissions` (`permission_id`),
  CONSTRAINT `FK__permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `FK__roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `nama` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'2016-08-11 21:19:19','2016-08-12 04:19:20','ADM','ADMINISTRATOR'),(2,'2016-08-11 21:19:39','2016-08-12 04:19:40','OPR','OPERATOR');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_role_users` (`user_id`),
  KEY `FK_user_role_roles` (`role_id`),
  CONSTRAINT `FK_user_role_roles` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_user_role_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'2016-08-11 21:20:00','2016-08-12 04:20:01',1,1);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'2016-08-11 10:19:31','2016-12-21','SYSTEM ADMINISTRATOR','admin','admin@localhost.com','$2y$10$IfJZtmvoB3HFgyv3PEdIVe7IZCOrATXv/P1yw3JC7Yrio/8uYzuHC','PTn5QP7QUWmYwZNoO1OCExCq8kguH5XOCqDYaJiPNYcM6MgxQDaPN8N8fGPc',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_data_pemesanan_hotel`
--

DROP TABLE IF EXISTS `view_data_pemesanan_hotel`;
/*!50001 DROP VIEW IF EXISTS `view_data_pemesanan_hotel`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_data_pemesanan_hotel` AS SELECT 
 1 AS `id`,
 1 AS `pemesanan_id`,
 1 AS `created_at`,
 1 AS `invoice_hotel_id`,
 1 AS `kode_pemesanan`,
 1 AS `harga`,
 1 AS `hotel`,
 1 AS `check_in`,
 1 AS `check_in_formatted`,
 1 AS `check_out`,
 1 AS `check_out_formatted`,
 1 AS `inv_num`,
 1 AS `tgl_cetak`,
 1 AS `tgl_cetak_formatted`,
 1 AS `jatuh_tempo`,
 1 AS `jatuh_tempo_formatted`,
 1 AS `nama`,
 1 AS `kantor`,
 1 AS `alamat`,
 1 AS `telp`,
 1 AS `email`,
 1 AS `user_id`,
 1 AS `total`,
 1 AS `terbilang`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_data_pemesanan_tiket`
--

DROP TABLE IF EXISTS `view_data_pemesanan_tiket`;
/*!50001 DROP VIEW IF EXISTS `view_data_pemesanan_tiket`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_data_pemesanan_tiket` AS SELECT 
 1 AS `id`,
 1 AS `pemesanan_id`,
 1 AS `created_at`,
 1 AS `invoice_tiket_id`,
 1 AS `kode_pemesanan`,
 1 AS `harga`,
 1 AS `maskapai`,
 1 AS `pergi`,
 1 AS `pulang`,
 1 AS `inv_num`,
 1 AS `tgl_cetak`,
 1 AS `tgl_cetak_formatted`,
 1 AS `jatuh_tempo`,
 1 AS `jatuh_tempo_formatted`,
 1 AS `nama`,
 1 AS `kantor`,
 1 AS `alamat`,
 1 AS `telp`,
 1 AS `email`,
 1 AS `user_id`,
 1 AS `total`,
 1 AS `terbilang`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_email`
--

DROP TABLE IF EXISTS `view_email`;
/*!50001 DROP VIEW IF EXISTS `view_email`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_email` AS SELECT 
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_kantor`
--

DROP TABLE IF EXISTS `view_kantor`;
/*!50001 DROP VIEW IF EXISTS `view_kantor`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_kantor` AS SELECT 
 1 AS `kantor`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_nama`
--

DROP TABLE IF EXISTS `view_nama`;
/*!50001 DROP VIEW IF EXISTS `view_nama`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_nama` AS SELECT 
 1 AS `nama`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_rekap_invoice_tiket`
--

DROP TABLE IF EXISTS `view_rekap_invoice_tiket`;
/*!50001 DROP VIEW IF EXISTS `view_rekap_invoice_tiket`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_rekap_invoice_tiket` AS SELECT 
 1 AS `titel`,
 1 AS `nama_penumpang`,
 1 AS `nomor_tiket`,
 1 AS `kode_pemesanan`,
 1 AS `harga`,
 1 AS `maskapai`,
 1 AS `pergi`,
 1 AS `pulang`,
 1 AS `inv_num`,
 1 AS `tgl_cetak`,
 1 AS `tgl_cetak_formatted`,
 1 AS `jatuh_tempo`,
 1 AS `jatuh_tempo_formatted`,
 1 AS `total`,
 1 AS `terbilang`,
 1 AS `nama_kustomer`,
 1 AS `kantor`,
 1 AS `alamat`,
 1 AS `telp`,
 1 AS `email`,
 1 AS `user_id`,
 1 AS `created_at`,
 1 AS `invoice_tiket_id`*/;
SET character_set_client = @saved_cs_client;

--
-- Current Database: `invapp_db`
--

USE `invapp_db`;

--
-- Final view structure for view `view_data_pemesanan_hotel`
--

/*!50001 DROP VIEW IF EXISTS `view_data_pemesanan_hotel`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_data_pemesanan_hotel` AS select `invoice_hotel_data_pemesanan`.`id` AS `id`,`invoice_hotel_data_pemesanan`.`id` AS `pemesanan_id`,`invoice_hotel_data_pemesanan`.`created_at` AS `created_at`,`invoice_hotel_data_pemesanan`.`invoice_hotel_id` AS `invoice_hotel_id`,`invoice_hotel_data_pemesanan`.`kode_pemesanan` AS `kode_pemesanan`,`invoice_hotel_data_pemesanan`.`harga` AS `harga`,`invoice_hotel_data_pemesanan`.`hotel` AS `hotel`,`invoice_hotel_data_pemesanan`.`check_in` AS `check_in`,date_format(`invoice_hotel_data_pemesanan`.`check_in`,'%d-%m-%Y') AS `check_in_formatted`,`invoice_hotel_data_pemesanan`.`check_out` AS `check_out`,date_format(`invoice_hotel_data_pemesanan`.`check_out`,'%d-%m-%Y') AS `check_out_formatted`,`invoice_hotel`.`inv_num` AS `inv_num`,`invoice_hotel`.`tgl_cetak` AS `tgl_cetak`,date_format(`invoice_hotel`.`tgl_cetak`,'%d-%m-%Y') AS `tgl_cetak_formatted`,`invoice_hotel`.`jatuh_tempo` AS `jatuh_tempo`,date_format(`invoice_hotel`.`jatuh_tempo`,'%d-%m-%Y') AS `jatuh_tempo_formatted`,`invoice_hotel`.`nama` AS `nama`,`invoice_hotel`.`kantor` AS `kantor`,`invoice_hotel`.`alamat` AS `alamat`,`invoice_hotel`.`telp` AS `telp`,`invoice_hotel`.`email` AS `email`,`invoice_hotel`.`user_id` AS `user_id`,`invoice_hotel`.`total` AS `total`,`invoice_hotel`.`terbilang` AS `terbilang` from (`invoice_hotel` join `invoice_hotel_data_pemesanan` on((`invoice_hotel`.`id` = `invoice_hotel_data_pemesanan`.`invoice_hotel_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_data_pemesanan_tiket`
--

/*!50001 DROP VIEW IF EXISTS `view_data_pemesanan_tiket`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_data_pemesanan_tiket` AS select `invoice_tiket_data_pemesanan`.`id` AS `id`,`invoice_tiket_data_pemesanan`.`id` AS `pemesanan_id`,`invoice_tiket_data_pemesanan`.`created_at` AS `created_at`,`invoice_tiket_data_pemesanan`.`invoice_tiket_id` AS `invoice_tiket_id`,`invoice_tiket_data_pemesanan`.`kode_pemesanan` AS `kode_pemesanan`,`invoice_tiket_data_pemesanan`.`harga` AS `harga`,`invoice_tiket_data_pemesanan`.`maskapai` AS `maskapai`,`invoice_tiket_data_pemesanan`.`pergi` AS `pergi`,`invoice_tiket_data_pemesanan`.`pulang` AS `pulang`,`invoice_tiket`.`inv_num` AS `inv_num`,`invoice_tiket`.`tgl_cetak` AS `tgl_cetak`,date_format(`invoice_tiket`.`tgl_cetak`,'%d-%m-%Y') AS `tgl_cetak_formatted`,`invoice_tiket`.`jatuh_tempo` AS `jatuh_tempo`,date_format(`invoice_tiket`.`jatuh_tempo`,'%d-%m-%Y') AS `jatuh_tempo_formatted`,`invoice_tiket`.`nama` AS `nama`,`invoice_tiket`.`kantor` AS `kantor`,`invoice_tiket`.`alamat` AS `alamat`,`invoice_tiket`.`telp` AS `telp`,`invoice_tiket`.`email` AS `email`,`invoice_tiket`.`user_id` AS `user_id`,`invoice_tiket`.`total` AS `total`,`invoice_tiket`.`terbilang` AS `terbilang` from (`invoice_tiket` join `invoice_tiket_data_pemesanan` on((`invoice_tiket`.`id` = `invoice_tiket_data_pemesanan`.`invoice_tiket_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_email`
--

/*!50001 DROP VIEW IF EXISTS `view_email`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_email` AS select `invoice_tiket`.`email` AS `email` from `invoice_tiket` union select `invoice_hotel`.`email` AS `email` from `invoice_hotel` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_kantor`
--

/*!50001 DROP VIEW IF EXISTS `view_kantor`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_kantor` AS select `invoice_tiket`.`kantor` AS `kantor` from `invoice_tiket` union select `invoice_hotel`.`kantor` AS `kantor` from `invoice_hotel` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_nama`
--

/*!50001 DROP VIEW IF EXISTS `view_nama`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_nama` AS select `invoice_tiket`.`nama` AS `nama` from `invoice_tiket` union select `invoice_tiket_data_penumpang`.`nama` AS `nama` from `invoice_tiket_data_penumpang` union select `invoice_hotel`.`nama` AS `nama` from `invoice_hotel` union select `invoice_hotel_data_tamu`.`nama` AS `nama` from `invoice_hotel_data_tamu` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_rekap_invoice_tiket`
--

/*!50001 DROP VIEW IF EXISTS `view_rekap_invoice_tiket`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_rekap_invoice_tiket` AS select `invoice_tiket_data_penumpang`.`titel` AS `titel`,`invoice_tiket_data_penumpang`.`nama` AS `nama_penumpang`,`invoice_tiket_data_penumpang`.`nomor_tiket` AS `nomor_tiket`,`invoice_tiket_data_pemesanan`.`kode_pemesanan` AS `kode_pemesanan`,`invoice_tiket_data_pemesanan`.`harga` AS `harga`,`invoice_tiket_data_pemesanan`.`maskapai` AS `maskapai`,`invoice_tiket_data_pemesanan`.`pergi` AS `pergi`,`invoice_tiket_data_pemesanan`.`pulang` AS `pulang`,`invoice_tiket`.`inv_num` AS `inv_num`,`invoice_tiket`.`tgl_cetak` AS `tgl_cetak`,date_format(`invoice_tiket`.`tgl_cetak`,'%d-%m-%Y') AS `tgl_cetak_formatted`,`invoice_tiket`.`jatuh_tempo` AS `jatuh_tempo`,date_format(`invoice_tiket`.`jatuh_tempo`,'%d-%m-%Y') AS `jatuh_tempo_formatted`,`invoice_tiket`.`total` AS `total`,`invoice_tiket`.`terbilang` AS `terbilang`,`invoice_tiket`.`nama` AS `nama_kustomer`,`invoice_tiket`.`kantor` AS `kantor`,`invoice_tiket`.`alamat` AS `alamat`,`invoice_tiket`.`telp` AS `telp`,`invoice_tiket`.`email` AS `email`,`invoice_tiket`.`user_id` AS `user_id`,`invoice_tiket`.`created_at` AS `created_at`,`invoice_tiket`.`id` AS `invoice_tiket_id` from ((`invoice_tiket_data_pemesanan` join `invoice_tiket_data_penumpang` on((`invoice_tiket_data_pemesanan`.`id` = `invoice_tiket_data_penumpang`.`invoice_tiket_data_pemesanan_id`))) join `invoice_tiket` on((`invoice_tiket_data_pemesanan`.`invoice_tiket_id` = `invoice_tiket`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-21  9:16:18
