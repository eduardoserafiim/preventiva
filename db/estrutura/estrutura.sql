create database informatica;
USE informatica;

create table imagem
(
	id int auto_increment,
	primary key(id),
	path_imagem varchar(255),
	nome_imagem varchar(255),
	nome_salvo varchar(255),
	data_salvo date
);

create table unidade
(
	id int auto_increment,
	primary key (id),
	nome varchar(50)
);

CREATE TABLE dispositivos_computadores(
	id int auto_increment,
	primary key (id),
	nome varchar(20) not NULL,
	modelo varchar(30) not NULL,
	monitor varchar(30),
	sistema_operacional varchar(20) not NULL,
	office varchar(20) not NULL,
	processador varchar(20) not NULL,
	memoria_ram varchar(6) not NULL,
	armazenamento varchar(20) not NULL,
	endereco_ip varchar(20) not NULL,
	endereco_mac varchar(20) not NULL,
	numero_serie int(20) not NULL,
	lacre varchar(20) not NULL,
	status varchar(10) not NULL,
	etiqueta_patrimonio varchar(10) not NULL,
	legenda_a boolean not NULL default 0,
	legenda_b boolean not NULL default 0,
	legenda_c boolean not NULL default 0,
	legenda_d boolean not NULL default 0,
	legenda_e boolean not NULL default 0,
	legenda_f boolean not NULL default 0,
	legenda_g boolean not NULL default 0,
	legenda_h boolean not NULL default 0,
	legenda_i boolean not NULL default 0,
	responsavel_cadastro varchar(30) not NULL,
	responsavel_uso varchar(30) not NULL,
	data_cadastro datetime not NULL,
	id_imagem int,
	id_unidade int,
	foreign key (id_imagem)
		references imagem(id),
	foreign key (id_unidade)
		references unidade(id)
);

CREATE TABLE usuarios (
	id INT AUTO_INCREMENT,
	PRIMARY KEY (id),
	nome VARCHAR(50) NOT NULL,
    usuario VARCHAR(20) NOT NULL,
	senha VARCHAR(100) NOT NULL,
	setor VARCHAR(70) NOT NULL,
    privilegio VARCHAR(20) NOT null,
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
    tipo varchar(40) NOT NULL,
	nome varchar(50) NOT NULL,
	ano year NOT NULL,
	semestre varchar(11) NOT NULL,
	setor varchar(100) NOT NULL,
	unidade varchar(20) NOT NULL,
	assinatura varchar(50) NOT NULL,
    data date NOT NULL,
    id_usuario int,
    foreign key (id_usuario)
        references usuarios(id)
);