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
        'msg' => 'Sesión no válida.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Recibir datos
|--------------------------------------------------------------------------
*/
$IdAsignacion = isset($_POST['IdAsignacion']) ? trim($_POST['IdAsignacion']) : '';
$IdUsuaAlumno = isset($_POST['IdUsua']) ? (int)$_POST['IdUsua'] : 0;
$Equipo       = isset($_POST['Equipo']) ? trim($_POST['Equipo']) : '';

if ($IdAsignacion === '' || $IdUsuaAlumno <= 0) {
    echo json_encode([
        'ok' => false,
        'msg' => 'Datos incompletos.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Validaciones
|--------------------------------------------------------------------------
*/
if ($Equipo !== '') {
    if (!preg_match('/^[0-9]+$/', $Equipo)) {
        echo json_encode([
            'ok' => false,
            'msg' => 'El número de equipo debe ser numérico.'
        ]);
        exit;
    }

    $Equipo = (int)$Equipo;

    if ($Equipo <= 0) {
        echo json_encode([
            'ok' => false,
            'msg' => 'El número de equipo debe ser mayor a cero.'
        ]);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Seguridad / sanitización
|--------------------------------------------------------------------------
*/
$IdAsignacionEsc = $db->real_escape_string($IdAsignacion);

/*
|--------------------------------------------------------------------------
| Verificar que exista el alumno en la asignación
|--------------------------------------------------------------------------
*/
$sqlExiste = $db->query("
    SELECT IdModuloAlumno, IdUsua, Equipo
    FROM tblp_moduloalumno
    WHERE IdAsignacion = '$IdAsignacionEsc'
      AND IdUsua = $IdUsuaAlumno
    LIMIT 1
");

if (!$sqlExiste) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'msg' => 'Error al validar el registro.'
    ]);
    exit;
}

$existe = $db->rows($sqlExiste);

if ($existe <= 0) {
    echo json_encode([
        'ok' => false,
        'msg' => 'No se encontró el alumno en la asignación.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Actualizar equipo
|--------------------------------------------------------------------------
| Si viene vacío, guarda NULL o vacío según tu estructura.
| Aquí lo dejaré como cadena vacía si se limpia.
|--------------------------------------------------------------------------
*/
if ($Equipo === '') {
    $sqlUpdate = $db->query("
        UPDATE tblp_moduloalumno
        SET Equipo = ''
        WHERE IdAsignacion = '$IdAsignacionEsc'
          AND IdUsua = $IdUsuaAlumno
        LIMIT 1
    ");
} else {
    $sqlUpdate = $db->query("
        UPDATE tblp_moduloalumno
        SET Equipo = '$Equipo'
        WHERE IdAsignacion = '$IdAsignacionEsc'
          AND IdUsua = $IdUsuaAlumno
        LIMIT 1
    ");
}

if (!$sqlUpdate) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'msg' => 'No se pudo actualizar el número de equipo.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Bitácora opcional
|--------------------------------------------------------------------------
*/
// if (method_exists($t ?? null, 'add_ingresos')) {
//     // solo si en esta vista tienes acceso a $t; si no, ignóralo
// }

/*
|--------------------------------------------------------------------------
| Respuesta
|--------------------------------------------------------------------------
*/
echo json_encode([
    'ok' => true,
    'msg' => 'Equipo actualizado correctamente.',
    'IdAsignacion' => $IdAsignacion,
    'IdUsua' => $IdUsuaAlumno,
    'Equipo' => $Equipo
]);
exit;
?>