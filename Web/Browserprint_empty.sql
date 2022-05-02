/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 80023
Source Host           : localhost:3306
Source Database       : ttt

Target Server Type    : MYSQL
Target Server Version : 80023
File Encoding         : 65001

Date: 2022-05-02 08:31:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of admin
-- ----------------------------

-- ----------------------------
-- Table structure for `bugreport`
-- ----------------------------
DROP TABLE IF EXISTS `bugreport`;
CREATE TABLE `bugreport` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `category` int NOT NULL,
  `message` varchar(255) NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bugreport
-- ----------------------------

-- ----------------------------
-- Table structure for `buy_log`
-- ----------------------------
DROP TABLE IF EXISTS `buy_log`;
CREATE TABLE `buy_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `productId` int NOT NULL,
  `virtualCurrency` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `refId` varchar(255) NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of buy_log
-- ----------------------------

-- ----------------------------
-- Table structure for `demo_ip`
-- ----------------------------
DROP TABLE IF EXISTS `demo_ip`;
CREATE TABLE `demo_ip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `used` int NOT NULL DEFAULT '0',
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of demo_ip
-- ----------------------------

-- ----------------------------
-- Table structure for `feedback`
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(50) NOT NULL,
  `reciver` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `feedbackdata` varchar(500) NOT NULL,
  `attachment` varchar(50) DEFAULT NULL,
  `answered` int NOT NULL DEFAULT '0',
  `answer_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `free_ip`
-- ----------------------------
DROP TABLE IF EXISTS `free_ip`;
CREATE TABLE `free_ip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `used` int NOT NULL DEFAULT '0',
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of free_ip
-- ----------------------------

-- ----------------------------
-- Table structure for `krake`
-- ----------------------------
DROP TABLE IF EXISTS `krake`;
CREATE TABLE `krake` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project` int NOT NULL,
  `browser` varchar(255) NOT NULL DEFAULT '-',
  `os` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1673 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of krake
-- ----------------------------

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL DEFAULT '',
  `Description` longtext NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for `notification`
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notiuser` varchar(50) NOT NULL,
  `notireciver` varchar(50) NOT NULL,
  `notitype` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=543 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notification
-- ----------------------------

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '-',
  `website` varchar(999) NOT NULL,
  `type` int NOT NULL,
  `idents` int NOT NULL DEFAULT '100',
  `save_ip_data` int NOT NULL DEFAULT '0',
  `save_fp_data` int NOT NULL DEFAULT '0',
  `subscribe_until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of project
-- ----------------------------

-- ----------------------------
-- Table structure for `pub_proxy`
-- ----------------------------
DROP TABLE IF EXISTS `pub_proxy`;
CREATE TABLE `pub_proxy` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `port` int NOT NULL,
  `scan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=489091 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of pub_proxy
-- ----------------------------

-- ----------------------------
-- Table structure for `save_fp`
-- ----------------------------
DROP TABLE IF EXISTS `save_fp`;
CREATE TABLE `save_fp` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `data` longtext,
  `active_save` int NOT NULL DEFAULT '0',
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=938 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of save_fp
-- ----------------------------

-- ----------------------------
-- Table structure for `save_ip`
-- ----------------------------
DROP TABLE IF EXISTS `save_ip`;
CREATE TABLE `save_ip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int NOT NULL,
  `data` longtext,
  `active_save` int NOT NULL DEFAULT '0',
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2154 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of save_ip
-- ----------------------------

-- ----------------------------
-- Table structure for `tbar_cate`
-- ----------------------------
DROP TABLE IF EXISTS `tbar_cate`;
CREATE TABLE `tbar_cate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sort` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `sname` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(999) NOT NULL,
  `needlogin` int DEFAULT '0',
  `visible` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbar_cate
-- ----------------------------
INSERT INTO `tbar_cate` VALUES ('1', '0', 'Dashboard', 'index', null, '<i class=\"fas fa-home\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('7', '1', 'News', 'news', 'news', '<i class=\"fab fa-neos\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('8', '3', 'IP Research', 'ip', 'ip', '<i class=\"fas fa-search\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('9', '6', 'Tor List', 'tor', 'tor', '<i class=\"fas fa-mask\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('10', '2', 'Fingerprinting', 'fp', 'fp', '<i class=\"fas fa-fingerprint\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('11', '4', 'Free API', 'free', 'free', '<i class=\"fas fa-lock-open\"></i>', '0', '1');
INSERT INTO `tbar_cate` VALUES ('12', '5', 'WhoIS', 'whois', 'whois', '<i class=\"fas fa-question\"></i>', '0', '1');

-- ----------------------------
-- Table structure for `tbar_subcate`
-- ----------------------------
DROP TABLE IF EXISTS `tbar_subcate`;
CREATE TABLE `tbar_subcate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subsideid` int NOT NULL DEFAULT '0',
  `cate` int NOT NULL,
  `sort` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `needlogin` int NOT NULL DEFAULT '0',
  `visible` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbar_subcate
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `dispname` varchar(50) NOT NULL,
  `utype` int NOT NULL DEFAULT '0',
  `token` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `subscription_until` timestamp NOT NULL DEFAULT '2020-01-01 09:00:00',
  `package` int NOT NULL DEFAULT '0',
  `currency` int NOT NULL DEFAULT '0',
  `deleted` int NOT NULL DEFAULT '0',
  `deltime` timestamp NULL DEFAULT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for `user_activate`
-- ----------------------------
DROP TABLE IF EXISTS `user_activate`;
CREATE TABLE `user_activate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `hash` varchar(255) NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_activate
-- ----------------------------

-- ----------------------------
-- Table structure for `whois`
-- ----------------------------
DROP TABLE IF EXISTS `whois`;
CREATE TABLE `whois` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ipf` varchar(255) NOT NULL,
  `ipt` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `asn` varchar(255) NOT NULL,
  `str` varchar(9999) NOT NULL,
  `dDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of whois
-- ----------------------------
