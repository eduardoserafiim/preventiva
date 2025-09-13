USE informatica;

CREATE TABLE computadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    semestre VARCHAR(11),
    ano INT,
    unidade VARCHAR(20),
    setor VARCHAR(50),
    nome VARCHAR(50),
    modelo VARCHAR(50),
    monitor VARCHAR(50),
    so VARCHAR(50),
    office VARCHAR(50),
    processador VARCHAR(50),
    memoria VARCHAR(4),
    disco VARCHAR(10),
    ip VARCHAR(15),
    lacre VARCHAR(10),
    status VARCHAR(10),
    legendaA boolean,
    legendaB boolean,
    legendaC boolean,
    legendaD boolean,
    legendaE boolean,
    legendaF boolean,
    legendaG boolean,
    legendaH boolean,
    legendaI boolean,
    dataCadastro DATE
);

CREATE TABLE usuarios (
	id INT AUTO_INCREMENT,
	PRIMARY KEY (id),
	nome VARCHAR(50) NOT NULL,
    usuario VARCHAR(20) NOT NULL,
	senha VARCHAR(100) NOT NULL,
	setor VARCHAR(70)

);

CREATE TABLE setores (
	id INT auto_increment,
	PRIMARY KEY (id),
	nome VARCHAR(70) NOT NULL
);

CREATE TABLE usuarios_setores (
    usuario_id INT,
    setor_id INT,
    PRIMARY KEY (usuario_id, setor_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (setor_id) REFERENCES setores(id)
);