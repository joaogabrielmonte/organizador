<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <title>Login - Organizador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #000000; /* Preto absoluto */
            font-family: 'Oxanium', sans-serif; /* Fonte tecnológica */
            color: #E6EDF3; /* Cor do texto padrão */
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
            background: rgba(18, 18, 18, 0.9); /* Fundo quase preto translúcido */
            border-radius: 1.5rem; /* Bordas mais arredondadas */
            border: 1px solid rgba(60, 0, 0, 0.6); /* Borda vermelha escura sutil */
            box-shadow: 0 12px 30px rgba(255, 0, 0, 0.15), 0 4px 10px rgba(255, 0, 0, 0.1); /* Sombra vermelha sutil */
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(8px); /* Efeito de desfoque no fundo */
            -webkit-backdrop-filter: blur(8px);
        }
        .input-custom {
            background: #0A0A0A; /* Fundo do input mais escuro */
            border: 1px solid #330000; /* Borda padrão do input vermelha escura */
            border-radius: 0.75rem;
            padding: 0.9rem 1.2rem;
            color: #E6EDF3;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }
        .input-custom::placeholder {
            color: #8B949E; /* Cinza mais escuro para placeholder */
        }
        .input-custom:focus {
            outline: none;
            border-color: #E50000; /* Vermelho vibrante de foco */
            background: #1A0000; /* Levemente mais claro no foco */
            box-shadow: 0 0 10px rgba(229, 0, 0, 0.5); /* Sombra vermelha no foco */
        }
        .btn-login {
            background: linear-gradient(90deg, #E50000 0%, #FF3333 100%); /* Gradiente vermelho para o botão */
            padding: 0.9rem;
            border-radius: 0.75rem;
            font-weight: 700;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            margin-top: 2rem;
            font-size: 1.15rem;
            user-select: none;
            color: #FFFFFF; /* Texto branco no botão para alto contraste */
            box-shadow: 0 6px 15px rgba(229, 0, 0, 0.3); /* Sombra vermelha */
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #FF3333 0%, #E50000 100%); /* Inverte o gradiente no hover */
            box-shadow: 0 8px 20px rgba(255, 51, 51, 0.4);
            transform: translateY(-2px);
        }
        .error-msg {
            background: #CC0000; /* Vermelho escuro para erro */
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #FFFFFF;
            box-shadow: 0 0 8px rgba(204, 0, 0, 0.6);
        }
        .footer-text {
            font-size: 0.8rem;
            color: #8B949E;
            text-align: center;
            margin-top: 2.5rem;
            user-select: none;
        }
        .heading-gradient {
            background: linear-gradient(90deg, #FF3333, #E50000); /* Gradiente vermelho para o título */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
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