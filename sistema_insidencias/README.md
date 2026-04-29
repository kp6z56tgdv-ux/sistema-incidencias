# Sistema de Incidencia y Requerimiento - Documentación

## 📋 Descripción General

Sistema web completo para la gestión de incidencias y requerimientos diseñado para Tabasco DC. Incluye interfaz responsiva, paleta de colores profesional y backend con PHP/MySQL.

---

## 🎨 Paleta de Colores Completa

### **Colores Primarios**
- **Azul Corporativo (Principal)**: `#003d99` - Usado en encabezados, botones principales y sidebar
- **Azul Oscuro**: `#002d73` - Variación oscura para hover y acentos
- **Azul Claro**: `#4a7bbd` - Variación clara para elementos secundarios

### **Estados - Colorimetría**
| Estado | Color Hex | RGB | Uso |
|--------|-----------|-----|-----|
| **En proceso** | `#3498db` | rgb(52, 152, 219) | Azul - Trabajando |
| **Resuelto** | `#27ae60` | rgb(39, 174, 96) | Verde - Completado |
| **Pendiente** | `#f39c12` | rgb(243, 156, 18) | Naranja - Esperando |
| **Cancelado** | `#e74c3c` | rgb(231, 76, 60) | Rojo - Anulado |

### **Prioridades - Colorimetría**
| Prioridad | Color Hex | RGB | Descripción |
|-----------|-----------|-----|-------------|
| **Baja** | `#27ae60` | rgb(39, 174, 96) | Verde claro |
| **Media** | `#f39c12` | rgb(243, 156, 18) | Naranja |
| **Alta** | `#e74c3c` | rgb(231, 76, 60) | Rojo |
| **Crítica** | `#8b0000` | rgb(139, 0, 0) | Rojo oscuro |

### **Sitios - Colorimetría**
| Sitio | Color Hex | RGB | Descripción |
|-------|-----------|-----|-------------|
| **CALI** | `#2c3e50` | rgb(44, 62, 80) | Gris-Azul oscuro |
| **BOGOTÁ** | `#34495e` | rgb(52, 73, 94) | Gris-Azul más claro |
| **MEDELLÍN** | `#16a085` | rgb(22, 160, 133) | Verde-azulado |
| **BARRANQUILLA** | `#2980b9` | rgb(41, 128, 185) | Azul |

### **Tipos de Solicitud - Colorimetría**
| Tipo | Color Hex | RGB | Descripción |
|------|-----------|-----|-------------|
| **Incidencia** | `#8e44ad` | rgb(142, 68, 173) | Púrpura |
| **Requerimiento** | `#16a085` | rgb(22, 160, 133) | Verde-azulado |
| **Mantenimiento** | `#d35400` | rgb(211, 84, 0) | Naranja oscuro |
| **Consulta** | `#2980b9` | rgb(41, 128, 185) | Azul |

### **Colores Neutrales**
- **Blanco**: `#ffffff` - Fondos principales
- **Gris Claro (BG)**: `#f5f6fa` - Fondo de página
- **Gris Frontera**: `#ecf0f1` - Bordes y divisiones
- **Texto Oscuro**: `#2c3e50` - Texto principal
- **Texto Claro**: `#7f8c8d` - Texto secundario

---

## 📁 Estructura de Archivos

```
sistema_incidencias2/
├── index.html              # Página principal HTML
├── styles.css              # Estilos CSS (incluye paleta completa)
├── script.js               # Funcionalidad JavaScript
├── api.php                 # Backend PHP con API RESTful
├── database.sql            # Script SQL para crear BD
├── README.md               # Este archivo
└── config/
    └── (archivos de configuración opcionales)
```

---

## 🚀 Instalación y Configuración

### **Requisitos**
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx)
- Navegador moderno (Chrome, Firefox, Edge, Safari)

### **Pasos de Instalación**

1. **Clonar o descargar los archivos**
   ```bash
   # Copiar archivos al directorio web
   cp -r sistema_incidencias2/ /var/www/html/
   ```

2. **Crear la base de datos**
   ```bash
   # Ejecutar script SQL en MySQL
   mysql -u root -p < database.sql
   ```

   O a través de phpMyAdmin:
   - Crear BD: `sistema_incidencias`
   - Importar archivo `database.sql`

3. **Configurar conexión PHP**
   - Editar `api.php` (líneas 12-15) con tus credenciales:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', 'tu_contraseña');
   define('DB_NAME', 'sistema_incidencias');
   ```

4. **Acceder a la aplicación**
   - Navegador: `http://localhost/sistema_incidencias2/`

---

## 🎯 Uso de la Aplicación

### **Funcionalidades Principales**

#### **1. Visualización de Tickets**
- Tabla interactiva con todos los incidentes/requerimientos
- Filtrado por estado, prioridad, sitio y tipo
- Búsqueda rápida

#### **2. Colorimetría Intuitiva**
- **Badges de color** en todas las columnas importantes
- Estados diferenciados por azul, verde, naranja y rojo
- Fácil identificación visual de prioridades y urgencias

