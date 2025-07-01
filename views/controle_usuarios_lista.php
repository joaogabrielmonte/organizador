<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Controle de Usuários</title>
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
      max-width: 900px;
      margin: 3rem auto;
      padding: 0 1rem;
    }
    h1 {
      font-weight: 700;
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
      color: <?= $tema === 'dark' ? '#f87171' : '#b91c1c' ?>;
    }
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 0.75rem;
    }
    thead tr th {
      text-align: left;
      font-weight: 600;
      padding-bottom: 0.5rem;
      color: <?= $tema === 'dark' ? '#fca5a5' : '#7f1d1d' ?>;
      border-bottom: 1px solid <?= $tema === 'dark' ? '#333' : '#ccc' ?>;
    }
    tbody tr {
      background-color: <?= $tema === 'dark' ? '#1f2937' : '#ffffff' ?>; /* Ajuste para light mode */
      box-shadow: 0 2px 6px <?= $tema === 'dark' ? 'rgba(0,0,0,0.8)' : 'rgba(0,0,0,0.1)' ?>;
      border-radius: 0.5rem;
      transition: background-color 0.3s ease;
    }
    tbody tr:hover {
      background-color: <?= $tema === 'dark' ? '#374151' : '#f3f4f6' ?>;
    }
    tbody tr td {
      padding: 0.75rem 1rem;
      vertical-align: middle;
    }
    .ativo {
      display: inline-block;
      padding: 0.15rem 0.5rem;
      font-size: 0.85rem;
      border-radius: 9999px;
      font-weight: 600;
      color: white;
    }
    .ativo.true {
      background-color: #22c55e; /* verde */
    }
    .ativo.false {
      background-color: #ef4444; /* vermelho */
    }
    .actions a {
      margin-right: 1rem;
      color: <?= $tema === 'dark' ? '#93c5fd' : '#2563eb' ?>;
      font-size: 1.1rem;
      transition: color 0.2s ease;
    }
    .actions a:hover {
      color: <?= $tema === 'dark' ? '#bfdbfe' : '#1d4ed8' ?>;
    }
    .btn-novo {
      background-color: <?= $tema === 'dark' ? '#f87171' : '#b91c1c' ?>;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: background-color 0.2s ease;
      margin-bottom: 1.5rem;
    }
    .btn-novo:hover {
      background-color: <?= $tema === 'dark' ? '#ef4444' : '#991b1b' ?>;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($flash): ?>
  <div class="mb-4 px-4 py-3 rounded text-white
             <?= $flash['type'] === 'success' ? 'bg-green-600' : 'bg-red-600' ?>">
    <?= htmlspecialchars($flash['msg']) ?>
  </div>
<?php endif; ?>
    <h1>Controle de Usuários</h1>
    <a href="controle_usuarios.php?action=create" class="btn-novo">
      <i class="fas fa-user-plus"></i> Novo Usuário
    </a>
    <a href="dashboard.php" class="btn-novo mt-2 bg-gray-600 hover:bg-gray-700">
  <i class="fas fa-arrow-left"></i> Voltar
</a>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Login</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['login']) ?></td>
          <td><?= htmlspecialchars($u['nome']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td>
            <span class="ativo <?= $u['ativo'] ? 'true' : 'false' ?>">
              <?= $u['ativo'] ? 'Ativo' : 'Inativo' ?>
            </span>
          </td>
          <td class="actions">
            <a href="controle_usuarios.php?action=edit&id=<?= $u['id'] ?>" title="Editar"><i class="fas fa-edit"></i></a>
            <a href="controle_usuarios.php?action=delete&id=<?= $u['id'] ?>" title="Excluir" onclick="return confirm('Deseja realmente excluir este usuário?');"><i class="fas fa-trash-alt"></i></a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>