<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Reporte_de_evaluacion_docente.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");

  require('../php/clases/class.System.php');
    require('../hace.php');
    $db = new Conexion();
    $IdDocente = $_GET["IdUsua"];
    $IdCiclo = $_GET["IdCiclo"];
    $prom = 0;
    $vbvc = 0;
    $sTods = 0;
      $sqlX = $db->query("SELECT
    tblx_respuesta.IdRespuesta,
    tblx_respuesta.IdPregunta,
    tblx_respuesta.IdDocente,
    tblx_respuesta.IdGrupo,
    tblx_respuesta.IdOferta,
    tblx_respuesta.IdCampus,
    tblx_respuesta.IdAsignacion,
    tblx_respuesta.IdEstatus,
    tblx_respuesta.IdModulo,
    tblx_respuesta.IdCiclo,
    tblp_grupo.CveGrupo,
    tblp_modulo.CodeModulo,
    tblp_modulo.NombreMod,
    tblp_educativa.Nombre AS Educativa
    FROM
    tblx_respuesta
    Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblx_respuesta.IdGrupo
    Left Join tblp_modulo ON tblp_modulo.IdModulo = tblx_respuesta.IdModulo
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblx_respuesta.IdOferta
    WHERE tblx_respuesta.IdDocente =  '$IdDocente' AND tblx_respuesta.IdCiclo =  '$IdCiclo' GROUP BY tblx_respuesta.IdAsignacion ");


    $sqlV = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdDocente'");
    $db->rows($sqlV);
    $datos91 = $db->recorrer($sqlV);

    $sqlH = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
    $db->rows($sqlH);
    $datos81 = $db->recorrer($sqlH);

    $sql_dat = $db->query("SELECT * FROM tblp_configuracion WHERE tblp_configuracion.IdConfig = '2'  ");
    $datos71 = $db->recorrer($sql_dat);
    $uni = $datos71["Descripcion"];
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; ">
      <tr><td style="text-align: center;" colspan="6"><b><?php echo $uni; ?></b></td></tr>
    </table>
    <br>
    <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr style=" padding: 15px; text-align: center; font-size: 15px; ">
              <td colspan="6">
                <b>RESULTADO DE LA EVALUACIÓN DOCENTE</b>
              </td>
            </tr>
            <tr style="background: #5a284f; color: #fbeb00; padding: 10px;">
              <td colspan="5">
                <b>ASESOR:</b> <?php echo $datos91["APaterno"].' '.$datos91["AMaterno"].' '.$datos91["Nombre"]; ?><br>
                <b>CICLO ESCOLAR:</b> <?php echo $datos81["Ciclo"]; ?><br>
              </td>
              <td>
                Fecha de impresión:<br> <?php echo date("Y-m-d H-m-s"); ?>
              </td>
            </tr>

            <?php while($x = $db->recorrer($sqlX)){
              $IdModulo = $x["IdModulo"];
              $IdGrupo = $x["IdGrupo"];
              $prom = 0;

              $sql = $db->query("SELECT tblx_respuesta.IdPregunta, Sum(tblx_respuesta.Respuesta) AS Total, tblx_pregunta.Pregunta FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta WHERE tblx_pregunta._Tipo = '1' AND tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdDocente = '$IdDocente' AND tblx_respuesta.IdGrupo = '$IdGrupo' GROUP BY tblx_respuesta.IdPregunta");
              ?>
            <tr style="background: #003A70; color: white;">
              <td style="padding: 10px;" colspan="6"><b><i class="fa fa-fw fa-book"></i> PLAN DE ESTUDIOS:</b> <?php echo $x["Educativa"]; ?></td>
            </tr>
            <tr style="background: #003A70; color: white;">
              <td style="padding: 10px;">MATERIA:</td>
              <td style="padding: 10px;" colspan="2"><?php echo $x["CodeModulo"].' '.$x["NombreMod"]; ?></td>
              <td style="padding: 10px;">GRUPO:</td>
              <td style="padding: 10px;" colspan="2"><?php echo $x["CveGrupo"]; ?></td>
            </tr>
            <?php $snx = 0; while($x = $db->recorrer($sql)){
              $preg = $x["IdPregunta"];
              $snx = $snx + 1;
              $sum10 = 0; $sum9 = 0; $sum8 = 0; $sum7 = 0;
              $sql2 = $db->query("SELECT tblx_respuesta.IdPregunta, Count(tblx_respuesta.Respuesta) AS Suma, tblx_pregunta.Pregunta, tblx_respuesta.Respuesta, tblxx_respuesta.Texto FROM tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta Left Join tblxx_respuesta ON tblxx_respuesta.IdResp = tblx_respuesta.Respuesta WHERE tblx_respuesta.IdModulo =  '$IdModulo' AND tblx_respuesta.IdPregunta =  '$preg' AND tblx_respuesta.IdDocente =  '$IdDocente' GROUP BY tblx_respuesta.Respuesta ORDER BY tblx_respuesta.Respuesta DESC");
              ?>
          <tr>
            <td colspan="6"><b><?php echo $x["Pregunta"]; ?></b></td>
          </tr>
          <tr>
            <?php   $res9 = 0; $res8= 0; $res7 = 0; $sum6 = 0; $res6 = 0; $pts = 0; $sumP = 0; while($x2 = $db->recorrer($sql2)){
              if($x2["Respuesta"] == 10) { $sum10 = $x2["Suma"];  $res10 = $x2["Respuesta"]; }
              if($x2["Respuesta"] == 9) { $sum9 = $x2["Suma"];  $res9 = $x2["Respuesta"]; }
              if($x2["Respuesta"] == 8) { $sum8 = $x2["Suma"];  $res8 = $x2["Respuesta"]; }
              if($x2["Respuesta"] == 7) { $sum7 = $x2["Suma"];  $res7 = $x2["Respuesta"]; }
              if($x2["Respuesta"] == 6) { $sum6 = $x2["Suma"];  $res6 = $x2["Respuesta"]; }
              $pts = ($pts + $x2["Suma"]);

            }
              ?>
              <td style="width: 16%;">Excelente <br><?php echo $sum10; ?> (<?php echo $x1 = ($sum10 * $res10); ?> pts.)</td>
              <td style="width: 16%;">Bueno <br><?php echo $sum9; ?> (<?php echo $x2 = ($sum9 * $res9); ?> pts.)</td>
              <td style="width: 16%;">Regular <br><?php echo $sum8; ?> (<?php echo $x3 = ($sum8 * $res8); ?> pts.)</td>
              <td style="width: 16%;">Malo <br><?php echo $sum7; ?> (<?php echo $x4 = ($sum7 * $res7); ?> pts.)</td>
              <td style="width: 16%;">Muy malo <br><?php echo $sum6; ?> (<?php echo $x5 = ($sum6 * $res6); ?> pts.)</td>


            <?php

             $sumPx = ($sum10 + $sum9 + $sum8 + $sum7 + $sum6);
             $tot = ($x1 + $x2 + $x3 + $x4 + $x5);
             ?>
            <td style="text-align: center;"><b>Promedio: </b><br><b><?php if($pts){ $c = ($tot/$sumPx);  echo round($c,2);  $prom = ($prom + $c); } ?></b></td>
          </tr>
        <?php $x1 = 0; $x2 = 0; $x3 = 0; $x4 = 0; $x5 = 0; }  ?>

        <tr style="background: #5a284f; color: #fbeb00;">
          <td colspan="5" style="text-align: right; padding: 14px;"><b>PROMEDIO DEL DOCENTE:</b></td>
          <td style="padding: 10px; font-size: 14px; text-align: center;"><b><?php if($prom){ $pmr = ($prom/$snx);  echo round($pmr,2);} ?></b></td>
        </tr>

          <?php $vbvc = ($pmr + $vbvc);  $sTods = ($sTods + 1); } ?>
          <tr style="background: #a6a7c1; color: black;">
            <td colspan="2">
              <button onclick="window.open('formConsulta/exp_encuesta_gral.php?IdUsua=<?php echo $IdDocente; ?>IdCiclo=<?php echo $IdCiclo; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar todo excel</button>
            </td>
            <td colspan="3" style="text-align: right; padding: 18px;"><b>PROMEDIO GENERAL DEL DOCENTE:</b></td>
            <td style="padding: 10px; font-size: 18px; text-align: center;"><b><?php if($vbvc){ $psmrX = ($vbvc/$sTods);  echo round($psmrX,2);} ?></b></td>
          </tr>

        </tbody>
 </table>
  </body>
</html>
