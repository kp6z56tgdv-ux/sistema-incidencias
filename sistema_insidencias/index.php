<?php
session_start();
require_once 'auth.php';
verificarSesion();
$rol    = $_SESSION['rol'];
$nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk - Sistema de Tickets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="layout">

        <!-- ===== SIDEBAR ===== -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon">🎧</div>
                <div class="logo-text">
                    <span>Help</span><strong>Desk</strong>
                </div>
            </div>

            <nav class="sidebar-nav">
                <button class="nav-btn active" data-filter="all">
                    <span class="nav-icon">⊞</span>
                    Todos los tickets
                </button>
                <button class="nav-btn" data-filter="pending">
                    <span class="nav-icon">⏳</span>
                    Pendientes
                </button>
                <button class="nav-btn" data-filter="process">
                    <span class="nav-icon">⚙</span>
                    En proceso
                </button>
                <button class="nav-btn" data-filter="high">
                    <span class="nav-icon">🔺</span>
                    Alta prioridad
                </button>
            </nav>

            <div class="sidebar-divider"></div>

            <div class="filter-section">
                <p class="filter-heading">Filtros</p>

                <div class="filter-group">
                    <label>Estado</label>
                    <input type="text" id="filterEstado" placeholder="Buscar estado..." autocomplete="off">
                </div>
                <div class="filter-group">
                    <label>Asignado a</label>
                    <input type="text" id="filterAsignado" placeholder="Buscar responsable..." autocomplete="off">
                </div>
                <div class="filter-group">
                    <label>Prioridad</label>
                    <input type="text" id="filterPrioridad" placeholder="Baja, Media, Alta..." autocomplete="off">
                </div>
                <div class="filter-group">
                    <label>Tipo de solicitud</label>
                    <input type="text" id="filterTipo" placeholder="Incidencia, Desarrollo..." autocomplete="off">
                </div>
            </div>

            <button class="sidebar-refresh" onclick="location.reload()">
                <span>↻</span> Actualizar
            </button>
        </aside>

        <!-- ===== MAIN ===== -->
        <main class="main">

            <!-- Header -->
            <header class="page-header">
                <div class="header-info">
                    <p class="eyebrow">Panel de control</p>
                    <h1>Tickets abiertos</h1>
                    <p class="header-desc">Revisa las solicitudes más importantes y mantén el flujo de trabajo en un solo lugar.</p>
                </div>
                <div class="header-actions">
                    <div class="header-user">
                        <span class="header-user-name"><?= htmlspecialchars($nombre) ?></span>
                        <span class="role-badge role-<?= htmlspecialchars($rol) ?>"><?= ucfirst(htmlspecialchars($rol)) ?></span>
                    </div>
                    <?php if ($rol === 'admin'): ?>
                    <button class="btn btn-outline">Exportar</button>
                    <?php endif; ?>
                    <?php if ($rol !== 'aprobaciones'): ?>
                    <button class="btn btn-primary">+ Nuevo ticket</button>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-outline">Salir</a>
                </div>
            </header>

            <!-- Search & Quick Filters -->
            <section class="toolbar">
                <div class="search-box">
                    <span class="search-ico">🔍</span>
                    <input id="searchInput" type="search" placeholder="Buscar ticket, solicitante, tipo..." autocomplete="off">
                </div>
                <div class="quick-filters">
                    <button class="chip active" data-quick="all">Todos</button>
                    <button class="chip" data-quick="pending">Pendiente</button>
                    <button class="chip" data-quick="process">En proceso</button>
                    <button class="chip" data-quick="high">Alta prioridad</button>
                    <button class="chip" data-quick="assigned">Asignados</button>
                </div>
            </section>

            <!-- Stats Row -->
            <section class="stats-row">
                <div class="stat-box">
                    <span class="stat-label">Tickets</span>
                    <strong class="stat-num">21</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">En espera</span>
                    <strong class="stat-num">12</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">En proceso</span>
                    <strong class="stat-num">9</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Asignados</span>
                    <strong class="stat-num">1</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Esperando</span>
                    <strong class="stat-num">0</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Cerrado</span>
                    <strong class="stat-num">0</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Reprogram.</span>
                    <strong class="stat-num">0</strong>
                </div>
                <div class="stat-box">
                    <span class="stat-label">Atendido</span>
                    <strong class="stat-num">0</strong>
                </div>
            </section>

            <!-- Ticket List -->
            <section class="ticket-list" id="ticketList">

                <article class="ticket-card" data-estado="pendiente" data-prioridad="" data-tipo="incidencia" data-asignado="">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004808</span>
                            <span class="tc-badge badge-espera">En espera</span>
                        </div>
                        <div class="tc-user">Luis Alberto Paez Alvarez</div>
                        <div class="tc-meta">RE.</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>24 abril 2026 0:40</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>24 abril 2026 0:40</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value">—</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card" data-estado="proceso" data-prioridad="alta" data-tipo="desarrollo" data-asignado="CA">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004771</span>
                            <span class="tc-badge badge-proceso">En proceso</span>
                        </div>
                        <div class="tc-user">Jose Pastor Careno Franco</div>
                        <div class="tc-meta">RE. Desarrollo Web Avanzado</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>17 abril 2026 12:45</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>23 abril 2026 18:21</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Asignado</span>
                            <span class="tc-avatar">CA</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value priority-alta">Alta</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Desarrollo</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card" data-estado="pendiente" data-prioridad="" data-tipo="incidencia" data-asignado="">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004799</span>
                            <span class="tc-badge badge-espera">En espera</span>
                        </div>
                        <div class="tc-user">Paola Lorena Ramirez Hurtado</div>
                        <div class="tc-meta">RE.</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>23 abril 2026 7:57</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>23 abril 2026 7:58</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value">—</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card" data-estado="proceso" data-prioridad="media" data-tipo="incidencia" data-asignado="JL">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004794</span>
                            <span class="tc-badge badge-proceso">En proceso</span>
                        </div>
                        <div class="tc-user">Mauricio Velez Mora</div>
                        <div class="tc-meta">RE. Problemas de software</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>22 abril 2026 16:55</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>22 abril 2026 17:54</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Asignado</span>
                            <span class="tc-avatar">JL</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value priority-media">Media</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card" data-estado="proceso" data-prioridad="media" data-tipo="incidencia" data-asignado="JL">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004787</span>
                            <span class="tc-badge badge-proceso">En proceso</span>
                        </div>
                        <div class="tc-user">Mauricio Velez Mora</div>
                        <div class="tc-meta">RE. Problemas de software</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>21 abril 2026 11:36</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>22 abril 2026 16:55</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Asignado</span>
                            <span class="tc-avatar">JL</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value priority-media">Media</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card" data-estado="proceso" data-prioridad="media" data-tipo="desarrollo" data-asignado="Ad">
                    <div class="tc-left">
                        <div class="tc-top">
                            <span class="tc-id">#004719</span>
                            <span class="tc-badge badge-proceso">En proceso</span>
                        </div>
                        <div class="tc-user">Valentina Idrobo Mendoza</div>
                        <div class="tc-meta">RE. Desarrollo Web Normal</div>
                    </div>
                    <div class="tc-mid">
                        <div class="tc-date-row">
                            <span class="tc-date-label">Creado</span>
                            <span>7 abril 2026 11:33</span>
                        </div>
                        <div class="tc-date-row">
                            <span class="tc-date-label">Actualizado</span>
                            <span>21 abril 2026 15:06</span>
                        </div>
                    </div>
                    <div class="tc-right">
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Asignado</span>
                            <span class="tc-avatar">Ad</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Prior.</span>
                            <span class="tc-attr-value priority-media">Media</span>
                        </div>
                        <div class="tc-meta-row">
                            <span class="tc-attr-label">Tipo</span>
                            <span class="tc-attr-value">Desarrollo</span>
                        </div>
                    </div>
                </article>

            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>