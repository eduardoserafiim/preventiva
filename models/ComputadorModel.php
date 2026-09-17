<?php
require_once __DIR__ . '/../db/db.php';

class ComputadorModel 
{
    private $db;

    public function __construct() 
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criarComputador($data) 
    {
        try
        {
            $sql = 'INSERT INTO dispositivos_computadores(id_unidade, id_imagem, nome, modelo, endereco_ip, endereco_mac, responsavel_cadastro, responsavel_uso, status, data_cadastro)
            VALUES(:unidade, :imagem, :nome, :modelo, :endereco_ip, :endereco_mac, :responsavel_cadastro, :responsavel_uso, :status, NOW())';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(
                [
                    ':unidade' => $data['unidade'],
                    ':nome' => $data['nome'],
                    ':modelo' => $data['modelo'],
                    ':endereco_ip' => $data['endereco_ip'],
                    ':endereco_mac' => $data['endereco_mac'],
                    ':responsavel_cadastro' => $data['responsavel_cadastro'],
                    ':responsavel_uso' => $data['responsavel_uso'],
                    ':status' => $data['status'],
                    ':imagem' => $data['id_imagem'] ?? null
                ]
            );
        
            return $this->db->lastInsertId();
        }
        catch (PDOException $e) 
        {
            return false;
        }
    }

    public function qunatidadeComputadoresRegistradosUnidade($idUnidade = null, $idSetor = null)
    {
        try
        {
            if ($idSetor !== null) {
                $sql = 'SELECT u.nome AS unidade, COUNT(DISTINCT c.id) AS total
                    FROM dispositivos_computadores_preventiva c
                    JOIN preventiva_computadores pc
                        ON pc.id_computador = c.id
                    JOIN unidade u
                        ON c.id_unidade = u.id
                    WHERE pc.id_setor = :id_setor';
                $params = [':id_setor' => (int) $idSetor];
            } else {
                $sql = 'SELECT u.nome AS unidade, COUNT(d.id) AS total
                    FROM dispositivos_computadores d
                    JOIN unidade u
                        ON d.id_unidade = u.id';
                $params = [];
            }

            if ($idUnidade !== null) {
                $sql .= $idSetor !== null ? ' AND c.id_unidade = :id_unidade' : ' WHERE d.id_unidade = :id_unidade';
                $params[':id_unidade'] = (int) $idUnidade;
            }

            $sql .= ' GROUP BY u.nome';
            $stmt = $this->db->prepare($sql);
            $query = $stmt->execute($params);
    
            if ($query)
            {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                throw new PDOException('Erro interno.');
            }
        }
        catch (PDOException $e)
        {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function quantidadeComputadoresPorStatus($idUnidade = null, $idSetor = null)
    {
        try {
            if ($idSetor !== null) {
                $sql = 'SELECT c.status, COUNT(DISTINCT c.id) AS total
                    FROM dispositivos_computadores_preventiva c
                    JOIN preventiva_computadores pc
                        ON pc.id_computador = c.id
                    WHERE pc.id_setor = :id_setor';
                $params = [':id_setor' => (int) $idSetor];
            } else {
                $sql = 'SELECT d.status, COUNT(d.id) AS total
                    FROM dispositivos_computadores d';
                $params = [];
            }

            if ($idUnidade !== null) {
                $sql .= $idSetor !== null ? ' AND c.id_unidade = :id_unidade' : ' WHERE d.id_unidade = :id_unidade';
                $params[':id_unidade'] = (int) $idUnidade;
            }

            $sql .= ' GROUP BY ' . ($idSetor !== null ? 'c.status' : 'd.status');
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listarComputador($id = null, $unidade = null, $limite = null, $offset = 0, array $filtros = [])
    {
        try {
            $sql = 'SELECT dc.*, 
                        u.nome AS nome_unidade, 
                        COALESCE(
                            i.nome_salvo,
                            (
                                SELECT i_vinculada.nome_salvo
                                FROM computador_imagem ci_vinculada
                                INNER JOIN imagem i_vinculada
                                    ON ci_vinculada.id_imagem = i_vinculada.id
                                WHERE ci_vinculada.id_computador = dc.id
                                ORDER BY ci_vinculada.data_vinculo ASC
                                LIMIT 1
                            )
                        ) AS nome_imagem,
                        i.id AS id_imagem_antiga 
                    FROM dispositivos_computadores dc 
                    LEFT JOIN unidade u 
                        ON dc.id_unidade = u.id 
                    LEFT JOIN imagem i 
                        ON dc.id_imagem = i.id';
            
            $params = [];

            if ($id)
            {
                $sql .= ' WHERE dc.id = ?';
                $params[] = $id;
            } 
            else 
            {
                $conditions = [];

                if ($unidade !== null && $unidade != 3) {
                    $conditions[] = 'dc.id_unidade = ?';
                    $params[] = $unidade;
                }

                if (!empty($filtros['busca'])) {
                    $conditions[] = '(dc.nome LIKE ? OR dc.endereco_ip LIKE ? OR dc.endereco_mac LIKE ? OR CAST(dc.numero_serie AS CHAR) LIKE ?)';
                    $termo = '%' . $filtros['busca'] . '%';
                    array_push($params, $termo, $termo, $termo, $termo);
                }

                if (!empty($filtros['unidade'])) {
                    $conditions[] = 'dc.id_unidade = ?';
                    $params[] = (int) $filtros['unidade'];
                }

                if (!empty($filtros['status'])) {
                    $conditions[] = 'dc.status = ?';
                    $params[] = $filtros['status'];
                }

                if (!empty($filtros['modelo'])) {
                    $conditions[] = 'dc.modelo = ?';
                    $params[] = $filtros['modelo'];
                }

                if ($conditions) {
                    $sql .= ' WHERE ' . implode(' AND ', $conditions);
                }

                $sql .= ' ORDER BY dc.id DESC';

                if ($limite !== null) {
                    $sql .= ' LIMIT ' . max(1, (int) $limite) . ' OFFSET ' . max(0, (int) $offset);
                }
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return $id ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $texto = $e->getMessage();

            return false;
        }
    }

    public function quantidadeComputadores($unidade = null, array $filtros = [])
    {
        try {
            $sql = 'SELECT COUNT(*) FROM dispositivos_computadores';
            $params = [];

            $conditions = [];

            if ($unidade !== null && $unidade != 3) {
                $conditions[] = 'id_unidade = ?';
                $params[] = $unidade;
            }

            if (!empty($filtros['busca'])) {
                $conditions[] = '(nome LIKE ? OR endereco_ip LIKE ? OR endereco_mac LIKE ? OR CAST(numero_serie AS CHAR) LIKE ?)';
                $termo = '%' . $filtros['busca'] . '%';
                array_push($params, $termo, $termo, $termo, $termo);
            }

            if (!empty($filtros['unidade'])) {
                $conditions[] = 'id_unidade = ?';
                $params[] = (int) $filtros['unidade'];
            }

            if (!empty($filtros['status'])) {
                $conditions[] = 'status = ?';
                $params[] = $filtros['status'];
            }

            if (!empty($filtros['modelo'])) {
                $conditions[] = 'modelo = ?';
                $params[] = $filtros['modelo'];
            }

            if ($conditions) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function listarOpcoesFiltros($unidade = null)
    {
        try {
            $where = '';
            $params = [];

            if ($unidade !== null && $unidade != 3) {
                $where = ' WHERE dc.id_unidade = ?';
                $params[] = $unidade;
            }

            $sql = 'SELECT DISTINCT u.nome AS unidade, dc.status, dc.modelo
                FROM dispositivos_computadores dc
                LEFT JOIN unidade u ON dc.id_unidade = u.id' . $where . '
                ORDER BY u.nome, dc.status, dc.modelo';
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            $opcoes = [
                'unidades' => [],
                'status' => [],
                'modelos' => []
            ];

            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $linha) {
                $opcoes['unidades'][] = $linha['unidade'];
                $opcoes['status'][] = $linha['status'];
                $opcoes['modelos'][] = $linha['modelo'];
            }

            foreach ($opcoes as $tipo => $valores) {
                $opcoes[$tipo] = array_values(array_unique(array_filter($valores)));
                natcasesort($opcoes[$tipo]);
            }

            return $opcoes;
        } catch (PDOException $e) {
            return ['unidades' => [], 'status' => [], 'modelos' => []];
        }
    }

    public function listarImagens($idComputador)
    {
        $sql = 'SELECT i.id, i.nome_salvo, i.nome_imagem
                FROM computador_imagem ci
                INNER JOIN imagem i ON i.id = ci.id_imagem
                WHERE ci.id_computador = :id_computador
                UNION
                SELECT i.id, i.nome_salvo, i.nome_imagem
                FROM dispositivos_computadores dc
                INNER JOIN imagem i ON i.id = dc.id_imagem
                WHERE dc.id = :id_computador_principal
                ORDER BY id ASC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_computador' => (int) $idComputador,
            ':id_computador_principal' => (int) $idComputador
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vincularImagens($idComputador, array $idsImagens)
    {
        $sql = 'INSERT IGNORE INTO computador_imagem (id_computador, id_imagem)
                VALUES (:id_computador, :id_imagem)';
        $stmt = $this->db->prepare($sql);

        foreach ($idsImagens as $idImagem) {
            $stmt->execute([
                ':id_computador' => (int) $idComputador,
                ':id_imagem' => (int) $idImagem
            ]);
        }
    }

    public function substituirImagens($idComputador, array $idsImagens)
    {
        if (empty($idsImagens)) {
            return true;
        }

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare('DELETE FROM computador_imagem WHERE id_computador = :id_computador');
            $stmt->execute([':id_computador' => (int) $idComputador]);

            $stmt = $this->db->prepare('UPDATE dispositivos_computadores SET id_imagem = :id_imagem WHERE id = :id');
            $stmt->execute([
                ':id_imagem' => (int) $idsImagens[0],
                ':id' => (int) $idComputador
            ]);

            $this->vincularImagens($idComputador, array_slice($idsImagens, 1));
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return false;
        }
    }

    public function editarComputador($data, $tipo)
    {
        try
        {
            if($tipo === 'editarBasico')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    nome            = :nome,
                    modelo          = :modelo,
                    endereco_ip     = :endereco_ip,
                    endereco_mac    = :endereco_mac,
                    responsavel_edicao = :responsavel_edicao,
                    responsavel_uso = :responsavel_uso,
                    status          = :status,
                    data_edicao     = NOW(),
                    id_imagem       = :id_imagem,
                    id_unidade      = :id_unidade
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':nome'                 => $data['nome'],
                        ':modelo'               => $data['modelo'],
                        ':endereco_ip'          => $data['endereco_ip'],
                        ':endereco_mac'         => $data['endereco_mac'],
                        ':responsavel_edicao'   => $data['responsavel_alteracao'],
                        ':responsavel_uso'      => $data['responsavel_uso'],
                        ':status'               => $data['status'],
                        ':id_imagem'            => $data['id_imagem'],
                        ':id_unidade'           => $data['id_unidade'],
                        ':id'                   => $data['id']
                    ]
                );
            }
            elseif ($tipo === 'editarLegenda')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    legenda_a = :legenda_a,
                    legenda_b = :legenda_b,
                    legenda_c = :legenda_c,
                    legenda_d = :legenda_d,
                    legenda_e = :legenda_e,
                    legenda_f = :legenda_f,
                    legenda_g = :legenda_g,
                    legenda_h = :legenda_h,
                    legenda_i = :legenda_i,
                    data_edicao         = NOW(),
                    responsavel_edicao  = :responsavel_edicao
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id'        => $data['id'],
                        ':legenda_a' => $data['legenda_a'],
                        ':legenda_b' => $data['legenda_b'],
                        ':legenda_c' => $data['legenda_c'],
                        ':legenda_d' => $data['legenda_d'],
                        ':legenda_e' => $data['legenda_e'],
                        ':legenda_f' => $data['legenda_f'],
                        ':legenda_g' => $data['legenda_g'],
                        ':legenda_h' => $data['legenda_h'],
                        ':legenda_i' => $data['legenda_i'],
                        ':responsavel_edicao' => $data['responsavel_alteracao']
                    ]
                );
            }
            elseif ($tipo === 'editarHardwarePatrimonio')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    processador         = :processador,
                    memoria_ram         = :memoria_ram,
                    armazenamento       = :armazenamento,
                    sistema_operacional = :sistema_operacional,
                    numero_serie        = :numero_serie,
                    lacre               = :lacre,
                    etiqueta_patrimonio = :etiqueta_patrimonio,
                    data_edicao         = NOW(),
                    responsavel_edicao  = :responsavel_edicao
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id'                   => $data['id'],
                        ':processador'          => $data['processador'],
                        ':memoria_ram'          => $data['memoria_ram'],
                        ':armazenamento'        => $data['armazenamento'],
                        ':sistema_operacional'  => $data['sistema_operacional'],
                        ':numero_serie'         => $data['numero_serie'],
                        ':lacre'                => $data['lacre'],
                        ':etiqueta_patrimonio'  => $data['etiqueta_patrimonio'],
                        ':responsavel_edicao'   => $data['responsavel_alteracao']
                    ]
                );
            }
            elseif ($tipo === 'editarComentarios')
            {
                $sql = 'UPDATE dispositivos_computadores
                SET
                    descricao = :comentario
                WHERE id = :id';

                $stmt = $this->db->prepare($sql);
                $stmt->execute(
                    [
                        ':id' => $data['id'],
                        ':comentario' => $data['comentario']
                    ]
                );
            }

            return true;
        }
        catch(PDOException $e)
        {
            $texto = $e->getMessage();

            return $texto;
        }
    }

    public function apagarComputador($id) 
    {
        try
        {
            $sql = "DELETE 
                FROM dispositivos_computadores 
                WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        }
        catch (PDOException $e) 
        {    
            return false;
        }
    }
}