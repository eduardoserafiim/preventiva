<?php
require_once '../../db/db.php';
require_once "../../models/setores.php";
require_once '../../public/components/session/mensagem.php';

session_start();

$id = intval($_POST['id']);
$nome = trim($_POST['nome']);

if ($_SESSION['privilegio'] === 'administrador')
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        try
        {
            $data = 
            [
                'nome' => $nome,
            ];
        
            $model = new SetorModel();
            $model->atualizar($id, $data);

            getMensagemSession('success', 'Sucesso ao editar o setor!', 'Setor editado com sucesso.', 'setores.php', 'listar');
        }
        catch (Exception $e)
        {
            error_log('Ocorreu algum erro na edição do setor: '. $e->getMessage());

            getMensagemSession('error', 'Erro ao editar o setor!', 'Houve algum erro e o setor não foi editado.', 'setores.php', 'listar');
        }
    }
    else
    {
        error_log('Tipo de requisição não aceitável para a edição do setor.');

        getMensagemSession('error', 'Erro ao editar o setor!', 'O metódo solicitado não foi aceito.', 'setores.php');
    }
}
else
{
    error_log('Erro na verificação do privilégio.');

    getMensagemSession('error', 'Erro ao editar o setor!', 'Falta de privilégio do setor.', 'setores.php', 'listar');
}