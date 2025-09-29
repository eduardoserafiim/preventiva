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
	setor VARCHAR(70) NOT NULL,
    privilegio VARCHAR(20) NOT NULL
    unidade VARCHAR(20) NOT NULL
);

CREATE TABLE setores (
    id INT AUTO_INCREMENT,
    PRIMARY KEY (id),
    nome VARCHAR(100) NOT NULL,
    icon VARCHAR(50) NOT NULL
);

create table assinaturas(
	id int AUTO_INCREMENT,
	primary key(id),
	nome varchar(50) NOT NULL,
	ano year NOT NULL,
	semestre varchar(11) NOT NULL,
	setor varchar(100) NOT NULL,
	unidade varchar(20) NOT NULL,
	assinatura varchar(50) NOT NULL
);