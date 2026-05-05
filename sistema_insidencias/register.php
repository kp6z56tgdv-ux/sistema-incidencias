<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'auth.php';
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre']    ?? '');
    $email     = trim($_POST['email']     ?? '');
    $password  = $_POST['password']       ?? '';
    $confirmar = $_POST['confirmar']      ?? '';
    $sitio     = $_POST['sitio']          ?? '';

    if (empty($nombre) || empty($email) || empty($password) || empty($confirmar) || empty($sitio)) {
        $error = 'Por favor completa todos los campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El correo electrónico no es válido.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($password !== $confirmar) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $resultado = registrarUsuario($nombre, $email, $password, $sitio);
        if ($resultado['exito']) {
            $success = $resultado['mensaje'];
        } else {
            $error = $resultado['mensaje'];
        }
    }
}

$sitios = ['CALI', 'BOGOTÁ', 'MEDELLÍN', 'BARRANQUILLA'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — Help Desk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="login-body">

    <div class="login-card">

        <div class="login-logo">
            <img src="logo.jpg" alt="Logo">
        </div>

        <h1 class="login-title">Crear cuenta</h1>
        <p class="login-sub">Completa los datos para registrarte en el sistema.</p>

        <?php if ($error): ?>
            <div class="login-error">
                <span>⚠</span> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="login-success">
                <span>✓</span> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" class="login-form" novalidate>
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Tu nombre"
                    value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                    required
                    autocomplete="name"
                >
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="tucorreo@empresa.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="sitio">Sede</label>
                <select id="sitio" name="sitio" required class="form-select">
                    <option value="" disabled <?= empty($_POST['sitio']) ? 'selected' : '' ?>>Selecciona tu sede</option>
                    <?php foreach ($sitios as $s): ?>
                        <option value="<?= $s ?>" <?= ($_POST['sitio'] ?? '') === $s ? 'selected' : '' ?>>
                            <?= $s ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-password-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 6 caracteres"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass('password','eye1')" title="Mostrar/ocultar contraseña">
                        <span id="eye1">👁</span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="confirmar">Confirmar contraseña</label>
                <div class="input-password-wrap">
                    <input
                        type="password"
                        id="confirmar"
                        name="confirmar"
                        placeholder="Repite la contraseña"
                        required
                        autocomplete="new-password"
                    >
                    <button type="button" class="toggle-pass" onclick="togglePass('confirmar','eye2')" title="Mostrar/ocultar contraseña">
                        <span id="eye2">👁</span>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-login">
                Registrarse →
            </button>

            <p class="login-sub-center">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
        </form>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary btn-login" style="text-align:center;text-decoration:none;margin-top:8px;">
                Ir al inicio de sesión →
            </a>
        <?php endif; ?>

    </div>

    <script>
    function togglePass(fieldId, eyeId) {
        const input = document.getElementById(fieldId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>
