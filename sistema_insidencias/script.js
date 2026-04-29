/* ============================
   FUNCIONALIDAD Y INTERACTIVIDAD
   ============================ */

document.addEventListener('DOMContentLoaded', function() {
    initializeNavigation();
    initializeTableInteractions();
    initializeFilters();
});

/**
 * Inicializa la navegación del sidebar
 */
function initializeNavigation() {
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remover clase activa de todos los items
            navItems.forEach(nav => nav.classList.remove('active'));
            // Agregar clase activa al item clickeado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterTable(filter);
            
            console.log('Filtro aplicado:', filter);
        });
    });
}

/**
 * Inicializa interacciones en la tabla
 */
function initializeTableInteractions() {
    const rows = document.querySelectorAll('.data-table tbody tr');
    const actionButtons = document.querySelectorAll('.btn-action');
    
    // Hacer filas clickeables
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Botones de acción
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const ticketId = this.closest('tr').querySelector('td').textContent;
            handleTicketAction(ticketId);
        });
    });
}

/**
 * Filtra la tabla según el criterio seleccionado
 */
function filterTable(filterType) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    
    rows.forEach(row => {
        let show = true;
        
        switch(filterType) {
            case 'all':
                show = true;
                break;
            case 'estado':
                const estado = row.querySelector('.badge-en-proceso, .badge-resuelto, .badge-pendiente, .badge-cancelado');
                show = estado && estado.textContent.toLowerCase() === 'en proceso';
                break;
            case 'priority':
                const priority = row.querySelector('[class*="badge-alta"], [class*="badge-media"], [class*="badge-baja"], [class*="badge-critica"]');
                show = priority !== null;
                break;
            case 'type':
                const type = row.querySelector('[class*="badge-incidencia"], [class*="badge-requerimiento"]');
                show = type !== null;
                break;
            case 'assigned':
                show = true; // Aquí puedes agregar lógica de asignados
                break;
        }
        
        row.style.display = show ? 'table-row' : 'none';
        row.style.animation = show ? 'fadeIn 0.3s ease-out' : 'none';
    });
}

/**
 * Maneja la acción de un ticket
 */
function handleTicketAction(ticketId) {
    console.log('Abriendo ticket:', ticketId);
    // Aquí puedes agregar lógica para abrir detalles del ticket
    alert(`Abriendo detalles del ticket ${ticketId}`);
    // En una aplicación real, redirigiría a una página de detalles o abriría un modal
}

/**
 * Inicializa funciones de filtro avanzado
 */
function initializeFilters() {
    // Función para ordenar tabla por columna (opcional)
    const headers = document.querySelectorAll('.data-table thead th');
    
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTableByColumn(index);
        });
    });
}

/**
 * Ordena la tabla por columna (función de ejemplo)
 */
function sortTableByColumn(columnIndex) {
    const tbody = document.querySelector('.data-table tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Prevenir ordenamiento en columnas no numéricas para este ejemplo
    if (columnIndex === 1 || columnIndex === 2 || columnIndex === 4 || columnIndex === 5 || columnIndex === 6) {
        rows.sort((a, b) => {
            const cellA = a.children[columnIndex].textContent.trim();
            const cellB = b.children[columnIndex].textContent.trim();
            return cellA.localeCompare(cellB);
        });
        
        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    }
}

/**
 * Función para exportar datos (opcional)
 */
function exportTableToCSV() {
    const table = document.querySelector('.data-table');
    let csv = [];
    
    // Agregar encabezados
    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent);
    csv.push(headers.join(','));
    
    // Agregar filas
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = Array.from(row.querySelectorAll('td')).map(td => td.textContent.trim());
        csv.push(cells.join(','));
    });
    
    // Descargar archivo
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = 'incidencias.csv';
    link.click();
    window.URL.revokeObjectURL(url);
}

/**
 * Función para buscar en la tabla
 */
function searchTable(searchTerm) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(term) ? 'table-row' : 'none';
    });
}

/**
 * Función para agregar nuevas filas (opcional)
 */
function addNewTicket(ticketData) {
    const tbody = document.querySelector('.data-table tbody');
    const newRow = document.createElement('tr');
    
    newRow.innerHTML = `
        <td>${ticketData.id}</td>
        <td><span class="badge ${ticketData.estadoClass}">${ticketData.estado}</span></td>
        <td>${ticketData.solicitante}</td>
        <td>
            <div class="date-cell">
                <div>${ticketData.fechaCrea}</div>
                <div>${ticketData.fechaResp}</div>
            </div>
        </td>
        <td><span class="badge ${ticketData.sitioClass}">${ticketData.sitio}</span></td>
        <td>${ticketData.lineaNegocio}</td>
        <td>${ticketData.asignado}</td>
        <td><span class="badge ${ticketData.tipoClass}">${ticketData.tipo}</span></td>
        <td><span class="badge ${ticketData.prioridadClass}">${ticketData.prioridad}</span></td>
        <td><button class="btn-action">→</button></td>
    `;
    
    tbody.appendChild(newRow);
    initializeTableInteractions();
}

/**
 * Utilidades - Funciones auxiliares
 */
const Utils = {
    // Obtener datos de la tabla como JSON
    getTableDataAsJSON: function() {
        const rows = document.querySelectorAll('.data-table tbody tr');
        const headers = Array.from(document.querySelectorAll('.data-table thead th')).map(th => th.textContent.trim());
        
        return Array.from(rows).map(row => {
            const data = {};
            Array.from(row.querySelectorAll('td')).forEach((cell, index) => {
                data[headers[index]] = cell.textContent.trim();
            });
            return data;
        });
    },
    
    // Aplicar tema oscuro (opcional)
    toggleDarkMode: function() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    },
    
    // Restaurar tema guardado
    restoreSavedTheme: function() {
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    }
};

// Restaurar tema al cargar la página
Utils.restoreSavedTheme();

console.log('Sistema de Incidencias - JavaScript cargado correctamente');
