<?php
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=DatosFacturar-$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $IdUsua = $_GET['IdUsua'];
  $configuracion=$t->get_configuracion();
  $dFacturar=$t->get_datosFacturar($IdUsua);
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="6"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="6"><b>Información para Facturar</b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th colspan="6">RFC</th>
      </tr>
      <tr>
        <td colspan="6" style="text-align: center;"><?php echo $dFacturar[0]["RFC"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="6">Razón Social: Nombre de la empresa o persona</th>
      </tr>
      <tr>
        <td colspan="6" style="text-align: center;"><?php echo $dFacturar[0]["Razon"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="6">Domicilio:</th>
      </tr>
      <tr>
        <td colspan="6" style="text-align: center;"><?php echo $dFacturar[0]["Domicilio"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="2">No. Exterior:</th>
        <th colspan="2">No. Interior:</th>
        <th colspan="2">Código Postal:</th>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;"><?php echo $dFacturar[0]["NoExterior"]; ?></td>
        <td colspan="2" style="text-align: center;"><?php echo $dFacturar[0]["NoInterior"]; ?></td>
        <td colspan="2" style="text-align: center;"><?php echo $dFacturar[0]["CP"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="3">Colonia:</th>
        <th colspan="3">Municipio:</th>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["Colonia"]; ?></td>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["Municipio"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="3">Ciudad:</th>
        <th colspan="3">Estado:</th>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["Ciudad"]; ?></td>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["Estado"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="3">Correo:</th>
        <th colspan="3">CURP:</th>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["Correo"]; ?></td>
        <td colspan="3" style="text-align: center;"><?php echo $dFacturar[0]["CURP"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="6">Uso CFDI:</th>
      </tr>
      <tr>
        <td colspan="1" style="text-align: center;"><?php echo $dFacturar[0]["Clave"]; ?></td>
        <td colspan="5" style="text-align: center;"><?php echo $dFacturar[0]["Descripcion"]; ?></td>
      </tr>
      <tr style=" background: #D0D0D0;">
        <th colspan="6" style="text-align: right;">Fecha de actualización:</th>
      </tr>
      <tr>
        <td colspan="6" style="text-align: right;"><?php echo $dFacturar[0]["FecCap"]; ?></td>
      </tr>
    </table>
  </body>
</html>
