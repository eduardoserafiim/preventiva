use informatica;

create table dispositivos_dvrs
(
	id int auto_increment,
	primary key (id),
	nome varchar(30) not null,
	modelo varchar(50) not null,
	marca varchar(50) not null,
	ano year not null,
	ip varchar(20) not null,
	mac varchar(17) not null,
	canais int(2) not null,
	horario varchar(2),
	semestre varchar(17),
	chamado_manutencao varchar(30),
	tecnico_responsavel varchar(30) not null,
	responsavel_edicao varchar(30),
	data_criacao datetime not null,
	data_edicao datetime,
	id_imagem int,
	id_unidade int not null,
	foreign key (id_imagem)
		references imagem(id),
	foreign key (id_unidade)
		references unidade(id)
);