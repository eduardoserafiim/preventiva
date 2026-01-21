use informatica;

create table preventiva
(
    id int auto_increment,
    primary key (id),
    ano year,
    semestre varchar(11),
    setor varchar(100),
    tecnico_responsavel varchar(50),
    setor_responsavel varchar(50),
    id_unidade int,
    foreign key (id_unidade)
        references unidade(id);
);

create table preventiva_computadores (
    id_preventiva int,
    id_computador int,
    primary key (id_preventiva, id_computador),
    foreign key (id_preventiva) 
        references preventiva(id),
    foreign key (id_computador) 
        references computadores(id)
);

create table preventiva_assinaturas (
    id_preventiva int,
    id_assinatura int,
    primary key (id_preventiva, id_assinatura),
    foreign key (id_preventiva) 
        references preventiva(id),
    foreign key (id_assinatura) 
        references assinaturas(id)
);