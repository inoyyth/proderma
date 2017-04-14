-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: proderma_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.21-MariaDB

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
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `path_foto` varchar(255) DEFAULT NULL,
  `access_menu` text,
  `super_admin` enum('1','2') DEFAULT '1' COMMENT '1 =>not super admin, 2 => is super admin',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime NOT NULL,
  `sys_update_date` datetime NOT NULL,
  `sys_delete_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `status` enum('1','2') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (6,'superadmin@proderma.com','Super Admin','4nWZTyIKWFti8DoSKAHGeq8gG+kLcAVfTkg9METALb5iOZ1rxbxZd+fULETN7JN/OrcjCvI9lmN1xEEE8vQafQ==','909090909','supri170845@gmail.com','assets/images/account/a93ac272e0099bcc4a867ffc01b343a3.png','a:18:{i:0;a:3:{s:4:\"menu\";s:2:\"23\";s:4:\"slug\";s:15:\"master-employee\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:1;a:3:{s:4:\"menu\";s:2:\"24\";s:4:\"slug\";s:12:\"master-level\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:2;a:3:{s:4:\"menu\";s:2:\"26\";s:4:\"slug\";s:14:\"master-product\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:3;a:3:{s:4:\"menu\";s:2:\"27\";s:4:\"slug\";s:23:\"master-product-category\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:4;a:3:{s:4:\"menu\";s:2:\"28\";s:4:\"slug\";s:19:\"master-payment-type\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:5;a:3:{s:4:\"menu\";s:2:\"29\";s:4:\"slug\";s:15:\"master-customer\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:6;a:3:{s:4:\"menu\";s:2:\"36\";s:4:\"slug\";s:15:\"user-management\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:7;a:3:{s:4:\"menu\";s:2:\"34\";s:4:\"slug\";s:11:\"sales-order\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:8;a:3:{s:4:\"menu\";s:2:\"45\";s:4:\"slug\";s:14:\"sales-delivery\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:9;a:3:{s:4:\"menu\";s:2:\"46\";s:4:\"slug\";s:7:\"invoice\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:10;a:3:{s:4:\"menu\";s:2:\"52\";s:4:\"slug\";s:16:\"status-transaksi\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:11;a:3:{s:4:\"menu\";s:2:\"53\";s:4:\"slug\";s:10:\"All Report\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:12;a:3:{s:4:\"menu\";s:2:\"49\";s:4:\"slug\";s:12:\"mapping-area\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:13;a:3:{s:4:\"menu\";s:2:\"50\";s:4:\"slug\";s:15:\"mapping-product\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:14;a:3:{s:4:\"menu\";s:2:\"32\";s:4:\"slug\";s:14:\"visit-activity\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:15;a:3:{s:4:\"menu\";s:2:\"33\";s:4:\"slug\";s:14:\"sales-activity\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:16;a:3:{s:4:\"menu\";s:2:\"48\";s:4:\"slug\";s:3:\"ojt\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:17;a:3:{s:4:\"menu\";s:2:\"51\";s:4:\"slug\";s:20:\"master-list-priority\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}}','2',NULL,6,NULL,'0000-00-00 00:00:00','2017-04-14 17:18:49','0000-00-00 00:00:00','2017-04-14 23:12:36','1'),(7,'sapta@gmail.com','Sapta','FPeGUTv9tqU2OK+ehIe1y8pL+LOh5ZmSomm7hY/ibO9N77b052+OaMFj/vNfzL298YcvFF/EAsBh8faI+QQvRA==','879979797979','supri170845@gmail.com','667fa1e720b199d98293f0eec4086ebe.jpg','a:27:{i:0;a:3:{s:4:\"menu\";s:2:\"23\";s:4:\"slug\";s:14:\"master-jabatan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:1;a:3:{s:4:\"menu\";s:2:\"24\";s:4:\"slug\";s:15:\"master-karyawan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:2;a:3:{s:4:\"menu\";s:2:\"26\";s:4:\"slug\";s:15:\"master-customer\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:3;a:3:{s:4:\"menu\";s:2:\"27\";s:4:\"slug\";s:12:\"master-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:4;a:3:{s:4:\"menu\";s:2:\"28\";s:4:\"slug\";s:16:\"master-aksesoris\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:5;a:3:{s:4:\"menu\";s:2:\"29\";s:4:\"slug\";s:13:\"master-gudang\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:6;a:3:{s:4:\"menu\";s:2:\"30\";s:4:\"slug\";s:14:\"master-leasing\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:7;a:3:{s:4:\"menu\";s:2:\"37\";s:4:\"slug\";s:16:\"master-biro-jasa\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:8;a:3:{s:4:\"menu\";s:2:\"32\";s:4:\"slug\";s:9:\"penjualan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:9;a:3:{s:4:\"menu\";s:2:\"38\";s:4:\"slug\";s:11:\"kwitansi-dp\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:10;a:3:{s:4:\"menu\";s:2:\"33\";s:4:\"slug\";s:10:\"pembayaran\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:11;a:3:{s:4:\"menu\";s:2:\"41\";s:4:\"slug\";s:3:\"pdi\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:12;a:3:{s:4:\"menu\";s:2:\"42\";s:4:\"slug\";s:4:\"stnk\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:13;a:3:{s:4:\"menu\";s:2:\"59\";s:4:\"slug\";s:11:\"terima-stnk\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:14;a:3:{s:4:\"menu\";s:2:\"43\";s:4:\"slug\";s:4:\"void\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:15;a:3:{s:4:\"menu\";s:2:\"44\";s:4:\"slug\";s:11:\"surat-jalan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:16;a:3:{s:4:\"menu\";s:2:\"34\";s:4:\"slug\";s:12:\"return-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:17;a:3:{s:4:\"menu\";s:2:\"45\";s:4:\"slug\";s:5:\"stock\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:18;a:3:{s:4:\"menu\";s:2:\"46\";s:4:\"slug\";s:23:\"import-penerimaan-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:19;a:3:{s:4:\"menu\";s:2:\"47\";s:4:\"slug\";s:26:\"input-penerimaan-aksesoris\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:20;a:3:{s:4:\"menu\";s:2:\"48\";s:4:\"slug\";s:12:\"motor-keluar\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:21;a:3:{s:4:\"menu\";s:2:\"49\";s:4:\"slug\";s:11:\"motor-masuk\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:22;a:3:{s:4:\"menu\";s:2:\"50\";s:4:\"slug\";s:22:\"cetak-kwitansi-leasing\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:23;a:3:{s:4:\"menu\";s:2:\"51\";s:4:\"slug\";s:13:\"rekap-tagihan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:24;a:3:{s:4:\"menu\";s:2:\"52\";s:4:\"slug\";s:16:\"surat-pernyataan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:25;a:3:{s:4:\"menu\";s:2:\"53\";s:4:\"slug\";s:17:\"pencairan-leasing\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:26;a:3:{s:4:\"menu\";s:2:\"54\";s:4:\"slug\";s:17:\"laporan-penjualan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}}','1',NULL,6,NULL,'0000-00-00 00:00:00','2017-03-12 01:16:44','0000-00-00 00:00:00','2017-03-12 01:13:19','1');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_customer_product`
