<?php
require('../php/clases/class.System.php');
$db = new Conexion();

$tipo = $_POST["TipoGuardar"];

if($tipo == "sav_cve_grupo"){
    $IdCampus = $_POST["IdCampus"];
    $IdOferta = $_POST["IdOferta"];
    $Modalidad = $_POST["Modalidad"];
    $Turno = $_POST["Turno"];
    $IdCiclo = $_POST["Ciclo"];
    $Dia = $_POST["Dia"];
    $Anio = substr($_POST["Inicio"],2,2);
    $Inicio = $_POST["Inicio"];
    $Final = $_POST["Final"];
    $Grupo = $_POST["Grupo"];

    $sql1 = $db->query("SELECT tblp_educativa.Clave FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta' ");
    $db->rows($sql1);
    $datos11 = $db->recorrer($sql1);
    $oferta = $datos11["Clave"];

    $sql2 = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Tipo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo =  '$IdCiclo' ");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $Ciclo = substr($datos21["Tipo"], 0, 1);

    $_cve = $oferta.$Modalidad.$Dia.$Ciclo.$Turno.$Anio.$Grupo;

    $sql2 = $db->query("SELECT tblp_grupo.IdGrupo FROM tblp_grupo WHERE tblp_grupo.CveGrupo =  '$_cve' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCicloIni = '$IdCiclo'");
    $db->rows($sql2);
    $datos21 = $db->recorrer($sql2);
    $IdGrupo = $datos21["IdGrupo"];
    if($IdGrupo){
      echo 2;
      exit();
    } else {

      $insertar = $db->query("INSERT INTO tblp_grupo (CveGrupo, Estatus, Turno, Oferta, Grupo, Modalidad, IdOferta,IdCampus, Anio, TipoCiclo, Dia, FecCap, Periodo,IdEstatus,IdCicloIni, Disponible, FechaIni, FechaFin, Grado) VALUES ('$_cve','Abierto', '$Turno','$oferta','$Grupo','$Modalidad','$IdOferta','$IdCampus','$Anio','$Ciclo','$Dia', NOW(),'---','12','$IdCiclo','SI','$Inicio','$Final','1')");
      $IdGrupo = $db->insert_id;
      $insertar = $db->query("INSERT INTO tblp_grupo_detalle (IdGrupo, CveGrupo, IdOferta, IdCampus) VALUES ('$IdGrupo','$_cve','$IdOferta','$IdCampus')");
      $insertar = $db->query("INSERT INTO tblc_ciclogrupo (IdCiclo, IdGrupo, FecCap, Grado) VALUES ('$IdCiclo','$IdGrupo',NOW(),'1')");
      $insertar = $db->query("INSERT INTO tblp_evaluacion (IdCiclo, IdGrupo, Valor) VALUES ('$IdCiclo','$IdGrupo','1')");

      $db->close();

      echo $insertar;
    }
}

?>
