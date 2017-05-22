/*
Navicat MySQL Data Transfer

Source Server         : PaP
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : pap

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-05-17 21:49:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `avaliacoes`
-- ----------------------------
DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE `avaliacoes` (
  `id_avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `n_avaliacoes` int(11),
  `n_avaliacoesRep` int(11),
  `nivelReputacao` decimal(3,1) DEFAULT '0.0',
  `nivelPericia` decimal(3,1) DEFAULT '0.0',
  `id_utilizador` int(11) DEFAULT NULL,
  `id_jogo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `id_utilizador` (`id_utilizador`),
  KEY `avaliacoes_id_jogo_index` (`id_jogo`),
  CONSTRAINT `avaliacoes_utilizadores_id_utilizador_fk` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of avaliacoes
-- ----------------------------
INSERT INTO `avaliacoes` VALUES ('1', '1', '1', '3.0', '9.9', '1', '730');
INSERT INTO `avaliacoes` VALUES ('6', '2', '1', '8.0', '4.0', '3', '730');

-- ----------------------------
-- Table structure for `categorias`
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `Nome` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`Nome`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES ('');
INSERT INTO `categorias` VALUES ('Dica/Ajudas');
INSERT INTO `categorias` VALUES ('Duvida');
INSERT INTO `categorias` VALUES ('Problema');
INSERT INTO `categorias` VALUES ('Site de apostas');

-- ----------------------------
-- Table structure for `chatbox`
-- ----------------------------
DROP TABLE IF EXISTS `chatbox`;
CREATE TABLE `chatbox` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(11) DEFAULT NULL,
  `text` text,
  `data_hora_enviada` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of chatbox
-- ----------------------------
INSERT INTO `chatbox` VALUES ('4', 'IceN', 'Como vai isso?', '12/02/2017 23:15');
INSERT INTO `chatbox` VALUES ('6', 'IceN', 'ola', '13-02-2017 22:06');
INSERT INTO `chatbox` VALUES ('7', 'IceN', 'boas!', '13-02-2017 22:06');
INSERT INTO `chatbox` VALUES ('13', 'IceN', 'teste', '13-02-2017 22:47');
INSERT INTO `chatbox` VALUES ('19', 'teste', 'top', '13-02-2017 22:57');
INSERT INTO `chatbox` VALUES ('24', 'teste', 'Yoh', '13-02-2017 23:24');
INSERT INTO `chatbox` VALUES ('31', 'IceN', 'Vai bem', '17-05-2017 20:06');
INSERT INTO `chatbox` VALUES ('32', 'IceN', 'Teste', '17-05-2017 20:06');

-- ----------------------------
-- Table structure for `convites`
-- ----------------------------
DROP TABLE IF EXISTS `convites`;
CREATE TABLE `convites` (
  `id_Convite` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(20) DEFAULT NULL,
  `dataConvite` varchar(150) DEFAULT NULL,
  `id_utilizadorConvidado` int(11) DEFAULT NULL,
  `id_utilizador` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_Convite`),
  KEY `id_utilizador` (`id_utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of convites
-- ----------------------------
INSERT INTO `convites` VALUES ('19', 'Recusado', '17-04-2017 13:03', '1', '2');
INSERT INTO `convites` VALUES ('20', 'Aceite', '17-04-2017 13:06', '2', '1');
INSERT INTO `convites` VALUES ('21', 'Pendente', '14-05-2017 23:47', '3', '1');

-- ----------------------------
-- Table structure for `definicoes`
-- ----------------------------
DROP TABLE IF EXISTS `definicoes`;
CREATE TABLE `definicoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manutencao` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of definicoes
-- ----------------------------
INSERT INTO `definicoes` VALUES ('1', '1');

-- ----------------------------
-- Table structure for `denuncias`
-- ----------------------------
DROP TABLE IF EXISTS `denuncias`;
CREATE TABLE `denuncias` (
  `ID_UtilizadorQueixoso` int(11) NOT NULL,
  `ID_UtilizadorDenunciado` int(11) NOT NULL,
  `Texto` text NOT NULL,
  `ID_Denuncia` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  PRIMARY KEY (`ID_Denuncia`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of denuncias
-- ----------------------------
INSERT INTO `denuncias` VALUES ('1', '2', 'denuncia', '1', '2017-05-11');
INSERT INTO `denuncias` VALUES ('2', '3', 'teste de denuncia', '2', '2017-05-11');

-- ----------------------------
-- Table structure for `estatisticas`
-- ----------------------------
DROP TABLE IF EXISTS `estatisticas`;
CREATE TABLE `estatisticas` (
  `id_estatistica` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilizador` int(11) DEFAULT NULL,
  `id_jogo` int(11) DEFAULT NULL,
  `tempoJogado` int(11) DEFAULT NULL,
  `lastmatch_kd` decimal(4,2) DEFAULT NULL,
  `percentagemVitorias` decimal(3,1) DEFAULT NULL,
  `kills_deaths` decimal(4,2) DEFAULT NULL,
  `lastmatch_bestweapon` varchar(40) DEFAULT NULL,
  `lastmatch_mvp` int(11) DEFAULT NULL,
  `mapaMaisJogado` varchar(40) DEFAULT NULL,
  `lastmatch_weapon_kills` int(11) DEFAULT NULL,
  `mapaMaisJogadoWins` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estatistica`),
  KEY `id_jogo` (`id_jogo`),
  KEY `id_utilizador` (`id_utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of estatisticas
-- ----------------------------
INSERT INTO `estatisticas` VALUES ('7', '1', '730', '1147', '0.58', '49.7', '0.96', 'Desert Eagle', '3', 'DE_DUST2', '5', '10663');
INSERT INTO `estatisticas` VALUES ('8', '3', '730', '1722', '0.75', '50.2', '0.77', 'M4', '5', 'DE_DUST2', '11', '7969');

-- ----------------------------
-- Table structure for `jogos`
-- ----------------------------
DROP TABLE IF EXISTS `jogos`;
CREATE TABLE `jogos` (
  `id_jogo` int(11) NOT NULL,
  `nome` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `descricao` longtext,
  `imagem` varchar(350) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jogos
-- ----------------------------
INSERT INTO `jogos` VALUES ('570', 'DOTA 2', 'Dota', 'images/dota2.jpg');
INSERT INTO `jogos` VALUES ('730', 'CS:GO', 'LINDU', 'images/oyg_csgo.png');

-- ----------------------------
-- Table structure for `jogossugeridos`
-- ----------------------------
DROP TABLE IF EXISTS `jogossugeridos`;
CREATE TABLE `jogossugeridos` (
  `id_jogoSugerido` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilizador` int(11) DEFAULT NULL,
  `nome` varchar(80) CHARACTER SET utf8 DEFAULT NULL,
  `numeroSugestao` int(11) DEFAULT NULL,
  `descricao` longtext,
  `razao` longtext,
  PRIMARY KEY (`id_jogoSugerido`),
  KEY `id_utilizador` (`id_utilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jogossugeridos
-- ----------------------------

-- ----------------------------
-- Table structure for `respostas`
-- ----------------------------
DROP TABLE IF EXISTS `respostas`;
CREATE TABLE `respostas` (
  `ID_Resposta` int(11) NOT NULL AUTO_INCREMENT,
  `Texto` text CHARACTER SET utf8mb4 NOT NULL,
  `ID_Topico` int(11) NOT NULL,
  `ID_Utilizador` int(11) NOT NULL,
  `dataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_Resposta`),
  KEY `ID_Topico` (`ID_Topico`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of respostas
-- ----------------------------
INSERT INTO `respostas` VALUES ('1', 'Bom topico', '2', '1', '2017-05-11 11:36:56');
INSERT INTO `respostas` VALUES ('2', 'Continua', '3', '10', '2017-05-11 11:36:56');

-- ----------------------------
-- Table structure for `sugestoes`
-- ----------------------------
DROP TABLE IF EXISTS `sugestoes`;
CREATE TABLE `sugestoes` (
  `ID_Sugestao` int(11) NOT NULL AUTO_INCREMENT,
  `Texto` text NOT NULL,
  `Categoria` text NOT NULL,
  `Vista` bit(1) DEFAULT NULL,
  PRIMARY KEY (`ID_Sugestao`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sugestoes
-- ----------------------------
INSERT INTO `sugestoes` VALUES ('1', 'mais jogos', 'Jogo', '');
INSERT INTO `sugestoes` VALUES ('2', 'menos jogos', 'Bug/Glitch', '');
INSERT INTO `sugestoes` VALUES ('3', 'melhorar algo', '', '');
INSERT INTO `sugestoes` VALUES ('6', 'teste', 'Sugestão', '');

-- ----------------------------
-- Table structure for `topicos`
-- ----------------------------
DROP TABLE IF EXISTS `topicos`;
CREATE TABLE `topicos` (
  `ID_Topico` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` text NOT NULL,
  `Descricao` longtext,
  `ID_Utilizador` int(11) NOT NULL,
  `ID_Jogo` int(11) NOT NULL DEFAULT '-1',
  `Categoria` varchar(50) NOT NULL DEFAULT '',
  `datahora` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_Topico`),
  KEY `ID_Utilizador` (`ID_Utilizador`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of topicos
-- ----------------------------
INSERT INTO `topicos` VALUES ('12', 'Teste para apagar topico', 'teste', '4', '730', 'Duvida', '2017-05-15 16:49:10');
INSERT INTO `topicos` VALUES ('2', 'topico', 'descrição', '1', '730', 'selectedCategoria', '2017-05-05 13:44:20');
INSERT INTO `topicos` VALUES ('3', 'NOME', 'sdasd', '1', '730', 'categorias', '2017-05-05 14:58:46');
INSERT INTO `topicos` VALUES ('7', 'PC DO RIKI DEMORA 1 HORA PARA LIGAR', 'Ajudem me rapido', '1', '570', 'Problema', '2017-05-05 18:04:04');
INSERT INTO `topicos` VALUES ('11', 'COMO SUBIR PARA GLOBAL ELITe', 'cOMO POSSO SUBIR PARA GLOBAL ELITE', '1', '730', 'Duvida', '2017-05-05 18:14:20');
INSERT INTO `topicos` VALUES ('14', '', '', '1', '730', 'Problema', '2017-05-17 20:44:57');

-- ----------------------------
-- Table structure for `utilizadores`
-- ----------------------------
DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(400) NOT NULL,
  `email` varchar(50) NOT NULL,
  `avatar_url` varchar(350) NOT NULL DEFAULT '',
  `dataRegisto` varchar(50) NOT NULL,
  `eliminado` tinyint(1) NOT NULL,
  `perfil` tinyint(1) NOT NULL,
  `steamId` varchar(100) NOT NULL,
  `id_jogo` int(11) DEFAULT NULL,
  `steamProfileLink` text,
  `linkRecuperar` text,
  PRIMARY KEY (`id_utilizador`),
  UNIQUE KEY `utilizadores_steamId_uindex` (`steamId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utilizadores
-- ----------------------------
INSERT INTO `utilizadores` VALUES ('1', 'IceN', 'adcd7048512e64b48da55b027577886ee5a36350', 'aereongames@gmail.com', 'images/avatars/085460.png', '19-01-2017 15:33', '0', '3', '76561198065520310', '730', 'http://steamcommunity.com/id/icengg/', '7fb2bb92242b814b36ce6e3acad01c81257568d1');
INSERT INTO `utilizadores` VALUES ('2', 'teste3', 'adcd7048512e64b48da55b027577886ee5a36350', 'teste@gmail.com', 'images/avatars/043310.gif', '12-02-2017 23:42', '0', '2', '76561198333525758', '730', 'http://steamcommunity.com/id/andrefilsantos/', null);
INSERT INTO `utilizadores` VALUES ('3', 'contateste', '531c154c293dfa54ca8eb77046c68c1aad5eb1f8', 'contateste@gmail.com', 'images/default_avatar.jpg', '17-04-2017 10:28', '0', '1', '76561198093160364', '730', null, null);
INSERT INTO `utilizadores` VALUES ('4', 'seconteste', 'adcd7048512e64b48da55b027577886ee5a36350', 'secondteste@gmail.com', 'images/avatars/default_avatar.jpg', '15-05-2017 15:47', '1', '1', '0', null, null, null);
