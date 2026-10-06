use informatica;

create table dispositivos_cameras
(
	id int auto_increment,
	primary key (id),
	id_unidade int not null,
	id_setor int,
	id_dvr int,
	canal int(2) not null,
	nome varchar(50) not null,
	marca varchar(20) not null,
	modelo varchar(20) not null,
	ip varchar(15) not null,
	mac varchar(17) not null,
	porta int(5) not null,
	dias_gravados int(3),
	status varchar(2) not null,
	data_criada date not null,
	id_responsavel_cadastro int not null,
	foreign key (id_unidade)
		references unidade(id)
		on delete cascade,
	foreign key (id_setor)
		references setores(id)
		on delete cascade,
	foreign key (id_responsavel_cadastro)
		references usuarios(id)
		on delete cascade,
	foreign key (id_dvr)
		references dispositivos_dvrs(id)
		on delete cascade
);

create table dispositivos_dvrs_cameras
(
	id_dvr int,
	id_camera int,
	primary key (id_dvr, id_camera),
	foreign key (id_dvr)
		references dispositivos_dvrs(id)
		on delete cascade,
	foreign key (id_camera)
		references dispositivos_cameras(id)
		on delete cascade
);