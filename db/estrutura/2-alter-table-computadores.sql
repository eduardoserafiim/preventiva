USE informatica;

ALTER TABLE computadores CHANGE COLUMN cadastro responsavelCadastroTI VARCHAR(100) NOT NULL;
ALTER TABLE computadores CHANGE COLUMN numserie numeroSerie VARCHAR(20) NOT NULL;
ALTER TABLE computadores CHANGE COLUMN so sistemaOperacional VARCHAR(50) NOT NULL;
