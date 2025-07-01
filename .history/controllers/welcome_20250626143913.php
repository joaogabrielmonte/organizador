<?php
// Arquivo: controllers/welcome.php

// A linha session_start(); foi REMOVIDA daqui
// porque já é chamada uma vez no index.php principal.

// Se o usuário já está logado, redireciona para o dashboard
// ATENÇÃO: Os redirecionamentos devem usar URLs amigáveis agora!
if (isset($_SESSION['usuario'])) {
    header("Location: /dashboard"); // Redireciona para a rota amigável
    exit;
}

// Inclui a view (o arquivo HTML).
// O caminho é '__DIR__ . /../views/welcome.php' porque welcome.php está em 'controllers/'
// e precisa voltar um nível ('/../') para acessar a pasta 'views/'.
require_once __DIR__ . '/../views/welcome.php';