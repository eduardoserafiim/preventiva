<?php

session_start();

try
{
    session_unset();            
    session_destroy();
    
    session_start();  

    $_SESSION['mensagem'] =
    [
        'tipo' => 'success',
        'titulo' => 'Logout realizado!',
        'texto' => 'Você foi deslogado.'
    ];
    
    header("Location: ../../view/login.php");
    exit();
}
catch (Exception $e)
{
    echo 'Houve algum problema e não foi possivel fazer o logout.';

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    $_SESSION['mensagem'] =
    [
        'tipo' => 'warning',
        'titulo' => 'Não foi possível fazer logout!',
        'texto' => 'Você não foi deslogado.'
    ];

    header("Location: ../../view/index.php");
    exit();
}


