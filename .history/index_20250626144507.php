<?php
// index.php (na raiz do seu projeto - AGORA É O ROTEADOR PRINCIPAL)

session_start(); // Inicia a sessão PHP

// Define o fuso horário (boa prática)
date_default_timezone_set('America/Sao_Paulo');

// Inclui arquivos de utilidade e funções globais
require_once __DIR__ . '/includes/auth.php'; // Para checkLogin()
require_once __DIR__ . '/includes/functions.php'; // Para lerUsuarios(), salvarUsuarios() etc.
require_once __DIR__ . '/includes/rotinas.php'; // Para carregarRotinas(), salvarRotinas() etc.

// --- LÓGICA DO ROTEADOR ---

// Obtém a URL requisitada (limpa de subdiretórios)
$requestUri = trim($_SERVER['REQUEST_URI'], '/');
// Se o projeto está em um subdiretório (ex: http://localhost/organizador/), remove o base path da URI
// ATENÇÃO: Ajuste esta linha se o seu `RewriteBase` no .htaccess for diferente de `/`.
// Se for `/seu_projeto/`, então $basePath deve ser '/seu_projeto/'.
$basePath = 'projetosporfolio/organizador/'; // <--- AJUSTE AQUI para o caminho do seu projeto
if ($basePath !== '/' && strpos($requestUri, trim($basePath, '/')) === 0) {
    $requestUri = substr($requestUri, strlen(trim($basePath, '/')));
}
$requestUri = trim($requestUri, '/'); // Remove barras extras

$segments = explode('/', $requestUri); // Divide a URL em segmentos

// Define a rota e os parâmetros
$route = $segments[0] ?? '';
$param1 = $segments[1] ?? null; // Usado para ações como 'editar', 'novo', 'excluir'
$param2 = $segments[2] ?? null; // Usado para IDs em 'editar/ID' ou 'excluir/ID'

// Lógica para obter o tema da sessão (coloque antes do roteamento principal, pois todos podem precisar)
$tema = $_SESSION['tema'] ?? 'dark';

// --- Despachador de Rotas (Controller Loader) ---
// Com base na rota, inclui o controlador apropriado
switch ($route) {
    case '': // Rota padrão (quando a URL é apenas /seu_projeto/)
        // Se o usuário já está logado, vá para o dashboard.
        // Se não, vá para a tela de welcome.
        if (isset($_SESSION['usuario'])) {
            require_once __DIR__ . '/controllers/dashboard.php';
        } else {
            require_once __DIR__ . '/controllers/welcome.php';
        }
        break;

    case 'welcome': // Se alguém acessar diretamente /seu_projeto/welcome
        require_once __DIR__ . '/controllers/welcome.php';
        break;

    case 'login':
        require_once __DIR__ . '/controllers/login.php';
        break;

    case 'dashboard':
        // Acesso direto ao dashboard deve verificar login, se não for feito pelo roteador global.
        // Já está coberto pela verificação global no topo.
        require_once __DIR__ . '/controllers/dashboard.php';
        break;

    case 'rotinas': // Usando /rotinas para o seu painel.php
        // As ações de exclusão/feito estão por GET.
        $_GET['excluir'] = ($param1 === 'excluir' && $param2) ? $param2 : null;
        $_GET['feito'] = ($param1 === 'feito' && $param2) ? $param2 : null;
        
        require_once __DIR__ . '/controllers/painel.php';
        break;

    case 'kanban':
        require_once __DIR__ . '/controllers/kanban.php';
        break;

    case 'admin': // Para rotas de administração como usuários
        if ($param1 === 'usuarios') {
            // Reenvia os parâmetros de action e id para o controlador unificado
            $_GET['action'] = $param2 ?? 'list'; // Ex: /admin/usuarios/novo -> action=novo
            $_GET['id'] = $segments[3] ?? null; // Ex: /admin/usuarios/editar/5 -> id=5
            
            require_once __DIR__ . '/controllers/controle_usuarios.php';
        } else {
            // Rota não encontrada dentro de admin
            http_response_code(404);
            echo "<h1>404 Not Found - Rota de administração não encontrada</h1>";
        }
        break;

    case 'logout':
        require_once __DIR__ . '/controllers/logout.php';
        break;

    // Rota para o tema (se você moveu assets/tema.php para controllers/tema.php)
    case 'tema':
        require_once __DIR__ . '/controllers/tema.php';
        break;

    default:
        // Se nenhuma rota for encontrada, exibe 404
        http_response_code(404);
        echo "<h1>404 Not Found - Página não encontrada</h1>";
        break;
}