<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCampus = substr($_GET["idCa"], 10,10);
  $IdCiclo = substr($_GET["idCi"],10,10);
  $IdTipo = substr($_GET["idTi"],10,10);

  $sqlH = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sqlC = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sqlC);
  $datos71 = $db->recorrer($sqlC);

  $sqlF = $db->query("SELECT tblc_tipoevaluacion.Evaluacion FROM tblc_tipoevaluacion WHERE tblc_tipoevaluacion.IdTipoEvaluacion = '$IdTipo'");
  $db->rows($sqlF);
  $datos61 = $db->recorrer($sqlF);

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
                          <b>Resultados de la <?php echo $datos61["Evaluacion"]; ?></b>
                      </td>
                    </tr>
                    <?php

                    $sql = $db->query("SELECT tblx_pregunta.IdPregunta, tblx_pregunta.Pregunta FROM tblx_pregunta WHERE tblx_pregunta.Tipo =  '$IdTipo' AND tblx_pregunta._Tipo =  '1' "); ?>
                      <tr style="background: gray; padding: 10px;">
                        <td colspan="4" style="padding: 10px;">
                          <b>CAMPUS:</b> <?php echo $datos71["Campus"]; ?><br>
                          <b>CICLO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?>
                        </td>
                        <td colspan="2" style="padding: 10px;">
                          Fecha de impresión:<br> <?php echo date("Y-m-d H-m-s"); ?>
                        </td>
                      </tr>

                    <?php $snx = 0; $cx =0; $prom = 0; while($x = $db->recorrer($sql)){  $sum6 = 0; $sum7 = 0; $sum8 = 0; $sum9 = 0; $sum10 = 0;
                      $preg = $x["IdPregunta"]; $snx = $snx + 1;

                      $sql2 = $db->query("SELECT tblx_respuesta.IdRespuesta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblxx_respuesta ON tblxx_respuesta.IdPregunta = tblx_respuesta.IdPregunta AND tblxx_respuesta.Valor = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdCampus =  '$IdCampus' AND tblx_respuesta.IdEstatus =  '26' AND tblx_respuesta.IdCiclo =  '$IdCiclo' AND tblx_respuesta.IdPregunta =  '$preg' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.Respuesta DESC");

                      ?>
                  <tr>
                    <td colspan="6" style="padding: 10px;"><b><?php echo $cx = $cx + 1; echo '.- '.$x["Pregunta"]; ?></b></td>
                  </tr>
                  <tr>
                    <?php $pts = 0; $sumP = 0; $txt10 = ''; $txt9 = ''; $txt8 = ''; $txt7 = ''; $txt6 = '';
                    $res10 = 0; $res9 = 0; $res8 = 0; $res7 = 0; $res6 = 0;
                    while($x2 = $db->recorrer($sql2)){
                      if($x2["Respuesta"] == 10) { $sum10 = $x2["Suma"];  $res10 = $x2["Respuesta"]; $txt10 = $x2["Texto"]; }
                      if($x2["Respuesta"] == 9) { $sum9 = $x2["Suma"];  $res9 = $x2["Respuesta"]; $txt9 = $x2["Texto"]; }
                      if($x2["Respuesta"] == 8) { $sum8 = $x2["Suma"];  $res8 = $x2["Respuesta"]; $txt8 = $x2["Texto"]; }
                      if($x2["Respuesta"] == 7) { $sum7 = $x2["Suma"];  $res7 = $x2["Respuesta"]; $txt7 = $x2["Texto"]; }
                      if($x2["Respuesta"] == 6) { $sum6 = $x2["Suma"];  $res6 = $x2["Respuesta"]; $txt6 = $x2["Texto"]; }
                       $pts = ($pts + $x2["Suma"]);

                    }
                      ?>
                      <td><?php if($txt10){ echo $txt10; } else { echo "---"; } ?><br><?php echo $sum10; ?> (<?php echo $x1 = ($sum10 * $res10); ?> pts.)</td>
                      <td><?php if($txt9){ echo $txt9; } else { echo "---"; } ?><br><?php echo $sum9; ?> (<?php echo $x2 = ($sum9 * $res9); ?> pts.)</td>
                      <td><?php if($txt8){ echo $txt8; } else { echo "---"; } ?><br><?php echo $sum8; ?> (<?php echo $x3 = ($sum8 * $res8); ?> pts.)</td>
                      <td><?php if($txt7){ echo $txt7; } else { echo "---"; } ?><br><?php echo $sum7; ?> (<?php echo $x4 = ($sum7 * $res7); ?> pts.)</td>
                      <td><?php if($txt6){ echo $txt6; } else { echo "---"; } ?><br><?php echo $sum6; ?> (<?php echo $x5 = ($sum6 * $res6); ?> pts.)</td>


                    <?php
                     $sumPx = ($sum10 + $sum9 + $sum8 + $sum7 + $sum6);
                     $tot = ($x1 + $x2 + $x3 + $x4 + $x5);
                     ?>
                    <td style="text-align: center;"><b>Promedio: </b><br><b><?php if($pts){ $c = ($tot/$sumPx);  echo round($c,2);  $prom = ($prom + $c); } ?></b></td>
                  </tr>
                <?php $x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0; $x5 = 0; }  ?>

                <tr style="background: gray; color: black;">
                  <td colspan="5" style="text-align: right; padding: 14px;"><b>PROMEDIO GENERAL DEL CAMPUS:</b></td>
                  <td style="padding: 10px; font-size: 14px;"><b><?php if($prom){ $pmr = ($prom/$snx);  echo round($pmr,2);} ?></b></td>
                </tr>

                </tbody></table>
              </div>
          </div>
    </div>
  </form>
