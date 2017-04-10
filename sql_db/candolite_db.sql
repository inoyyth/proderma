/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50620
Source Host           : localhost:3306
Source Database       : candolite_db

Target Server Type    : MYSQL
Target Server Version : 50620
File Encoding         : 65001

Date: 2016-11-06 14:05:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `password` varchar(1000) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `path_foto` varchar(255) DEFAULT NULL,
  `access_menu` text,
  `token` text,
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime NOT NULL,
  `sys_update_date` datetime NOT NULL,
  `sys_delete_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `status` enum('1','2') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('6', 'inoy@sportix.com', 'inoy YTH', 'KabibatOT8vCt3pmqwyg11pCrU~A4Uvao374MdetKgoHkfNbbJKUBRXDWHib8AMTwCQ3F5FJCvBnn~~I2fkMpA--', '67676', 'supri170845@gmail.com', 'assets/images/account/044373c973cec18499a2b7c71525595e.jpg', 'a:13:{i:0;a:3:{s:4:\"menu\";s:2:\"23\";s:4:\"slug\";s:14:\"master-jabatan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:1;a:3:{s:4:\"menu\";s:2:\"24\";s:4:\"slug\";s:15:\"master-karyawan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:2;a:3:{s:4:\"menu\";s:2:\"26\";s:4:\"slug\";s:15:\"master-customer\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:3;a:3:{s:4:\"menu\";s:2:\"27\";s:4:\"slug\";s:12:\"master-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:4;a:3:{s:4:\"menu\";s:2:\"28\";s:4:\"slug\";s:16:\"master-aksesoris\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:5;a:3:{s:4:\"menu\";s:2:\"29\";s:4:\"slug\";s:13:\"master-gudang\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:6;a:3:{s:4:\"menu\";s:2:\"30\";s:4:\"slug\";s:14:\"master-leasing\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:7;a:3:{s:4:\"menu\";s:2:\"31\";s:4:\"slug\";s:15:\"master-supplier\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:8;a:3:{s:4:\"menu\";s:2:\"36\";s:4:\"slug\";s:15:\"user-management\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:9;a:3:{s:4:\"menu\";s:2:\"32\";s:4:\"slug\";s:9:\"penjualan\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:10;a:3:{s:4:\"menu\";s:2:\"33\";s:4:\"slug\";s:10:\"pembayaran\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:11;a:3:{s:4:\"menu\";s:2:\"34\";s:4:\"slug\";s:12:\"return-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:12;a:3:{s:4:\"menu\";s:2:\"35\";s:4:\"slug\";s:3:\"pdi\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}}', '7PjiZaV7dxYGob9IDlm2VnFTCCzc3B6c20Y4G~3oiyCCTxHShsLPRhuBnzVJPUjyB62KyNYa7k0zub2d7ScEYg--', null, '6', null, '0000-00-00 00:00:00', '2016-11-06 00:37:36', '0000-00-00 00:00:00', '2016-11-05 23:16:12', '1');
INSERT INTO `account` VALUES ('7', 'sapta@gmail.com', 'Sapta', 'GsMxDWTIw95OSkBGV7MjIrA4muCNpIzN9Mm74/Z92hYzlyKeoHtM3Z5u2bAi/UVKTplMlUztEy4wXAI2aHnOYw==', '879979797979', 'supri170845@gmail.com', '667fa1e720b199d98293f0eec4086ebe.jpg', 'a:10:{i:0;a:3:{s:4:\"menu\";s:2:\"23\";s:4:\"slug\";s:14:\"master-jabatan\";s:5:\"child\";a:4:{s:3:\"add\";i:0;s:3:\"upd\";i:0;s:3:\"del\";i:0;s:3:\"prt\";i:1;}}i:1;a:3:{s:4:\"menu\";s:2:\"24\";s:4:\"slug\";s:15:\"master-karyawan\";s:5:\"child\";a:4:{s:3:\"add\";i:0;s:3:\"upd\";i:0;s:3:\"del\";i:0;s:3:\"prt\";i:1;}}i:2;a:3:{s:4:\"menu\";s:2:\"26\";s:4:\"slug\";s:15:\"master-customer\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:3;a:3:{s:4:\"menu\";s:2:\"27\";s:4:\"slug\";s:12:\"master-motor\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:0;s:3:\"prt\";i:1;}}i:4;a:3:{s:4:\"menu\";s:2:\"28\";s:4:\"slug\";s:16:\"master-aksesoris\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:5;a:3:{s:4:\"menu\";s:2:\"29\";s:4:\"slug\";s:13:\"master-gudang\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:6;a:3:{s:4:\"menu\";s:2:\"30\";s:4:\"slug\";s:14:\"master-leasing\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:7;a:3:{s:4:\"menu\";s:2:\"31\";s:4:\"slug\";s:15:\"master-supplier\";s:5:\"child\";a:4:{s:3:\"add\";i:1;s:3:\"upd\";i:1;s:3:\"del\";i:1;s:3:\"prt\";i:1;}}i:8;a:3:{s:4:\"menu\";s:2:\"32\";s:4:\"slug\";s:9:\"penjualan\";s:5:\"child\";a:4:{s:3:\"add\";i:0;s:3:\"upd\";i:0;s:3:\"del\";i:0;s:3:\"prt\";i:0;}}i:9;a:3:{s:4:\"menu\";s:2:\"33\";s:4:\"slug\";s:10:\"pembayaran\";s:5:\"child\";a:4:{s:3:\"add\";i:0;s:3:\"upd\";i:0;s:3:\"del\";i:0;s:3:\"prt\";i:0;}}}', null, null, '1', null, '0000-00-00 00:00:00', '2016-10-26 01:27:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');
INSERT INTO `account` VALUES ('9', '', '', '7pMEMyy14A5H~4NO.x6pDL6Fvfr.PeqjBVsvPyT1gQagUVLUPLgXt0LfrNcK9nm.7QUZC.rNBwEW15lnsp1AjQ--', '', '', 'assets/images/account/user_icon.png', 'a:0:{}', null, '6', null, null, '2016-11-05 07:52:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');

-- ----------------------------
-- Table structure for `global_data`
-- ----------------------------
DROP TABLE IF EXISTS `global_data`;
CREATE TABLE `global_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_data` varchar(50) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  `global_data_status` enum('1','2','3') DEFAULT NULL COMMENT '1(Aktif), 2(In-Aktif), 3(Delete)',
  `sys_create_user` int(11) DEFAULT NULL,
  `sys_update_user` int(11) DEFAULT NULL,
  `sys_delete_user` int(11) DEFAULT NULL,
  `sys_create_date` datetime DEFAULT NULL,
  `sys_update_date` datetime DEFAULT NULL,
  `sys_delete_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of global_data
