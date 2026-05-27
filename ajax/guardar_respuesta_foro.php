<?php
session_start();
header('Content-Type: application/json');

require('../php/clases/class.System.php');

$db = new Conexion();

if (!isset($_SESSION['IdUsua'])) {
	echo json_encode([
		'ok' => false,
		'msg' => 'Sesión expirada.'
	]);
	exit;
}

$IdAlumno = intval($_SESSION['IdUsua']);
$IdActividad = intval($_POST['IdActividadesDocente']);
$IdAsignacion = trim($_POST['IdAsignacion']);
$IdParcial = intval($_POST['IdParcialDocente']);
$IdComentarioPadre = intval($_POST['IdComentarioPadre']);
$Comentario = trim($_POST['Comentario']);

if ($Comentario == '') {
	echo json_encode([
		'ok' => false,
		'msg' => 'La respuesta está vacía.'
	]);
	exit;
}

$Comentario = $db->real_escape_string($Comentario);

$sql = "INSERT INTO tblp_foro_comentarios (
		IdActividadesDocente,
		IdAsignacion,
		IdParcialDocente,
		IdAlumno,
		IdComentarioPadre,
		Comentario,
		FecCap,
		Estatus
	) VALUES (
		$IdActividad,
		'$IdAsignacion',
		$IdParcial,
		$IdAlumno,
		$IdComentarioPadre,
		'$Comentario',
		NOW(),
		'Activo'
	)";

$insert = $db->query($sql);

if (!$insert) {

	echo json_encode([
		'ok' => false,
		'msg' => 'No se pudo guardar la respuesta.'
	]);
	exit;

}

echo json_encode([
	'ok' => true,
	'msg' => 'Respuesta publicada correctamente.'
]);
exit;