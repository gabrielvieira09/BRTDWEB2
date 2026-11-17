CREATE DATABASE IF NOT EXISTS `barrefertas` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `barrefertas`;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(200) NOT NULL,
  `nome` VARCHAR(200) NOT NULL,
  `nascimento` DATE DEFAULT NULL,
  `senha` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_usuario_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Se o banco antigo da Aula 10 ainda existir, adiciona o nascimento
-- somente quando essa coluna nao existir (sem apagar usuarios).
SET @tem_nascimento = (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = 'barrefertas' AND TABLE_NAME = 'usuarios' AND COLUMN_NAME = 'nascimento'
);
SET @comando_nascimento = IF(@tem_nascimento = 0,
  'ALTER TABLE `usuarios` ADD COLUMN `nascimento` DATE DEFAULT NULL AFTER `nome`',
  'SELECT 1');
PREPARE comando_ajuste FROM @comando_nascimento;
EXECUTE comando_ajuste;
DEALLOCATE PREPARE comando_ajuste;

CREATE TABLE IF NOT EXISTS `filmes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(11) NOT NULL,
  `nome` VARCHAR(200) NOT NULL,
  `descricao` VARCHAR(300) NOT NULL,
  `foto` VARCHAR(200) NOT NULL,
  `link` VARCHAR(200) NOT NULL,
  `classificacao` INT(2) NOT NULL,
  `nota_usuario` INT(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_filmes_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `comentarios` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) NOT NULL,
  `id_filme` INT(10) NOT NULL,
  `comentario` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_comentarios_filme` (`id_filme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `curtidas` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) NOT NULL,
  `id_filme` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_curtida` (`id_usuario`,`id_filme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `amigos` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) NOT NULL,
  `id_amigo` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_amizade` (`id_usuario`,`id_amigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela adicionada porque o enunciado pede solicitações pendentes.
CREATE TABLE IF NOT EXISTS `pendente` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` INT(10) NOT NULL COMMENT 'Quem solicita',
  `id_amigo` INT(10) NOT NULL COMMENT 'Quem recebe e aprova',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_pedido` (`id_usuario`,`id_amigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
