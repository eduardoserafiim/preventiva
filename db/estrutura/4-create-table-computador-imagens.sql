CREATE TABLE IF NOT EXISTS computador_imagem
(
    id_computador INT NOT NULL,
    id_imagem INT NOT NULL,
    data_vinculo DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_computador, id_imagem),
    FOREIGN KEY (id_computador) REFERENCES dispositivos_computadores(id) ON DELETE CASCADE,
    FOREIGN KEY (id_imagem) REFERENCES imagem(id) ON DELETE CASCADE
);
