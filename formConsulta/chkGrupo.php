<?php
require('../php/clases/class.System.php');
$db = new Conexion();

$html = '';
$Ciclo = $_POST['Ciclo'];
$Oferta = $_POST['Oferta'];
$IdTipo = $_POST['IdEvaluacion'];
$Fec1 = $_POST['Fec1'];
$Fec2 = $_POST['Fec2'];
 
$sql8 = $db->query("SELECT tblc_tipoevaluacion.Cve FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion =  '$IdTipo'");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$Cve = $datos81["Cve"];

$sqly = $db->query("SELECT tblp_evaluacion.IdEvaluacion, tblp_evaluacion.IdGrupo FROM tblp_evaluacion Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblp_evaluacion.IdGrupo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta WHERE tblp_evaluacion.Valor_$IdTipo = '2' AND tblp_evaluacion.IdCiclo = '$Ciclo' AND tblp_grupo.IdOferta = '$Oferta'");
while($z = $db->recorrer($sqly)){
  $IdEva = $z["IdEvaluacion"];
  $IdGrp = $z["IdGrupo"];

  $sqlx = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.IdCampus, tblc_usuario.IdOferta FROM tblc_usuario WHERE tblc_usuario.IdGrupo = '$IdGrp' AND ((tblc_usuario.IdEstatus = '8') || (tblc_usuario.IdEstatus = '50'))");
  while($x = $db->recorrer($sqlx)){
    $IdU = $x["IdUsua"];
    $IdC = $x["IdCampus"];
    $IdO = $x["IdOferta"];

    $insertar = $db->query("INSERT INTO tblx_evaluacion (IdEvaluacion, IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, Tipo, IdTipo)VALUES ('$IdEva','$Ciclo','$IdC','$IdO','$IdGrp','$IdU',NOW(),'12','$Fec1','$Fec2', '$Cve','$IdTipo')");
    // $insertar = $db->query("INSERT INTO tblx_evaluacion (IdEvaluacion, IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, Tipo)VALUES ('$IdEva','$Ciclo','$IdC','$IdO','$IdGrp','$IdU',NOW(),'12','$Fec1','$Fec2', 'EC')");
    // $insertar = $db->query("INSERT INTO tblx_evaluacion (IdEvaluacion, IdCiclo, IdCampus, IdOferta, IdGrupo, IdUsua, FecCap, IdEstatus, FecIni, FecFin, Tipo)VALUES ('$IdEva','$Ciclo','$IdC','$IdO','$IdGrp','$IdU',NOW(),'12','$Fec1','$Fec2', 'ES')");
  }

  $insertar = $db->query("UPDATE tblp_evaluacion SET tblp_evaluacion.Valor_$IdTipo = '3', tblp_evaluacion.FecIni_$IdTipo = '$Fec1', tblp_evaluacion.FecFin_$IdTipo = '$Fec2' WHERE tblp_evaluacion.IdEvaluacion = '$IdEva'");
}




$db->close();

echo $html;
?>
