<?php
require_once '../../db/db.php';
require_once '../../models/computadores.php';

session_start();

$url = $_POST['setor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['privilegio'] == 'TI' && $_SESSION['setor'] === 'TI') 
{
    try
    {        
        $id = intval($_POST['id']);

        $data = [
            'setor' => $_POST['setor'] ?? '',
            'nome' => $_POST['nome'] ?? '',
            'modelo' => $_POST['modelo'] ?? '',
            'processador' => $_POST['processador'] ?? '',
            'memoria' => $_POST['memoria'] ?? '',
            'disco' => $_POST['disco'] ?? '',
            'so' => $_POST['so'] ?? '',
            'office' => $_POST['office'] ?? '',
            'monitor' => $_POST['monitor'] ?? '',
            'ip' => $_POST['ip'] ?? '',
            'mac' => $_POST['mac'] ?? '',
            'numserie' => $_POST['numserie'] ?? '',
            'lacre' => $_POST['lacre'] ?? '',
            'status' => $_POST['status'] ?? '',
            'ano' => $_POST['ano'] ?? '',
            'semestre' => $_POST['semestre'] ?? '',
            'unidade' => $_POST['unidade'] ?? '',
            'legendaA' => isset($_POST['legendaA']) ? 1 : 0,
            'legendaB' => isset($_POST['legendaB']) ? 1 : 0,
            'legendaC' => isset($_POST['legendaC']) ? 1 : 0,
            'legendaD' => isset($_POST['legendaD']) ? 1 : 0,
            'legendaE' => isset($_POST['legendaE']) ? 1 : 0,
            'legendaF' => isset($_POST['legendaF']) ? 1 : 0,
            'legendaG' => isset($_POST['legendaG']) ? 1 : 0,
            'legendaH' => isset($_POST['legendaH']) ? 1 : 0,
            'legendaI' => isset($_POST['legendaI']) ? 1 : 0,
        ];
    
        $model = new ComputerModel();
        $model->atualizar($id, $data);

        echo 'Sucesso ao atualizar o computador.';

        $_SESSION['mensagem'] =
        [
            'tipo' => 'success',
            'titulo' => 'Computador atualizado com sucesso!',
            'texto' => 'A atualização foi realizada com sucesso.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
    catch (Exception $e)
    {
        echo 'Ocorreu algum erro na atualização do computador: ', $e;

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao atualizar o computador!',
            'texto' => 'O computador não foi atualizado no sistema.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    }
}
else
{
    echo "Tipo de requisição não aceitavel para a atualização do computador.";

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao atualizar o computador!',
        'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para atualizar esse computador.'
    ];

    header("Location: ../../view/preventiva.php?url=".urlencode($url));
    exit();
};
