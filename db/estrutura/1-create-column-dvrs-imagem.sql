use informatica;

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

create table dispositivos_dvrs
(
	id int auto_increment,
	primary key (id),
	nome varchar(30) not null,
	modelo varchar(50) not null,
	marca varchar(50) not null,
	ano year not null,
	ip varchar(20),
	mac varchar(17),
	canais int(2) not null,
	horario time not null,
	chamadoManutencao varchar(30) not null,
	id_localizacao int not null,
	id_assinatura int,
	id_imagem int,
	id_unidade int,
	foreign key (id_localizacao)
		references setores(id),
	foreign key (id_assinatura)
		references assinaturastecnicos(id),
	foreign key (id_imagem)
		references imagem(id),
	foreign key (id_unidade)
		references unidade(id)
);