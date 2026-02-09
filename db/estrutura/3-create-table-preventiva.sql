use informatica;

create table preventiva(
	id int auto_increment,
	primary key (id),
	id_unidade int not NULL,
	id_usuario int not NULL,
	id_setor int not NULL,
	nome varchar(20) not NULL,
	ano year not NULL,
	semestre varchar(20) not NULL,
	foreign key (id_unidade)
		references unidade(id)
		on delete cascade,
	foreign key (id_usuario)
		references usuarios(id)
		on delete cascade,
	foreign key (id_setor)
		references setores(id)
		on delete cascade
);

create table preventiva_computadores
(
	id_preventiva int,
	id_computador int,
	primary key(id_preventiva, id_computador),
	foreign key (id_preventiva)
		references preventiva(id)
		on delete cascade,
	foreign key (id_computador)
		references dispositivos_computadores(id)
		on delete cascade
);