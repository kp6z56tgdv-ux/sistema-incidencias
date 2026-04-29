# 📚 Estructura de Archivos Creados

## 📁 Sistema de Incidencias y Requerimientos - Tabasco DC

### 🎯 Archivos Principales (Obligatorios)

```
sistema_incidencias2/
├── index.html              ✅ Página principal - Tabla interactiva
├── styles.css              ✅ Estilos completos + PALETA DE COLORES
├── script.js               ✅ Interactividad y funciones JS
├── api.php                 ✅ Backend API RESTful
├── database.sql            ✅ Script de base de datos
```

### 📄 Archivos Complementarios (Referencia)

```
├── crear-ticket.html       📝 Formulario para crear tickets
├── paleta-colores.html     🎨 Visualizador interactivo de colores
├── api-ejemplos.js         💻 Ejemplos de uso de la API
├── PALETA-COLORES.md       📋 Guía rápida de colores
├── README.md               📚 Documentación completa
└── ESTRUCTURA.md           📑 Este archivo
```

---

## 🎨 Paleta de Colores - Resumen Rápido

### **ESTADOS** (Para columna ESTADO)
| Estado | Hex | Clase CSS |
|--------|-----|-----------|
| En proceso | #3498db | `.badge-en-proceso` |
| Resuelto | #27ae60 | `.badge-resuelto` |
| Pendiente | #f39c12 | `.badge-pendiente` |
| Cancelado | #e74c3c | `.badge-cancelado` |

### **PRIORIDADES** (Para columna PRIORIDAD)
| Prioridad | Hex | Clase CSS |
|-----------|-----|-----------|
| Baja | #27ae60 | `.badge-baja` |
| Media | #f39c12 | `.badge-media` |
| Alta | #e74c3c | `.badge-alta` |
| Crítica | #8b0000 | `.badge-critica` |

### **SITIOS** (Para columna SITIO)
| Sitio | Hex | Clase CSS |
|-------|-----|-----------|
| CALI | #2c3e50 | `.badge-cali` |
| BOGOTÁ | #34495e | `.badge-bogota` |
| MEDELLÍN | #16a085 | `.badge-medellin` |
| BARRANQUILLA | #2980b9 | `.badge-barranquilla` |

### **TIPOS** (Para columna TIPO)
| Tipo | Hex | Clase CSS |
|------|-----|-----------|
| Incidencia | #8e44ad | `.badge-incidencia` |
| Requerimiento | #16a085 | `.badge-requerimiento` |
| Mantenimiento | #d35400 | `.badge-mantenimiento` |
| Consulta | #2980b9 | `.badge-consulta` |

### **CORPORATIVOS**
| Elemento | Hex | Uso |
|----------|-----|-----|
| Principal | #003d99 | Headers, botones |
| Oscuro | #002d73 | Hover, enfasis |
| Claro | #4a7bbd | Acentos |
| Fondo | #f5f6fa | Página |
| Texto | #2c3e50 | Principal |

---

## 🚀 Cómo Usar

### 1. **Iniciar Rápido**
```bash
# Copiar todos los archivos a:
C:\xampp\htdocs\sistema_incidencias2\
```

### 2. **Crear Base de Datos**
```bash
# En terminal MySQL:
mysql -u root -p < database.sql

# O importar en phpMyAdmin
```

### 3. **Acceder**
```
http://localhost/sistema_incidencias2/
```

### 4. **Personalizar Colores**
Editar solamente **styles.css** líneas 1-35 (variables CSS)

---

## 📑 Descripción de Archivos

### `index.html` - Página Principal
- ✅ Tabla interactiva de tickets
- ✅ Sidebar con filtros
- ✅ Badges con colorimetría completa
- ✅ Paleta visible en la página
- ✅ 100% responsivo

### `styles.css` - Estilos + Colores
- ✅ Variables CSS para toda la paleta
- ✅ Clases `.badge-*` para cada combinación
- ✅ Diseño responsivo
- ✅ Animaciones suaves
- ✅ Accesibilidad WCAG 2.1 AA

**ARCHIVO CLAVE PARA COLORIMETRÍA ⭐**

### `script.js` - Interactividad
- ✅ Filtros funcionales
- ✅ Búsqueda
- ✅ Ordenamiento
- ✅ Exportación de datos
- ✅ Integración con API

### `api.php` - Backend
- ✅ Obtener tickets
- ✅ Crear ticket
- ✅ Actualizar ticket
- ✅ Eliminar ticket
- ✅ Sanitización y validación

**REQUIERE: PHP 7.4+, MySQL 5.7+**

