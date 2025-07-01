<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - Bem-vindo <?= htmlspecialchars($usuario) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <style>
    /* Sidebar estilo */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0; /* ocupa toda a altura */
      width: 16rem; /* 256px */
      padding: 1.5rem;
      background-color: <?= $tema === 'dark' ? '#18181b' : '#e5e7eb' ?>;
      box-shadow: 2px 0 8px rgb(0 0 0 / 0.1);
      overflow-x: visible;
      transition: width 0.3s ease-in-out;
      z-index: 40;
    }

    /* Sidebar colapsada */
    .sidebar.collapsed {
      width: 5.5rem; /* espaço maior para botão */
    }

    /* Título do menu flex com espaço */
    .sidebar h2 {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      color: <?= $tema === 'dark' ? 'white' : 'black' ?>;
      user-select: none;
    }

    /* Esconder textos ao colapsar */
    .sidebar.collapsed .menu-text {
      display: none;
    }

    /* Links e detalhes centralizados no colapsado */
    .sidebar.collapsed nav a,
    .sidebar.collapsed details summary,
    .sidebar.collapsed details div a {
      justify-content: center;
    }
    .sidebar.collapsed details div {
      margin-left: 0;
    }

    /* Botão hamburguer dentro da sidebar no topo direito */
    #toggleSidebar {
      background: transparent; /* sem background */
      color: <?= $tema === 'dark' ? 'white' : 'black' ?>;
      border: none;
      cursor: pointer;
      padding: 0.4rem;
      border-radius: 9999px;
      font-size: 1.5rem;
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
      transition: color 0.3s;
      z-index: 50;
      /* Posicionamento */
      position: relative;
      /* alinhado ao topo direito do h2 */
      margin-left: auto;
      flex-shrink: 0;
    }

    #toggleSidebar:hover {
      color: <?= $tema === 'dark' ? '#f87171' : '#b91c1c' ?>; /* hover vermelho */
    }

    /* Ajuste conteúdo principal */
    .main {
      transition: margin-left 0.3s ease-in-out;
      margin-left: 16rem;
      min-height: 100vh;
      background-color: <?= $tema === 'dark' ? '#121212' : '#fff' ?>;
    }

    /* Conteúdo principal deslocado ao colapsar */
    .sidebar.collapsed ~ .main {
      margin-left: 5.5rem;
    }

    /* Header com padding para não encostar na sidebar */
    header.header-adjust {
      padding-left: 1rem;
      padding-right: 1rem;
      transition: margin-left 0.3s ease-in-out;
      
    }
    /* Ajusta o header quando sidebar está colapsada */
    .sidebar.collapsed ~ .main header.header-adjust {
      margin-left: 0;
    }

    @keyframes slide {
      0% {
        transform: translateX(-100%);
      }
      100% {
        transform: translateX(100%);
      }
    }
    .animate-slide {
      animation: slide 2s linear infinite;
    }
  </style>
</head>
<body class="<?= $tema === 'dark' ? 'bg-black text-white' : 'bg-white text-black' ?> min-h-screen flex">

  <aside id="sidebar" class="sidebar">
    <h2>
      <span class="menu-text"></span>
      <button id="toggleSidebar" aria-label="Abrir ou fechar menu">
        <i class="fas fa-bars"></i>
      </button>
    </h2>

    <?php
    // O PHP para carregar o menu do JSON ainda precisa estar aqui na view,
    // pois ele é responsável por "renderizar" o menu.
    // O caminho para o JSON é relativo a este arquivo de view, que está em 'views/'.
    // Portanto, precisa voltar dois níveis para chegar na raiz e então acessar 'data/'.
    $menu = json_decode(file_get_contents(__DIR__ . '/../data/menu.json'), true);
    ?>

    <nav class="flex flex-col gap-2">
      <?php foreach ($menu as $item): ?>
        <?php if (isset($item['submenu'])): ?>
          <details class="group">
            <summary
              class="cursor-pointer hover:text-rose-400 font-semibold flex items-center gap-2"
            >
              <i class="<?= $item['icone'] ?? 'fas fa-bars' ?>"></i>
              <span class="menu-text"><?= $item['titulo'] ?></span>
            </summary>
            <div class="ml-6 mt-2 flex flex-col gap-1">
              <?php foreach ($item['submenu'] as $sub): ?>
                <a
                  href="<?= $sub['link'] ?>"
                  class="hover:text-rose-400 text-sm flex items-center gap-2"
                >
                  <i class="<?= $sub['icone'] ?? 'fas fa-dot-circle' ?>"></i>
                  <span class="menu-text"><?= $sub['titulo'] ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </details>
        <?php else: ?>
          <a href="<?= $item['link'] ?>" class="hover:text-rose-400 flex items-center gap-2">
            <i class="<?= $item['icone'] ?? 'fas fa-circle' ?>"></i>
            <span class="menu-text"><?= $item['titulo'] ?></span>
          </a>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
  </aside>

  <div class="main flex-1">
    <header
      class="header-adjust <?= $tema === 'dark' ? 'bg-zinc-950' : 'bg-gray-100' ?> p-4 flex items-center justify-between shadow-md sticky top-0 z-30"
    >
      <h1 class="text-xl font-semibold">Dashboard</h1>
      <span class="hidden md:block text-sm text-gray-400">
        <?= htmlspecialchars($usuario) ?>
      </span>
    </header>

    <main class="p-6 max-w-4xl mx-auto flex flex-col items-center text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-wide text-red-400 drop-shadow-[0_0_8px_rgba(248,113,113,0.7)] flex items-center gap-3">
        <i class="fas fa-hand-wave animate-pulse"></i>
        Bem-vindo de volta, <span class="underline decoration-rose-300 decoration-4"><?= htmlspecialchars($usuario) ?></span>!
      </h2>
      <div class="w-24 h-[2px] bg-rose-400 rounded-full mb-6 relative overflow-hidden">
        <div class="absolute left-0 top-0 h-[2px] w-16 bg-gradient-to-r from-transparent via-white to-transparent
                     animate-slide"></div>
      </div>
      <p class="text-gray-400 font-mono text-lg max-w-md leading-relaxed">
        Seu painel está pronto para acelerar suas tarefas com foco e simplicidade.
      </p>
    </main>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleSidebar = document.getElementById('toggleSidebar');

    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });
  </script>
</body>
</html>