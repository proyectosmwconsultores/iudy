<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['IdUsua']) || empty($_SESSION['IdUsua'])) {
	echo json_encode([
		'ok' => false,
		'msg' => 'Tu sesión ha expirado. Debes iniciar sesión nuevamente.'
	]);
	exit;
}

require('../php/clases/class.System.php');
$db = new Conexion();

$IdAlumno = intval($_SESSION['IdUsua']);
$IdTarea = isset($_POST['IdTarea']) ? intval($_POST['IdTarea']) : 0;

if ($IdTarea <= 0) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se recibió el identificador de la tarea.'
	]);
	exit;
}

/* Buscar tarea del alumno */
$sqlBuscar = "SELECT IdTarea, IdAsignacion, Link FROM tblp_tareas WHERE IdTarea = $IdTarea AND IdAlumno = $IdAlumno LIMIT 1";
$resBuscar = $db->query($sqlBuscar);
if (!$resBuscar || mysqli_num_rows($resBuscar) == 0) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se encontró la tarea o no tienes permiso para eliminarla.'
	]);
	exit;
}

$tarea = mysqli_fetch_assoc($resBuscar);

$IdAsignacion = $tarea['IdAsignacion'];

$sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.Mes FROM tblp_asignacion WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' AND tblp_asignacion.Tipo = '2'");
$db->rows($sql3);
$datos31 = $db->recorrer($sql3);
$AAnio = $datos31["Anio"];
$MMes = $datos31["Mes"];

$baseDir = '../assets/trabajos/';
$year = $datos31["Anio"];
$month = $datos31["Mes"];

$targetDir = $baseDir . $year . '/' . $month . '/' . $IdAsignacion . '/tareas/';


/* Eliminar archivo físico si existe */
if (!empty($tarea['Link'])) {
	$rutaFisica = $baseDir . $year . '/' . $month . '/' . $IdAsignacion . '/tareas/'. $tarea['Link'];
	if (file_exists($rutaFisica)) {
		@unlink($rutaFisica);
	}
}

/* actualizar registro */
$sqlUpdate = "UPDATE tblp_tareas SET tblp_tareas.Link = NULL, tblp_tareas.Comentario = NULL, tblp_tareas.Estatus = NULL, tblp_tareas.FecCap = NULL, tblp_tareas.Porcentaje = NULL, tblp_tareas.Calificacion = NULL WHERE tblp_tareas.IdTarea = '$IdTarea'";
$update = $db->query($sqlUpdate);
if (!$update) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se pudo eliminar el registro de la tarea.'
	]);
	exit;
}

echo json_encode([
	'ok' => true,
	'msg' => 'La tarea se eliminó correctamente.'
]);
exit;
