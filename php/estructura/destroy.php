<?php
session_start();
require('../clases/class.php');
$t=new Trabajo();
$U = $_SESSION['IdUsua'];
$C = $_SESSION['codex'];

$Hoy = "2019-01-10 11:59:04";
$date1=date_create($Hoy);
$FeLimPagmx = "2019-01-10 11:53:54";
$date2=date_create($FeLimPagmx);
$diff=date_diff($date1,$date2);
$dias = $diff->format("%R%a");

$t->upd_salida($_SESSION['IdUsua'],$_SESSION['codex'],$_SESSION['inicio']);

// $query3="UPDATE tblh_contador SET tblh_contador.FecSal = NOW(), tblh_contador.Duracion = '$dias' WHERE tblh_contador.IdUsua = '$U' AND tblh_contador.Codex = '$C' ";
// mysql_query($query3,Conectar::con());

if($_SESSION['Permisos'] != 5) {
  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Ha salido de la Plataforma Educativa Online');
}

$_session= array();
session_unset();
session_destroy();
unset($_SESSION['IdUsua']);
header("Location: ../../index.php");
?>
