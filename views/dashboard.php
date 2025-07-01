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
    body {
      /* Matching login's body background and text color */
      background: <?= $tema === 'dark' ? '#000000' : '#f0f2f5' ?>; /* Absolute black for dark mode */
      color: <?= $tema === 'dark' ? '#E6EDF3' : '#222' ?>; /* Light text for dark mode */
      min-height: 100vh;
      font-family: 'Inter', sans-serif; /* Keep your existing font family */
    }

    /* Sidebar style */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0; /* occupies full height */
      width: 16rem; /* 256px */
      padding: 1.5rem;
      /* Matching login's card background and subtle red border/shadow */
      background-color: <?= $tema === 'dark' ? 'rgba(18, 18, 18, 0.9)' : '#e5e7eb' ?>;
      border: <?= $tema === 'dark' ? '1px solid rgba(60, 0, 0, 0.6)' : 'none' ?>; /* Subtle red border */
      box-shadow: <?= $tema === 'dark' ? '0 12px 30px rgba(255, 0, 0, 0.15), 0 4px 10px rgba(255, 0, 0, 0.1)' : '2px 0 8px rgb(0 0 0 / 0.1)' ?>; /* Subtle red shadow */
      backdrop-filter: blur(8px); /* Blur effect */
      -webkit-backdrop-filter: blur(8px);
      overflow-x: visible;
      transition: width 0.3s ease-in-out;
      z-index: 40;
    }

    /* Sidebar collapsed */
    .sidebar.collapsed {
      width: 5.5rem; /* larger space for button */
    }

    /* Menu title flex with space */
    .sidebar h2 {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      color: <?= $tema === 'dark' ? '#E6EDF3' : 'black' ?>; /* Use light text color */
      user-select: none;
    }

    /* Hide texts when collapsed */
    .sidebar.collapsed .menu-text {
      display: none;
    }

    /* Centered links and details when collapsed */
    .sidebar.collapsed nav a,
    .sidebar.collapsed details summary,
    .sidebar.collapsed details div a {
      justify-content: center;
    }
    .sidebar.collapsed details div {
      margin-left: 0;
    }

    /* Hamburger button inside sidebar top right */
    #toggleSidebar {
      background: transparent; /* no background */
      color: <?= $tema === 'dark' ? '#E6EDF3' : 'black' ?>; /* Use light text color */
      border: none;
      cursor: pointer;
      padding: 0.4rem;
      border-radius: 9999px;
      font-size: 1.5rem;
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
      transition: color 0.3s;
      z-index: 50;
      position: relative;
      margin-left: auto;
      flex-shrink: 0;
    }

    #toggleSidebar:hover {
      color: <?= $tema === 'dark' ? '#E50000' : '#b91c1c' ?>; /* Red hover color */
    }

    /* Main content adjustment */
    .main {
      transition: margin-left 0.3s ease-in-out;
      margin-left: 16rem;
      min-height: 100vh;
      background-color: <?= $tema === 'dark' ? '#0A0A0A' : '#fff' ?>; /* Darker background for main content area */
    }

    /* Main content shifted when collapsed */
    .sidebar.collapsed ~ .main {
      margin-left: 5.5rem;
    }

    /* Header with padding not to touch sidebar */
    header.header-adjust {
      padding-left: 1rem;
      padding-right: 1rem;
      transition: margin-left 0.3s ease-in-out;
      /* Matching login's input background/border */
      background-color: <?= $tema === 'dark' ? '#0A0A0A' : '#f3f4f6' ?>; /* Darker background */
      border-bottom: <?= $tema === 'dark' ? '1px solid #330000' : 'none' ?>; /* Subtle red border */
    }
    /* Adjust header when sidebar is collapsed */
    .sidebar.collapsed ~ .main header.header-adjust {
      margin-left: 0;
    }

    /* Main content welcome text */
    h2.main-welcome-heading {
      color: <?= $tema === 'dark' ? '#E50000' : '#b91c1c' ?>; /* Primary red for welcome text */
      text-shadow: <?= $tema === 'dark' ? '0 0 10px rgba(229, 0, 0, 0.5)' : 'none' ?>; /* Glow for dark mode */
    }
    h2.main-welcome-heading .underline {
      text-decoration-color: <?= $tema === 'dark' ? '#FF3333' : '#e31a1a' ?>; /* Lighter red for underline */
    }

    /* Animated line below welcome text */
    div.animate-line {
      background-color: <?= $tema === 'dark' ? '#E50000' : '#b91c1c' ?>; /* Red color for the line */
    }

    /* Menu item hover color */
    nav a.hover\:text-rose-400:hover,
    details summary.hover\:text-rose-400:hover {
        color: <?= $tema === 'dark' ? '#E50000' : '#b91c1c' ?>; /* Primary red for menu item hover */
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
    // The PHP to load the menu from JSON still needs to be here in the view,
    // as it is responsible for "rendering" the menu.
    // The path to the JSON is relative to this view file, which is in 'views/'.
    // So, it needs to go up one level to the root and then access 'data/'.
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
      class="header-adjust p-4 flex items-center justify-between shadow-md sticky top-0 z-30"
    >
      <h1 class="text-xl font-semibold" style="color: <?= $tema === 'dark' ? '#E50000' : '#b91c1c' ?>;">Dashboard</h1> <span class="hidden md:block text-sm text-gray-400">
        <?= htmlspecialchars($usuario) ?>
      </span>
    </header>

    <main class="p-6 max-w-4xl mx-auto flex flex-col items-center text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-wide main-welcome-heading flex items-center gap-3">
        <i class="fas fa-hand-wave animate-pulse"></i>
        Bem-vindo de volta, <span class="underline decoration-4"><?= htmlspecialchars($usuario) ?></span>!
      </h2>
      <div class="w-24 h-[2px] rounded-full mb-6 relative overflow-hidden animate-line">
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