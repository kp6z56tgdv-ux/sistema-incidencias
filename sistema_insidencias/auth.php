<?php
if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'sistema_incidencias');
}

if (!function_exists('conectarBD')) {
    function conectarBD() {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($db->connect_error) return null;
        $db->set_charset("utf8mb4");
        return $db;
    }
}

function verificarSesion($roles = []) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
    if (!empty($roles) && !in_array($_SESSION['rol'], $roles)) {
        http_response_code(403);
        die('Acceso denegado para tu rol.');
    }
}

function iniciarSesion($email, $password) {
    $db = conectarBD();
    if (!$db) return ['exito' => false, 'mensaje' => 'Error al conectar con la base de datos.'];

    $stmt = $db->prepare(
        "SELECT id, nombre, email, contrasena, rol, sitio, activo FROM usuarios WHERE email = ? LIMIT 1"
    );
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $db->close();
        return ['exito' => false, 'mensaje' => 'Credenciales incorrectas.'];
    }

    $usuario = $result->fetch_assoc();
    $db->close();

    if (!$usuario['activo']) {
        return ['exito' => false, 'mensaje' => 'Tu cuenta está desactivada. Contacta al administrador.'];
    }

    if (!password_verify($password, $usuario['contrasena'])) {
        return ['exito' => false, 'mensaje' => 'Credenciales incorrectas.'];
    }

    if (session_status() === PHP_SESSION_NONE) session_start();
    session_regenerate_id(true);

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre']     = $usuario['nombre'];
    $_SESSION['email']      = $usuario['email'];
    $_SESSION['rol']        = $usuario['rol'];
    $_SESSION['sitio']      = $usuario['sitio'] ?? '';

    return ['exito' => true, 'mensaje' => 'Sesión iniciada.'];
}

function registrarUsuario($nombre, $email, $password, $sitio) {
    $db = conectarBD();
    if (!$db) return ['exito' => false, 'mensaje' => 'Error al conectar con la base de datos.'];

    $check = $db->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $db->close();
        return ['exito' => false, 'mensaje' => 'Ya existe una cuenta con ese correo electrónico.'];
    }
    $check->close();

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare(
        "INSERT INTO usuarios (nombre, email, contrasena, rol, sitio, activo) VALUES (?, ?, ?, 'usuario', ?, 1)"
    );
    $stmt->bind_param("ssss", $nombre, $email, $hash, $sitio);
    $ok = $stmt->execute();
    $db->close();

    if (!$ok) return ['exito' => false, 'mensaje' => 'No se pudo crear la cuenta. Intenta de nuevo.'];
    return ['exito' => true, 'mensaje' => 'Cuenta creada exitosamente. Ya puedes iniciar sesión.'];
}

function actualizarContrasena($usuario_id, $contrasenaActual, $contrasenaNueva) {
    if (empty($contrasenaActual) || empty($contrasenaNueva)) {
        return ['exito' => false, 'mensaje' => 'Todos los campos son obligatorios.'];
    }

    if (strlen($contrasenaNueva) < 6) {
        return ['exito' => false, 'mensaje' => 'La contraseña nueva debe tener al menos 6 caracteres.'];
    }

    $db = conectarBD();
    if (!$db) return ['exito' => false, 'mensaje' => 'Error al conectar con la base de datos.'];

    $stmt = $db->prepare("SELECT contrasena FROM usuarios WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $db->close();
        return ['exito' => false, 'mensaje' => 'Usuario no encontrado.'];
    }

    $usuario = $result->fetch_assoc();
    if (!password_verify($contrasenaActual, $usuario['contrasena'])) {
        $db->close();
        return ['exito' => false, 'mensaje' => 'La contraseña actual es incorrecta.'];
    }

    $hash = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
    $update = $db->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $update->bind_param("si", $hash, $usuario_id);
    $ok = $update->execute();
    $db->close();

    if (!$ok) return ['exito' => false, 'mensaje' => 'No se pudo actualizar la contraseña. Intenta de nuevo.'];
    return ['exito' => true, 'mensaje' => 'Contraseña actualizada correctamente.'];
}

function cerrarSesion() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