### `database.sql` - Base de Datos
- ✅ Tabla `tickets` con enums de colores
- ✅ Tabla `usuarios` (opcional)
- ✅ Tabla `auditoria` (opcional)
- ✅ Vistas para reportes

### `crear-ticket.html` - Formulario
- ✅ Creación de nuevos tickets
- ✅ Visualización de colores en tiempo real
- ✅ Validación de datos
- ✅ Demostración de colorimetría

### `paleta-colores.html` - Visualizador
- ✅ Galería interactiva de colores
- ✅ Copiar códigos al portapapeles
- ✅ Tabs para cada categoría
- ✅ Vista completa de toda la paleta

### `api-ejemplos.js` - Ejemplos de API
- ✅ Cómo usar cada endpoint
- ✅ Ejemplos de JavaScript fetch
- ✅ Validación de datos
- ✅ Exportación de datos (JSON, CSV)

---

## 📱 Responsive Breakpoints

```css
Desktop:    1024px+
Tablet:     768px - 1023px
Móvil:      < 768px
Móvil Peq:  < 600px
```

Todos los archivos HTML son 100% responsivos

---

## 🔧 Configuración Requerida

### En `api.php` - Líneas 12-15:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');              // ← Cambiar si tienes contraseña
define('DB_NAME', 'sistema_incidencias');
```

---

## ✨ Características Principales

✅ **Paleta Completa** - Colores para 4 categorías
✅ **Responsivo** - Mobile, tablet, desktop
✅ **Interactivo** - Filtros, búsqueda, exportación
✅ **Backend** - API RESTful con PHP
✅ **BD** - MySQL normalizada
✅ **Accesible** - WCAG 2.1 AA compliant
✅ **Documentado** - Guías y ejemplos

---

## 📊 Ejemplo de Uso HTML

```html
<!-- Badge de Estado -->
<span class="badge badge-en-proceso">En proceso</span>

<!-- Badge de Prioridad -->
<span class="badge badge-alta">Alta</span>

<!-- Badge de Sitio -->
<span class="badge badge-cali">CALI</span>

<!-- Badge de Tipo -->
<span class="badge badge-incidencia">Incidencia</span>
```

---

## 🎯 Próximos Pasos Recomendados

1. **Copiar archivos** al servidor
2. **Crear BD** con SQL
3. **Configurar** credenciales en `api.php`
4. **Personalizar** colores en `styles.css` si es necesario
5. **Agregar** autenticación de usuarios (opcional)
6. **Implementar** lógica de permisos (opcional)

---

## 🔐 Checklist de Seguridad

- [ ] Cambiar contraseña de BD
- [ ] Usar HTTPS en producción
- [ ] Implementar autenticación
- [ ] Validar permisos de usuario
- [ ] Configurar CORS si es necesario
- [ ] Hacer backup regular de BD

---

## 📞 Soporte Rápido

**¿Cómo cambiar colores?**
→ Editar `styles.css` líneas 1-35

**¿Cómo agregar un nuevo sitio?**
→ Modificar `database.sql` ENUM y agregar clase en CSS

**¿El formulario no envía?**
→ Verificar que `api.php` está accesible

**¿La tabla no carga datos?**
→ Verificar conexión BD en `api.php`

---

## 📈 Estadísticas del Proyecto

- **Líneas de HTML**: ~200
- **Líneas de CSS**: ~400 (incluye paleta completa)
- **Líneas de JavaScript**: ~250
- **Líneas de PHP**: ~180
- **Líneas SQL**: ~120
- **Total**: ~1,150 líneas de código

---

## 🎨 Paleta Aplicable a Todo el Sitio

Toda la paleta está centralizada en **styles.css** usando variables CSS:

```css
:root {
    --color-primary: #003d99;
    --state-en-proceso: #3498db;
    --priority-alta: #e74c3c;
    --site-cali: #2c3e50;
    --type-incidencia: #8e44ad;
    /* ... más variables */
}
```

Para cambiar un color en TODO el sitio, modifica una sola variable.

---

## ✅ Validación Final

- ✅ HTML válido y semántico
- ✅ CSS optimizado y responsive
- ✅ JavaScript moderno (ES6+)
- ✅ PHP 7.4+ compatible
- ✅ Paleta coherente
- ✅ Documentación completa
- ✅ Ejemplos funcionales

---

## 📝 Versión

**v1.0** - Abril 2026
Desarrollado para Tabasco DC

---

**¡Sistema listo para usar! 🚀**

Todos los archivos están en:
`C:\xampp\htdocs\sistema_incidencias2\`

Para comenzar, abre en navegador:
`http://localhost/sistema_incidencias2/`
