/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50538
 Source Host           : localhost
 Source Database       : base_v2

 Target Server Type    : MySQL
 Target Server Version : 50538
 File Encoding         : utf-8

 Date: 09/11/2017 19:44:10 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `acos`
-- ----------------------------
DROP TABLE IF EXISTS `acos`;
CREATE TABLE `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_acos_lft_rght` (`lft`,`rght`) COMMENT '(null)',
  KEY `idx_acos_alias` (`alias`) COMMENT '(null)'
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `acos`
-- ----------------------------
BEGIN;
INSERT INTO `acos` VALUES ('1', null, null, null, 'controllers', '1', '60'), ('36', '1', null, null, 'AclExtras', '2', '3'), ('37', '1', null, null, 'Base', '4', '59'), ('38', '37', null, null, 'Acos', '5', '16'), ('39', '38', null, null, 'admin_index', '6', '7'), ('40', '38', null, null, 'admin_view', '8', '9'), ('41', '38', null, null, 'admin_add', '10', '11'), ('42', '38', null, null, 'admin_edit', '12', '13'), ('43', '38', null, null, 'admin_delete', '14', '15'), ('45', '37', null, null, 'Grupos', '17', '32'), ('46', '45', null, null, 'admin_index', '18', '19'), ('47', '45', null, null, 'admin_view', '20', '21'), ('48', '45', null, null, 'admin_add', '22', '23'), ('49', '45', null, null, 'admin_edit', '24', '25'), ('50', '45', null, null, 'admin_delete', '26', '27'), ('51', '45', null, null, 'admin_permitir', '28', '29'), ('52', '45', null, null, 'admin_denegar', '30', '31'), ('54', '37', null, null, 'Usuarios', '33', '58'), ('55', '54', null, null, 'login', '34', '35'), ('56', '54', null, null, 'logout', '36', '37'), ('57', '54', null, null, 'code', '38', '39'), ('58', '54', null, null, 'recover', '40', '41'), ('59', '54', null, null, 'view', '42', '43'), ('60', '54', null, null, 'edit_password', '44', '45'), ('61', '54', null, null, 'admin_index', '46', '47'), ('62', '54', null, null, 'admin_add', '48', '49'), ('63', '54', null, null, 'admin_edit', '50', '51'), ('64', '54', null, null, 'admin_delete', '52', '53'), ('65', '54', null, null, 'createsessionbar', '54', '55'), ('74', '54', null, null, 'admin_change_password', '56', '57');
COMMIT;

-- ----------------------------
--  Table structure for `aros`
-- ----------------------------
DROP TABLE IF EXISTS `aros`;
CREATE TABLE `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_aros_lft_rght` (`lft`,`rght`) COMMENT '(null)',
  KEY `idx_aros_alias` (`alias`) COMMENT '(null)'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `aros`
-- ----------------------------
BEGIN;
INSERT INTO `aros` VALUES ('1', null, 'Grupo', '1', null, '1', '2'), ('3', null, 'Grupo', '2', null, '3', '4');
COMMIT;

-- ----------------------------
--  Table structure for `aros_acos`
-- ----------------------------
DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`) COMMENT '(null)',
  KEY `idx_aco_id` (`aco_id`) COMMENT '(null)'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `aros_acos`
-- ----------------------------
BEGIN;
INSERT INTO `aros_acos` VALUES ('1', '1', '1', '1', '1', '1', '1'), ('14', '3', '54', '1', '1', '1', '1');
COMMIT;

-- ----------------------------
--  Table structure for `grupos`
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) DEFAULT NULL,
  `redirect` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `grupos`
-- ----------------------------
BEGIN;
INSERT INTO `grupos` VALUES ('1', 'Dev', '/admin/base/usuarios/', '1'), ('2', 'Administrador', '/admin/base/usuarios/', '1');
COMMIT;

-- ----------------------------
--  Table structure for `recoveres`
-- ----------------------------
DROP TABLE IF EXISTS `recoveres`;
CREATE TABLE `recoveres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`) COMMENT '(null)',
  CONSTRAINT `recoveres_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `proveedor_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `password_show` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `usuarios`
-- ----------------------------
BEGIN;
INSERT INTO `usuarios` VALUES ('1', '1', 'dev', 'dev', '12874e432b2dfb97c8533acc997e2ccfcf06c948e9057ee694fbbde6eaa0d79e', 'hvillasana@bisso.mx', '1', null, '2015-12-22 12:31:06', '2016-11-09 13:21:35', 'oeg03yoh');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
