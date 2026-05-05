<?php
require_once 'auth.php';
verificarSesion();

$error = '';
$success = '';
$nombre = $_SESSION['nombre'] ?? '';
$email  = $_SESSION['email'] ?? '';
$rol    = $_SESSION['rol'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actual   = $_POST['password_actual'] ?? '';
    $nueva    = $_POST['password_nueva'] ?? '';
    $confirmo = $_POST['password_confirmar'] ?? '';

    if (empty($actual) || empty($nueva) || empty($confirmo)) {
        $error = 'Por favor completa todos los campos.';
    } elseif ($nueva !== $confirmo) {
        $error = 'Las contraseñas nuevas no coinciden.';
    } else {
        $resultado = actualizarContrasena($_SESSION['usuario_id'], $actual, $nueva);
        if ($resultado['exito']) {
            $success = $resultado['mensaje'];
        } else {
            $error = $resultado['mensaje'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi cuenta — Sistema de Incidencias</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons/css/regular-rounded.css">
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

        <h1 class="crear-title">Mi cuenta</h1>
        <p class="crear-sub">Gestiona tus datos personales y seguridad</p>

        <?php if ($error): ?>
            <div class="login-error" style="margin-bottom:16px;">
                <span>⚠</span> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="login-success" style="margin-bottom:16px;">
                <span>✓</span> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="cuenta-info">
            <div class="cuenta-info-row">
                <span class="cuenta-info-label"><i class="fi fi-rs-user"></i> Nombre</span>
                <span class="cuenta-info-value"><?= htmlspecialchars($nombre) ?></span>
            </div>
            <div class="cuenta-info-row">
                <span class="cuenta-info-label"><i class="fi fi-rs-envelope"></i> Email</span>
                <span class="cuenta-info-value"><?= htmlspecialchars($email) ?></span>
            </div>
            <div class="cuenta-info-row">
                <span class="cuenta-info-label"><i class="fi fi-rs-id-badge"></i> Rol</span>
                <span class="cuenta-info-value"><?= htmlspecialchars(ucfirst($rol)) ?></span>
            </div>
        </div>

        <form method="POST" class="crear-form" novalidate>
            <div class="form-group">
                <label for="password_actual"><span class="req">*</span> Contraseña actual</label>
                <div class="input-password-wrap">
                    <input type="password" id="password_actual" name="password_actual" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="toggle-pass" onclick="togglePass('password_actual','eye-actual')" title="Mostrar/ocultar contraseña">
                        <span id="eye-actual"><i class="fi fi-rs-eye"></i></span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_nueva"><span class="req">*</span> Nueva contraseña</label>
                <div class="input-password-wrap">
                    <input type="password" id="password_nueva" name="password_nueva" placeholder="••••••••" required autocomplete="new-password">
                    <button type="button" class="toggle-pass" onclick="togglePass('password_nueva','eye-nueva')" title="Mostrar/ocultar contraseña">
                        <span id="eye-nueva"><i class="fi fi-rs-eye"></i></span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmar"><span class="req">*</span> Confirmar nueva contraseña</label>
                <div class="input-password-wrap">
                    <input type="password" id="password_confirmar" name="password_confirmar" placeholder="Repite la contraseña" required autocomplete="new-password">
                    <button type="button" class="toggle-pass" onclick="togglePass('password_confirmar','eye-confirmar')" title="Mostrar/ocultar contraseña">
                        <span id="eye-confirmar"><i class="fi fi-rs-eye"></i></span>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-create-ticket">
                Actualizar contraseña
            </button>
        </form>
    </div>

    <script>
    function togglePass(inputId, iconId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>
