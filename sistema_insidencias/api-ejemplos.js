/**
 * EJEMPLOS DE INTEGRACIÓN - API.PHP CON JAVASCRIPT
 * ===================================================
 * Este archivo muestra ejemplos de cómo usar la API PHP desde JavaScript
 */

// ============================
// CONFIGURACIÓN
// ============================

const API_URL = 'api.php';

// ============================
// OBTENER TICKETS
// ============================

/**
 * Obtener todos los tickets
 */
async function obtenerTodosTickets() {
    try {
        const response = await fetch(`${API_URL}?action=obtenerTickets&filtro=todos`);
        const data = await response.json();
        
        if (data.estado === 'exito') {
            console.log('Tickets obtenidos:', data.datos);
            renderizarTabla(data.datos);
        } else {
            console.error('Error:', data.mensaje);
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
    }
}

/**
 * Obtener tickets con filtro específico
 * Filtros: 'todos', 'en_proceso', 'resuelto', 'pendiente', 'alta_prioridad'
 */
async function obtenerTicketsFiltrados(filtro) {
    try {
        const response = await fetch(`${API_URL}?action=obtenerTickets&filtro=${filtro}`);
        const data = await response.json();
        
        if (data.estado === 'exito') {
            console.log(`Tickets con filtro "${filtro}":`, data.datos);
            return data.datos;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Obtener ticket específico por ID
 */
async function obtenerTicketPorID(id) {
    try {
        const response = await fetch(`${API_URL}?action=obtenerTicket&id=${id}`);
        const data = await response.json();
        
        if (data.estado === 'exito') {
            console.log('Ticket encontrado:', data.datos);
            return data.datos;
        } else {
            console.log('Ticket no encontrado');
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

// ============================
// CREAR TICKET
// ============================

/**
 * Crear nuevo ticket
 */
async function crearNuevoTicket(datosTicket) {
    try {
        const response = await fetch(`${API_URL}?action=crearTicket`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosTicket)
        });
        
        const data = await response.json();
        
        if (data.estado === 'exito') {
            console.log('Ticket creado exitosamente:', data);
            return data.datos;
        } else {
            console.error('Error al crear:', data.mensaje);
            return null;
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo de uso - Crear ticket
 */
async function ejemploCrearTicket() {
    const nuevoTicket = {
        solicitante: 'Juan Pérez',
        estado: 'Pendiente',
        sitio: 'CALI',
        tipo: 'Incidencia',
        prioridad: 'Alta',
        linea_negocio: 'SEDE CALI SUR',
        asignado_a: 'Carlos López'
    };
    
    const resultado = await crearNuevoTicket(nuevoTicket);
    if (resultado) {
        console.log('Nuevo ticket creado con ID:', resultado.id);
    }
}

// ============================
// ACTUALIZAR TICKET
// ============================

/**
 * Actualizar datos de un ticket
 */
async function actualizarTicketExistente(id, datosActualizar) {
    try {
        const response = await fetch(`${API_URL}?action=actualizarTicket&id=${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosActualizar)
        });
        
        const data = await response.json();
        
        if (data.estado === 'exito') {
            console.log('Ticket actualizado:', data.mensaje);
            return true;
        } else {
            console.error('Error:', data.mensaje);
            return false;
        }
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
}

/**
 * Ejemplo de uso - Actualizar ticket
 */
async function ejemploActualizarTicket() {
    const datosActualizar = {
        estado: 'En proceso',
        prioridad: 'Media',
        asignado_a: 'María García'
    };
    
    const exito = await actualizarTicketExistente(1, datosActualizar);
    if (exito) {
        console.log('Ticket #1 actualizado correctamente');
    }
}

// ============================
// ELIMINAR TICKET
// ============================

/**
 * Eliminar un ticket
 */
async function eliminarTicketPorID(id) {
    if (confirm(`¿Estás seguro de eliminar el ticket #${id}?`)) {
        try {
            const response = await fetch(`${API_URL}?action=eliminarTicket&id=${id}`, {
                method: 'POST'
            });
            
            const data = await response.json();
            
            if (data.estado === 'exito') {
                console.log('Ticket eliminado:', data.mensaje);
                return true;
            } else {
                console.error('Error:', data.mensaje);
                return false;
            }
        } catch (error) {
            console.error('Error:', error);
            return false;
        }
    }
    return false;
}

// ============================
// UTILIDADES - RENDERIZADO
// ============================

/**
 * Renderizar tabla con tickets
 */
function renderizarTabla(tickets) {
    const tbody = document.querySelector('.data-table tbody');
    
    if (!tbody) {
        console.warn('Tabla no encontrada');
        return;
    }
    
    tbody.innerHTML = '';
    
    tickets.forEach(ticket => {
        const fila = document.createElement('tr');
        
        fila.innerHTML = `
            <td>${ticket.id}</td>
            <td>
                <span class="badge badge-${convertirAClaseCSS(ticket.estado)}">
                    ${ticket.estado}
                </span>
            </td>
            <td>${ticket.solicitante}</td>
            <td>
                <div class="date-cell">
                    <div>${formatearFecha(ticket.fecha_creacion)}</div>
                    <div>${ticket.fecha_respuesta ? formatearFecha(ticket.fecha_respuesta) : 'Sin respuesta'}</div>
                </div>
            </td>
            <td>
                <span class="badge badge-${convertirAClaseCSS(ticket.sitio)}">
                    ${ticket.sitio}
                </span>
            </td>
            <td>${ticket.linea_negocio}</td>
            <td>${ticket.asignado_a}</td>
            <td>
                <span class="badge badge-${convertirAClaseCSS(ticket.tipo)}">
                    ${ticket.tipo}
                </span>
            </td>
            <td>
                <span class="badge badge-${convertirAClaseCSS(ticket.prioridad)}">
                    ${ticket.prioridad}
                </span>
            </td>
            <td>
                <button class="btn-action" onclick="verDetalles(${ticket.id})">→</button>
            </td>
        `;
        
        tbody.appendChild(fila);
    });
}

/**
 * Convertir valor a clase CSS
 */
function convertirAClaseCSS(valor) {
    return valor.toLowerCase().replace(/\s+/g, '-').replace(/á/g, 'a').replace(/é/g, 'e').replace(/í/g, 'i').replace(/ó/g, 'o').replace(/ú/g, 'u');
}

/**
 * Formatear fecha
 */
function formatearFecha(fecha) {
    if (!fecha) return '';
    const date = new Date(fecha);
    const dia = String(date.getDate()).padStart(2, '0');
    const mes = String(date.getMonth() + 1).padStart(2, '0');
    const año = date.getFullYear();
    const horas = String(date.getHours()).padStart(2, '0');
    const minutos = String(date.getMinutes()).padStart(2, '0');
    
    return `${dia}/${mes}/${año} ${horas}:${minutos}`;
}

/**
 * Ver detalles de un ticket
 */
async function verDetalles(id) {
    const ticket = await obtenerTicketPorID(id);
    if (ticket) {
        alert(`
Ticket #${ticket.id}
Solicitante: ${ticket.solicitante}
Estado: ${ticket.estado}
Prioridad: ${ticket.prioridad}
Sitio: ${ticket.sitio}
Tipo: ${ticket.tipo}
        `);
    }
}

// ============================
// BÚSQUEDA Y FILTROS AVANZADOS
// ============================

/**
 * Buscar tickets por solicitante
 */
async function buscarPorSolicitante(nombre) {
    const tickets = await obtenerTodosTickets();
    const resultados = tickets.filter(t => 
        t.solicitante.toLowerCase().includes(nombre.toLowerCase())
    );
    return resultados;
}

/**
 * Obtener estadísticas
 */
async function obtenerEstadisticas() {
    const tickets = await obtenerTodosTickets();
    
    const estadisticas = {
        total: tickets.length,
        porEstado: {},
        porPrioridad: {},
        porSitio: {},
        porTipo: {}
    };
    
    tickets.forEach(ticket => {
        // Por estado
        estadisticas.porEstado[ticket.estado] = (estadisticas.porEstado[ticket.estado] || 0) + 1;
        
        // Por prioridad
        estadisticas.porPrioridad[ticket.prioridad] = (estadisticas.porPrioridad[ticket.prioridad] || 0) + 1;
        
        // Por sitio
        estadisticas.porSitio[ticket.sitio] = (estadisticas.porSitio[ticket.sitio] || 0) + 1;
        
        // Por tipo
        estadisticas.porTipo[ticket.tipo] = (estadisticas.porTipo[ticket.tipo] || 0) + 1;
    });
    
    return estadisticas;
}

// ============================
// VALIDACIÓN DE DATOS
// ============================

/**
 * Validar datos de ticket antes de crear/actualizar
 */
function validarDatosTicket(datos) {
    const errores = [];
    
    if (!datos.solicitante || datos.solicitante.trim() === '') {
        errores.push('Solicitante es requerido');
    }
    
    if (!datos.estado) {
        errores.push('Estado es requerido');
    }
    
    if (!datos.sitio) {
        errores.push('Sitio es requerido');
    }
    
    if (!datos.tipo) {
        errores.push('Tipo es requerido');
    }
    
    if (!datos.prioridad) {
        errores.push('Prioridad es requerida');
    }
    
    return {
        valido: errores.length === 0,
        errores: errores
    };
}

// ============================
// EXPORTACIÓN DE DATOS
// ============================

/**
 * Exportar tickets a JSON
 */
async function exportarComoJSON() {
    const tickets = await obtenerTodosTickets();
    const json = JSON.stringify(tickets, null, 2);
    
    const blob = new Blob([json], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `tickets_${new Date().toISOString().split('T')[0]}.json`;
    link.click();
}

/**
 * Exportar tickets a CSV
 */
async function exportarComoCSV() {
    const tickets = await obtenerTodosTickets();
    
    let csv = 'ID,Solicitante,Estado,Prioridad,Sitio,Tipo,Asignado a\n';
    
    tickets.forEach(ticket => {
        csv += `${ticket.id},"${ticket.solicitante}","${ticket.estado}","${ticket.prioridad}","${ticket.sitio}","${ticket.tipo}","${ticket.asignado_a}"\n`;
    });
    
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `tickets_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
}

// ============================
// USO EN CONSOLA DEL NAVEGADOR
// ============================

/*
EJEMPLOS RÁPIDOS PARA USAR EN LA CONSOLA (F12):

1. Obtener todos los tickets:
   obtenerTodosTickets()

2. Crear nuevo ticket:
   crearNuevoTicket({
       solicitante: 'Test User',
       estado: 'Pendiente',
       sitio: 'CALI',
       tipo: 'Incidencia',
       prioridad: 'Media',
       linea_negocio: 'SEDE CALI SUR',
       asignado_a: 'Admin'
   })

3. Actualizar ticket:
   actualizarTicketExistente(1, {
       estado: 'En proceso',
       prioridad: 'Alta'
   })

4. Eliminar ticket:
   eliminarTicketPorID(1)

5. Ver detalles:
   verDetalles(1)

6. Obtener estadísticas:
   obtenerEstadisticas()

7. Exportar JSON:
   exportarComoJSON()

8. Exportar CSV:
   exportarComoCSV()
*/

console.log('✓ Módulo de API cargado correctamente');
console.log('Funciones disponibles:');
console.log('- obtenerTodosTickets()');
console.log('- obtenerTicketsFiltrados(filtro)');
console.log('- crearNuevoTicket(datos)');
console.log('- actualizarTicketExistente(id, datos)');
console.log('- eliminarTicketPorID(id)');
console.log('- obtenerEstadisticas()');
console.log('- exportarComoJSON()');
console.log('- exportarComoCSV()');
