<?php session_start();
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["employee_id"];
  $IdCampus = $_POST["IdCampus"];
  $IdCiclo = $_POST["IdCiclo"];

  $sqlH = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sqlC = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sqlC);
  $datos71 = $db->recorrer($sqlC);

  $sqlv = $db->query("SELECT Count(tblx_respuesta.IdRespuesta) AS Total FROM tblx_respuesta WHERE tblx_respuesta.IdDocente = '$IdUsua' AND tblx_respuesta.IdCiclo = '$IdCiclo' AND tblx_respuesta.IdCampus = '$IdCampus'");
  $db->rows($sqlv);
  $datos51 = $db->recorrer($sqlv);
  $tot =  $datos51["Total"];
  if($tot){ $valor = (100/$tot); }

  $sqlz = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sqlz);
  $datosc1 = $db->recorrer($sqlz);
  $nombreX =  $datosc1["APaterno"].' '.$datosc1["AMaterno"].' '.$datosc1["Nombre"];
$sql = $db->query("SELECT tblx_respuesta.IdPregunta, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdDocente =  '$IdUsua' AND tblx_respuesta.IdCiclo =  '$IdCiclo' AND tblx_respuesta.IdCampus =  '$IdCampus' AND tblx_respuesta.IdEstatus =  '26' GROUP BY tblx_respuesta.IdPregunta");
  ?>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    <div class="table-responsive">
          <div class="box-body">
          <div class="col-md-12">

            <table class="table table-striped">
                  <tbody>
                    <?php
                    //$sql = $db->query("SELECT Sum(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdDocente =  '$IdUsua' AND tblx_respuesta.IdCiclo =  '$IdCiclo' AND tblx_respuesta.IdCampus =  '$IdCampus' GROUP BY tblx_respuesta.IdPregunta"); ?>
                      <tr style="background: #ddd; padding: 10px;">
                        <td colspan="4" style="padding: 10px;">
                          <b>CAMPUS:</b> <?php echo $datos71["Campus"]; ?><br>
                          <b>CICLO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?><br>
                          <b>PROFESOR:</b> <?php echo $nombreX; ?>
                        </td>
                        <td colspan="2" style="padding: 10px;">
                          <b>Fecha de impresión:</b><br> <?php echo date("Y-m-d H-m-s"); ?>
                        </td>
                      </tr>
                      <tr style="background: #acacac;">
                        <td colspan="5" style="padding: 10px;"><b>PREGUNTA</b></td>
                        <td style="padding: 10px; text-align: center;"><b>RESULTADO</b></td>
                      </tr>

                    <?php $cx = 0; $rS = 0; $sProm = 0; while($x = $db->recorrer($sql)){ $IdPrg = $x["IdPregunta"];
                      $sumR10 = 0;
                      $sumR9 = 0;
                      $sumR8 = 0;
                      $sumR7 = 0;
                      $sumR6 = 0;
                      $sumNum = 0;
                      $suma = 0;

                      $sqlRes = $db->query("SELECT Count(tblx_respuesta.Respuesta) AS Suma, tblx_respuesta.Respuesta FROM tblx_respuesta WHERE tblx_respuesta.IdDocente =  '$IdUsua' AND tblx_respuesta.IdCiclo =  '$IdCiclo' AND tblx_respuesta.IdCampus =  '$IdCampus' AND tblx_respuesta.IdEstatus =  '26' AND tblx_respuesta.IdPregunta =  '$IdPrg' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.Respuesta DESC");
 while($y = $db->recorrer($sqlRes)){
   if($y["Respuesta"] == 10){ $sumR10 = ($y["Suma"] * 10); }
   if($y["Respuesta"] == 9){ $sumR9 = ($y["Suma"] * 9); }
   if($y["Respuesta"] == 8){ $sumR8 = ($y["Suma"] * 8); }
   if($y["Respuesta"] == 7){ $sumR7 = ($y["Suma"] * 7); }
   if($y["Respuesta"] == 6){ $sumR6 = ($y["Suma"] * 6); }
   $sumNum = $sumNum + $y["Suma"];
 }

  $suma = ($sumR10 + $sumR9 + $sumR8 + $sumR7 + $sumR6);
 if($suma){
    $prom = ($suma/$sumNum);
 }





                      ?>
                  <tr>
                    <td colspan="5" style="padding: 10px;"><?php echo $cx = $cx + 1; echo '.- '.$x["Pregunta"]; ?></td>
                    <td style="padding: 10px;  text-align: center;"><?php echo round($prom,2); ?></td>
                  </tr>
                <?php $rS = $rS +  1;  $sProm = $sProm + $prom; }  ?>

                <tr style="background: gray; color: black;">
                  <td colspan="5" style="text-align: right; padding: 14px;">
                    <b>PROMEDIO GENERAL:</b></td>
                  <td style="padding: 10px; font-size: 14px; text-align: center;"><b><?php if($sProm){  $pmr = ($sProm/$rS);  echo $ptommm = round($pmr,2); } ?></b></td>
                </tr>
                <?php if($pmr){ ?>
                <tr>
                  <td colspan="6" style="text-align: center;">
                    <button onclick="javascript:window.open('formConsulta/expPreguntas.php?IdCampus=<?php echo $IdCampus; ?>&IdCiclo=<?php echo $IdCiclo ?>&IdUsua=<?php echo $IdUsua; ?>');" href="javascript:void(0);" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-gg-circle"></i> Exportar Excel</button>
                  </td>
                </tr><?php } ?>

                </tbody></table>
              </div>
          </div>
    </div>
  </form>
  <?php
  $sqlD = $db->query("SELECT tblp_evaluaciondocente.IdEvaluacion FROM tblp_evaluaciondocente WHERE tblp_evaluaciondocente.IdCiclo = '$IdCiclo' AND tblp_evaluaciondocente.IdUsua = '$IdUsua' AND tblp_evaluaciondocente.IdCampus = '$IdCampus'");
  $db->rows($sqlD);
  $datos41 = $db->recorrer($sqlD);
  if(!$datos41["IdEvaluacion"]){
    $insertar = $db->query("INSERT INTO tblp_evaluaciondocente (IdUsua, IdCiclo, FecCap, IdCampus)VALUES ('$IdUsua','$IdCiclo',NOW(),'$IdCampus')");
    $IdEvaDoc = $db->insert_id;
  } else {
    $IdEvaDoc = $datos41["IdEvaluacion"];
  }

  $insertar = $db->query("UPDATE tblp_evaluaciondocente SET tblp_evaluaciondocente.Promedio = '$ptommm' WHERE tblp_evaluaciondocente.IdEvaluacion = '$IdEvaDoc'");
}
?>
