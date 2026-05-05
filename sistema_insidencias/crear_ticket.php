<?php
session_start();
// require_once 'auth.php';
// verificarSesion(['admin', 'usuario']);

$rol   = $_SESSION['rol'] ?? 'usuario';
$nombre_usuario = $_SESSION['nombre'] ?? '';
$email_usuario  = $_SESSION['email'] ?? '';
$sitio_usuario  = $_SESSION['sitio'] ?? 'CALI';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $solicitante  = trim($_POST['nombre']       ?? '');
    $tipo         = $_POST['tipo']              ?? '';
    $prioridad    = $_POST['prioridad']         ?? 'Media';
    $linea        = $_POST['linea_negocio']     ?? '';
    $descripcion  = $_POST['descripcion']       ?? '';

    $tipos_validos     = ['Incidencia','Requerimiento Equipo de Computo','Trino','Dearrollo'];
    $prioridades_validas = ['Baja','Media','Alta'];
    $lineas_validas     = ['SEDE CALI SUR', 'SEDE CALI NORTE', 'SEDE BOGOTÁ', 'SEDE MEDELLÍN', 'SEDE BARRANQUILLA'];

    if (empty($solicitante) || empty($tipo)) {
        $error = 'Por favor completa los campos requeridos.';
    } elseif (!in_array($tipo, $tipos_validos)) {
        $error = 'Tipo de solicitud no válido.';
    } elseif (!in_array($prioridad, $prioridades_validas)) {
        $error = 'Prioridad no válida.';
    } elseif (!in_array($linea, $lineas_validas)) {
        $error = 'Línea de negocio no válida.';
    } else {
        $db = conectarBD();
        if ($db) {
            $stmt = $db->prepare(
                "INSERT INTO tickets (solicitante, estado, sitio, tipo, prioridad, linea_negocio, descripcion, fecha_creacion)
                 VALUES (?, 'Pendiente', ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->bind_param("ssssss", $solicitante, $sitio_usuario, $tipo, $prioridad, $linea, $descripcion);
            if ($stmt->execute()) {
                $success = 'Ticket creado correctamente.';
            } else {
                $error = 'Error al guardar el ticket.';
            }
            $db->close();
        } else {
            $error = 'Error de conexión a la base de datos.';
        }
    }
}

$tipos     = ['Incidencia','Requerimiento Equipo de computo','Trino','Desarrollo'];
$prioridades = ['Baja','Media','Alta'];
$lineas     = ['SEDE CALI SUR', 'SEDE CALI NORTE', 'SEDE BOGOTÁ', 'SEDE MEDELLÍN', 'SEDE BARRANQUILLA'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Ticket — Sistema de Incidencias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="crear-body">

    <!-- TOP BAR -->
    <header class="crear-header">
        <div class="crear-header-logo">
            <img src="logo.jpg" alt="Logo">
        </div>
        <div class="crear-header-user">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
        </div>
    </header>

    <!-- CARD -->
    <div class="crear-card">

        <a href="index.php" class="crear-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        </a>

        <h1 class="crear-title">Crear un ticket</h1>
        <p class="crear-sub">Introduzca los datos a continuación para enviar su solicitud de soporte</p>

        <?php if ($error): ?>
            <div class="login-error" style="margin-bottom:16px;">
                <span>⚠</span> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="login-success" style="margin-bottom:16px;">
                <span>✓</span> <?= htmlspecialchars($success) ?>
            </div>
            <a href="index.php" class="btn-create-ticket" style="width:fit-content;margin:0 auto;">Ver mis tickets →</a>
        <?php else: ?>

        <form method="POST" enctype="multipart/form-data" class="crear-form" novalidate>

            <div class="crear-row-2">
                <div class="form-group">
                    <label for="nombre"><span class="req">*</span> Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                           value="<?= htmlspecialchars($_POST['nombre'] ?? $nombre_usuario) ?>"
                           placeholder="Nombre del solicitante" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" id="correo" name="correo"
                           value="<?= htmlspecialchars($_POST['correo'] ?? $email_usuario) ?>"
                           placeholder="correo@empresa.com">
                </div>
            </div>

            <div class="crear-row-2">
                <div class="form-group">
                    <label for="tipo"><span class="req">*</span> Tipo de solicitud</label>
                    <select id="tipo" name="tipo" class="form-select" required>
                        <option value="" disabled <?= empty($_POST['tipo'])?'selected':'' ?>>Seleccionar tipo</option>
                        <?php foreach ($tipos as $t): ?>
                        <option value="<?= $t ?>" <?= ($_POST['tipo'] ?? '')===$t?'selected':'' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="prioridad">Prioridad</label>
                    <select id="prioridad" name="prioridad" class="form-select">
                        <?php foreach ($prioridades as $p): ?>
                        <option value="<?= $p ?>" <?= ($_POST['prioridad'] ?? 'Media')===$p?'selected':'' ?>><?= $p ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="linea_negocio">Línea de negocio</label>
                <select id="linea_negocio" name="linea_negocio" class="form-select">
                    <option value="" disabled <?= empty($_POST['linea_negocio'])?'selected':'' ?>>Seleccionar línea</option>
                    <?php foreach ($lineas as $l): ?>
                    <option value="<?= $l ?>" <?= ($_POST['linea_negocio'] ?? '')===$l?'selected':'' ?>><?= $l ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <div id="quill-editor" class="quill-editor-box"></div>
                <input type="hidden" id="descripcion" name="descripcion">
            </div>

            <div class="form-group">
                <label>Archivos adjuntos <span class="req-hint">(puede seleccionar varios archivos)</span></label>
                <p class="file-label-hint">Seleccione El archivo Aquí</p>
                <div class="file-input-wrap">
                    <label class="file-btn" for="adjuntos">Seleccionar Archivo</label>
                    <span class="file-name" id="fileName">No se ha seleccionado ningún archivo...</span>
                    <input type="file" id="adjuntos" name="adjuntos[]" multiple style="display:none"
                           onchange="updateFileName(this)">
                </div>
            </div>

            <button type="submit" class="btn-create-ticket" onclick="syncDesc()">
                Crear ticket
            </button>

        </form>
        <?php endif; ?>

    </div>

    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Describe el problema o requerimiento...',
        modules: {
            toolbar: [
                ['bold','italic','underline','strike'],
                [{ list:'ordered' }, { list:'bullet' }],
                [{ align: [] }],
                ['link']
            ]
        }
    });

    function syncDesc() {
        document.getElementById('descripcion').value = quill.root.innerHTML;
    }

    document.querySelector('.crear-form')?.addEventListener('submit', syncDesc);

    function updateFileName(input) {
        const names = Array.from(input.files).map(f => f.name).join(', ');
        document.getElementById('fileName').textContent = names || 'No se ha seleccionado ningún archivo...';
    }
    </script>
</body>
</html>