--

DROP TABLE IF EXISTS `group_customer_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_customer_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_customer_product` varchar(100) DEFAULT NULL,
  `group_customer_product_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_customer_product`
--

LOCK TABLES `group_customer_product` WRITE;
/*!40000 ALTER TABLE `group_customer_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_customer_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_activity`
--

DROP TABLE IF EXISTS `m_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(100) DEFAULT NULL,
  `activity_status` int(2) DEFAULT '1' COMMENT '1=>active,2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_activity`
--

LOCK TABLES `m_activity` WRITE;
/*!40000 ALTER TABLE `m_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_customer`
--

DROP TABLE IF EXISTS `m_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_clinic` varchar(100) DEFAULT NULL,
  `customer_address` text,
  `customer_city` text,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `customer_latitude` text,
  `customer_longitude` text,
  `id_group_customer_product` varchar(10) DEFAULT NULL,
  `id_source_lead_customer` int(11) DEFAULT NULL,
  `id_status_lead_customer` int(11) DEFAULT NULL,
  `current_lead_customer_status` enum('C','L') DEFAULT 'L' COMMENT 'C =>Customer , L =>Lead Customer',
  `update_date_lead_to_customer` datetime DEFAULT NULL COMMENT 'waktu perubahan dari lead ke customer',
  `update_user_lead_to_customer` int(11) DEFAULT NULL COMMENT 'id user yang melakukan perubahan dari lead ke customer',
  `customer_as_priority` int(11) DEFAULT '1' COMMENT '1=>not_priority, 2=>priority',
  `status_customer` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_source_lead_customer` (`id_source_lead_customer`),
  KEY `fk_status_lead_customer` (`id_status_lead_customer`),
  CONSTRAINT `fk_source_lead_customer` FOREIGN KEY (`id_source_lead_customer`) REFERENCES `source_lead_customer` (`id`),
  CONSTRAINT `fk_status_lead_customer` FOREIGN KEY (`id_status_lead_customer`) REFERENCES `status_lead_customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_customer`
--

LOCK TABLES `m_customer` WRITE;
/*!40000 ALTER TABLE `m_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_employee`
--

DROP TABLE IF EXISTS `m_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) DEFAULT NULL,
  `employee_nip` varchar(30) DEFAULT NULL,
  `employee_name` varchar(50) DEFAULT NULL,
  `employee_email` varchar(50) DEFAULT NULL,
  `employee_phone` varchar(20) DEFAULT NULL,
  `employee_gender` enum('F','M') DEFAULT 'M',
  `employee_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jabatan` (`id_jabatan`),
  CONSTRAINT `fk_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `m_jabatan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_employee`
--

LOCK TABLES `m_employee` WRITE;
/*!40000 ALTER TABLE `m_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_jabatan`
--

DROP TABLE IF EXISTS `m_jabatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(100) DEFAULT NULL,
  `jabatan_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_jabatan`
--

LOCK TABLES `m_jabatan` WRITE;
/*!40000 ALTER TABLE `m_jabatan` DISABLE KEYS */;
INSERT INTO `m_jabatan` VALUES (1,'sales',1,1,NULL,NULL,'2017-04-09 07:56:36',NULL,NULL),(2,'manager',1,1,NULL,NULL,'2017-04-09 07:56:36',NULL,NULL),(3,'supervisor',1,1,NULL,NULL,'2017-04-09 07:56:36',NULL,NULL),(4,'direktur',1,1,NULL,NULL,'2017-04-09 07:56:36',NULL,NULL),(5,'admin',1,1,NULL,NULL,'2017-04-09 07:56:36',NULL,NULL);
/*!40000 ALTER TABLE `m_jabatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_motor`
--

DROP TABLE IF EXISTS `m_motor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_motor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_motor` varchar(25) NOT NULL DEFAULT '',
  `nama_motor` varchar(50) DEFAULT 'unknow-name',
  `varian` varchar(50) DEFAULT 'unknown-varian',
  `merk` varchar(50) DEFAULT 'unknown-merk',
  `harga_otr` float DEFAULT '0',
  `nama_foto` text,
  `url_foto` text,
  `m_status` enum('1','2','3') DEFAULT '1',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`tipe_motor`),
  UNIQUE KEY `unique_A` (`tipe_motor`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=894 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_motor`
--

LOCK TABLES `m_motor` WRITE;
/*!40000 ALTER TABLE `m_motor` DISABLE KEYS */;
INSERT INTO `m_motor` VALUES (1,'AFX12U08','SupraX 125 D','Manual','Honda',15000000,'assets/images/motor/7875eb7c85881c95c21b8995f0de1e9a.jpg','/assets/images//assets/images/motor/7875eb7c85881c95c21b8995f0de1e9a.jpg','1',NULL,6,NULL,NULL,'2016-12-26 22:52:57',NULL),(3,'AFX12U8A','Spacy','Automatic','Honda',16000000,'assets/images/motor/a390e0181be2d62aee6c3aef26f2575d.jpg','/assets/images//assets/images/motor/a390e0181be2d62aee6c3aef26f2575d.jpg','1',NULL,6,NULL,NULL,'2016-12-26 22:53:32',NULL),(5,'C1CN16M2','Supra X 125','Manual','Honda',14500000,'assets/images/motor/9a482b5e17d0940d026120082284d945.jpg','/assets/images//assets/images/motor/9a482b5e17d0940d026120082284d945.jpg','1',NULL,6,NULL,NULL,'2016-12-26 22:55:08',NULL),(7,'C1CN16MS','Vario 110','Automatic','Honda',15600000,'assets/images/motor/54a634dc98176830475eb278f29135c1.jpg','/assets/images//assets/images/motor/54a634dc98176830475eb278f29135c1.jpg','1',NULL,6,NULL,NULL,'2016-12-26 22:55:49',NULL),(8,'D1A2N8MA','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(9,'EF02N12M','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(16,'K1H2N4LM','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(22,'NF12ACF3','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(24,'NFT13C01','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(74,'GL15BCF2','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(79,'NC1D1CF2','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(80,'X1B2N7L0','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(94,'X1B2N4LA','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(102,'YG2N15L1','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(117,'GL15C21A','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(118,'K1H2N4L0','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(121,'NFT13C03','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(127,'YG2N2LAA','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(128,'T5E02RL0','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(138,'YG2N2L1A','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(149,'D1A2N18M','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(150,'D1A2N19M','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(151,'D1A2N9MA','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(158,'YG02N2L1','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(164,'EF02N11S','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(174,'X1B2N4LO','SupraX 125 D','Bebek','Honda',14000000,'assets/images/motor/cf19ce1d4adbd1f03a206d077745183a.jpg','/assets/images//assets/images/motor/cf19ce1d4adbd1f03a206d077745183a.jpg','1',NULL,6,NULL,NULL,'2016-12-24 22:21:17',NULL),(182,'Y3B2R17L','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(263,'H5C2R2MA','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(392,'K1H2N14S','Vario 125','Matic','Honda',13500000,'assets/images/motor/icon.png','/assets/images//assets/images/motor/icon.png','1',NULL,6,NULL,NULL,'2016-12-24 22:20:20',NULL),(606,'H5C2R2M1','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(641,'EF02N12S','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(790,'H5C2R2MB','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(800,'AFP12W08','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL),(893,'NFT13C02','unknow-name','unknown-varian','unknown-merk',0,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `m_motor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_objective`
--

DROP TABLE IF EXISTS `m_objective`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_objective` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `objective` varchar(200) DEFAULT NULL,
  `objective_status` int(2) DEFAULT '1' COMMENT '1=>active,2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_objective`
--

LOCK TABLES `m_objective` WRITE;
/*!40000 ALTER TABLE `m_objective` DISABLE KEYS */;
INSERT INTO `m_objective` VALUES (1,'Order',1,1,NULL,NULL,'2017-04-09 21:00:09',NULL,NULL),(2,'Kirim',1,1,NULL,NULL,'2017-04-09 21:00:13',NULL,NULL),(3,'Canvas',1,1,NULL,NULL,'2017-04-09 21:00:15',NULL,NULL);
/*!40000 ALTER TABLE `m_objective` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_payment_type`
--

DROP TABLE IF EXISTS `m_payment_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(100) DEFAULT NULL,
  `payment_type_description` text,
  `payment_type_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not_active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_payment_type`
--

LOCK TABLES `m_payment_type` WRITE;
/*!40000 ALTER TABLE `m_payment_type` DISABLE KEYS */;
INSERT INTO `m_payment_type` VALUES (1,'CBD','Cash Before Delivery',1,1,NULL,NULL,'2017-04-09 09:36:18',NULL,NULL),(2,'COD','Cash On Delivery',1,1,NULL,NULL,'2017-04-09 09:36:18',NULL,NULL),(3,'Termin','Termin',1,1,NULL,NULL,'2017-04-09 09:36:18',NULL,NULL);
/*!40000 ALTER TABLE `m_payment_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_product`
--

DROP TABLE IF EXISTS `m_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_product_category` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `product_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_product`
--

LOCK TABLES `m_product` WRITE;
/*!40000 ALTER TABLE `m_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_product_category`
--

DROP TABLE IF EXISTS `m_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category` varchar(100) DEFAULT NULL,
  `product_status_category_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_product_category`
--

LOCK TABLES `m_product_category` WRITE;
/*!40000 ALTER TABLE `m_product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `status` enum('1','2') DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`) USING BTREE,
  CONSTRAINT `fkmenuparentid` FOREIGN KEY (`parent`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,NULL,'-','Master','fa fa-home','javascript:void(0);',1,'1'),(2,NULL,'-','Transaction','fa fa-edit','javascript:void(0);',3,'1'),(3,NULL,'-','Report','fa fa-tasks','javascript:void(0);',4,'1'),(23,1,'md_employee','Master Employee','fa fa-circle','master-employee',1,'1'),(24,1,'md_level','Master Emp.Level','fa fa-circle','master-level',2,'1'),(26,1,'md_product','Master Product','fa fa-circle','master-product',3,'1'),(27,1,'md_product_category','Master Prd.Category','fa fa-circle','master-product-category',4,'1'),(28,1,'md_payment_type','Master Pay.Type','fa fa-circle','master-payment-type',5,'1'),(29,1,'md_customer','Master Customer','fa fa-circle','master-customer',6,'1'),(32,47,'t_visting','Customer List','fa fa-circle','visit-activity',3,'1'),(33,47,'t_activity','Master List','fa fa-circle','sales-activity',4,'1'),(34,2,'t_sales_order','Sales Order','fa fa-circle','sales-order',1,'1'),(36,1,'account','Users Management','fa fa-circle','user-management',9,'1'),(45,2,'t_sales_delivery','Sales Delivery','fa fa-circle','sales-delivery',2,'1'),(46,2,'t_invoice','Invoice','fa fa-circle','invoice',3,'1'),(47,NULL,'-','Activity','fa fa-home','javascript:void(0);',2,'1'),(48,47,'t_ojt','OJT','fa fa-circle','ojt',5,'1'),(49,47,'t_mapping_area','Mapping Area','fa fa-circle','mapping-area',1,'1'),(50,47,'t_mapping_product','Mapping Product','fa fa-circle','mapping-product',2,'1'),(51,47,'t_master_priority','Master List Priority','fa fa-circle','master-list-priority',6,'1'),(52,2,'t_status_transaksi','Status Transksi','fa fa-circle','status-transaksi',5,'1'),(53,3,'r_report','All Report','fa fa-circle','All Report',1,'1');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `source_lead_customer`
--

DROP TABLE IF EXISTS `source_lead_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `source_lead_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_lead_customer` varchar(100) DEFAULT NULL,
  `source_lead_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `source_lead_customer`
--

LOCK TABLES `source_lead_customer` WRITE;
/*!40000 ALTER TABLE `source_lead_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `source_lead_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_lead_customer`
--

DROP TABLE IF EXISTS `status_lead_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_lead_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_lead_customer` varchar(100) DEFAULT NULL,
  `source_lead_customer_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_lead_customer`
--

LOCK TABLES `status_lead_customer` WRITE;
/*!40000 ALTER TABLE `status_lead_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `status_lead_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_meeting`
--

DROP TABLE IF EXISTS `t_meeting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meeting_subject` varchar(200) DEFAULT NULL,
  `meeting_staff` int(11) DEFAULT NULL,
  `meeting_attendence` int(11) DEFAULT NULL,
  `meeting_start_date` date DEFAULT NULL,
  `meeting_end_date` date DEFAULT NULL,
  `meeting_location` text,
  `meeting_activity` int(11) DEFAULT NULL,
  `meeting_description` text,
  `meeting_objective` int(11) DEFAULT NULL,
  `meeting_status` int(2) DEFAULT '1' COMMENT '1=>active,2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meeting_activity` (`meeting_activity`),
  KEY `fk_meeting_objective` (`meeting_objective`),
  CONSTRAINT `fk_meeting_activity` FOREIGN KEY (`meeting_activity`) REFERENCES `m_activity` (`id`),
  CONSTRAINT `fk_meeting_objective` FOREIGN KEY (`meeting_objective`) REFERENCES `m_objective` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_meeting`
--

LOCK TABLES `t_meeting` WRITE;
/*!40000 ALTER TABLE `t_meeting` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_meeting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_sales_order`
--

DROP TABLE IF EXISTS `t_sales_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_sales_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `so_code` varchar(30) DEFAULT NULL,
  `id_customer` int(11) DEFAULT NULL,
  `so_date` date DEFAULT NULL,
  `so_payment_term` int(11) DEFAULT NULL,
  `so_discount_type` enum('Percent','Fixed') DEFAULT 'Percent',
  `so_discount_value` float DEFAULT NULL,
  `so_signature` text,
  `so_status` int(2) DEFAULT '1' COMMENT '1=>active,2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payment_type` (`so_payment_term`),
  CONSTRAINT `fk_payment_type` FOREIGN KEY (`so_payment_term`) REFERENCES `m_payment_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_sales_order`
--

LOCK TABLES `t_sales_order` WRITE;
/*!40000 ALTER TABLE `t_sales_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_sales_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_sales_order_detail`
--

DROP TABLE IF EXISTS `t_sales_order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_sales_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `so_code` varchar(30) DEFAULT NULL,
  `product_so_detail` int(11) DEFAULT NULL,
  `qty_so_detail` float DEFAULT NULL,
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_sales_order_detail`
--

LOCK TABLES `t_sales_order_detail` WRITE;
/*!40000 ALTER TABLE `t_sales_order_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_sales_order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_visit_activity`
--

DROP TABLE IF EXISTS `t_visit_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_visit_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visit_date_plan` date DEFAULT NULL,
  `visit_doctor_name` varchar(50) DEFAULT NULL,
  `visit_assistant_name` varchar(50) DEFAULT NULL,
  `visit_notes` text,
  `user_id` int(11) DEFAULT NULL,
  `order_id` varchar(10) DEFAULT NULL,
  `id_activity` int(11) DEFAULT NULL,
  `visit_date_actual` datetime DEFAULT NULL,
  `visit_signature` text,
  `visit_longitude` text,
  `visit_latitude` text,
  `visit_status` int(2) DEFAULT '1' COMMENT '1=>active, 2=>not active',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activity` (`id_activity`),
  CONSTRAINT `fk_activity` FOREIGN KEY (`id_activity`) REFERENCES `m_activity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_visit_activity`
--

LOCK TABLES `t_visit_activity` WRITE;
/*!40000 ALTER TABLE `t_visit_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_visit_activity` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-15  0:07:08
