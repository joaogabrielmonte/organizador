<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Organizador de Rotinas</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <style>
    #tsparticles {
      position: fixed;
      z-index: 0;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .content {
      position: relative;
      z-index: 1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
      animation: fadeIn 1s ease-out;
    }
  </style>
</head>
<body class="bg-black text-white min-h-screen flex items-center justify-center overflow-hidden font-sans">

  <div id="tsparticles"></div>

  <div class="content text-center px-4 animate-fadeIn">
    <h1 class="text-5xl font-semibold tracking-tight mb-4 text-gray-100">
      Organize com precisão.
    </h1>
    <p class="text-lg text-gray-400 mb-8 max-w-xl mx-auto">
      Painel moderno para gerenciar rotinas com estilo e controle total.
    </p>
    <a href="login.php"
       class="inline-block bg-white text-black hover:bg-rose-600 hover:text-white transition font-medium px-6 py-3 rounded shadow">
      Acessar painel
    </a>
  </div>

  <script>
    tsParticles.load("tsparticles", {
      fullScreen: { enable: false },
      background: { color: "transparent" },
      particles: {
        number: { value: 50 },
        size: { value: { min: 1.5, max: 3 } },
        color: { value: ["#ffffff", "#fda4af"] }, // branco + rosa claro
        opacity: { value: 0.5 },
        move: {
          enable: true,
          speed: 0.8,
          direction: "none",
          outModes: { default: "out" }
        },
        links: {
          enable: true,
          color: "#fda4af",
          distance: 120,
          opacity: 0.3
        }
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

</body>
</html>