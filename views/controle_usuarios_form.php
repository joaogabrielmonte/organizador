<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title><?= $editando ? 'Editar Usuário' : 'Novo Usuário' ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <style>
    body {
      background-color: <?= $tema === 'dark' ? '#121212' : '#f0f2f5' ?>; /* Ajuste para light mode */
      color: <?= $tema === 'dark' ? '#e0e0e0' : '#222' ?>;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
    }
    .container {
      max-width: 600px;
      margin: 3rem auto;
      padding: 0 1rem;
    }
    h1 {
      font-weight: 700;
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
      color: <?= $tema === 'dark' ? '#f87171' : '#b91c1c' ?>;
    }
    label {
      display: block;
      margin-bottom: 0.25rem;
      font-weight: 600;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border-radius: 0.375rem;
      border: 1px solid <?= $tema === 'dark' ? '#444' : '#ccc' ?>;
      background-color: <?= $tema === 'dark' ? '#1f2937' : '#ffffff' ?>; /* Ajuste para light mode */
      color: <?= $tema === 'dark' ? '#eee' : '#222' ?>;
    }
    input[type="checkbox"] {
      margin-right: 0.5rem;
    }
    .btn-save {
      background-color: <?= $tema === 'dark' ? '#f87171' : '#b91c1c' ?>;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .btn-save:hover {
      background-color: <?= $tema === 'dark' ? '#ef4444' : '#991b1b' ?>;
    }
    .btn-cancel {
      margin-left: 1rem;
      background-color: <?= $tema === 'dark' ? '#374151' : '#ccc' ?>;
      color: <?= $tema === 'dark' ? '#aaa' : '#555' ?>;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.2s ease;
    }
    .btn-cancel:hover {
      background-color: <?= $tema === 'dark' ? '#4b5563' : '#bbb' ?>;
    }
    .error-msg {
      background-color: #ef4444;
      color: white;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><?= $editando ? 'Editar Usuário' : 'Novo Usuário' ?></h1>

    <?php if (!empty($erro)): ?>
      <div class="error-msg"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="post" action="controle_usuarios.php">
      <input type="hidden" name="action" value="<?= $editando ? 'update' : 'store' ?>" />
      <input type="hidden" name="id" value="<?= htmlspecialchars($usuarioParaForm['id'] ?? '') ?>" />

      <label for="login">Login *</label>
      <input type="text" id="login" name="login" required value="<?= htmlspecialchars($usuarioParaForm['login'] ?? '') ?>" />

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuarioParaForm['nome'] ?? '') ?>" />

      <label for="email">E-mail</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuarioParaForm['email'] ?? '') ?>" />

      <label for="ativo" class="flex items-center">
        <input type="checkbox" id="ativo" name="ativo" <?= ($usuarioParaForm['ativo'] ?? false) ? 'checked' : '' ?> />
        Ativo
      </label>

      <label for="senha"><?= $editando ? 'Nova senha (deixe em branco para não alterar)' : 'Senha *' ?></label>
      <input type="password" id="senha" name="senha" <?= $editando ? '' : 'required' ?> />

      <button type="submit" class="btn-save"><?= $editando ? 'Salvar Alterações' : 'Cadastrar Usuário' ?></button>
      <a href="controle_usuarios.php" class="btn-cancel">Cancelar</a>
    </form>
  </div>
</body>
</html>