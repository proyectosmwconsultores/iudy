<?php
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=BalanzaGeneral-$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $balanza=$t->get_balanzaGral($_GET["IdO"],$_GET["F1"],$_GET["F2"]);
  if($_GET["IdO"] == "TODAS"){
    $txtCond = "Todas las ofertas educativas";
  } else {
    $oferta=$t->get_ofertaId($_GET["IdO"]);
    $txtCond = $oferta[0]["Tipo"].' en '.$oferta[0]["Nombre"];
  }

?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" width: 500px; color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="6"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="6"><b>Balanza General</b></td></tr>
      <tr><td style="text-align: center;" colspan="6"><b>Oferta Educativa: <?php echo $txtCond; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="6"><b>con rango de fecha del <?php echo $_GET["F1"]; ?> al <?php echo $_GET["F2"]; ?> </b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>Oferta educativa</th>
        <th>Tipo concepto</th>
        <th>Cve. Grupo</th>
        <th>Nombre</th>
        <th>Fecha ingreso</th>
        <th>Total</th>
      </tr>
      <?php for ($i=0;$i< sizeof($balanza);$i++) { $total = $balanza[$i]["TotalPagado"] + $total; ?>
      <tr>
        <td style="text-align: left;"><?php echo $balanza[$i]["nomEducativa"]; ?></td>
        <td style="text-align: left;"><?php echo $balanza[$i]["NomConcepto"]; ?></td>
        <td style="text-align: left;"><?php echo $balanza[$i]["CveGrupo"].' '.$balanza[$i]["Grupo"]; ?></td>
        <td style="text-align: left;"><?php echo $balanza[$i]["Nombre"].' '.$balanza[$i]["APaterno"].' '.$balanza[$i]["AMaterno"]; ?></td>
        <td style="text-align: left;"><?php echo $balanza[$i]["FecPago"]; ?></td>
        <td style="text-align: right;">$ <?php echo number_format($balanza[$i]["TotalPagado"], 2, '.', ','); ?></td>
      </tr><?php } ?>
      <tr style=" background: #D0D0D0;">
        <th colspan="5" style="text-align: right;">Totales:</th>
        <th style="text-align: right;">$ <?php echo number_format($total, 2, '.', ','); ?></th>
      </tr>
    </table>
  </body>
</html>
