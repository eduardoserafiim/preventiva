<?php
session_start();  

try
{
    session_unset();            
    session_destroy();
    
    header("Location: ../../view/login.php");
    exit();
}
catch (Exception $e)
{
    echo 'Houve algum problema e não foi possivel fazer o logout.';

    $_SESSION['mensagem'] =
    [
        'tipo' => 'warning',
        'titulo' => 'Não foi possível fazer logout!',
        'texto' => 'Você não foi deslogado.'
    ];

    header("Location ../../view/index.php");
    exit();
}


