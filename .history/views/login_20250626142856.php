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
            background: #0D1117; /* GitHub Dark Background */
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
            background: rgba(1, 4, 9, 0.8); /* Fundo mais escuro e translúcido */
            border-radius: 1.5rem; /* Bordas mais arredondadas */
            border: 1px solid rgba(48, 54, 61, 0.6); /* Borda sutil */
            box-shadow: 0 12px 30px rgba(0, 255, 255, 0.15), 0 4px 10px rgba(0, 255, 255, 0.1); /* Sombra azul/ciano sutil */
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 420px; /* Levemente mais largo */
            backdrop-filter: blur(8px); /* Efeito de desfoque no fundo */
            -webkit-backdrop-filter: blur(8px);
        }
        .input-custom {
            background: #161B22; /* Fundo do input mais escuro */
            border: 1px solid #30363D; /* Borda padrão do input */
            border-radius: 0.75rem;
            padding: 0.9rem 1.2rem; /* Mais padding */
            color: #E6EDF3;
            transition: all 0.3s ease; /* Transição mais suave */
            width: 100%;
            font-size: 1rem;
        }
        .input-custom::placeholder {
            color: #8B949E; /* Cinza mais escuro para placeholder */
        }
        .input-custom:focus {
            outline: none;
            border-color: #58A6FF; /* Azul de foco mais vibrante */
            background: #21262D; /* Levemente mais claro no foco */
            box-shadow: 0 0 10px rgba(88, 166, 255, 0.4); /* Sombra azul no foco */
        }
        .btn-login {
            background: linear-gradient(90deg, #58A6FF 0%, #00C7FF 100%); /* Gradiente azul para o botão */
            padding: 0.9rem;
            border-radius: 0.75rem;
            font-weight: 700; /* Mais negrito */
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            margin-top: 2rem; /* Mais espaço acima do botão */
            font-size: 1.15rem; /* Levemente maior */
            user-select: none;
            color: #0D1117; /* Cor do texto do botão para contraste */
            box-shadow: 0 6px 15px rgba(88, 166, 255, 0.3); /* Sombra azul */
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #00C7FF 0%, #58A6FF 100%); /* Inverte o gradiente no hover */
            box-shadow: 0 8px 20px rgba(0, 199, 255, 0.4);
            transform: translateY(-2px); /* Efeito de "levantar" */
        }
        .error-msg {
            background: #E5534B; /* Vermelho mais forte */
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            text-align: center;
            margin-bottom: 1.5rem; /* Mais margem */
            font-weight: 600;
            font-size: 0.9rem;
            color: #FFFFFF;
            box-shadow: 0 0 8px rgba(229, 83, 75, 0.6);
        }
        .footer-text {
            font-size: 0.8rem; /* Fonte ligeiramente maior */
            color: #8B949E;
            text-align: center;
            margin-top: 2.5rem;
            user-select: none;
        }
        .heading-gradient {
            background: linear-gradient(90deg, #00C7FF, #58A6FF); /* Gradiente para o título */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen overflow-hidden">

    <div id="tsparticles"></div>

    <div class="login-card">

        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold tracking-wide heading-gradient select-none">SYSTEM ACCESS</h1>
            <p class="text-gray-400 mt-2 text-md select-none">Insira suas credenciais</p>
        </div>

        <?php if (!empty($erro)): ?>
            <div class="error-msg"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6" autocomplete="off" spellcheck="false">
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
            <button type="submit" class="btn-login">ACESSAR</button>
        </form>

        <div class="footer-text">© <?= date('Y') ?> Desenvolvido por KINGLYTIC</div>
    </div>

    <script>
        tsParticles.load("tsparticles", {
            background: { color: "transparent" },
            fullScreen: { enable: false },
            particles: {
                number: { value: 60 }, /* Mais partículas */
                color: { value: ["#00C7FF", "#58A6FF", "#E6EDF3"] }, /* Cores das partículas: azul, ciano, branco */
                opacity: { value: { min: 0.1, max: 0.4 } }, /* Opacidade variada */
                size: { value: { min: 1, max: 4 } }, /* Tamanho menor */
                links: {
                    enable: true,
                    distance: 120, /* Distância das linhas */
                    color: "#30363D", /* Cor das linhas */
                    opacity: 0.3,
                    width: 1
                },
                move: {
                    enable: true,
                    direction: "none", /* Movimento aleatório */
                    speed: 0.5,
                    outModes: { default: "bounce" }
                },
                shape: { type: "circle" }
            },
            interactivity: {
                events: { onHover: { enable: true, mode: "grab" } }, /* Modo de interação "grab" */
                modes: { grab: { distance: 160, links: { opacity: 0.6 } } }
            }
        });
    </script>
</body>
</html>