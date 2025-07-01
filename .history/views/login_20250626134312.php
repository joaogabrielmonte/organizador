<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <title>Login - Organizador</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
  <style>
    body {
      background: #000000; /* preto */
      font-family: 'Inter', sans-serif;
    }
    #tsparticles {
      position: fixed;
      z-index: 0;
      top: 0; left: 0;
      width: 100%; height: 100%;
    }
    .login-card {
      position: relative;
      z-index: 1;
      background: #18181b; /* dark gray */
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgb(248 113 113 / 0.4); /* sombra rosa */
      padding: 3rem 2.5rem;
      width: 100%;
      max-width: 400px;
      color: white;
    }
    .input-custom {
      background: #1f1f23; /* cinza escuro */
      border: 1.5px solid transparent;
      border-radius: 0.75rem;
      padding: 0.75rem 1rem;
      color: white;
      transition: border-color 0.3s ease;
      width: 100%;
      font-size: 1rem;
    }
    .input-custom::placeholder {
      color: #9ca3af; /* cinza claro */
    }
    .input-custom:focus {
      outline: none;
      border-color: #f87171; /* rosa vivo */
      background: #2a2a2e; /* leve mais claro */
      box-shadow: 0 0 8px #f87171aa;
    }
    .btn-login {
      background-color: #f87171; /* rosa vivo */
      padding: 0.75rem;
      border-radius: 0.75rem;
      font-weight: 600;
      text-align: center;
      transition: background-color 0.3s ease;
      cursor: pointer;
      width: 100%;
      margin-top: 1.5rem;
      font-size: 1.1rem;
      user-select: none;
      box-shadow: 0 4px 8px rgb(248 113 113 / 0.6);
    }
    .btn-login:hover {
      background-color: #db5c5c; /* rosa escuro */
      box-shadow: 0 6px 12px rgb(219 92 92 / 0.7);
    }
    .error-msg {
      background: #b91c1c; /* vermelho escuro */
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      text-align: center;
      margin-bottom: 1rem;
      font-weight: 600;
      font-size: 0.875rem;
      box-shadow: 0 0 5px #b91c1caa;
    }
    .footer-text {
      font-size: 0.75rem;
      color: #9ca3af; /* cinza claro */
      text-align: center;
      margin-top: 2rem;
      user-select: none;
    }
    .logo {
      font-weight: 700;
      font-size: 1.8rem;
      margin-bottom: 2rem;
      color: #f87171; /* rosa vivo */
      letter-spacing: 0.12em;
      text-align: center;
      user-select: none;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen overflow-hidden">

  <div id="tsparticles"></div>

  <div class="login-card">

  <div class="mb-6 text-center">
    <h1 class="text-2xl font-light tracking-wide text-rose-400 select-none">Bem-vindo(a)</h1>
    <p class="text-gray-400 mt-1 text-sm select-none">Faça login para continuar</p>
  </div>

  <?php if (!empty($erro)): ?>
    <div class="error-msg"><?= htmlspecialchars($erro) ?></div>
  <?php endif; ?>

  <form method="POST" class="space-y-5" autocomplete="off" spellcheck="false">
    <input
      type="text"
      name="usuario"
      placeholder="Usuário"
      required
      autofocus
      class="input-custom"
    />
    <input
      type="password"
      name="senha"
      placeholder="Senha"
      required
      class="input-custom"
    />
    <button type="submit" class="btn-login">Entrar</button>
  </form>

  <div class="footer-text">© <?= date('Y') ?> by KINGLYTIC</div>
</div>

  <script>
    tsParticles.load("tsparticles", {
      background: { color: "transparent" },
      fullScreen: { enable: false },
      particles: {
        number: { value: 35 },
        color: { value: "#f87171" }, // rosa
        opacity: { value: 0.2 },
        size: { value: { min: 2, max: 6 } },
        move: {
          enable: true,
          direction: "top",
          speed: 0.8,
          outModes: { default: "out" }
        },
        shape: { type: "circle" }
      },
      interactivity: {
        events: { onHover: { enable: true, mode: "repulse" } },
        modes: { repulse: { distance: 150, duration: 0.4 } }
      }
    });
  </script>
</body>
</html>