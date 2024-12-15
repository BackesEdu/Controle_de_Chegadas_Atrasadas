CREATE database IF NOT EXISTS faltas DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE faltas;

CREATE TABLE IF NOT EXISTS aluno (
  idaluno INT NOT NULL,
  nameAluno VARCHAR(75) NOT NULL,
  PRIMARY KEY (idaluno))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS turmas (
  idTurma INT NOT NULL AUTO_INCREMENT,
  nameTurma VARCHAR(150) NOT NULL,
  PRIMARY KEY (idTurma))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS registros (
  idRegistro INT NOT NULL AUTO_INCREMENT,
  dtRegistro DATE NOT NULL,
  hrRegistro TIME NOT NULL,
  idAluno INT NOT NULL,
  idTurma INT NOT NULL,
  PRIMARY KEY (idRegistro),
  INDEX fk_registros_turmas_idx (idTurma ASC) VISIBLE,
  INDEX fk_registros_alunos1_idx (idAluno ASC) VISIBLE,
  CONSTRAINT fk_registros_turmas
    FOREIGN KEY (idTurma)
    REFERENCES faltas.turmas (idTurma)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_registros_alunos1
    FOREIGN KEY (idAluno)
    REFERENCES faltas.alunos (idaluno)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


CREATE TABLE IF NOT EXISTS usuarios (
  idUsuario INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(12) NOT NULL,
  foto VARCHAR(200) NOT NULL,
  PRIMARY KEY (idUsuario))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;
