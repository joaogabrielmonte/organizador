<?php
// index.php (na raiz do seu projeto - Redirecionamento simples para welcome)

// Redireciona o navegador para a página de boas-vindas.
// O caminho é relativo à localização do index.php para o arquivo welcome.php
// que está agora dentro da pasta 'controllers'.
header('Location: controllers/welcome.php');
exit;
?>