<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdCampus = substr($_GET["idCa"], 10,10);
  $IdCiclo = substr($_GET["idCi"],10,10);

  $sqlH = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
  $db->rows($sqlH);
  $datos81 = $db->recorrer($sqlH);

  $sqlC = $db->query("SELECT tblc_campus.Campus FROM tblc_campus WHERE tblc_campus.IdCampus = '$IdCampus'");
  $db->rows($sqlC);
  $datos71 = $db->recorrer($sqlC);

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
                          <b>RESULTADO DE LA ENCUESTA DE SATISFACCIÓN ACADÉMICA</b>
                      </td>
                    </tr>
                    <?php $sql = $db->query("SELECT tblx_pregunta.IdPregunta, tblx_pregunta.Pregunta FROM tblx_pregunta WHERE tblx_pregunta.Tipo =  '3'"); ?>
                      <tr style="background: gray; padding: 10px;">
                        <td colspan="4" style="padding: 10px;">
                          <b>CAMPUS:</b> <?php echo $datos71["Campus"]; ?><br>
                          <b>CICLO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?>
                        </td>
                        <td colspan="2" style="padding: 10px;">
                          Fecha de impresión:<br> <?php echo date("Y-m-d H-m-s"); ?>
                        </td>
                      </tr>

                    <?php while($x = $db->recorrer($sql)){ $sum10 = 0; $sum9 = 0; $sum8 = 0; $sum7 = 0;
                      $preg = $x["IdPregunta"]; $snx = $snx + 1;
// echo"SELECT tblx_encuesta.IdPregunta, Sum(tblx_encuesta.Respuesta) AS Suma, tblx_encuesta.Respuesta FROM tblx_encuesta WHERE tblx_encuesta.IdCampus =  '$IdCampus' AND tblx_encuesta.IdEstatus =  '26' AND tblx_encuesta.IdCiclo =  '$IdCiclo' AND tblx_encuesta.IdPregunta =  '$preg' GROUP BY tblx_encuesta.Respuesta ORDER BY tblx_encuesta.Respuesta DESC";

                      $sql2 = $db->query("SELECT tblx_encuesta.IdPregunta, Count(tblx_encuesta.Respuesta) AS Suma, tblx_encuesta.Respuesta FROM tblx_encuesta WHERE tblx_encuesta.IdCampus =  '$IdCampus' AND tblx_encuesta.IdEstatus =  '26' AND tblx_encuesta.IdCiclo =  '$IdCiclo' AND tblx_encuesta.IdPregunta =  '$preg' GROUP BY tblx_encuesta.Respuesta ORDER BY tblx_encuesta.Respuesta DESC");
                      ?>
                  <tr>
                    <td colspan="6" style="padding: 10px;"><b><?php echo $cx = $cx + 1; echo '.- '.$x["Pregunta"]; ?></b></td>
                  </tr>
                  <tr>
                    <?php $pts = 0; $sumP = 0; while($x2 = $db->recorrer($sql2)){
                      if($x2["Respuesta"] == 10) { $sum10 = $x2["Suma"];  $res10 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 8) { $sum9 = $x2["Suma"];  $res9 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 7) { $sum8 = $x2["Suma"];  $res8 = $x2["Respuesta"]; }
                      if($x2["Respuesta"] == 5) { $sum7 = $x2["Suma"];  $res7 = $x2["Respuesta"]; }
                      $pts = ($pts + $x2["Suma"]);

                    }
                      ?>
                      <td>Muy Satisfecho<br><?php echo $sum10; ?> (<?php echo $x1 = ($sum10 * $res10); ?> pts.)</td>
                      <td>Satisfecho<br><?php echo $sum9; ?> (<?php echo $x2 = ($sum9 * $res9); ?> pts.)</td>
                      <td>Poco Satisfecho<br><?php echo $sum8; ?> (<?php echo $x3 = ($sum8 * $res8); ?> pts.)</td>
                      <td>Insatisfecho<br><?php echo $sum7; ?> (<?php echo $x4 = ($sum7 * $res7); ?> pts.)</td>
                    <?php
                     $sumPx = ($sum10 + $sum9 + $sum8 + $sum7);
                     $tot = ($x1 + $x2 + $x3 + $x4);
                     ?>
                    <td style="text-align: center;"><b>Promedio: </b><br><b><?php if($pts){ $c = ($tot/$sumPx);  echo round($c,2);  $prom = ($prom + $c); } ?></b></td>
                  </tr>
                <?php $x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0; }  ?>

                <tr style="background: gray; color: black;">
                  <td colspan="4" style="text-align: right; padding: 14px;"><b>PROMEDIO GENERAL DEL CAMPUS:</b></td>
                  <td style="padding: 10px; font-size: 14px;"><b><?php if($prom){ $pmr = ($prom/$snx);  echo round($pmr,2);} ?></b></td>
                </tr>

                </tbody></table>
              </div>
          </div>
    </div>
  </form>
