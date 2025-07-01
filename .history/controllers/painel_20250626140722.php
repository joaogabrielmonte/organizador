<?php
// Arquivo: config/painel.php

// Fuso horário
date_default_timezone_set('America/Sao_Paulo');
session_start();

// Inclusão da lógica de autenticação
// Caminho relativo de 'config/painel.php' para 'includes/auth.php'
include __DIR__ . '/../includes/auth.php';
checkLogin(); // Certifica-se de que o usuário está logado

// Pega o tema da sessão
$tema = $_SESSION['tema'] ?? 'dark';

// Inclusão da lógica de rotinas (carregar e salvar)
// Caminho relativo de 'config/painel.php' para 'includes/rotinas.php'
include __DIR__ . '/../includes/rotinas.php';

// Carrega as rotinas (função de includes/rotinas.php)
$rotinas = carregarRotinas();

// Processamento da lógica de exclusão de rotina
if (isset($_GET['excluir'])) {
    $idExcluir = $_GET['excluir'];
    // Filtra as rotinas, removendo a que corresponde ao ID e ao usuário logado
    $rotinas = array_filter($rotinas, function($r) use ($idExcluir) {
        return !($r['id'] === $idExcluir && $r['usuario'] === $_SESSION['usuario']);
    });
    // Reindexa o array para evitar chaves vazias ou não sequenciais
    $rotinas = array_values($rotinas); 
    salvarRotinas($rotinas); // Salva as rotinas atualizadas
    header("Location: painel.php"); // Redireciona para evitar re-envio do formulário
    exit;
}

// Processamento da lógica de adição de nova rotina
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $nova = [
        'id' => uniqid(), // Gera um ID único para a nova rotina
        'usuario' => $_SESSION['usuario'],
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'horario' => $_POST['horario'],
        'criado_em' => date('Y-m-d H:i:s'),
        'feito' => false,
        'comentarios' => []
    ];
    $rotinas[] = $nova; // Adiciona a nova rotina ao array
    salvarRotinas($rotinas); // Salva as rotinas atualizadas
    header("Location: painel.php"); // Redireciona
    exit;
}

// Processamento da lógica de adicionar comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario'], $_POST['id_comentario'])) {
    $id = $_POST['id_comentario'];
    foreach ($rotinas as &$r) { // Usa referência para modificar o array original
        if ($r['id'] === $id && $r['usuario'] === $_SESSION['usuario']) {
            $r['comentarios'][] = [
                'texto' => $_POST['comentario'],
                'data' => date('Y-m-d H:i:s')
            ];
            salvarRotinas($rotinas); // Salva as rotinas atualizadas
            header("Location: painel.php"); // Redireciona
            exit;
        }
    }
    unset($r); // Remove a referência
}

// Processamento da lógica de marcar/desmarcar como feito
if (isset($_GET['feito'])) {
    $idFeito = $_GET['feito'];
    foreach ($rotinas as &$r) { // Usa referência para modificar o array original
        if ($r['id'] === $idFeito && $r['usuario'] === $_SESSION['usuario']) {
            $r['feito'] = !$r['feito']; // Inverte o status 'feito'
            salvarRotinas($rotinas); // Salva as rotinas atualizadas
            header("Location: painel.php"); // Redireciona
            exit;
        }
    }
    unset($r); // Remove a referência
}

// Inclui a view (o arquivo HTML). As variáveis PHP ($usuario, $tema, $rotinas)
// estarão disponíveis para serem usadas dentro da view.
require_once __DIR__ . '/../views/painel.php';