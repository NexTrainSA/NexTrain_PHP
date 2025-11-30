CREATE DATABASE IF NOT EXISTS `nextrain_production;
USE `nextrain_production`;

CREATE TABLE IF NOT EXISTS `agenda` (
  `id_tarefa` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` int(11) NOT NULL,
  `descricao_tarefa` varchar(300) NOT NULL,
  `data_tarefa` date NOT NULL,
  PRIMARY KEY (`id_tarefa`),
  KEY `id_funcionario` (`id_funcionario`),
  CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `usuario` (`id_usuario`)
);

CREATE TABLE IF NOT EXISTS `alertas` (
  `id_alerta` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` int(11) NOT NULL,
  `id_funcionario_recebe` int(11) NOT NULL,
  `descricao_alerta` varchar(100) NOT NULL,
  PRIMARY KEY (`id_alerta`),
  KEY `id_funcionario` (`id_funcionario`),
  KEY `id_funcionario_recebe` (`id_funcionario_recebe`),
  CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `alertas_ibfk_2` FOREIGN KEY (`id_funcionario_recebe`) REFERENCES `usuario` (`id_usuario`)
);

CREATE TABLE IF NOT EXISTS `arestas_grafo_estacoes` (
  `id_estacao1` int(11) NOT NULL,
  `id_estacao2` int(11) NOT NULL,
  PRIMARY KEY (`id_estacao1`,`id_estacao2`),
  KEY `fk2` (`id_estacao2`),
  CONSTRAINT `fk1` FOREIGN KEY (`id_estacao1`) REFERENCES `estacao` (`id_estacao`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk2` FOREIGN KEY (`id_estacao2`) REFERENCES `estacao` (`id_estacao`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `chamados_manutencao` (
  `ordem_servico` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcionario` int(11) NOT NULL,
  `id_trem` int(11) NOT NULL,
  `descricao_problema` varchar(500) NOT NULL,
  `data_entrada` date NOT NULL,
  PRIMARY KEY (`ordem_servico`),
  KEY `chamados_manutencao_ibfk_1` (`id_funcionario`),
  KEY `chamados_manutencao_ibfk_2` (`id_trem`),
  CONSTRAINT `chamados_manutencao_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chamados_manutencao_ibfk_2` FOREIGN KEY (`id_trem`) REFERENCES `trens` (`id_trem`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `estacao` (
  `id_estacao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_estacao` varchar(50) DEFAULT NULL,
  `status_estacao` enum('OPEN','PERMANENTLY_CLOSED','UNKNOWN','MAINTENANCE') DEFAULT 'UNKNOWN',
  PRIMARY KEY (`id_estacao`)
);

CREATE TABLE IF NOT EXISTS `itinerario` (
  `id_itinerario` int(11) NOT NULL AUTO_INCREMENT,
  `origem_itinerario` int(11) NOT NULL,
  `destino_itinerario` int(11) NOT NULL,
  PRIMARY KEY (`id_itinerario`),
  KEY `fk_destino` (`destino_itinerario`),
  KEY `fk_origem` (`origem_itinerario`),
  CONSTRAINT `fk_destino` FOREIGN KEY (`destino_itinerario`) REFERENCES `estacao` (`id_estacao`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_origem` FOREIGN KEY (`origem_itinerario`) REFERENCES `estacao` (`id_estacao`) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `permissao` (
  `id_permissao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_permissao` varchar(50) NOT NULL,
  PRIMARY KEY (`id_permissao`)
);

CREATE TABLE IF NOT EXISTS `permissao_usuario` (
  `id_idx_permissao` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario_permissao` int(11) DEFAULT NULL,
  `id_permissao` int(11) NOT NULL,
  PRIMARY KEY (`id_idx_permissao`) USING BTREE,
  KEY `FK_permissao_usuario_permissao` (`id_permissao`),
  KEY `FK_permissao_usuario_usuario` (`id_usuario_permissao`),
  CONSTRAINT `FK_permissao_usuario_permissao` FOREIGN KEY (`id_permissao`) REFERENCES `permissao` (`id_permissao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_permissao_usuario_usuario` FOREIGN KEY (`id_usuario_permissao`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `rota` (
  `id_rota` int(11) NOT NULL AUTO_INCREMENT,
  `itinerario_rota` int(11) DEFAULT NULL,
  `caminho_rota` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rota`),
  KEY `fk_itinerario` (`itinerario_rota`),
  CONSTRAINT `fk_itinerario` FOREIGN KEY (`itinerario_rota`) REFERENCES `itinerario` (`id_itinerario`) ON DELETE CASCADE ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `trens` (
  `id_trem` int(11) NOT NULL AUTO_INCREMENT,
  `nome_trem` varchar(100) NOT NULL,
  `id_funcionario_encarregado_trem` int(11) NOT NULL,
  `modelo_trem` varchar(100) NOT NULL,
  `infos_trem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_trem`),
  KEY `id_funcionario_encarregado_trem` (`id_funcionario_encarregado_trem`),
  CONSTRAINT `trens_ibfk_1` FOREIGN KEY (`id_funcionario_encarregado_trem`) REFERENCES `usuario` (`id_usuario`)
);

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username_usuario` varchar(50) NOT NULL DEFAULT '0',
  `senha_usuario` varchar(64) NOT NULL DEFAULT '0',
  `nome_completo_usuario` varchar(100) DEFAULT 'Indefinido',
  `email_usuario` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
);
