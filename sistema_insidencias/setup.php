<?php
/**
 * Setup inicial — crea los 3 usuarios por defecto.
 * IMPORTANTE: Elimina o protege este archivo después de ejecutarlo.
 */

require_once 'auth.php';
$db = conectarBD();

if (!$db) {
    die('<p style="color:red;font-family:sans-serif">Error de conexión. Verifica la base de datos.</p>');
}

$usuarios = [
    [
        'nombre'     => 'Administrador',
        'email'      => 'admin@helpdesk.com',
        'password'   => 'admin123',
        'rol'        => 'admin',
        'sitio'      => 'CALI',
    ],
    [
        'nombre'     => 'Usuario Demo',
        'email'      => 'usuario@helpdesk.com',
        'password'   => 'user123',
        'rol'        => 'usuario',
        'sitio'      => 'BOGOTÁ',
    ],
    [
        'nombre'     => 'Aprobador Demo',
        'email'      => 'aprobaciones@helpdesk.com',
        'password'   => 'apro123',
        'rol'        => 'aprobaciones',
        'sitio'      => 'MEDELLÍN',
    ],
];

$resultados = [];

foreach ($usuarios as $u) {
    $hash = password_hash($u['password'], PASSWORD_DEFAULT);
    $stmt = $db->prepare(
        "INSERT INTO usuarios (nombre, email, contrasena, rol, sitio, activo)
         VALUES (?, ?, ?, ?, ?, 1)
         ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), rol = VALUES(rol)"
    );
    $stmt->bind_param("sssss", $u['nombre'], $u['email'], $hash, $u['rol'], $u['sitio']);

    if ($stmt->execute()) {
        $resultados[] = ['ok' => true,  'email' => $u['email'], 'pass' => $u['password'], 'rol' => $u['rol']];
    } else {
        $resultados[] = ['ok' => false, 'email' => $u['email'], 'error' => $db->error];
    }
}

$db->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Setup — Sistema de Incidencias</title>
<style>
  body { font-family: 'Segoe UI', sans-serif; background: #f0f2f7; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
  .card { background: #fff; border-radius: 16px; padding: 40px 48px; box-shadow: 0 8px 32px rgba(0,0,0,.1); max-width: 520px; width: 100%; }
  h1 { font-size: 22px; color: #1a3a6b; margin-bottom: 4px; }
  p.sub { color: #6b7a95; font-size: 14px; margin-bottom: 24px; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; }
  th { text-align: left; padding: 8px 12px; background: #f0f2f7; color: #1a3a6b; font-size: 11px; text-transform: uppercase; letter-spacing: .06em; }
  td { padding: 10px 12px; border-bottom: 1px solid #dde3ef; }
  .ok  { color: #1e8c4d; font-weight: 700; }
  .err { color: #c9310f; font-weight: 700; }
  .warn { background: #fff8e8; border: 1px solid #f5d67a; border-radius: 10px; padding: 14px 18px; margin-top: 24px; font-size: 13px; color: #7a5a00; }
  a { color: #1a3a6b; font-weight: 600; }
</style>
</head>
<body>
<div class="card">
    <h1><img src="logo.jpg" alt="Logo" style="width:48px;height:48px;object-fit:contain;border-radius:8px;vertical-align:middle;margin-right:12px;">Setup completado</h1>
    <p class="sub">Usuarios creados en la base de datos.</p>
    <table>
        <tr><th>Email</th><th>Contraseña</th><th>Rol</th><th>Estado</th></tr>
        <?php foreach ($resultados as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['email']) ?></td>
            <td><?= isset($r['pass']) ? htmlspecialchars($r['pass']) : '—' ?></td>
            <td><?= isset($r['rol']) ? htmlspecialchars($r['rol']) : '—' ?></td>
            <td><?= $r['ok'] ? '<span class="ok">✓ OK</span>' : '<span class="err">✗ ' . htmlspecialchars($r['error']) . '</span>' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="warn">
        ⚠ <strong>Elimina este archivo</strong> del servidor después de usarlo.<br>
        <a href="login.php">→ Ir al login</a>
    </div>
</div>
</body>
</html>
