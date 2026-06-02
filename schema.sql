-- Schema SQL para o projeto (MySQL)
-- Banco e tabelas usadas pelo site

CREATE DATABASE IF NOT EXISTS `sistemasae` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistemasae`;

-- Tabela de usuários / contas do sistema
CREATE TABLE IF NOT EXISTS `dadossae` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `empresa` VARCHAR(150) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Frota de veículos
CREATE TABLE IF NOT EXISTS `frota` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `marca` VARCHAR(150) NOT NULL,
  `modelo` VARCHAR(150) NOT NULL,
  `ano` YEAR NOT NULL,
  `placa` VARCHAR(20) NOT NULL,
  `empresa` VARCHAR(150) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Funcionários / colaboradores
CREATE TABLE IF NOT EXISTS `funcionarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cargo` VARCHAR(150) NOT NULL,
  `datanasc` DATE NOT NULL,
  `dataadmissao` DATE NOT NULL,
  `empresa` VARCHAR(150) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Relatórios / Gestão
CREATE TABLE IF NOT EXISTS `gestao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `tipo` VARCHAR(100) NOT NULL,
  `data_registro` DATE NOT NULL,
  `valor` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `status` VARCHAR(50) NOT NULL,
  `empresa` VARCHAR(150) DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exemplos de dados (opcional)
INSERT INTO `dadossae` (`nome`, `email`, `senha`, `empresa`) VALUES
('Empresa Exemplo - Admin', 'admin@empresa.local', '$2y$10$exampleplaceholderhash000000000000000000000000000000000', 'Empresa Exemplo');

INSERT INTO `frota` (`marca`, `modelo`, `ano`, `placa`, `empresa`) VALUES
('Toyota', 'Corolla', '2021', 'ABC1234', 'Empresa Exemplo'),
('Mercedes-Benz', 'Sprinter', '2019', 'DEF5678', 'Empresa Exemplo');

INSERT INTO `funcionarios` (`nome`, `cargo`, `datanasc`, `dataadmissao`, `empresa`) VALUES
('João da Silva', 'Motorista', '1985-07-12', '2020-03-01', 'Empresa Exemplo'),
('Maria Oliveira', 'Administrativo', '1990-11-02', '2021-06-15', 'Empresa Exemplo');

INSERT INTO `gestao` (`titulo`, `tipo`, `data_registro`, `valor`, `status`, `empresa`) VALUES
('Fechamento Mensal - Abril', 'Financeiro', '2026-04-30', 45250.00, 'Concluído', 'Empresa Exemplo'),
('Auditoria de Combustível', 'Operacional', '2026-05-15', 12400.15, 'Concluído', 'Empresa Exemplo');

-- Observações:
-- 1) O hash de senha acima é um placeholder. Para criar um usuário real, registre via cadastrar.php
--    ou insira uma senha gerada por PHP usando password_hash().
-- 2) Ajuste os nomes de empresa, permissões e usuários conforme necessário para seu ambiente.
