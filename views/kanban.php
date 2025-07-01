<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Painel Kanban</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Oxanium', sans-serif; /* Fonte tecnológica */
      background: <?= $tema === 'dark' ? '#000000' : '#f0f2f5' ?>; /* Preto absoluto para dark mode */
      color: <?= $tema === 'dark' ? '#E6EDF3' : '#222' ?>; /* Cor do texto padrão */
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    /* Common Button Styles (matching painel) */
    .btn-common {
        background-color: <?= $tema === 'dark' ? '#E50000' : '#e2e8f0' ?>; /* Vermelho forte no dark mode */
        color: <?= $tema === 'dark' ? '#FFFFFF' : '#4b5563' ?>; /* Texto branco para alto contraste no dark mode */
        border: 1px solid <?= $tema === 'dark' ? '#FF3333' : '#d1d5db' ?>; /* Borda um pouco mais clara que o fundo do botão */
        box-shadow: <?= $tema === 'dark' ? '0 4px 10px rgba(255, 0, 0, 0.4)' : '0 2px 5px rgba(0,0,0,0.1)' ?>; /* Sombra mais visível e vermelha no dark mode */
        transition: all 0.3s ease;
        padding: 0.75rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-shadow: <?= $tema === 'dark' ? '0 0 5px rgba(255, 255, 255, 0.5)' : 'none' ?>; /* Sutil brilho no texto no dark mode */
    }
    .btn-common:hover {
        background: <?= $tema === 'dark' ? 'linear-gradient(90deg, #FF3333 0%, #E50000 100%)' : '#cbd5e1' ?>; /* Gradiente no hover do dark mode */
        color: <?= $tema === 'dark' ? '#FFFFFF' : '#333' ?>; /* Texto branco no hover do dark mode */
        box-shadow: <?= $tema === 'dark' ? '0 6px 15px rgba(255, 51, 51, 0.5)' : '0 4px 8px rgba(0,0,0,0.2)' ?>; /* Sombra mais intensa no hover */
        transform: translateY(-1px);
    }

    /* Kanban Column Styling */
    .kanban-column {
      background: <?= $tema === 'dark' ? 'rgba(18, 18, 18, 0.9)' : 'rgba(255, 255, 255, 0.9)' ?>; /* Matching login/painel backgrounds */
      backdrop-filter: blur(8px); /* Increased blur for consistency */
      -webkit-backdrop-filter: blur(8px);
      border-radius: 1.5rem; /* More rounded corners */
      padding: 1.5rem;
      box-shadow: <?= $tema === 'dark' ? '0 12px 30px rgba(255, 0, 0, 0.15), 0 4px 10px rgba(255, 0, 0, 0.1)' : '0 8px 25px rgba(0, 0, 0, 0.1)' ?>; /* Red glow shadow for dark */
      display: flex;
      flex-direction: column;
      min-height: 300px;
      transition: all 0.3s ease;
      border: <?= $tema === 'dark' ? '1px solid rgba(60, 0, 0, 0.6)' : '1px solid #e2e8f0' ?>; /* Red border for dark */
    }

    .kanban-column.drag-over {
      background-color: <?= $tema === 'dark' ? 'rgba(255, 51, 51, 0.15)' : '#fee2e2' ?>; /* Lighter red for drag-over in dark */
      box-shadow: <?= $tema === 'dark' ? '0 0 40px 8px rgba(255, 51, 51, 0.7)' : '0 0 40px 5px #f87171aa' ?>; /* More intense red glow */
      border: 2px dashed <?= $tema === 'dark' ? '#E50000' : '#f87171' ?>; /* Solid red dashed border */
    }

    /* Task Styling */
    .task {
      cursor: grab;
      background: <?= $tema === 'dark' ? '#0A0A0A' : '#ffffff' ?>; /* Darker background for tasks in dark mode */
      border: 1px solid <?= $tema === 'dark' ? '#330000' : '#e2e8f0' ?>; /* Matching input border */
      box-shadow: 0 1.5px 5px rgb(0 0 0 / 0.1);
      padding: 0.75rem 1rem;
      border-radius: 0.75rem;
      font-weight: 600;
      transition: all 0.3s ease;
      user-select: none;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
      color: <?= $tema === 'dark' ? '#E6EDF3' : '#333' ?>;
    }

    .task:hover {
      transform: scale(1.03);
      box-shadow: <?= $tema === 'dark' ? '0 6px 12px rgba(255, 0, 0, 0.4)' : '0 6px 12px rgb(248 113 113 / 0.4)' ?>; /* Red glow on hover */
      background-color: <?= $tema === 'dark' ? 'rgba(26, 0, 0, 0.8)' : '#fff0f3' ?>; /* Dark red background on hover */
    }

    .task.dragging {
      opacity: 0.6;
      cursor: grabbing;
      box-shadow: 0 0 25px 5px rgba(255, 51, 51, 0.7); /* More intense drag glow */
      transform: scale(0.95);
    }

    /* Delete Button */
    .delete-btn {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      color: #CC0000; /* Stronger red for delete */
      font-weight: bold;
      font-size: 1.2rem;
      cursor: pointer;
      opacity: 0.6;
      transition: opacity 0.2s ease;
      user-select: none;
      line-height: 1;
    }
    .task:hover .delete-btn {
      opacity: 1;
    }

    /* Column Headers (h2) */
    h2 {
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      user-select: none;
      /* Gradient text for titles */
      background: linear-gradient(90deg, #FF3333, #E50000);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: <?= $tema === 'dark' ? '0 0 10px rgba(229, 0, 0, 0.3)' : 'none' ?>; /* Subtle red glow for dark */
    }

    h2 i {
      animation-duration: 2.5s;
      animation-iteration-count: infinite;
    }
    .slow-spin { animation: slow-spin 4s linear infinite; }
    .fa-spin { animation: fa-spin 1.5s linear infinite; }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

    @keyframes slow-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

    /* Layout Grid */
    .kanban-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 1.25rem;
    }

    /* New Task Form */
    form.nova-tarefa-form {
      margin-top: auto;
      display: flex;
      gap: 0.75rem;
    }

    form.nova-tarefa-form input[type="text"] {
      flex-grow: 1;
      padding: 0.9rem 1.2rem; /* Matching login input padding */
      border-radius: 0.75rem; /* More rounded */
      border: 1px solid <?= $tema === 'dark' ? '#330000' : '#cbd5e1' ?>; /* Matching login input border */
      background: <?= $tema === 'dark' ? '#0A0A0A' : '#f8fafc' ?>; /* Matching login input background */
      color: <?= $tema === 'dark' ? '#E6EDF3' : '#333' ?>; /* Matching login input text color */
      font-weight: 600;
      font-size: 0.9rem;
      box-shadow: inset 0 0 5px rgb(0 0 0 / 0.1);
      transition: all 0.3s ease;
    }

    form.nova-tarefa-form input[type="text"]::placeholder {
      color: <?= $tema === 'dark' ? '#8B949E' : '#a0aec0' ?>; /* Matching login input placeholder */
      opacity: 0.8;
    }

    form.nova-tarefa-form input[type="text"]:focus {
      outline: none;
      border-color: <?= $tema === 'dark' ? '#E50000' : '#93c5fd' ?>; /* Matching login input focus border */
      background: <?= $tema === 'dark' ? '#1A0000' : '#ffffff' ?>; /* Matching login input focus background */
      box-shadow: <?= $tema === 'dark' ? '0 0 10px rgba(229, 0, 0, 0.5)' : '0 0 10px rgba(147,197,253,0.5)' ?>; /* Matching login input focus shadow */
    }

    form.nova-tarefa-form button {
      background: linear-gradient(90deg, #E50000 0%, #FF3333 100%); /* Matching primary button gradient */
      color: white;
      font-weight: 700;
      padding: 0.75rem 1rem; /* Adjusted padding */
      border-radius: 0.5rem;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      user-select: none;
      box-shadow: 0 4px 10px rgba(229, 0, 0, 0.3);
    }

    form.nova-tarefa-form button:hover {
      background: linear-gradient(90deg, #FF3333 0%, #E50000 100%); /* Invert gradient on hover */
      box-shadow: 0 6px 15px rgba(255, 51, 51, 0.4);
      transform: translateY(-1px);
    }

    form.nova-tarefa-form button i {
      animation: pulse 1.6s infinite;
    }

    /* Header for Kanban (matching dashboard) */
    .kanban-header {
      background: rgba(18, 18, 18, 0.9); /* Fundo quase preto translúcido */
      border-bottom: 1px solid rgba(60, 0, 0, 0.6); /* Borda vermelha escura sutil */
      box-shadow: 0 4px 15px rgba(255, 0, 0, 0.1); /* Sombra vermelha sutil */
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-radius: 0.75rem; /* Bordas arredondadas */
      padding: 1.5rem 2rem; /* Padding generoso */
      margin-bottom: 2.5rem; /* More space below header */
      color: #E6EDF3;
    }
    .kanban-header h1 {
        background: linear-gradient(90deg, #FF3333, #E50000);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
        text-shadow: 0 0 10px rgba(229, 0, 0, 0.3);
    }
    /* Link "Voltar para o Dashboard" and "Toggle Theme" button in header */
    .kanban-header .btn-common {
        background-color: <?= $tema === 'dark' ? '#E50000' : '#e2e8f0' ?>; /* Strong red for dark, light gray for light */
        color: <?= $tema === 'dark' ? '#FFFFFF' : '#4b5563' ?>;
        border: 1px solid <?= $tema === 'dark' ? '#FF3333' : '#d1d5db' ?>;
        box-shadow: <?= $tema === 'dark' ? '0 4px 10px rgba(255, 0, 0, 0.4)' : '0 2px 5px rgba(0,0,0,0.1)' ?>;
        transition: all 0.3s ease;
        padding: 0.75rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-shadow: <?= $tema === 'dark' ? '0 0 5px rgba(255, 255, 255, 0.5)' : 'none' ?>;
    }
    .kanban-header .btn-common:hover {
        background: <?= $tema === 'dark' ? 'linear-gradient(90deg, #FF3333 0%, #E50000 100%)' : '#cbd5e1' ?>;
        color: <?= $tema === 'dark' ? '#FFFFFF' : '#333' ?>;
        box-shadow: <?= $tema === 'dark' ? '0 6px 15px rgba(255, 51, 51, 0.5)' : '0 4px 8px rgba(0,0,0,0.2)' ?>;
        transform: translateY(-1px);
    }
    
    /* Light mode adjustments */
    body.bg-gray-100 { 
        background-color: #f0f2f5;
        color: #333;
    }
    body.bg-gray-100 .kanban-column,
    body.bg-gray-100 .task,
    body.bg-gray-100 form.nova-tarefa-form input[type="text"] {
        background-color: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        color: #333;
    }
    body.bg-gray-100 .kanban-column.drag-over {
        background-color: #fee2e2;
        border-color: #f87171;
        box-shadow: 0 0 40px 5px rgba(248, 113, 113, 0.7);
    }
    body.bg-gray-100 .task:hover {
        background-color: #fff0f3;
        box-shadow: 0 6px 12px rgb(248 113 113 / 0.4);
    }
    body.bg-gray-100 h2 {
        background: linear-gradient(90deg, #ef4444, #b91c1c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: none;
    }
    body.bg-gray-100 form.nova-tarefa-form input[type="text"]::placeholder {
        color: #a0aec0;
    }
    body.bg-gray-100 form.nova-tarefa-form input[type="text"]:focus {
        background-color: #ffffff;
        border-color: #93c5fd;
        box-shadow: 0 0 10px rgba(147,197,253,0.5);
    }
    body.bg-gray-100 form.nova-tarefa-form button {
        background: linear-gradient(90deg, #b91c1c 0%, #ef4444 100%);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.3);
    }
    body.bg-gray-100 form.nova-tarefa-form button:hover {
        background: linear-gradient(90deg, #ef4444 0%, #b91c1c 100%);
    }
    body.bg-gray-100 .kanban-header {
        background-color: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        color: #333;
    }
    body.bg-gray-100 .kanban-header h1 {
        background: linear-gradient(90deg, #ef4444, #b91c1c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: none;
    }
    
    /* Message Feedback (Redesigned) */
    #msg-feedback {
        position: fixed;
        bottom: 20px; /* Appear from bottom */
        left: 50%; /* Center horizontally */
        transform: translateX(-50%) translateY(20px); /* Start below center, invisible */
        color: #E6EDF3; /* Light text color */
        padding: 1rem 2rem;
        border-radius: 0.75rem; /* Rounded corners */
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease, transform 0.4s ease;
        z-index: 10000; /* Ensure it's on top */
        max-width: 380px; /* Slightly wider */
        text-align: center;
        border: 1px solid; /* Border for subtle definition */
        font-family: 'Oxanium', sans-serif; /* Consistent font */
        display: flex; /* Use flex for icon and text */
        align-items: center;
        gap: 0.75rem; /* Space between icon and text */
    }

    #msg-feedback.show {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(-50%) translateY(0); /* Slide up to visible */
    }

    /* Message Types (Colors with borders) */
    #msg-feedback.success {
        background-color: rgba(22, 163, 74, 0.9); /* Green translucent */
        border-color: rgba(34, 197, 94, 0.8); /* Lighter green border */
        box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
    }

    #msg-feedback.warning {
        background-color: rgba(217, 119, 6, 0.9); /* Amber translucent */
        border-color: rgba(253, 186, 116, 0.8); /* Lighter amber border */
        box-shadow: 0 8px 20px rgba(217, 119, 6, 0.4);
    }

    #msg-feedback.error {
        background-color: rgba(204, 0, 0, 0.9); /* Strong red translucent */
        border-color: rgba(255, 51, 51, 0.8); /* Lighter red border */
        box-shadow: 0 8px 20px rgba(204, 0, 0, 0.4);
    }
    
    /* Icon in message */
    #msg-feedback i {
        font-size: 1.25rem;
    }

    /* Header specific styles (from original code, just renamed class) */
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .icon-spin-on-hover { display: inline-block; transition: transform 0.3s ease; }
    a:hover .icon-spin-on-hover { animation: spin 1s linear infinite; }

  </style>
</head>

<body
  class="<?= $tema === 'dark' ? 'bg-black text-white' : 'bg-gray-100 text-gray-800' ?> min-h-screen">
  <div class="p-6 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6 kanban-header">
      <h1 class="text-3xl font-extrabold tracking-tight drop-shadow-md">🚀 Painel de Projetos - Kanban
      </h1>
      <div class="flex items-center gap-3"> <a href="dashboard.php"
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg select-none btn-common"
           title="Voltar para o Dashboard">
         <i class="fas fa-home"></i> Inicio
        </a>
        <button id="toggleTheme" 
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg select-none btn-common"
                title="Mudar Tema">
          <i class="fas <?= $tema === 'dark' ? 'fa-sun' : 'fa-moon' ?>"></i>
          <span class="hidden sm:inline"><?= $tema === 'dark' ? 'Modo Claro' : 'Modo Escuro' ?></span>
        </button>
      </div>
    </div>

    <div class="kanban-grid">
      <?php
      // Defined column colors for gradients and consistency
      $colunas = [
        'todo' => ['label' => 'A Fazer', 'color_start' => '#FF3333', 'color_end' => '#E50000', 'icon' => 'fa-hourglass-start', 'anim' => 'slow-spin'],
        'doing' => ['label' => 'Em Andamento', 'color_start' => '#E50000', 'color_end' => '#FF3333', 'icon' => 'fa-spinner', 'anim' => 'fa-spin'],
        'done' => ['label' => 'Concluído', 'color_start' => '#16a34a', 'color_end' => '#22c55e', 'icon' => 'fa-check-circle', 'anim' => 'animate-pulse'] // Green for done
      ];
      foreach ($colunas as $status => $info):
        $column_border_color = ($tema === 'dark') ? 'rgba(60, 0, 0, 0.6)' : '#e2e8f0'; 
        $column_shadow_color = ($tema === 'dark') ? 'rgba(255, 0, 0, 0.15)' : 'rgba(0,0,0,0.1)';
        ?>
        <div
          class="kanban-column"
          style="box-shadow: 0 12px 30px <?= $column_shadow_color ?>, 0 4px 10px <?= $column_shadow_color ?>; border: 1px solid <?= $column_border_color ?>;">
          <h2 style="background: linear-gradient(90deg, <?= $info['color_start'] ?>, <?= $info['color_end'] ?>); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: <?= $tema === 'dark' ? '0 0 10px rgba(229, 0, 0, 0.3)' : 'none' ?>;">
            <i class="fas <?= $info['icon'] ?> <?= $info['anim'] ?>"></i> <?= $info['label'] ?>
          </h2>
          <div class="space-y-3 kanban-column min-h-[120px]" data-status="<?= $status ?>">
            <?php foreach ($kanbanData[$status] as $tarefa): ?>
              <div class="task" draggable="true">
                <?= htmlspecialchars($tarefa) ?>
                <button type="button" class="delete-btn" title="Excluir tarefa">&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
          <form class="nova-tarefa-form mt-3 flex gap-2" data-status="<?= $status ?>">
            <input type="text" name="titulo" placeholder="Nova tarefa..." class="flex-1 p-2 rounded input-kanban-task" required>
            <button type="submit" class="px-3 py-2 rounded text-white text-sm font-bold btn-common">
              <i class="fas fa-plus animate-pulse"></i>
            </button>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div id="msg-feedback"></div>

  <script>
    const forms = document.querySelectorAll('.nova-tarefa-form');
    const columns = document.querySelectorAll('.kanban-column > div.kanban-column');
    const msgFeedback = document.getElementById('msg-feedback');

  /**
   * Exibe mensagem no topo com tipo (success, warning, error)
   * @param {string} msg - Texto da mensagem
   * @param {string} type - Tipo: 'success', 'warning', 'error'
   */
  function showMessage(msg, type = 'success') { // 'success' é o padrão
    msgFeedback.textContent = msg; // Text content only, icon added via JS
    // Add icon based on type
    let iconClass = '';
    if (type === 'success') iconClass = 'fa-check-circle';
    else if (type === 'warning') iconClass = 'fa-exclamation-triangle';
    else if (type === 'error') iconClass = 'fa-times-circle';

    // Create icon element
    const iconElement = document.createElement('i');
    iconElement.className = `fas ${iconClass}`;
    // Prepend icon to message feedback
    msgFeedback.prepend(iconElement);


    // Remove all type classes first
    msgFeedback.classList.remove('success', 'warning', 'error');

    // Add the class according to the type
    msgFeedback.classList.add(type);
    msgFeedback.classList.add('show');

    clearTimeout(msgFeedback._timeout);
    msgFeedback._timeout = setTimeout(() => {
      msgFeedback.classList.remove('show');
      msgFeedback.innerHTML = ''; // Clear content including icon after hiding
    }, 2500);
  }

    function createTaskElement(text) {
      const task = document.createElement('div');
      task.className = 'task';
      task.setAttribute('draggable', 'true');
      task.textContent = text;

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'delete-btn';
      btn.title = 'Excluir tarefa';
      btn.innerHTML = '&times;';
      btn.onclick = async (e) => {
        e.stopPropagation();
        task.remove();
        await saveKanban();
        showMessage('Tarefa excluída', 'error');
      };

      task.appendChild(btn);

      return task;
    }

    // On load, add events to existing delete buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.onclick = async (e) => {
        e.stopPropagation();
        const task = btn.closest('.task');
        if (task) {
          task.remove();
          await saveKanban();
          showMessage('Tarefa excluída', 'error');
        }
      };
    });

    forms.forEach(form => {
      form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const input = this.querySelector('input');
        const titulo = input.value.trim();
        if (!titulo) return;

        const status = this.dataset.status;
        const task = createTaskElement(titulo);

        document.querySelector(`[data-status="${status}"]`).appendChild(task);
        input.value = '';

        await saveKanban();
        showMessage('Tarefa adicionada', 'success');
      });
    });

    columns.forEach(col => {
      col.addEventListener('dragover', e => {
        e.preventDefault();
        col.classList.add('drag-over');
      });

      col.addEventListener('dragleave', () => {
        col.classList.remove('drag-over');
      });

      col.addEventListener('drop', async e => {
        e.preventDefault();
        const dragging = document.querySelector('.dragging');
        if (dragging) {
          col.appendChild(dragging);
          dragging.classList.remove('dragging');
          col.classList.remove('drag-over');
          await saveKanban();
          showMessage('Tarefa movida', 'warning');
        }
      });
    });

    document.addEventListener('dragstart', e => {
      if (e.target.classList.contains('task')) {
        e.target.classList.add('dragging');
      }
    });

    document.addEventListener('dragend', e => {
      if (e.target.classList.contains('task')) {
        e.target.classList.remove('dragging');
      }
    });

   // Inside views/kanban.php, in the saveKanban() function
async function saveKanban() {
  const data = {};
  document.querySelectorAll('.kanban-column > div.kanban-column').forEach(col => {
    const status = col.dataset.status;
    data[status] = [];
    col.querySelectorAll('.task').forEach(task => {
      let texto = '';
      for(let node of task.childNodes) {
        if(node.nodeType === Node.TEXT_NODE) {
          texto += node.nodeValue.trim();
        }
      }
      if(texto) data[status].push(texto);
    });
  });

  // Path from views/kanban.php to controllers/kanban.php
  await fetch('../controllers/kanban.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
}
  </script>

  <script>
    document.getElementById('toggleTheme').addEventListener('click', () => {
      fetch('../assets/tema.php', { method: 'POST' }) // Call backend to switch theme
        .then(() => {
          location.reload(); // Reload page to apply new theme
        });
    });
  </script>
</body>

</html>