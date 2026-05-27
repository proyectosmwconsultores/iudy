<?php
require('../php/clases/class.System.php');
include('../hace.php');

header('Content-Type: application/json; charset=utf-8');

$db = new Conexion();

$idAsignacion = isset($_POST['idAsignacion']) ? $_POST['idAsignacion'] : 0;
$start = isset($_POST['start']) ? $_POST['start'] : null;
$end   = isset($_POST['end']) ? $_POST['end'] : null;

$eventos = [];

/*
  AJUSTA ESTA CONSULTA A TU ESTRUCTURA REAL.
  Aquí te dejo una base genérica para actividades por rango de fecha.
*/

$sql = $db->query("
  SELECT
    IdActividadesDocente,
    NomActividad,
    IdTipoActividad,
    FecIni,
    FecFin,
    IdParcialDocente,
    IdSemanaDocente
  FROM tblp_actividadesdocente
  WHERE IdEstatus <> '12' AND IdAsignacion = '$idAsignacion'
    AND FecIni >= '$start'
    AND FecIni <= '$end'
  ORDER BY FecIni ASC
");

while($row = $db->recorrer($sql)) {

  $color = '#2563eb';

  if ($row['IdTipoActividad'] == 1) {
    $color = '#2563eb'; // tarea
  } elseif ($row['IdTipoActividad'] == 2) {
    $color = '#d97706'; // foro
  } elseif ($row['IdTipoActividad'] == 3) {
    $color = '#059669'; // recurso
  } elseif ($row['IdTipoActividad'] == 4) {
    $color = '#dc2626'; // examen
  }

  $idToks = $row['IdParcialDocente'] . '_' . $row['IdSemanaDocente'] . '_' . $row['IdActividadesDocente'];

  $eventos[] = [
    'title' => $row['NomActividad'],
    'start' => date('Y-m-d', strtotime($row['FecIni'])),
    'end'   => !empty($row['FecFin']) ? date('Y-m-d', strtotime($row['FecFin'] . ' +1 day')) : null,
    'backgroundColor' => $color,
    'borderColor' => $color,
    'textColor' => '#ffffff',
    'extendedProps' => [
      'tipo' => $row['IdTipoActividad'],
      'urlInterna' => "miAula.php?idAsignacion=" . $idAsignacion . "&idToks=" . $idToks
    ]
  ];
}

echo json_encode($eventos, JSON_UNESCAPED_UNICODE);