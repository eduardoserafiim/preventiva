use informatica;

create table dispositivos_cameras
(
	id int auto_increment,
	primary key (id),
	id_unidade int not null,
	id_setor int,
	canal int(2) not null,
	nome varchar(20) not null,
	marca varchar(20) not null,
	modelo varchar(20) not null,
	ip varchar(15) not null,
	mac varchar(17) not null,
	porta int(5) not null,
	status varchar(2) not null,
	data_criada date not null,
	id_responsavel_cadastro int not null,
	foreign key (id_unidade)
		references unidade(id),
	foreign key (id_setor)
		references setores(id),
	foreign key (id_responsavel_cadastro)
		references usuarios(id)
);
