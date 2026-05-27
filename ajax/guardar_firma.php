<?php
header('Content-Type: application/json');

if (!isset($_POST['firma']) || empty($_POST['firma'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se recibió ninguna firma.'
    ]);
    exit;
}
require('../php/clases/class.System.php');
$db = new Conexion();

$firma = $_POST['firma'];
$IdUsua = $_POST['IdUsua'];

// Validar que venga como imagen base64 PNG
if (strpos($firma, 'data:image/png;base64,') !== 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Formato de firma inválido.'
    ]);
    exit;
}

if ($IdUsua <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'El usuario del alumno es válido.'
    ]);
    exit;
}

// Quitar encabezado base64
$firma = str_replace('data:image/png;base64,', '', $firma);
$firma = str_replace(' ', '+', $firma);

$imagenDecodificada = base64_decode($firma);

if ($imagenDecodificada === false) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se pudo decodificar la imagen.'
    ]);
    exit;
}

// Carpeta donde se guardarán las firmas
$carpeta = '../assets/firma/';

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

// Nombre único para evitar sobrescribir archivos
$nombreArchivo = date('Ymd_His') . '_' . uniqid() . '.png';

$rutaArchivo = $carpeta . $nombreArchivo;

if (file_put_contents($rutaArchivo, $imagenDecodificada)) {
    $sql3 = $db->query("SELECT tblc_usuario.id_paquete FROM tblc_usuario WHERE tblc_usuario.IdUsua ='$IdUsua' ");
    $db->rows($sql3);
    $datos31 = $db->recorrer($sql3);

    if (isset($datos31['id_paquete'])) {
        $rutaEliminar = "../assets/firma/".$datos31['id_paquete'];
        if (file_exists($rutaEliminar) && is_file($rutaEliminar)) {
            unlink($rutaEliminar);
        }
    }

    $sql = "UPDATE tblc_usuario SET fecha_firma = NOW(), id_paquete = '$nombreArchivo' WHERE IdUsua = '$IdUsua'";
    $insert = $db->query($sql);
    echo json_encode([
        'status' => 'success',
        'message' => 'Firma guardada correctamente.',
        'ruta' => $rutaArchivo
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se pudo guardar la firma en el servidor.'
    ]);
}
?>