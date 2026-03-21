<?php
require_once '../db/db.php';

require_once '../models/CameraDVRModel.php';

require_once '../public/components/session/mensagem.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $token = trim($_POST['token']);
}

class CameraController
{
    public function relacionarCameraComDVR($dataCameraDVR)
    {
        try
        {
            $modelCameraDVR = new CameraDVRModel();

            $tokenRecebido = trim($_POST['token']);
            $tokenAtual = $_SESSION['token'];

            if ($tokenAtual === $tokenRecebido)
            {
                $modelCameraDVR->relacionarCamerasComDVR($dataCameraDVR);

                getMensagemSession('success', 'Sucesso ao criar!', 'Relacionado com sucesso.', 'cameras.php');
            }
            else
            {
                echo 'Falha na verificação da ação.';

                getMensagemSession('error', 'Erro na verificação', 'Não foi possivel verificar a ação.', 'cameras.php?url=criar&tipo=dvr');
            }
        }
        catch (Error $e)
        {
            return $e->getMessage();
        }
    }
}

exit();

