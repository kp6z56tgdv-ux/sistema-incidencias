<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk - Sistema de Incidencias</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">🎧</div>
                <div>
                    <span class="brand-label">Help</span>
                    <span class="brand-label strong">Desk</span>
                </div>
            </div>

            <div class="filter-panel">
                <h2>Filtros</h2>
                <label for="filterEstado">Estados</label>
                <input id="filterEstado" type="text" placeholder="Buscar estado...">
                <label for="filterAsignado">Asignado a:</label>
                <input id="filterAsignado" type="text" placeholder="Buscar responsable...">
                <label for="filterPrioridad">Prioridad</label>
                <input id="filterPrioridad" type="text" placeholder="Baja, Media, Alta...">
                <label for="filterTipo">Tipo de solicitud</label>
                <input id="filterTipo" type="text" placeholder="Incidencia, Desarrollo...">
            </div>

            <button class="sidebar-action">
                <span>↻</span>
                Actualizar
            </button>
        </aside>

        <main class="main-content">
            <section class="page-header">
                <div>
                    <p class="eyebrow">Panel de control</p>
                    <h1>Tickets abiertos</h1>
                    <p class="page-copy">Revisa las solicitudes más importantes y mantén el flujo de trabajo en un solo lugar.</p>
                </div>
                <div class="action-group">
                    <button class="btn btn-primary">+ Nuevo ticket</button>
                    <button class="btn btn-secondary">Exportar</button>
                </div>
            </section>

            <section class="top-bar">
                <div class="top-search">
                    <div>
                        <label class="search-label" for="searchTickets">Buscar ticket</label>
                        <div class="search-field">
                            <span class="search-icon">🔍</span>
                            <input id="searchTickets" type="search" placeholder="Buscar ticket, solicitante, tipo...">
                        </div>
                    </div>
                </div>

                <div class="quick-filters">
                    <button class="filter-chip active">Todos</button>
                    <button class="filter-chip">Pendiente</button>
                    <button class="filter-chip">En proceso</button>
                    <button class="filter-chip">Alta prioridad</button>
                    <button class="filter-chip">Asignados</button>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <span class="stat-title">Tickets</span>
                        <strong>21</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">En espera</span>
                        <strong>12</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">En proceso</span>
                        <strong>9</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">Asignados</span>
                        <strong>1</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">Esperando</span>
                        <strong>0</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">Cerrado</span>
                        <strong>0</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">Reprogram.</span>
                        <strong>0</strong>
                    </div>
                    <div class="stat-card">
                        <span class="stat-title">Atendido</span>
                        <strong>0</strong>
                    </div>
                </div>
            </section>

            <section class="ticket-list">
                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004808</div>
                        <div class="ticket-badge badge-pendiente">En espera</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Luis Alberto Paez Alvarez</div>
                            <div class="ticket-meta">RE.</div>
                        </div>
                        <div class="ticket-dates">
                            <div>24 abril 2026 0:40</div>
                            <div>24 abril 2026 0:40</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value">-</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004771</div>
                        <div class="ticket-badge badge-proceso">En proceso</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Jose Pastor Careno Franco</div>
                            <div class="ticket-meta">RE. Desarrollo Web Avanzado</div>
                        </div>
                        <div class="ticket-dates">
                            <div>17 abril 2026 12:45</div>
                            <div>23 abril 2026 18:21</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Asignado</span>
                            <span class="ticket-value">CA</span>
                        </div>
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value priority-high">Alta</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Desarrollo</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004799</div>
                        <div class="ticket-badge badge-pendiente">En espera</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Paola Lorena Ramirez Hurtado</div>
                            <div class="ticket-meta">RE.</div>
                        </div>
                        <div class="ticket-dates">
                            <div>23 abril 2026 7:57</div>
                            <div>23 abril 2026 7:58</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value">-</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004794</div>
                        <div class="ticket-badge badge-proceso">En proceso</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Mauricio Velez Mora</div>
                            <div class="ticket-meta">RE. Problemas de software</div>
                        </div>
                        <div class="ticket-dates">
                            <div>22 abril 2026 16:55</div>
                            <div>22 abril 2026 17:54</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Asignado</span>
                            <span class="ticket-value">JL</span>
                        </div>
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value priority-medium">Media</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004787</div>
                        <div class="ticket-badge badge-proceso">En proceso</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Mauricio Velez Mora</div>
                            <div class="ticket-meta">RE. Problemas de software</div>
                        </div>
                        <div class="ticket-dates">
                            <div>21 abril 2026 11:36</div>
                            <div>22 abril 2026 16:55</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Asignado</span>
                            <span class="ticket-value">JL</span>
                        </div>
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value priority-medium">Media</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Incidencia</span>
                        </div>
                    </div>
                </article>

                <article class="ticket-card ticket-warning">
                    <div class="ticket-head">
                        <div class="ticket-id">#004719</div>
                        <div class="ticket-badge badge-proceso">En proceso</div>
                    </div>
                    <div class="ticket-body">
                        <div>
                            <div class="ticket-user">Valentina Idrobo Mendoza</div>
                            <div class="ticket-meta">RE. Desarrollo Web Normal</div>
                        </div>
                        <div class="ticket-dates">
                            <div>7 abril 2026 11:33</div>
                            <div>21 abril 2026 15:06</div>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <div>
                            <span class="ticket-label">Asignado</span>
                            <span class="ticket-value">Ad</span>
                        </div>
                        <div>
                            <span class="ticket-label">Prior.</span>
                            <span class="ticket-value priority-medium">Media</span>
                        </div>
                        <div>
                            <span class="ticket-label">Tipo</span>
                            <span class="ticket-value">Desarrollo</span>
                        </div>
                    </div>
                </article>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
