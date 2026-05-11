use informatica;

create table dispositivos_computadores_preventiva(
	id int auto_increment,
	primary key (id),
	nome varchar(20) not NULL,
	modelo varchar(30) not NULL,
	monitor varchar(30),
	sistema_operacional varchar(20),
	office varchar(20),
	processador varchar(20),
	memoria_ram varchar(6),
	armazenamento varchar(20),
	endereco_ip varchar(20) not NULL,
	endereco_mac varchar(20) not NULL,
	numero_serie int(20),
	lacre varchar(20),
	status varchar(10) not NULL,
	etiqueta_patrimonio varchar(10),
	legenda_a boolean default 0,
	legenda_b boolean default 0,
	legenda_c boolean default 0,
	legenda_d boolean default 0,
	legenda_e boolean default 0,
	legenda_f boolean default 0,
	legenda_g boolean default 0,
	legenda_h boolean default 0,
	legenda_i boolean default 0,
	responsavel_cadastro varchar(30) not NULL,
	responsavel_uso varchar(30) not NULL,
	responsavel_edicao varchar(30),
	data_cadastro datetime not NULL,
	data_edicao datetime,
	id_imagem int,
	id_unidade int not NULL,
	foreign key (id_imagem)
		references imagem(id),
	foreign key (id_unidade)
		references unidade(id)
);

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
		references dispositivos_computadores_preventiva(id)
		on delete cascade,
	foreign key (id_setor)
		references setores(id)
		on delete cascade
);

create table preventiva_setores
(
	id_preventiva int,
	id_setor int,
	status ENUM('Aberta', 'Fechado') DEFAULT 'Aberta',
	id_usuario_responsavel_preventiva int,
	id_usuario_responsavel_setor int,
	data_inicio datetime not null,
	data_finalizacao datetime,
	primary key (id_preventiva, id_setor),
	foreign key (id_preventiva)
		references preventiva(id) 
		on delete cascade,
	foreign key (id_setor)
		references setores(id) 
		on delete cascade,
	foreign key (id_usuario_responsavel_preventiva)
		references usuarios(id)
		on delete cascade,
	foreign key (id_usuario_responsavel_setor)
		references usuarios(id)
		on delete cascade
);