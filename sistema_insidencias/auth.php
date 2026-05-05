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
        "SELECT id, nombre, email, contraseña, rol, sitio, activo FROM usuarios WHERE email = ? LIMIT 1"
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

    if (!password_verify($password, $usuario['contraseña'])) {
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

function cerrarSesion() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
