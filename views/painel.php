<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Painel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
 <link rel="stylesheet" href="../assets/css/painel.css">
</head>

<body class="<?= $tema === 'dark' ? 'bg-black text-white' : 'bg-white text-black' ?>">

  <div id="tsparticles"></div>

  <div class="content">
    <header class="mb-10 flex flex-col md:flex-row justify-between items-center header-painel gap-4">
      <h1 class="text-2xl font-semibold tracking-tight text-title-secondary mb-2 md:mb-0">
        Olá, <span class="username"><?= htmlspecialchars($_SESSION['usuario']) ?></span>!
      </h1>

      <div class="flex flex-wrap justify-center gap-3">
        <a href="dashboard.php"
          class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm rounded btn-painel-secondary">
          <i class="fas fa-home"></i>
          <span class="hidden sm:inline">inicio</span>
        </a>

        <button id="toggleTheme" class="px-4 py-2 text-sm rounded btn-painel-secondary">
          <i class="fas <?= $tema === 'dark' ? 'fa-sun' : 'fa-moon' ?>"></i> <span
            class="hidden sm:inline"><?= $tema === 'dark' ? 'Modo Claro' : 'Modo Escuro' ?></span>
        </button>

        <a href="logout.php" class="px-4 py-2 text-sm rounded btn-painel-secondary">
          <i class="fas fa-sign-out-alt"></i> <span class="hidden sm:inline">Sair</span>
        </a>
      </div>
    </header>

    <form method="POST" action="painel.php"
      class="form-painel p-6 rounded-lg shadow mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
      <input name="titulo" placeholder="Título" class="input-painel p-2 rounded" required>
      <input name="descricao" placeholder="Descrição" class="input-painel p-2 rounded" required>
      <input name="horario" type="time" class="input-painel p-2 rounded" required>
      <button type="submit" class="btn-painel-primary px-4 py-2 rounded col-span-full font-medium">Adicionar
        Rotina</button>
    </form>

    <h2 class="text-xl font-semibold mb-6 heading-gradient">Suas Rotinas</h2>
    <ul class="space-y-6">
      <?php foreach ($rotinas as $r): ?>
        <?php if ($r['usuario'] === $_SESSION['usuario']): ?>
          <li class="p-5 rounded-lg shadow list-item-painel">
            <div class="flex justify-between items-center mb-3">
              <strong class="<?= $r['feito'] ? 'line-through text-gray-500' : 'heading-gradient' ?>">
                <?= htmlspecialchars($r['titulo']) ?>
              </strong>
              <div class="text-sm flex items-center gap-3">
                <a href="painel.php?feito=<?= $r['id'] ?>" class="text-green-400 hover:text-green-500">
                  <i class="fas <?= $r['feito'] ? 'fa-times-circle' : 'fa-check-circle' ?>"></i>
                  <?= $r['feito'] ? 'Desmarcar' : 'Marcar feito' ?>
                </a>
                <a href="painel.php?excluir=<?= $r['id'] ?>" class="text-red-400 hover:text-red-500"
                  onclick="return confirm('Deseja realmente excluir esta rotina?')">
                  <i class="fas fa-trash-alt"></i> Excluir
                </a>
              </div>
            </div>

            <p class="<?= $r['feito'] ? 'line-through text-gray-600' : 'text-gray-300' ?>">
              <?= htmlspecialchars($r['descricao']) ?>
            </p>
            <p class="text-sm text-gray-500 mt-1">Horário: <?= htmlspecialchars($r['horario']) ?></p>
            <p class="text-xs text-gray-600">Criado em: <?= date('d/m/Y H:i', strtotime($r['criado_em'])) ?></p>

            <details class="mt-4">
              <summary class="cursor-pointer text-sm comments-summary">
                <i class="fas fa-comment-dots"></i> Comentários (<?= count($r['comentarios']) ?>)
              </summary>
              <ul class="mt-2 max-h-40 overflow-y-auto p-2 rounded comments-container">
                <?php foreach ($r['comentarios'] as $c): ?>
                  <li class="mb-2 text-sm">
                    <span><?= htmlspecialchars($c['texto']) ?></span><br>
                    <small class="text-gray-500 text-xs"><?= date('d/m/Y H:i', strtotime($c['data'])) ?></small>
                  </li>
                <?php endforeach; ?>
              </ul>
              <form method="POST" action="painel.php" class="flex gap-2 mt-2">
                <input type="hidden" name="id_comentario" value="<?= $r['id'] ?>">
                <input name="comentario" placeholder="Novo comentário" class="flex-grow p-2 rounded input-painel" required>
                <button type="submit" class="btn-painel-primary px-3 py-1 rounded">
                  <i class="fas fa-plus"></i> Adicionar
                </button>
              </form>
            </details>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>

  <script>
    tsParticles.load("tsparticles", {
      fullScreen: { enable: false },
      background: { color: "transparent" },
      particles: {
        number: { value: 40 },
        size: { value: { min: 1.5, max: 3 } },
        color: { value: ["#E50000", "#FF3333", "#E6EDF3"] }, /* Adicionado branco para mais variedade */
        opacity: { value: 0.8 },
        move: { enable: true, speed: 0.8, direction: "none", outModes: { default: "bounce" } },
        links: { enable: true, color: "#E50000", distance: 120, opacity: 0.8 } /* Cor dos links das partículas */
      },
      interactivity: {
        events: {
          onHover: { enable: true, mode: "repulse" },
          onClick: { enable: true, mode: "push" }
        },
        modes: {
          repulse: { distance: 100 },
          push: { quantity: 2 }
        }
      }
    });
  </script>

  <script>
    document.getElementById('toggleTheme').addEventListener('click', () => {
      fetch('../assets/tema.php', { method: 'POST' }) // chamar a troca no backend
        .then(() => {
          location.reload(); // recarrega a página para aplicar o novo tema
        });
    });
  </script>

</body>

</html>