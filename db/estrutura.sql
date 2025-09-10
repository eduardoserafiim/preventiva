USE informatica;

CREATE TABLE computadores(
    id INT AUTO_INCREMENT PRIMARY KEY,
    semestre VARCHAR(11),
    ano INT,
    unidade VARCHAR(100),
    setor VARCHAR(100),
    nome VARCHAR(100),
    modelo VARCHAR(100),
    monitor VARCHAR(100),
    so VARCHAR(50),
    office VARCHAR(50),
    processador VARCHAR(100),
    memoria VARCHAR(50),
    disco VARCHAR(50),
    ip VARCHAR(45),
    lacre VARCHAR(50),
    status VARCHAR(50),
    legendaA boolean,
    legendaB boolean,
    legendaC boolean,
    legendaD boolean,
    legendaE boolean,
    legendaF boolean,
    legendaG boolean,
    legendaH boolean,
    dataCadastro DATE
);

CREATE TABLE usuarios(
	id INT AUTO_INCREMENT,
	PRIMARY KEY (id),
	nome VARCHAR(50) NOT NULL,
    usuario VARCHAR(20) NOT NULL,
	senha VARCHAR(100) NOT NULL,
	setor VARCHAR(70)

);