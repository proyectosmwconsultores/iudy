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
$IdAsignacion = isset($_POST['IdAsignacion']) ? trim($_POST['IdAsignacion']) : '';
$IdActividadesDocente = isset($_POST['IdActividadesDocente']) ? intval($_POST['IdActividadesDocente']) : 0;
$IdParcialDocente = isset($_POST['IdParcialDocente']) ? intval($_POST['IdParcialDocente']) : 0;
$IdTarea = isset($_POST['IdTarea']) ? intval($_POST['IdTarea']) : 0;
$Comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

if ($IdAsignacion == '' || $IdActividadesDocente <= 0 || $IdTarea <= 0) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se recibieron correctamente los datos de la actividad.'
	]);
	exit;
}

if (!isset($_FILES['archivo'])) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se recibió ningún archivo.'
	]);
	exit;
}
sleep(1);

$archivo = $_FILES['archivo'];

if ($archivo['error'] !== UPLOAD_ERR_OK) {
	$mensaje = 'Error al subir el archivo.';

	switch ($archivo['error']) {
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
			$mensaje = 'El archivo excede el tamaño permitido por el servidor.';
			break;
		case UPLOAD_ERR_PARTIAL:
			$mensaje = 'El archivo se subió parcialmente.';
			break;
		case UPLOAD_ERR_NO_FILE:
			$mensaje = 'No seleccionaste ningún archivo.';
			break;
		default:
			$mensaje = 'Ocurrió un error durante la carga del archivo.';
			break;
	}

	echo json_encode([
		'ok' => false,
		'msg' => $mensaje
	]);
	exit;
}

$maxSize = 20 * 1024 * 1024;
if ($archivo['size'] > $maxSize) {
	echo json_encode([
		'ok' => false,
		'msg' => 'El archivo supera el tamaño máximo permitido de 20 MB.'
	]);
	exit;
}

$nombreOriginal = $archivo['name'];
$extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

$extensionesPermitidas = [
	'pdf', 'doc', 'docx', 'txt', 'rtf',
	'xls', 'xlsx', 'csv',
	'ppt', 'pptx',
	'jpg', 'jpeg', 'png', 'gif', 'webp',
	'zip', 'rar'
];

if (!in_array($extension, $extensionesPermitidas)) {
	echo json_encode([
		'ok' => false,
		'msg' => 'Formato no permitido. Solo se aceptan PDF, Word, Excel, PowerPoint, imágenes y ZIP/RAR.'
	]);
	exit;
}


$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $archivo['tmp_name']);
finfo_close($finfo);

$mimesPermitidos = [
	'application/pdf',

	'application/msword',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'text/plain',
	'application/rtf',
	'text/rtf',

	'application/vnd.ms-excel',
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'text/csv',
	'application/csv',

	'application/vnd.ms-powerpoint',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation',

	'image/jpeg',
	'image/png',
	'image/gif',
	'image/webp',

	'application/zip',
	'application/x-zip-compressed',
	'application/vnd.rar',
	'application/x-rar-compressed',

	'application/octet-stream'
];

$extensionesOfficeZip = ['docx', 'xlsx', 'pptx'];

$mimeValido = in_array($mime, $mimesPermitidos);

if (!$mimeValido && in_array($extension, $extensionesOfficeZip)) {
	$mimeValido = in_array($mime, ['application/zip', 'application/octet-stream']);
}

if (!$mimeValido) {
	echo json_encode([
		'ok' => false,
		'msg' => 'El archivo no cumple con un tipo válido permitido por la plataforma. MIME detectado: ' . $mime
	]);
	exit;
}

$sql3 = $db->query("SELECT tblp_asignacion.Anio, tblp_asignacion.IdUsua, tblp_asignacion.Mes 
	FROM tblp_asignacion 
	WHERE tblp_asignacion.IdAsignacion ='$IdAsignacion' 
	AND tblp_asignacion.Tipo = '2'");

$db->rows($sql3);
$datos31 = $db->recorrer($sql3);

if (!$datos31) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se encontró la asignación relacionada con la actividad.'
	]);
	exit;
}

$AAnio = $datos31["Anio"];
$MMes = $datos31["Mes"];
$IdUsua_recibe = $datos31["IdUsua"];

$baseDir = '../assets/trabajos/';
$year = $datos31["Anio"];
$month = $datos31["Mes"];

$targetDir = $baseDir . $year . '/' . $month . '/' . $IdAsignacion . '/tareas/';

if (!is_dir($targetDir)) {
	if (!mkdir($targetDir, 0777, true)) {
		echo json_encode([
			'ok' => false,
			'msg' => 'No se pudo crear la carpeta de destino para guardar la tarea.'
		]);
		exit;
	}
}

$nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
$nombreBase = preg_replace('/[^A-Za-z0-9\-_]/', '_', $nombreBase);
$nombreBase = preg_replace('/_+/', '_', $nombreBase);
$nombreBase = trim($nombreBase, '_');

if ($nombreBase == '') {
	$nombreBase = 'archivo';
}

$nombreSeguro = $IdAlumno . '_' . $IdActividadesDocente . '_' . date('Ymd_His') . '_' . $nombreBase . '.' . $extension;

$rutaFisica = $targetDir . $nombreSeguro;
$rutaBD = $nombreSeguro;

if (!move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
	echo json_encode([
		'ok' => false,
		'msg' => 'No se pudo mover el archivo al directorio final.'
	]);
	exit;
}

$ExtensionArchivo = $db->real_escape_string($extension);
$PesoArchivo = intval($archivo['size']);
$PesoArchivoMB = round($PesoArchivo / 1024 / 1024, 2);

$Comentario = $db->real_escape_string($Comentario);
$IdAsignacionEsc = $db->real_escape_string($IdAsignacion);
$rutaBDEsc = $db->real_escape_string($rutaBD);

if (!empty($Comentario)) {
	$db->query("INSERT INTO tblp_tareascomentarios (
		IdTarea, Tipo, Comentario, IdUsua, FecCap, IdUsua_envia, IdUsua_recibe, Visto, IdActividad
	) VALUES (
		'$IdTarea','A','$Comentario','$IdAlumno',NOW(),'$IdAlumno','$IdUsua_recibe','1','$IdActividadesDocente'
	)");
}

$sql = "UPDATE tblp_tareas 
		SET Link = '$rutaBDEsc',
			Comentario = '$Comentario',
			Estatus = 'Entregada',
			FecCap = NOW(),
			ExtensionArchivo = '$ExtensionArchivo',
			PesoArchivo = '$PesoArchivoMB'
		WHERE IdTarea = '$IdTarea'";

$insert = $db->query($sql);

if (!$insert) {
	if (file_exists($rutaFisica)) {
		unlink($rutaFisica);
	}

	echo json_encode([
		'ok' => false,
		'msg' => 'El archivo se cargó, pero no se pudo guardar el registro en la base de datos.'
	]);
	exit;
}

echo json_encode([
	'ok' => true,
	'msg' => 'La tarea se subió correctamente.'
]);
exit;