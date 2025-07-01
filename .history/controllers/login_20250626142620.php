<?php

session_start();

// Carrega a lista de usuários do JSON
$usuariosFilePath = __DIR__ . '/../data/usuarios.json';
$usuarios = json_decode(file_get_contents($usuariosFilePath), true) ?? [];

$erro = ''; // Variável para armazenar mensagens de erro

// Ao submeter o formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['usuario'] ?? '');
    $pass = $_POST['senha'] ?? ''; // Senha em texto puro digitada pelo usuário
    $usuarioAutenticado = null;

    foreach ($usuarios as $index => $u) {
        if ($u['login'] === $user && $u['ativo']) {
            if (str_starts_with($u['senha'], '$2y$') || str_starts_with($u['senha'], '$2a$')) {
                // Se for um hash, usa password_verify()
                if (password_verify($pass, $u['senha'])) {
                    $usuarioAutenticado = $u;
                    break;
                }
            } else {
                // Se NÃO for um hash (senha antiga em texto puro)
                if ($pass === $u['senha']) {
                    $usuarioAutenticado = $u;
                    
                    // IMPORTANTE: Hasheia a senha antiga e atualiza no JSON
                    $usuarios[$index]['senha'] = password_hash($pass, PASSWORD_DEFAULT);
                    file_put_contents($usuariosFilePath, json_encode($usuarios, JSON_PRETTY_PRINT));
                    
                    break;
                }
            }
        }
    }

    if ($usuarioAutenticado) {
        // Autenticado: salva na sessão e redireciona
        $_SESSION['usuario'] = $usuarioAutenticado['login'];
        $_SESSION['tema'] = $_SESSION['tema'] ?? 'dark';
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Usuário ou senha inválidos, ou conta inativa.";
    }
}

// Inclui a view (o arquivo HTML). As variáveis PHP definidas acima ($erro) estarão disponíveis nela.
require_once __DIR__ . '/../views/login.php';