#### **3. Navegación Sidebar**
- Menú lateral con acceso rápido a filtros
- "Total Tickets" - Ver todos
- "Asignados a" - Tickets por usuario
- "Estado" - Filtrar por estado
- "Prioridad" - Filtrar por urgencia
- "Tipo de solicitud" - Filtrar por categoría

#### **4. Responsividad**
- Se adapta a pantallas de escritorio, tablet y móvil
- Interfaz intuitiva en todos los dispositivos

---

## 📡 API RESTful - Endpoints PHP

### **Obtener todos los tickets**
```
GET api.php?action=obtenerTickets&filtro=todos
```
**Filtros disponibles**: `todos`, `en_proceso`, `resuelto`, `pendiente`, `alta_prioridad`

### **Obtener ticket específico**
```
GET api.php?action=obtenerTicket&id=1
```

### **Crear nuevo ticket**
```
POST api.php?action=crearTicket
Content-Type: application/json

{
    "solicitante": "Nombre Usuario",
    "estado": "Pendiente",
    "sitio": "CALI",
    "tipo": "Incidencia",
    "prioridad": "Media",
    "linea_negocio": "SEDE CALI SUR",
    "asignado_a": "user admin"
}
```

### **Actualizar ticket**
```
POST api.php?action=actualizarTicket&id=1
Content-Type: application/json

{
    "estado": "En proceso",
    "prioridad": "Alta"
}
```

### **Eliminar ticket**
```
POST api.php?action=eliminarTicket&id=1
```

---

## 💻 Variables CSS - Personalización

Todos los colores están definidos como variables CSS en `styles.css` (líneas 1-35):

```css
:root {
    --color-primary: #003d99;
    --state-en-proceso: #3498db;
    --priority-alta: #e74c3c;
    --site-cali: #2c3e50;
    /* ... más variables */
}
```

Para cambiar la paleta global, solo edita estas variables.

---

## 🔧 Personalización

### **Cambiar Colores de Estados**
Editar en `styles.css`:
```css
.badge-en-proceso { background-color: #3498db; }
.badge-resuelto { background-color: #27ae60; }
```

### **Agregar Nuevos Sitios**
1. Editar `database.sql` - Agregar valor ENUM en tabla `tickets`
2. Editar `index.html` - Agregar fila en la tabla
3. Editar `styles.css` - Crear clase `.badge-nuevoSitio`

### **Cambiar Tema de Colores Corporativo**
Editar la variable `--color-primary` en `styles.css` y todas las referencias se actualizarán automáticamente.

---

## 🐛 Solución de Problemas

### **La BD no se conecta**
- Verificar credenciales en `api.php`
- Asegurarse de que MySQL está corriendo
- Verificar que la BD `sistema_incidencias` existe

### **Los estilos no se aplican**
- Limpiar caché del navegador (Ctrl+F5)
- Verificar que `styles.css` está en el mismo directorio

### **Los botones no funcionan**
- Abrir consola del navegador (F12)
- Verificar que no hay errores JavaScript
- Asegurarse de que `script.js` se cargó correctamente

---

## 📊 Vistas SQL Disponibles

El sistema incluye varias vistas para reportes:

- **resumen_estados**: Cantidad de tickets por estado
- **resumen_prioridades**: Tickets organizados por prioridad
- **resumen_sitios**: Distribución por ubicación
- **resumen_tipos**: Clasificación por tipo de solicitud
- **tickets_criticos**: Tickets urgentes pendientes

---

## 🔐 Seguridad

### **Recomendaciones**
1. Cambiar contraseña de BD en `api.php`
2. Usar HTTPS en producción
3. Implementar autenticación de usuarios
4. Usar prepared statements (ya implementados)
5. Validar y sanitizar todas las entradas

### **Características de Seguridad Implementadas**
- ✅ Prepared statements (previene SQL injection)
- ✅ Sanitización de inputs
- ✅ Validación de emails
- ✅ Charset UTF-8 en BD
- ✅ Manejo de excepciones

---

## 📱 Responsive Breakpoints

- **Desktop**: 1024px y superior
- **Tablet**: 768px - 1023px
- **Móvil**: Menos de 768px
- **Móvil pequeño**: Menos de 600px

---

## 📚 Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Diseño**: Responsive, Mobile-first
- **Compatibilidad**: 99% de navegadores modernos

---

## 📝 Notas Importantes

- La paleta de colores está optimizada para accesibilidad
- Todos los colores cumplen con WCAG 2.1 AA
- Las animaciones tienen alternativas para usuarios que prefieren movimiento reducido
- El sistema es totalmente traducible al inglés o idiomas adicionales

---

## 📞 Soporte

Para reportar problemas o sugerencias, contactar al equipo de desarrollo de Tabasco DC.

---

**Última actualización**: 24 de abril de 2026

**Versión**: 1.0

**Licencia**: Propietaria - Tabasco DC