-- ----------------------------
INSERT INTO `global_data` VALUES ('1', 'aksesoris', 'aki', '1', null, null, null, null, null, null);
INSERT INTO `global_data` VALUES ('2', 'aksesoris', 'spion', '1', null, null, null, null, null, null);
INSERT INTO `global_data` VALUES ('3', 'aksesoris', 'helm', '1', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
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
  CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menus
-- ----------------------------
INSERT INTO `menus` VALUES ('1', null, '-', 'Commerce', 'fa fa-home', 'javascript:void(0);', '1', '2');
INSERT INTO `menus` VALUES ('2', null, '-', 'Blog', 'fa fa-edit', 'javascript:void(0);', '2', '2');
INSERT INTO `menus` VALUES ('3', null, '-', 'Inventory', 'fa fa-tasks', 'javascript:void(0);', '3', '2');
INSERT INTO `menus` VALUES ('4', null, '-', 'Leasing', 'fa fa-users', 'javascript:void(0);', '4', '2');
INSERT INTO `menus` VALUES ('5', null, '-', 'Laporan', 'fa fa-envelope', 'javascript:void(0);', '5', '2');
INSERT INTO `menus` VALUES ('23', '1', 'md_jabatan', 'Product Category', '', 'product-category', '1', '2');
INSERT INTO `menus` VALUES ('24', '1', 'md_karyawan', 'Product Brand', '', 'product-brand', '2', '2');
INSERT INTO `menus` VALUES ('26', '1', 'md_customer', 'Product List', '', 'product-list', '3', '2');
INSERT INTO `menus` VALUES ('27', '1', 'md_motor', 'Master Motor', '', 'master-motor', '4', '2');
INSERT INTO `menus` VALUES ('28', '1', 'md_aksesoris', 'Master Aksesoris', '', 'master-aksesoris', '5', '2');
INSERT INTO `menus` VALUES ('29', '1', 'md_gudang', 'Master Gudang', '', 'master-gudang', '6', '2');
INSERT INTO `menus` VALUES ('30', '1', 'md_leasing', 'Master Leasing', '', 'master-leasing', '7', '2');
INSERT INTO `menus` VALUES ('32', '2', 'penjualan', 'Penjualan', '', 'penjualan', '1', '2');
INSERT INTO `menus` VALUES ('33', '2', 'pembayaran', 'Pembayaran', '', 'pembayaran', '2', '2');
INSERT INTO `menus` VALUES ('34', '3', 'retur_motor', 'Retur Motor', '', 'return-motor', '1', '2');
INSERT INTO `menus` VALUES ('35', '3', 'pdi', 'PDI', '', 'pdi', '3', '2');
INSERT INTO `menus` VALUES ('36', '1', 'account', 'Users Management', '', 'user-management', '8', '2');
