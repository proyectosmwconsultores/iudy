<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once '../php/clases/class.System.php';
$db = new Conexion();

/*
|--------------------------------------------------------------------------
| Validar sesión
|--------------------------------------------------------------------------
*/
$IdUsuaSesion = isset($_SESSION['IdUsua']) ? (int)$_SESSION['IdUsua'] : 0;

if ($IdUsuaSesion <= 0) {
    http_response_code(401);
    echo json_encode([
        'ok' => false,
        'msg' => 'Sesión no válida'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Recibir datos
|--------------------------------------------------------------------------
*/
$IdAsignacion = isset($_POST['IdAsignacion']) ? trim($_POST['IdAsignacion']) : '';

if ($IdAsignacion === '') {
    echo json_encode([
        'ok' => false,
        'msg' => 'IdAsignacion requerido'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Seguridad
|--------------------------------------------------------------------------
*/
$IdAsignacionEsc = $db->real_escape_string($IdAsignacion);

/*
|--------------------------------------------------------------------------
| Limpiar equipos (SET NULL)
|--------------------------------------------------------------------------
*/
$sql = $db->query("
    UPDATE tblp_moduloalumno
    SET Equipo = NULL
    WHERE IdAsignacion = '$IdAsignacionEsc'
");

if (!$sql) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'msg' => 'Error al limpiar la asignación'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Respuesta
|--------------------------------------------------------------------------
*/
echo json_encode([
    'ok' => true,
    'msg' => 'Asignación limpiada correctamente'
]);
exit;