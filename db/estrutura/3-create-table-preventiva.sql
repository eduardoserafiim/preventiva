use informatica;

create table preventiva(
	id int auto_increment,
	primary key (id),
	id_unidade int not NULL,
	id_usuario_responsavel_criacao int not NULL,
	ano year not NULL,
	semestre varchar(20) not NULL,
	foreign key (id_unidade)
		references unidade(id)
		on delete cascade,
	foreign key (id_usuario_responsavel_criacao)
		references usuarios(id)
		on delete cascade
);

create table preventiva_computadores
(
	id_preventiva int,
	id_computador int,
	id_setor int,
	primary key(id_preventiva, id_computador),
	foreign key (id_preventiva)
		references preventiva(id)
		on delete cascade,
	foreign key (id_computador)
		references dispositivos_computadores(id)
		on delete cascade,
	foreign key (id_setor)
		references setores(id)
		on delete cascade
);

create table preventiva_setores
(
	id_preventiva int,
	id_setor int,
	primary key (id_preventiva, id_setor),
	status ENUM('Aberto', 'Fechado') DEFAULT 'Nenhum',
	id_usuario_responsavel_preventiva int,
	id_usuario_responsavel_setor int,
	data_inicio datetime not null,
	data_finalizacao datetime not null,
	foreign key (id_preventiva)
		references preventiva(id),
	foreign key (id_setor)
		references setores(id),
	foreign key (id_usuario_responsavel_preventiva)
);