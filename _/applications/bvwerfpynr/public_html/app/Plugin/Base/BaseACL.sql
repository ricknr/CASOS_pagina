/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : quantto

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-08 18:26:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for acos
-- ----------------------------
DROP TABLE IF EXISTS `acos`;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`),
  KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of acos
-- ----------------------------
INSERT INTO `acos` VALUES ('1', null, null, null, 'controllers', '1', '60');
INSERT INTO `acos` VALUES ('2', '1', null, null, 'Pages', '56', '59');
INSERT INTO `acos` VALUES ('3', '2', null, null, 'display', '57', '58');
INSERT INTO `acos` VALUES ('4', '1', null, null, 'AclExtras', '2', '3');
INSERT INTO `acos` VALUES ('5', '1', null, null, 'Base', '4', '55');
INSERT INTO `acos` VALUES ('6', '5', null, null, 'Acos', '5', '16');
INSERT INTO `acos` VALUES ('7', '6', null, null, 'admin_index', '12', '13');
INSERT INTO `acos` VALUES ('8', '6', null, null, 'admin_view', '14', '15');
INSERT INTO `acos` VALUES ('9', '6', null, null, 'admin_add', '6', '7');
INSERT INTO `acos` VALUES ('10', '6', null, null, 'admin_edit', '10', '11');
INSERT INTO `acos` VALUES ('11', '6', null, null, 'admin_delete', '8', '9');
INSERT INTO `acos` VALUES ('12', '5', null, null, 'Grupos', '17', '32');
INSERT INTO `acos` VALUES ('13', '12', null, null, 'admin_index', '26', '27');
INSERT INTO `acos` VALUES ('14', '12', null, null, 'admin_view', '30', '31');
INSERT INTO `acos` VALUES ('15', '12', null, null, 'admin_add', '18', '19');
INSERT INTO `acos` VALUES ('16', '12', null, null, 'admin_edit', '24', '25');
INSERT INTO `acos` VALUES ('17', '12', null, null, 'admin_delete', '20', '21');
INSERT INTO `acos` VALUES ('18', '5', null, null, 'Usuarios', '33', '54');
INSERT INTO `acos` VALUES ('19', '18', null, null, 'login', '46', '47');
INSERT INTO `acos` VALUES ('20', '18', null, null, 'logout', '48', '49');
INSERT INTO `acos` VALUES ('21', '18', null, null, 'code', '42', '43');
INSERT INTO `acos` VALUES ('22', '18', null, null, 'recover', '50', '51');
INSERT INTO `acos` VALUES ('23', '18', null, null, 'view', '52', '53');
INSERT INTO `acos` VALUES ('24', '18', null, null, 'edit_password', '44', '45');
INSERT INTO `acos` VALUES ('25', '18', null, null, 'admin_index', '40', '41');
INSERT INTO `acos` VALUES ('26', '18', null, null, 'admin_add', '34', '35');
INSERT INTO `acos` VALUES ('27', '18', null, null, 'admin_edit', '38', '39');
INSERT INTO `acos` VALUES ('28', '18', null, null, 'admin_delete', '36', '37');
INSERT INTO `acos` VALUES ('33', '12', null, null, 'admin_permitir', '28', '29');
INSERT INTO `acos` VALUES ('34', '12', null, null, 'admin_denegar', '22', '23');

-- ----------------------------
-- Table structure for aros
-- ----------------------------
DROP TABLE IF EXISTS `aros`;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`),
  KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of aros
-- ----------------------------
INSERT INTO `aros` VALUES ('1', null, 'Grupo', '1', null, '1', '2');
INSERT INTO `aros` VALUES ('2', null, 'Grupo', '2', null, '3', '4');

-- ----------------------------
-- Table structure for aros_acos
-- ----------------------------
DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_read` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_update` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `_delete` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`),
  KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of aros_acos
-- ----------------------------
INSERT INTO `aros_acos` VALUES ('1', '1', '1', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('2', '2', '12', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('3', '2', '34', '-1', '-1', '-1', '-1');
INSERT INTO `aros_acos` VALUES ('4', '2', '33', '-1', '-1', '-1', '-1');
INSERT INTO `aros_acos` VALUES ('5', '2', '23', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('6', '2', '24', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('7', '2', '25', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('8', '2', '26', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('9', '2', '27', '1', '1', '1', '1');
INSERT INTO `aros_acos` VALUES ('10', '2', '28', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES ('1', 'dev');
INSERT INTO `grupos` VALUES ('2', 'admin');

-- ----------------------------
-- Table structure for recoveres
-- ----------------------------
DROP TABLE IF EXISTS `recoveres`;
CREATE TABLE `recoveres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` varchar(36) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `code` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of recoveres
-- ----------------------------

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `usuario` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', '1', 'Equipo de desarrollo', 'dev', '5a9835c851930cab305930768ddf435655c5bdfe0f0c0e2439c5e1beee529e6e', 'dev@dev.com', '1');
INSERT INTO `usuarios` VALUES ('2', '2', 'Admin', 'admin', 'ea24c574595c6f28abd6a2c7ffaad0ca589fd44f9cfd6d1a09e1ced545bdc904', 'admin@admin.com', '1');
INSERT INTO `usuarios` VALUES ('3', '2', 'luis lozano', 'luis-lozano', '938ca458c1b852e9953ebf94ee90f24e5569d8e0bd24e7cd18dcc808182da9d7', 'luis.lozano@bisso.mx', '1');
