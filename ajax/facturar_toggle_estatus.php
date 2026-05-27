<?php
session_start();
header('Content-Type: application/json');

require('../php/clases/class.System.php');
$db = new Conexion();

// Seguridad básica
$IdUsua = $_SESSION['IdUsua'] ?? null;
if (!$IdUsua) {
  echo json_encode(['ok' => false, 'msg' => 'Su sesión no es válida, favor de ingresar nuevamente']);
  exit;
}

$IdPago = isset($_POST['idpago']) ? (int)$_POST['idpago'] : 0;
$Estatus  = isset($_POST['Estatus']) ? trim($_POST['Estatus']) : '';


$sql8 = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdUsua, tblc_datosfactura.IdEstatus FROM tblp_pagos LEFT JOIN tblc_datosfactura ON tblp_pagos.IdUsua = tblc_datosfactura.IdUsua WHERE tblp_pagos.IdPago = '$IdPago' ");
$datos81 = $db->recorrer($sql8);


if(!isset($datos81["IdEstatus"])){
  echo json_encode(['ok' => false, 'msg' => 'No existe datos de facturación, favor de capturarlo.']);
  exit;
}

$IdEstatus = $datos81["IdEstatus"];

if($IdEstatus <> 8){
  echo json_encode(['ok' => false, 'msg' => 'Sus datos de facturación no esta activo, favor de validarlo con el área financiera.']);
  exit;
}

if ($IdPago <= 0) {
  echo json_encode(['ok' => false, 'msg' => 'Concepto de pago inválido.']);
  exit;
}

if ($Estatus !== 'SI' && $Estatus !== 'NO') {
  echo json_encode(['ok' => false, 'msg' => 'Estatus inválido.']);
  exit;
}

// (Opcional) validar permisos aquí si lo necesitas
// Ej: validar que el usuario tenga acceso al módulo 80 o rol admin

// Actualizar BD


$sql = $db->query("UPDATE tblp_pagos SET Facturar = '$Estatus' WHERE IdPago = '$IdPago'");

if ($sql) {
  echo json_encode(['ok' => true, 'msg' => 'Actualizado']);
} else {
  echo json_encode(['ok' => false, 'msg' => 'No se pudo guardar en BD.']);
}
?>