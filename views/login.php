<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <title>Login - Organizador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body class="flex items-center justify-center min-h-screen overflow-hidden">

    <div id="tsparticles"></div>

    <div class="login-card">

        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold tracking-wide heading-gradient select-none">DATA CORE</h1>
            <p class="text-gray-400 mt-2 text-md select-none">Autenticação de Acesso</p>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="error-msg"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6" autocomplete="off" spellcheck="false">
            <input
                type="text"
                name="usuario"
                placeholder="Identificador"
                required
                autofocus
                class="input-custom"
            />
            <input
                type="password"
                name="senha"
                placeholder="Chave de Segurança"
                required
                class="input-custom"
            />
            <button type="submit" class="btn-login">VERIFICAR</button>
        </form>

        <div class="footer-text">© <?= date('Y') ?> Desenvolvido por KINGLYTIC</div>
    </div>

    <script>
        tsParticles.load("tsparticles", {
            background: { color: "transparent" },
            fullScreen: { enable: false },
            particles: {
                number: { value: 60 },
                color: { value: ["#E50000", "#FF3333", "#E6EDF3"] }, /* Cores das partículas: tons de vermelho e branco */
                opacity: { value: { min: 0.1, max: 0.4 } },
                size: { value: { min: 1, max: 4 } },
                links: {
                    enable: true,
                    distance: 120,
                    color: "#330000", /* Cor das linhas vermelha escura */
                    opacity: 0.3,
                    width: 1
                },
                move: {
                    enable: true,
                    direction: "none",
                    speed: 0.5,
                    outModes: { default: "bounce" }
                },
                shape: { type: "circle" }
            },
            interactivity: {
                events: { onHover: { enable: true, mode: "grab" } },
                modes: { grab: { distance: 160, links: { opacity: 0.6 } } }
            }
        });
    </script>
</body>
</html>