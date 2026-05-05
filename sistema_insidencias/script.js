/* ============================================
   HELP DESK — INTERACTIVIDAD
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {
    initNavBtns();
    initQuickChips();
    initSearch();
    initSidebarFilters();
});

/* ---- Helper: apply visibility ---- */
function applyVisibility(predicate) {
    document.querySelectorAll('.ticket-card').forEach(card => {
        card.classList.toggle('hidden', !predicate(card));
    });
}

/* ---- Sidebar nav buttons ---- */
function initNavBtns() {
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            syncQuickChip(filter);
            applyFilter(filter);
        });
    });
}

/* ---- Quick-filter chips ---- */
function initQuickChips() {
    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');

            const filter = chip.dataset.quick;
            syncNavBtn(filter);
            applyFilter(filter);
        });
    });
}

function syncQuickChip(filter) {
    document.querySelectorAll('.chip').forEach(c => {
        c.classList.toggle('active', c.dataset.quick === filter || (filter === 'all' && c.dataset.quick === 'all'));
    });
}

function syncNavBtn(filter) {
    document.querySelectorAll('.nav-btn').forEach(b => {
        b.classList.toggle('active', b.dataset.filter === filter);
    });
}

function applyFilter(filter) {
    applyVisibility(card => {
        const estado = card.dataset.estado || '';
        const prioridad = card.dataset.prioridad || '';
        const asignado = card.dataset.asignado || '';

        switch (filter) {
            case 'pending':  return estado === 'pendiente';
            case 'process':  return estado === 'proceso';
            case 'high':     return prioridad === 'alta' || prioridad === 'critica';
            case 'assigned': return asignado.trim() !== '';
            default:         return true; // 'all'
        }
    });
}

/* ---- Live search ---- */
function initSearch() {
    const input = document.getElementById('searchInput');
    if (!input) return;

    input.addEventListener('input', () => {
        const term = input.value.trim().toLowerCase();
        if (!term) {
            applyVisibility(() => true);
            return;
        }
        applyVisibility(card => card.textContent.toLowerCase().includes(term));
    });
}

/* ---- Sidebar text filters ---- */
function initSidebarFilters() {
    const fields = [
        { id: 'filterEstado',    attr: 'data-estado' },
        { id: 'filterPrioridad', attr: 'data-prioridad' },
        { id: 'filterTipo',      attr: 'data-tipo' },
        { id: 'filterAsignado',  attr: 'data-asignado' },
    ];

    fields.forEach(({ id, attr }) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', () => runSidebarFilters(fields));
    });
}

function runSidebarFilters(fields) {
    const terms = fields.map(({ id, attr }) => ({
        term: (document.getElementById(id)?.value || '').trim().toLowerCase(),
        attr,
    }));

    applyVisibility(card => {
        return terms.every(({ term, attr }) => {
            if (!term) return true;
            const val = (card.getAttribute(attr) || '').toLowerCase();
            return val.includes(term);
        });
    });
}