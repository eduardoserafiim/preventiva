<?php
require_once '../db/db.php';

require_once '../models/cameras.php';
require_once '../models/imagens.php';

require_once '../public/components/session/mensagem.php';

include '../public/rules/regrasImagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $acao = trim($_POST['acao']);
    $token = trim($_POST['token']);
}

class CamerasController
{
    public function criar($data)
    {
        try
        {
            $modelCameras = new CamerasModel();

            $acao = trim($_POST['acao']);

            if ($acao === 'criar')
            {
                $unidade        = $_POST['id_unidade'];
                $canais         = $_POST['canais'];
                $nome           = $_POST['nome'];
                $marca          = $_POST['marca'];
                $modelo         = $_POST['modelo'];
                $localizacao    = $_POST['localizacao'];
                $ip             = $_POST['ip'];
                $mac            = $_POST['mac'];

                $idImagemNovo = null;

                $pasta = '../upload/dvrs/';

                imagemRegras($pasta);

                $data =
                [
                    'unidade'        => $unidade,
                    'canais'         => $canais,
                    'nome'           => $nome,
                    'marca'          => $marca,
                    'modelo'         => $modelo,
                    'id_localizacao' => $localizacao,
                    'ip'             => $ip,
                    'mac'            => $mac
                ];

                if ($idImagemNovo) {
                    $data['id_imagem'] = $idImagemNovo;
                }

                $modelCameras->criar($data);
                
            }
            else
            {
                echo 'Falha na verificação da ação.';

                getMensagemSession('error', 'Erro na verificação', 'Não foi possivel verificar a ação.', 'cameras.php?url=criar&tipo=dvr');
            }
        }
        catch (PDOException $e)
        {
            return $e->getMessage();
        }
    }
}