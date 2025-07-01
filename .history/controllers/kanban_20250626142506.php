<?php


session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  // Se não estiver logado E for uma requisição AJAX para salvar, retorna 403
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
      http_response_code(403);
      echo json_encode(['error'=>'Não autenticado']);
      exit;
  }
  // Caso contrário, redireciona para o login (fluxo normal do navegador)
  header('Location: login.php');
  exit;
}

$usuario = $_SESSION['usuario']; // Pega o nome de usuário da sessão
$tema = $_SESSION['tema'] ?? 'dark'; // Pega o tema da sessão ou define um padrão

// Garante que a pasta 'kanbans' existe
// O caminho é relativo a 'config/kanban.php'
$dir = __DIR__ . '/../kanbans'; 
if (!is_dir($dir)) {
  mkdir($dir, 0755, true);
}

// Cada usuário tem seu próprio arquivo JSON de Kanban
$file = "$dir/kanban_{$usuario}.json";

// --- Lógica de Salvamento (Antigo kanban_save.php) ---
// Verifica se é uma requisição POST e se o conteúdo é JSON (provavelmente vindo do JavaScript)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && file_get_contents('php://input')) {
    $raw  = file_get_contents('php://input');
    $data = json_decode($raw, true);

    // Validação básica do formato dos dados recebidos
    if (!is_array($data) || !isset($data['todo'], $data['doing'], $data['done'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['error'=>'Formato de dados inválido para o Kanban.']);
        exit;
    }

    // Persiste os dados recebidos no arquivo JSON do usuário
    if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) === false) {
        http_response_code(500); // Internal Server Error
        echo json_encode(['error'=>'Erro ao salvar os dados do Kanban.']);
        exit;
    }

    // Sucesso na operação de salvamento
    http_response_code(200);
    echo json_encode(['status'=>'ok']);
    exit; // É crucial sair aqui para não renderizar a view HTML após uma requisição AJAX de salvamento
}
// --- Fim da Lógica de Salvamento ---


// --- Lógica de Carregamento (Existente) ---
// Carrega os dados (ou estrutura vazia se o arquivo não existir)
if (file_exists($file)) {
  $kanbanData = json_decode(file_get_contents($file), true);
  // Garante que as chaves 'todo', 'doing', 'done' existem para evitar erros
  if (!isset($kanbanData['todo'], $kanbanData['doing'], $kanbanData['done'])) {
    $kanbanData = ['todo' => [], 'doing' => [], 'done' => []];
  }
} else {
  // Se o arquivo não existe, inicializa com uma estrutura vazia
  $kanbanData = ['todo' => [], 'doing' => [], 'done' => []];
}
// --- Fim da Lógica de Carregamento ---


// Inclui a view (o arquivo HTML). As variáveis PHP ($usuario, $tema, $kanbanData)
// estarão disponíveis para serem usadas dentro da view.
// O caminho é relativo de 'config/kanban.php' para 'views/kanban.php'
require_once __DIR__ . '/../views/kanban.php';