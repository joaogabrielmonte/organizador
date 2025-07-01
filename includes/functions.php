<?php

define('USUARIOS_FILE', __DIR__ . '/../data/usuarios.json');

/**
 * Lê os usuários do arquivo JSON.
 * Retorna array de usuários (cada usuário é um array associativo).
 */
function lerUsuarios(): array
{
    if (!file_exists(USUARIOS_FILE)) {
        return [];
    }

    $json = file_get_contents(USUARIOS_FILE);
    $data = json_decode($json, true);

    // Se seu JSON é simples login=>senha, converte para formato esperado
    if ($data && array_keys($data) !== range(0, count($data) - 1)) {
        $usuarios = [];
        $id = 1;
        foreach ($data as $login => $senha) {
            $usuarios[] = [
                'id' => $id++,
                'login' => $login,
                'nome' => $login,
                'email' => '',
                'ativo' => true,
            ];
        }
        return $usuarios;
    }

    // Se já for array de usuários, só retorna
    return $data ?: [];
}

/**
 * Salva o array de usuários no arquivo JSON.
 * Recebe array de usuários.
 */
function salvarUsuarios(array $usuarios): bool
{
    $json = json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents(USUARIOS_FILE, $json) !== false;
}

/**
 * Busca usuário por ID, retorna o usuário ou null se não encontrado.
 */
function buscarUsuarioPorId(int $id): ?array
{
    $usuarios = lerUsuarios();
    foreach ($usuarios as $usuario) {
        if ($usuario['id'] === $id) {
            return $usuario;
        }
    }
    return null;
}
