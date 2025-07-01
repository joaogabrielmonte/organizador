<?php

session_start();

// Se o usuário já está logado, redireciona para o dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit;
}

// Inclui a view (o arquivo HTML).
// O caminho é '__DIR__ . /../views/welcome.php' porque welcome.php está em 'controllers/'
// e precisa voltar um nível ('/../') para acessar a pasta 'views/'.
require_once __DIR__ . '/../views/welcome.php';