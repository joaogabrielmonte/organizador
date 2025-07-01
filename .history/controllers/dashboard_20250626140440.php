<?php

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php'); // Redireciona para a página de login se não estiver logado
    exit;
}

$usuario = $_SESSION['usuario']; // Pega o nome de usuário da sessão
$tema = $_SESSION['tema'] ?? 'dark'; // Pega o tema da sessão ou define um padrão

// ATENÇÃO: Se você tiver quaisquer funções PHP globais ou configurações que o dashboard precise
// (além do carregamento do menu, que moveremos para a view), inclua-as aqui.
// Por exemplo, se lerUsuarios() for usado em algum lugar neste arquivo para alguma lógica de dashboard,
// você precisaria incluir:
// require_once __DIR__ . '/../includes/functions.php';

// Inclui a view (o arquivo HTML). As variáveis PHP definidas acima ($usuario, $tema)
// estarão disponíveis para serem usadas dentro da view.
require_once __DIR__ . '/../views/dashboard.php';