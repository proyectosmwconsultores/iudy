<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdUsua = substr($_GET["idToks"], 10,10);
  $IdCampus = substr($_GET["idCa"], 10,10);
  $IdCiclo = substr($_GET["idCi"],10,10);

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
  $valor = (100/$tot);

  $sqlz = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sqlz);
  $datosc1 = $db->recorrer($sqlz);
  $nombreX =  $datosc1["APaterno"].' '.$datosc1["AMaterno"].' '.$datosc1["Nombre"];

?>

   <style>
   table {
       font-family: arial, sans-serif;
       border-collapse: collapse;
       width: 100%;
   		font-size: 12px;
   }

   td, th {
       border: 1px solid #dddddd;
       padding: 3px;
   }
   tr:nth-child(even) {
       background-color: #dddddd;
   }


   </style>
   <title>Vista de respuestas</title>
  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
    <div class="table-responsive">
          <div class="box-body">
          <div class="col-md-12">

            <table class="table table-striped">
                  <tbody>
                    <tr style="background: gray; padding: 15px; text-align: center; font-size: 15px; ">
                      <td colspan="6" style="padding: 5px;">
                          <b>RESULTADO DE LA CALIFICACIÓN OBTENIDA POR PREGUNTA</b>
                      </td>
                    </tr>
                    <?php

                    $sql = $db->query("SELECT Sum(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_respuesta.IdDocente =  '$IdUsua' AND tblx_respuesta.IdCiclo =  '$IdCiclo' AND tblx_respuesta.IdCampus =  '$IdCampus' GROUP BY tblx_respuesta.IdPregunta"); ?>
                      <tr style="background: gray; padding: 10px;">
                        <td colspan="4" style="padding: 10px;">
                          <b>CAMPUS:</b> <?php echo $datos71["Campus"]; ?><br>
                          <b>CICLO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?><br>
                          <b>PROFESOR:</b> <?php echo $nombreX; ?>
                        </td>
                        <td colspan="2" style="padding: 10px;">
                          Fecha de impresión:<br> <?php echo date("Y-m-d H-m-s"); ?>
                        </td>
                      </tr>
                      <tr style="background: #8dadce;">
                        <td colspan="5" style="padding: 10px;"><b>PREGUNTA</b></td>
                        <td style="padding: 10px; text-align: center;"><b>RESULTADO</b></td>
                      </tr>

                    <?php while($x = $db->recorrer($sql)){

                      $snx = $snx + 1;

                      ?>
                  <tr>
                    <td colspan="5" style="padding: 10px;"><b><?php echo $cx = $cx + 1; echo '.- '.$x["Pregunta"]; ?></b></td>
                    <td style="padding: 10px;  text-align: center;"><b><?php  $xy = (($x["Suma"] * $valor) / 10); echo round($xy,2); ?></b></td>
                  </tr>
                <?php $rSum = $rSum +  $xy; }  ?>

                <tr style="background: gray; color: black;">
                  <td colspan="5" style="text-align: right; padding: 14px;"><b>PROMEDIO GENERAL:</b></td>
                  <td style="padding: 10px; font-size: 14px; text-align: center;"><b><?php if($snx){ $pmr = ($rSum/$snx);  echo round($pmr,2);} ?></b></td>
                </tr>

                </tbody></table>
              </div>
          </div>
    </div>
  </form>
