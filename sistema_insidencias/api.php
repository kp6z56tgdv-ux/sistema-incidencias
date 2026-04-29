<?php
/**
 * Sistema de Incidencias y Requerimientos - Backend
 * Archivo de configuración y funciones PHP
 */

// ============================
// CONFIGURACIÓN Y CONEXIÓN BD
// ============================

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sistema_incidencias');

// Función para conectar a la base de datos
function conectarBD() {
    try {
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Verificar la conexión
        if ($conexion->connect_error) {
            throw new Exception("Error de conexión: " . $conexion->connect_error);
        }
        
        // Configurar charset UTF-8
        $conexion->set_charset("utf8");
        
        return $conexion;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

// ============================
// FUNCIONES DE UTILIDAD
// ============================

/**
 * Sanitizar entrada del usuario
 */
function sanitizar($datos) {
    return htmlspecialchars(trim($datos), ENT_QUOTES, 'UTF-8');
}

/**
 * Validar email
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Retornar respuesta JSON
 */
function respuestaJSON($estado, $mensaje, $datos = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'estado' => $estado,
        'mensaje' => $mensaje,
        'datos' => $datos
    ]);
    exit;
}

// ============================
// FUNCIONES DE TICKETS
// ============================

/**
 * Obtener todos los tickets
 */
function obtenerTickets($conexion, $filtro = 'todos') {
    $query = "SELECT * FROM tickets";
    
    switch($filtro) {
        case 'en_proceso':
            $query .= " WHERE estado = 'En proceso'";
            break;
        case 'resuelto':
            $query .= " WHERE estado = 'Resuelto'";
            break;
        case 'pendiente':
            $query .= " WHERE estado = 'Pendiente'";
            break;
        case 'alta_prioridad':
            $query .= " WHERE prioridad IN ('Alta', 'Crítica')";
            break;
    }
    
    $query .= " ORDER BY fecha_creacion DESC";
    
    $resultado = $conexion->query($query);
    
    if (!$resultado) {
        return [];
    }
    
    $tickets = [];
    while ($fila = $resultado->fetch_assoc()) {
        $tickets[] = $fila;
    }
    
    return $tickets;
}

/**
 * Obtener ticket por ID
 */
function obtenerTicketPorID($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 0) {
        return null;
    }
    
    return $resultado->fetch_assoc();
}

/**
 * Crear nuevo ticket
 */
function crearTicket($conexion, $datos) {
    // Validar datos requeridos
    $campos_requeridos = ['solicitante', 'estado', 'sitio', 'tipo', 'prioridad'];
    
    foreach ($campos_requeridos as $campo) {
        if (!isset($datos[$campo]) || empty($datos[$campo])) {
            return ['exito' => false, 'mensaje' => "El campo $campo es requerido"];
        }
    }
    
    // Preparar consulta
    $stmt = $conexion->prepare("
        INSERT INTO tickets (solicitante, estado, sitio, tipo, prioridad, linea_negocio, asignado_a, fecha_creacion)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmt->bind_param(
        "sssssss",
        $datos['solicitante'],
        $datos['estado'],
        $datos['sitio'],
        $datos['tipo'],
        $datos['prioridad'],
        $datos['linea_negocio'],
        $datos['asignado_a']
    );
    
    if ($stmt->execute()) {
        return ['exito' => true, 'mensaje' => 'Ticket creado correctamente', 'id' => $conexion->insert_id];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al crear el ticket: ' . $conexion->error];
    }
}

/**
 * Actualizar ticket
 */
function actualizarTicket($conexion, $id, $datos) {
    $campos_actualizar = [];
    $tipos = "";
    $parametros = [];
    
    // Construir consulta dinámicamente según los campos proporcionados
    foreach ($datos as $campo => $valor) {
        if (in_array($campo, ['estado', 'sitio', 'tipo', 'prioridad', 'asignado_a', 'linea_negocio'])) {
            $campos_actualizar[] = "$campo = ?";
            $tipos .= "s";
            $parametros[] = $valor;
        }
    }
    
    if (empty($campos_actualizar)) {
        return ['exito' => false, 'mensaje' => 'No hay campos para actualizar'];
    }
    
    $tipos .= "i";
    $parametros[] = $id;
    
    $query = "UPDATE tickets SET " . implode(", ", $campos_actualizar) . " WHERE id = ?";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param($tipos, ...$parametros);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'mensaje' => 'Ticket actualizado correctamente'];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al actualizar: ' . $conexion->error];
    }
}

/**
 * Eliminar ticket
 */
function eliminarTicket($conexion, $id) {
    $stmt = $conexion->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        return ['exito' => true, 'mensaje' => 'Ticket eliminado correctamente'];
    } else {
        return ['exito' => false, 'mensaje' => 'Error al eliminar: ' . $conexion->error];
    }
}

// ============================
// API ENDPOINTS
// ============================

// Detectar la acción solicitada
if (isset($_GET['action'])) {
    $accion = sanitizar($_GET['action']);
    $conexion = conectarBD();
    
    if (!$conexion) {
        respuestaJSON('error', 'No se pudo conectar a la base de datos');
    }
    
    switch($accion) {
        case 'obtenerTickets':
            $filtro = isset($_GET['filtro']) ? sanitizar($_GET['filtro']) : 'todos';
            $tickets = obtenerTickets($conexion, $filtro);
            respuestaJSON('exito', 'Tickets obtenidos', $tickets);
            break;
            
        case 'obtenerTicket':
            if (!isset($_GET['id'])) {
                respuestaJSON('error', 'ID de ticket no proporcionado');
            }
            $id = intval($_GET['id']);
            $ticket = obtenerTicketPorID($conexion, $id);
            
            if ($ticket) {
                respuestaJSON('exito', 'Ticket encontrado', $ticket);
            } else {
                respuestaJSON('error', 'Ticket no encontrado', []);
            }
            break;
            
        case 'crearTicket':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                respuestaJSON('error', 'Método no permitido');
            }
            
            $datos = json_decode(file_get_contents("php://input"), true);
            $resultado = crearTicket($conexion, $datos);
            
            $estado = $resultado['exito'] ? 'exito' : 'error';
            respuestaJSON($estado, $resultado['mensaje'], $resultado);
            break;
            
        case 'actualizarTicket':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                respuestaJSON('error', 'Método no permitido');
            }
            
            if (!isset($_GET['id'])) {
                respuestaJSON('error', 'ID de ticket no proporcionado');
            }
            
            $id = intval($_GET['id']);
            $datos = json_decode(file_get_contents("php://input"), true);
            $resultado = actualizarTicket($conexion, $id, $datos);
            
            $estado = $resultado['exito'] ? 'exito' : 'error';
            respuestaJSON($estado, $resultado['mensaje'], $resultado);
            break;
            
        case 'eliminarTicket':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                respuestaJSON('error', 'Método no permitido');
            }
            
            if (!isset($_GET['id'])) {
                respuestaJSON('error', 'ID de ticket no proporcionado');
            }
            
            $id = intval($_GET['id']);
            $resultado = eliminarTicket($conexion, $id);
            
            $estado = $resultado['exito'] ? 'exito' : 'error';
            respuestaJSON($estado, $resultado['mensaje'], $resultado);
            break;
            
        default:
            respuestaJSON('error', 'Acción no reconocida');
    }
    
    $conexion->close();
}
?>
