<?php
// controllers/login.php

session_start(); // Start the session here, as index.php no longer does it globally for all controllers.

// Load the list of users from the JSON file
// The path is relative from 'controllers/login.php' to 'data/usuarios.json'
$usuariosFilePath = __DIR__ . '/../data/usuarios.json';
$usuarios = json_decode(file_get_contents($usuariosFilePath), true) ?? [];

$erro = ''; // Variable to store error messages

// If the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['usuario'] ?? '');
    $pass = $_POST['senha'] ?? ''; // Plaintext password entered by the user
    $usuarioAutenticado = null;

    foreach ($usuarios as $index => $u) {
        if ($u['login'] === $user && $u['ativo']) {
            // Check if the stored password is a hash (starts with $2y$ or $2a$)
            if (str_starts_with($u['senha'], '$2y$') || str_starts_with($u['senha'], '$2a$')) {
                // If it's a hash, use password_verify()
                if (password_verify($pass, $u['senha'])) {
                    $usuarioAutenticado = $u;
                    break;
                }
            } else {
                // If it's NOT a hash (i.e., an old plaintext password)
                // Compare directly AND HASH the password for future use.
                if ($pass === $u['senha']) {
                    $usuarioAutenticado = $u;
                    
                    // IMPORTANT: Hash the old password and update it in the JSON file
                    $usuarios[$index]['senha'] = password_hash($pass, PASSWORD_DEFAULT);
                    file_put_contents($usuariosFilePath, json_encode($usuarios, JSON_PRETTY_PRINT));
                    
                    break;
                }
            }
        }
    }

    if ($usuarioAutenticado) {
        // Authenticated: save to session and redirect
        $_SESSION['usuario'] = $usuarioAutenticado['login'];
        $_SESSION['tema'] = $_SESSION['tema'] ?? 'dark';
        // Redirect to the dashboard.php file, which is in the same 'controllers/' directory.
        header("Location: dashboard.php"); // Correct relative path
        exit;
    } else {
        $erro = "Usuário ou senha inválidos, ou conta inativa.";
    }
}

// Include the view (the HTML file). PHP variables defined above ($erro) will be available in it.
// The path is relative from 'controllers/login.php' to 'views/login.php'
require_once __DIR__ . '/../views/login.php';