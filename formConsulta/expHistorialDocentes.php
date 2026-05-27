<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=historialDocente.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $historial=$t->get_historialDoc($_GET["Id"]);
  $datos=$t->get_datAlumno($_GET["Id"]);
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="5"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="5"><b>Reporte de historial de asignatura por docente</b></td></tr>
      <tr><td style="text-align: center;" colspan="5"><b>Docente: <?php echo $datos[0]["Nombre"].' '.$datos[0]["APaterno"].' '.$datos[0]["AMaterno"]; ?> </b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tbody>
        <?php $ini = 0; $grado = 1; $valor = 0;
         for ($i=0;$i< sizeof($historial);$i++) {

          if($grado == $historial[$i]["IdEducativa"]){ $ini = 1; } else { $ini = 0; } ?>
          <?php if(($ini == 0) || ($valor == 0)){ ?>
          <tr style="background: #aeaaaa; color: #000; font-size: 12px; ">
            <th colspan="5"><?php echo $historial[$i]["NomEducativa"] ?></th>
          </tr>
          <tr style="background: #e1dede; color: #000; font-size: 12px;">
            <th>Asignatura</th>
            <th>Fecha</th>
            <th>Estatus</th>
            <th>Ciclo</th>
            <th>CveGrupo</th>
          </tr> <?php } ?>
          <tr style="font-size: 12px;">
            <td><?php echo $historial[$i]["NoModulo"].' '.$historial[$i]["NombreMod"]; ?></td>
            <td><?php echo $historial[$i]["FecIni"].' - '.$historial[$i]["FecFin"]; ?></td>
            <td><?php echo $historial[$i]["Estatus"]; ?></td>
            <td><?php echo $historial[$i]["Ciclo"]; ?></td>
            <td><?php echo $historial[$i]["CveGrupo"].' '.$historial[$i]["Grupo"]; ?></td>
          </tr>
      <?php $valor = 1; $grado = $historial[$i]["IdEducativa"]; } ?>
    </tbody></table>


  </body>
</html>
