<?php
require_once '../../db/db.php';
require_once '../../models/computadores.php';

session_start();

$url = $_POST['setor'];
$unidade = $_SESSION['unidade'];
$responsavel = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['privilegio'] === 'TI' && $_SESSION['setor'] === 'TI') 
{
    try 
    {
        $data = 
        [
            'semestre' => $_POST['semestre'],
            'ano' => $_POST['ano'],
            'unidade' => $unidade,
            'setor' => $_POST['setor'],
            'nome' => $_POST['nome'],
            'modelo' => $_POST['modelo'],
            'monitor' => $_POST['monitor'],
            'so' => $_POST['so'],
            'office' => $_POST['office'],
            'processador' => $_POST['processador'],
            'memoria' => $_POST['memoria'],
            'disco' => $_POST['disco'],
            'ip' => $_POST['ip'],
            'mac' => $_POST['mac'],
            'numserie' => $_POST['numserie'],
            'lacre' => $_POST['lacre'],
            'legendaA' => isset($_POST['legendaA']) ? 1 : 0,
            'legendaB' => isset($_POST['legendaB']) ? 1 : 0,
            'legendaC' => isset($_POST['legendaC']) ? 1 : 0,
            'legendaD' => isset($_POST['legendaD']) ? 1 : 0,
            'legendaE' => isset($_POST['legendaE']) ? 1 : 0,
            'legendaF' => isset($_POST['legendaF']) ? 1 : 0,
            'legendaG' => isset($_POST['legendaG']) ? 1 : 0,
            'legendaH' => isset($_POST['legendaH']) ? 1 : 0,
            'legendaI' => isset($_POST['legendaI']) ? 1 : 0,
            'status' => $_POST['status'],
            'cadastro' => $responsavel,
        ];

        $model = new ComputerModel();
        $model->criar($data);

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'success',
            'titulo' => 'Computador cadastrado com sucesso!',
            'texto' => 'O cadastro foi realizado com sucesso.'
        ];

        header("Location: ../../view/preventiva.php?url=".urlencode($url));
        exit();
    } 
    catch (Exception $e) 
    {
        echo 'Ocorreu algum erro no cadastro do computador: ', $e;

        $_SESSION['mensagem'] = 
        [
            'tipo' => 'warning',
            'titulo' => 'Erro ao cadastrar o computador!',
            'texto' => 'O computador não foi cadastrado no sistema.'
        ];

        header("Location: ../../view/computadores.php");
        exit();
    }
} 
else 
{
    echo 'Tipo de requisição não aceitável para a criação do computador.';

    $_SESSION['mensagem'] = 
    [
        'tipo' => 'error',
        'titulo' => 'Erro ao cadastrar o computador!',
        'texto' => 'O metódo solicitado não foi aceito ou você não tem permissão para criar computadores.'
    ];
    
    header("Location: ../../view/computadores.php");
    exit();
}