<?php

session_start();

// Inclusão da lógica de autenticação
require_once __DIR__ . '/../includes/auth.php';
checkLogin(); // Certifica-se de que o usuário está logado

$usuarioLogado = $_SESSION['usuario'];
$tema = $_SESSION['tema'] ?? 'dark';

// Inclui o arquivo com as funções de CRUD de usuários (lerUsuarios, salvarUsuarios)
require_once __DIR__ . '/../includes/functions.php';

$usuarios = lerUsuarios(); // Carrega todos os usuários para manipulação
$erro = ''; // Para mensagens de erro no formulário
$flash = $_SESSION['flash'] ?? null; // Mensagem flash para a lista de usuários
unset($_SESSION['flash']);

// Dados iniciais para o formulário (novo usuário)
$editando = false;
$usuarioParaForm = [
    'id' => '',
    'login' => '',
    'nome' => '',
    'email' => '',
    'ativo' => true,
    'senha' => '', // Senha não será pré-preenchida no form por segurança
];

// --- Lógica de Processamento de Ações (GET e POST) ---

// Define a ação padrão (listar)
$action = $_GET['action'] ?? $_POST['action'] ?? 'list';
$id = $_GET['id'] ?? $_POST['id'] ?? null;

// Normaliza o ID para inteiro, se existir
if ($id !== null) {
    $id = (int)$id;
}

switch ($action) {
    case 'create':
        // Ação para exibir o formulário de criação
        // Variáveis $usuarioParaForm e $editando já estão definidas para um novo usuário
        require_once __DIR__ . '/../views/controle_usuarios_form.php';
        break;

    case 'store':
        // Ação para salvar um NOVO usuário (POST do formulário)
        $login = trim($_POST['login'] ?? '');
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $ativo = isset($_POST['ativo']) ? true : false;
        $senha = $_POST['senha'] ?? '';

        if (empty($login)) {
            $erro = "Login é obrigatório.";
        } elseif (empty($senha)) {
            $erro = "Senha é obrigatória para novos usuários.";
        } else {
            // Verifica se o login já existe (para evitar duplicatas)
            $loginExiste = false;
            foreach ($usuarios as $u) {
                if ($u['login'] === $login) {
                    $loginExiste = true;
                    break;
                }
            }
            if ($loginExiste) {
                $erro = "Este login já está em uso.";
            } else {
                $novoId = count($usuarios) > 0 ? max(array_column($usuarios, 'id')) + 1 : 1;
                $usuarios[] = [
                    'id' => $novoId,
                    'login' => $login,
                    'nome' => $nome,
                    'email' => $email,
                    'ativo' => $ativo,
                    'senha' => password_hash($senha, PASSWORD_DEFAULT), // Hash da senha
                ];
                if (salvarUsuarios($usuarios)) {
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Usuário cadastrado com sucesso.'];
                    header('Location: controle_usuarios.php');
                    exit;
                } else {
                    $erro = "Erro ao salvar os dados.";
                }
            }
        }
        // Se houver erro, preenche $usuarioParaForm com os dados enviados para manter o formulário preenchido
        $usuarioParaForm = [
            'id' => '',
            'login' => $login,
            'nome' => $nome,
            'email' => $email,
            'ativo' => $ativo,
            'senha' => '',
        ];
        require_once __DIR__ . '/../views/controle_usuarios_form.php'; // Reexibe o formulário com erro
        break;

    case 'edit':
        // Ação para exibir o formulário de edição
        if ($id === null) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'ID de usuário não especificado para edição.'];
            header('Location: controle_usuarios.php');
            exit;
        }

        foreach ($usuarios as $u) {
            if ($u['id'] === $id) {
                $usuarioParaForm = $u;
                $usuarioParaForm['senha'] = ''; // Não exibir senha existente por segurança
                $editando = true;
                break;
            }
        }
        if (!$editando) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Usuário para edição não encontrado.'];
            header('Location: controle_usuarios.php');
            exit;
        }
        require_once __DIR__ . '/../views/controle_usuarios_form.php';
        break;

    case 'update':
        // Ação para ATUALIZAR um usuário existente (POST do formulário)
        $idPost = $_POST['id'] ?? null;
        $login = trim($_POST['login'] ?? '');
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $ativo = isset($_POST['ativo']) ? true : false;
        $senha = $_POST['senha'] ?? ''; // Nova senha, se preenchida

        if ($idPost === null || empty($login)) {
            $erro = "Dados inválidos para atualização.";
        } else {
            $usuarioOriginal = null;
            foreach ($usuarios as &$u) {
                if ($u['id'] === $idPost) {
                    $usuarioOriginal = $u; // Guarda o usuário original para a senha
                    $u['login'] = $login;
                    $u['nome'] = $nome;
                    $u['email'] = $email;
                    $u['ativo'] = $ativo;
                    if (!empty($senha)) { // Só atualiza a senha se um novo valor for fornecido
                        $u['senha'] = password_hash($senha, PASSWORD_DEFAULT);
                    }
                    break;
                }
            }
            unset($u); // Quebra a referência para evitar problemas

            // Verifica se o login está duplicado (apenas se for diferente do original)
            $loginExiste = false;
            foreach ($usuarios as $u) {
                if ($u['id'] !== $idPost && $u['login'] === $login) {
                    $loginExiste = true;
                    break;
                }
            }

            if ($loginExiste) {
                $erro = "Este login já está em uso por outro usuário.";
            } elseif ($usuarioOriginal) {
                 if (salvarUsuarios($usuarios)) {
                    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Usuário atualizado com sucesso.'];
                    header('Location: controle_usuarios.php');
                    exit;
                } else {
                    $erro = "Erro ao salvar as alterações.";
                }
            } else {
                $erro = "Usuário não encontrado para atualização.";
            }
        }

        // Se houver erro, preenche $usuarioParaForm com os dados enviados para manter o formulário preenchido
        $usuarioParaForm = [
            'id' => $idPost,
            'login' => $login,
            'nome' => $nome,
            'email' => $email,
            'ativo' => $ativo,
            'senha' => '', // Nunca exiba a senha
        ];
        $editando = true; // Permanece no modo de edição
        require_once __DIR__ . '/../views/controle_usuarios_form.php'; // Reexibe o formulário com erro
        break;

    case 'delete':
        // Ação para EXCLUIR um usuário
        if ($id === null) {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'ID de usuário não especificado para exclusão.'];
            header('Location: controle_usuarios.php');
            exit;
        }
        
        $usuarioEncontrado = false;
        foreach ($usuarios as $index => $u) {
            if ($u['id'] === $id) {
                // Não permite que o próprio usuário logado se exclua
                if ($u['login'] === $usuarioLogado) {
                    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Você não pode excluir seu próprio usuário.'];
                    header('Location: controle_usuarios.php');
                    exit;
                }
                unset($usuarios[$index]);
                $usuarioEncontrado = true;
                break;
            }
        }

        if ($usuarioEncontrado) {
            $usuarios = array_values($usuarios); // Reindexar
            if (salvarUsuarios($usuarios)) {
                $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Usuário excluído com sucesso.'];
            } else {
                $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Erro ao excluir o usuário.'];
            }
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Usuário não encontrado para exclusão.'];
        }
        header('Location: controle_usuarios.php'); // Sempre redireciona para a lista após delete
        exit;
        break;

    case 'list':
    default:
        // Ação padrão: listar usuários
        usort($usuarios, function($a, $b) {
            return $a['id'] <=> $b['id']; // Ordena pelo ID
        });
        require_once __DIR__ . '/../views/controle_usuarios_lista.php';
        break;
}