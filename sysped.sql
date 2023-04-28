-- -----------------------------------------------------
-- Table sysped.PRODUTO
-- -----------------------------------------------------
CREATE TABLE PRODUTO (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(45) NOT NULL,
  UNDVENDA VARCHAR(2) NOT NULL,
  VLRVENDA DOUBLE NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.ACESSO
-- -----------------------------------------------------
CREATE TABLE ACESSO (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(45) NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.ATENDENTE
-- -----------------------------------------------------
CREATE TABLE ATENDENTE (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(100) NOT NULL,
  LOGIN VARCHAR(16) NOT NULL,
  SENHA VARCHAR(255) NOT NULL,
  ACESSO_ID INT NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.FPAGAMENTO
-- -----------------------------------------------------
CREATE TABLE FPAGAMENTO (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(45) NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.CLIENTE
-- -----------------------------------------------------
CREATE TABLE CLIENTE (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(45) NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.VENDA
-- -----------------------------------------------------
CREATE TABLE VENDA (
  ID INT NOT NULL AUTO_INCREMENT,
  DATA DATETIME NOT NULL,
  SUBTOTAL DOUBLE NOT NULL,
  DESCONTO DOUBLE NULL,
  VLRTOTAL DOUBLE NOT NULL,
  STATUS INT NULL,
  ATENDENTE_ID INT NOT NULL,
  FPAGAMENTO_ID INT NOT NULL,
  CLIENTE_ID INT NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.ITENSVENDA
-- -----------------------------------------------------
CREATE TABLE ITENSVENDA (
  VENDA_ID INT NOT NULL,
  PRODUTO_ID INT NOT NULL,
  DATA DATETIME NULL,
  ATENDENTE_ID INT NOT NULL,
  PRIMARY KEY (VENDA_ID, PRODUTO_ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.FORNECEDOR
-- -----------------------------------------------------
CREATE TABLE FORNECEDOR (
  ID INT NOT NULL AUTO_INCREMENT,
  NOME VARCHAR(100) NOT NULL,
  TELEFONE VARCHAR(16) NULL,
  CELULAR VARCHAR(16) NULL,
  EMAIL VARCHAR(255) NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.COMPRA
-- -----------------------------------------------------
CREATE TABLE COMPRA (
  ID INT NOT NULL AUTO_INCREMENT,
  DATA DATETIME NOT NULL,
  VALOR DOUBLE NOT NULL,
  VENCIMENTO DATE NOT NULL,
  FPAGAMENTO_ID INT NOT NULL,
  FORNECEDOR_ID INT NOT NULL,
  ATENDENTE_ID INT NOT NULL,
  PRIMARY KEY (ID))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table sysped.ITENSCOMPRA
-- -----------------------------------------------------
CREATE TABLE ITENSCOMPRA (
  COMPRA_ID INT NOT NULL,
  PRODUTO_ID INT NOT NULL,
  PRIMARY KEY (COMPRA_ID, PRODUTO_ID))
ENGINE = InnoDB;