<?php
session_start();
header('Content-Type: application/json');

require('../php/clases/class.System.php');

$db = new Conexion();

$IdAlumno = intval($_SESSION['IdUsua']);
$IdActividad = intval($_POST['IdActividadesDocente']);
$IdAsignacion = trim($_POST['IdAsignacion']);
$IdParcial = intval($_POST['IdParcialDocente']);
$Comentario = trim($_POST['Comentario']);

if ($Comentario == '') {
    echo json_encode([
        'ok' => false,
        'msg' => 'El comentario está vacío.'
    ]);
    exit;
}

$Comentario = $db->real_escape_string($Comentario);

$sql = "INSERT INTO tblp_foro_comentarios (
            IdActividadesDocente,
            IdAsignacion,
            IdParcialDocente,
            IdAlumno,
            Comentario,
            IdComentarioPadre,
            FecCap,
            Estatus
        ) VALUES (
            $IdActividad,
            '$IdAsignacion',
            $IdParcial,
            $IdAlumno,
            '$Comentario',
            NULL,
            NOW(),
            'Activo'
        )";

$insert = $db->query($sql);

if (!$insert) {
    echo json_encode([
        'ok' => false,
        'msg' => 'No se pudo guardar el comentario.'
    ]);
    exit;
}

echo json_encode([
    'ok' => true,
    'msg' => 'Comentario publicado.'
]);
exit;