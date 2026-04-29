-- ============================
-- SCRIPT SQL - SISTEMA DE INCIDENCIAS
-- ============================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS sistema_incidencias;
USE sistema_incidencias;

-- Crear tabla de tickets
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitante VARCHAR(255) NOT NULL,
    estado ENUM('En proceso', 'Resuelto', 'Pendiente', 'Cancelado') NOT NULL DEFAULT 'Pendiente',
    sitio ENUM('CALI', 'BOGOTÁ', 'MEDELLÍN', 'BARRANQUILLA') NOT NULL,
    tipo ENUM('Incidencia', 'Requerimiento', 'Mantenimiento', 'Consulta') NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta', 'Crítica') NOT NULL DEFAULT 'Media',
    linea_negocio VARCHAR(255),
    asignado_a VARCHAR(255),
    fecha_creacion DATETIME NOT NULL,
    fecha_respuesta DATETIME,
    descripcion LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_estado (estado),
    INDEX idx_prioridad (prioridad),
    INDEX idx_sitio (sitio),
    INDEX idx_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo
INSERT INTO tickets (solicitante, estado, sitio, tipo, prioridad, linea_negocio, asignado_a, fecha_creacion, fecha_respuesta) VALUES
('User name', 'En proceso', 'CALI', 'Incidencia', 'Baja', 'SEDE CALI SUR', 'user admin', '2026-04-21 07:30:00', '2026-04-23 09:30:00'),
('User name', 'En proceso', 'BOGOTÁ', 'Requerimiento', 'Media', 'SEDE CENTRAL', 'user admin', '2026-04-21 07:30:00', '2026-04-23 09:30:00'),
('User name', 'Resuelto', 'MEDELLÍN', 'Incidencia', 'Alta', 'SEDE NORTE', 'user admin', '2026-04-20 14:15:00', '2026-04-22 16:45:00'),
('User name', 'Pendiente', 'BARRANQUILLA', 'Requerimiento', 'Crítica', 'SEDE CARIBE', 'user admin', '2026-04-22 10:00:00', NULL);

-- Crear tabla de usuarios (opcional)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Agente', 'Usuario') DEFAULT 'Usuario',
    sitio ENUM('CALI', 'BOGOTÁ', 'MEDELLÍN', 'BARRANQUILLA'),
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla de auditoría (opcional)
CREATE TABLE IF NOT EXISTS auditoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT,
    usuario_id INT,
    accion VARCHAR(255),
    descripcion TEXT,
    datos_anteriores JSON,
    datos_nuevos JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    INDEX idx_fecha (created_at),
    INDEX idx_ticket (ticket_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vistas útiles

-- Vista: Resumen por estado
CREATE OR REPLACE VIEW resumen_estados AS
SELECT 
    estado,
    COUNT(*) as cantidad,
    ROUND((COUNT(*) / (SELECT COUNT(*) FROM tickets)) * 100, 2) as porcentaje
FROM tickets
GROUP BY estado
ORDER BY cantidad DESC;

-- Vista: Resumen por prioridad
CREATE OR REPLACE VIEW resumen_prioridades AS
SELECT 
    prioridad,
    COUNT(*) as cantidad,
    ROUND((COUNT(*) / (SELECT COUNT(*) FROM tickets)) * 100, 2) as porcentaje
FROM tickets
GROUP BY prioridad
ORDER BY cantidad DESC;

-- Vista: Resumen por sitio
CREATE OR REPLACE VIEW resumen_sitios AS
SELECT 
    sitio,
    COUNT(*) as cantidad,
    ROUND((COUNT(*) / (SELECT COUNT(*) FROM tickets)) * 100, 2) as porcentaje
FROM tickets
GROUP BY sitio
ORDER BY cantidad DESC;

-- Vista: Resumen por tipo
CREATE OR REPLACE VIEW resumen_tipos AS
SELECT 
    tipo,
    COUNT(*) as cantidad,
    ROUND((COUNT(*) / (SELECT COUNT(*) FROM tickets)) * 100, 2) as porcentaje
FROM tickets
GROUP BY tipo
ORDER BY cantidad DESC;

-- Vista: Tickets críticos pendientes
CREATE OR REPLACE VIEW tickets_criticos AS
SELECT 
    id,
    solicitante,
    estado,
    sitio,
    tipo,
    prioridad,
    fecha_creacion,
    DATEDIFF(NOW(), fecha_creacion) as dias_transcurridos
FROM tickets
WHERE prioridad IN ('Alta', 'Crítica') AND estado != 'Resuelto'
ORDER BY fecha_creacion ASC;
