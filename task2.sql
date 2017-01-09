/*
Navicat MySQL Data Transfer

Source Server         : LOCALE
Source Server Version : 50546
Source Host           : 192.168.56.101:3306
Source Database       : task2

Target Server Type    : MYSQL
Target Server Version : 50546
File Encoding         : 65001

Date: 2017-01-09 15:35:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `doctors`
-- ----------------------------
DROP TABLE IF EXISTS `doctors`;
CREATE TABLE `doctors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(11) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of doctors
-- ----------------------------
INSERT INTO `doctors` VALUES ('37', 'Терапевт');
INSERT INTO `doctors` VALUES ('39', 'Хирург');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` enum('patient','doctor','admin') NOT NULL,
  `status` varchar(10) NOT NULL,
  `activation_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('36', 'Николай Громов', '', 'admin@local', 'admin', 'OK', '0bc5d6ed73d193587ebcf7aeda081fe4');
INSERT INTO `users` VALUES ('37', 'Руслан Волков', '', 'doctor@local', 'doctor', 'OK', 'f4224d6bc10845f9fdd081381440f1a4');
INSERT INTO `users` VALUES ('38', 'Зарина Зимина', '', 'patient@local', 'patient', 'OK', '');
INSERT INTO `users` VALUES ('39', 'Василий Еремеев', '', 'doctor@local', 'doctor', 'OK', '');
INSERT INTO `users` VALUES ('40', 'Николай Петров', '', 'patient@local', 'patient', 'OK', '');

-- ----------------------------
-- Table structure for `visiting`
-- ----------------------------
DROP TABLE IF EXISTS `visiting`;
CREATE TABLE `visiting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(10) NOT NULL,
  `patient_id` int(10) NOT NULL,
  `status` enum('Закрыт','Ожидание') NOT NULL,
  `date` datetime NOT NULL,
  `notice` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of visiting
-- ----------------------------
INSERT INTO `visiting` VALUES ('1', '37', '36', 'Закрыт', '2017-01-18 12:34:00', 'Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне.');
INSERT INTO `visiting` VALUES ('2', '37', '36', 'Закрыт', '2017-01-09 20:00:00', 'Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне.');
INSERT INTO `visiting` VALUES ('4', '37', '38', 'Закрыт', '2017-01-09 20:00:00', 'Запись №4');
INSERT INTO `visiting` VALUES ('5', '37', '38', 'Ожидание', '2017-01-18 20:00:00', '');
INSERT INTO `visiting` VALUES ('6', '37', '38', '', '2017-01-06 15:00:00', '');
INSERT INTO `visiting` VALUES ('7', '37', '38', 'Закрыт', '2017-01-13 20:20:00', '');
INSERT INTO `visiting` VALUES ('24', '39', '38', 'Закрыт', '2017-01-05 10:00:00', '');
INSERT INTO `visiting` VALUES ('25', '37', '40', 'Закрыт', '2017-01-03 15:00:00', 'Новое примечание');
