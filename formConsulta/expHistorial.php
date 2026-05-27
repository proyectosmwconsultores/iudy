<?php
//date_default_timezone_set('America/Mexico_City');
  $Fecha=date("Y-m-d");
  $IdUsua = $_GET['IdUsua'];
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Historial-$IdUsua.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();

  $configuracion=$t->get_configuracion();
  $F1 = $_GET['F1'];
  $F2 = $_GET['F2'];
  $dFacturar=$t->get_datosFacturar($IdUsua);
  $lstIngresos=$t->get_lstIngresos($F1,$F2,$IdUsua);
  $datosUser = $t->get_datoDocente($IdUsua);
  $lstContador=$t->get_lstContador($F1,$F2,$IdUsua);
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="4"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="4"><b>Información del Historial en la Plataforma</b></td></tr>
      <tr><td style="text-align: center;" colspan="4"><b><?php echo $datosUser[0]["Nombre"].' '.$datosUser[0]["APaterno"].' '.$datosUser[0]["AMaterno"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="4">Con fecha del <?php echo $F1; ?> al <?php echo $F2; ?></td></tr>
      <tr><td style="text-align: right;" colspan="4"><b>Total Ingreso: <?php echo $_GET["Ing"]; ?> </b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #709ffe;">
        <th>#</th>
        <th>Fec. Captura</th>
        <th colspan="2">Movimiento</th>
      </tr>
      <?php for ($i=0;$i< sizeof($lstIngresos);$i++) { ?>
      <tr>
        <td style="text-align: center;"><?php echo $i+1; ?></td>
        <td style="text-align: center;"><?php echo $lstIngresos[$i]["FecCap"]; ?></td>
        <td colspan="2" style="text-align: left;"><?php echo $lstIngresos[$i]["Pagina"]; ?></td>
      </tr><?php } ?>

    </table>
    <br><br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #709ffe;">
        <th>#</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Duración Aproximada</th>
      </tr>
      <tbody>
        <?php for ($i=0;$i< sizeof($lstContador);$i++) {  $total = $total  +  $ingresos[$i]["Porcentaje"]; ?>
        <tr style=" cursor: pointer;">
          <td><?php echo $i+1; ?></td>
          <td><?php echo $lstContador[$i]["FecIng"]; ?></td>
          <td><?php echo $lstContador[$i]["FecSal"]; ?></td>
          <td><?php echo $lstContador[$i]["Duracion"]; ?></td>
        </tr>
        <?php } ?>
      </tbody>

    </table>
  </body>
</html>
