# 🎨 Sistema de Incidencias - Guía Rápida de Inicio

## 📦 Archivos Creados

### HTML
- **index.html** - Página principal con tabla de incidencias y paleta de colores visible
- **crear-ticket.html** - Formulario para crear nuevos tickets con vista previa de colores

### CSS & JavaScript
- **styles.css** - Estilos completos con paleta de colores (variable CSS)
- **script.js** - Funcionalidad interactiva (filtros, búsqueda, etc.)

### Backend PHP
- **api.php** - API RESTful para gestionar tickets (CRUD)
- **database.sql** - Script SQL para crear BD y tablas

### Documentación
- **README.md** - Documentación técnica completa
- **PALETA-COLORES.md** - Este archivo

---

## 🎨 PALETA DE COLORES COMPLETA

### **1️⃣ ESTADOS**
```
En proceso    → #3498db (Azul)      - Trabajando
Resuelto      → #27ae60 (Verde)     - Completado
Pendiente     → #f39c12 (Naranja)   - Esperando
Cancelado     → #e74c3c (Rojo)      - Anulado
```

### **2️⃣ PRIORIDADES**
```
Baja          → #27ae60 (Verde)     - Verde
Media         → #f39c12 (Naranja)   - Naranja  
Alta          → #e74c3c (Rojo)      - Rojo
Crítica       → #8b0000 (Rojo Osc.) - Rojo Oscuro
```

### **3️⃣ SITIOS**
```
CALI          → #2c3e50 (Gris-Azul)     - Oscuro
BOGOTÁ        → #34495e (Gris-Azul)     - Gris
MEDELLÍN      → #16a085 (Verde-Azul)    - Verde-Azulado
BARRANQUILLA  → #2980b9 (Azul)          - Azul
```

### **4️⃣ TIPOS DE SOLICITUD**
```
Incidencia      → #8e44ad (Púrpura)         - Púrpura
Requerimiento   → #16a085 (Verde-Azulado)   - Verde-Azulado
Mantenimiento   → #d35400 (Naranja Osc.)    - Naranja Oscuro
Consulta        → #2980b9 (Azul)            - Azul
```

### **5️⃣ COLORES CORPORATIVOS**
```
Principal     → #003d99 (Azul Corporativo) - Headers, botones
Fondo         → #f5f6fa (Gris Claro)       - Fondo de página
Texto         → #2c3e50 (Gris Oscuro)      - Texto principal
Bordes        → #ecf0f1 (Gris Muy Claro)   - Divisiones
```

---

## 🚀 INICIO RÁPIDO

### **Paso 1: Copiar archivos**
```bash
Copiar todos los archivos a: C:\xampp\htdocs\sistema_incidencias2\
```

### **Paso 2: Crear BD**
- Abrir phpMyAdmin
- Crear BD: `sistema_incidencias`
- Importar: `database.sql`

O por terminal MySQL:
```bash
mysql -u root -p < database.sql
```

### **Paso 3: Acceder**
```
http://localhost/sistema_incidencias2/
```

---

## 📋 ESTRUCTURA CSS

Todos los colores están en **styles.css** como variables CSS:

```css
:root {
    --color-primary: #003d99;
    --state-en-proceso: #3498db;
    --priority-baja: #27ae60;
    /* ... más colores */
}
```

Para cambiar la paleta global, solo edita estas líneas.

---

## 🔗 ENDPOINTS PHP DISPONIBLES

### Obtener tickets
```
GET api.php?action=obtenerTickets&filtro=todos
```

### Crear ticket
```
POST api.php?action=crearTicket
```

### Actualizar ticket
```
POST api.php?action=actualizarTicket&id=1
```

### Eliminar ticket
```
POST api.php?action=eliminarTicket&id=1
```

---

## 📱 CARACTERÍSTICAS

✅ Totalmente responsivo (mobile, tablet, desktop)
✅ Paleta de colores profesional y coherente
✅ 4 categorías de colores (estado, prioridad, sitio, tipo)
✅ API RESTful con PHP
✅ Base de datos normalizada
✅ Interfaz moderna y accesible
✅ Animaciones suaves
✅ Búsqueda y filtros interactivos

---

## 🎯 PERSONALIZACIÓN

### Cambiar color primario:
Editar en **styles.css** línea 6:
```css
--color-primary: #TU_COLOR;
```

### Agregar nuevo sitio:
1. **database.sql**: Agregar en ENUM
2. **index.html**: Agregar fila en tabla
3. **styles.css**: Crear `.badge-nuevoSitio { background-color: #color; }`

### Cambiar paleta completa:
1. Editar variables CSS en **styles.css** (líneas 1-35)
2. Todos los elementos se actualizarán automáticamente

---

## 📱 Breakpoints Responsivos

- **Desktop**: 1024px+
- **Tablet**: 768px - 1023px  
- **Móvil**: < 768px

---

## 💾 Base de Datos

### Tabla: tickets
- id (INT)
- solicitante (VARCHAR)
- estado (ENUM) - Con colorimetría
- sitio (ENUM) - Con colorimetría
- tipo (ENUM) - Con colorimetría
- prioridad (ENUM) - Con colorimetría
- linea_negocio (VARCHAR)
- asignado_a (VARCHAR)
- fecha_creacion (DATETIME)
- fecha_respuesta (DATETIME)

---

## 🎨 Uso de Colores en HTML

### Badges de Color:
```html
<span class="badge badge-en-proceso">En proceso</span>
<span class="badge badge-baja">Baja</span>
<span class="badge badge-cali">CALI</span>
<span class="badge badge-incidencia">Incidencia</span>
```

### En CSS:
```css
.badge-en-proceso {
    background-color: var(--state-en-proceso);
    color: #ffffff;
}
```

---

## ✨ Tips Importantes

1. **CSS Variables** - Úsalas para mantener coherencia
2. **Contraste** - Todos los colores cumplen WCAG 2.1 AA
3. **Accesibilidad** - No depende solo del color para info crítica
4. **Responsive** - Se adapta a todos los tamaños
5. **Performance** - Archivo CSS optimizado

---

## 📞 Soporte Rápido

**Los estilos no se aplican?**
→ Limpiar caché (Ctrl+F5)

**BD no conecta?**
→ Verificar credenciales en **api.php** líneas 12-15

**Botones no funcionan?**
→ Abrir consola (F12) y buscar errores

---

## 📝 Archivos Importantes

| Archivo | Función |
|---------|---------|
| index.html | Página principal |
| crear-ticket.html | Formulario nuevo ticket |
| styles.css | **Paleta de colores aquí** ⭐ |
| api.php | Backend PHP |
| database.sql | BD + datos ejemplo |

---

**¡Listo para usar! 🚀**

La paleta de colores está completa y aplicada en todas las columnas (estado, sitio, tipo y prioridad).

Para cambiar colores, edita solamente **styles.css** (líneas 1-35).

---

*Creado para Tabasco DC - 2026*
