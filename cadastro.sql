/* Para criar tabelas */

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cadastro`;
CREATE TABLE `cadastro` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `dataNasc` date DEFAULT NULL,
  `salario` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
