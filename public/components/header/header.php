<?php
$caminhoView = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/view/index.php')), '/') . '/';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPORTE HAP</title>
    <base href="<?= htmlspecialchars($caminhoView, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="../public/styles/styles.css?v=20260917">
    <link rel="icon" type="image/x-icon" href="../public/images/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="../public/styles/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/styles/sweetalert2.min.css">
</head>