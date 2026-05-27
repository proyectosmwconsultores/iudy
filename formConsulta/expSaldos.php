<?php
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=SaldoAlumnos-$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  include("../php/estructura/session.php");
  include("../php/estructura/validationlogin.php");
  require('../php/clases/class.php');
  $t=new Trabajo();
  $configuracion=$t->get_configuracion();
  $pagoId=$t->get_verificarPagosId($_GET["IdUsua"]);
  $alumno=$t->get_datAlumno($_GET["IdUsua"]);
?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" width: 500px; color: #0073b7; font-size: 16px; font-family: Arial, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="7"><b><?php echo $configuracion[0]["Descripcion"]; ?></b></td></tr>
      <tr><td style="text-align: center;" colspan="7"><b>Reporte de saldo por alumno</b></td></tr>
      <tr><td style="text-align: center;" colspan="7"><b style="color: red;"><?php echo $alumno[0]["Nombre"].' '.$alumno[0]["APaterno"].' '.$alumno[0]["AMaterno"]; ?></b></td></tr>
    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial,Century Gothic,sans-serif;">
      <tr style=" background: #D0D0D0;">
        <th>Concepto</th>
        <th>Cuenta</th>
        <th>Fecha de pago</th>
        <th>Estatus</th>
        <th>Monto</th>
        <th>Recargo</th>
        <th>Total pagado</th>
      </tr>
      <?php for ($i=0;$i< sizeof($pagoId);$i++) {
        if($pagoId[$i]["DetEstatus"] != 7){
            $descuento=$t->get_descuento($pagoId[$i]["IdDescuento"]);
            $total = $total + $pagoId[$i]["TotalPagado"];
          ?>
          <tr>
            <td><?php echo $pagoId[$i]["NomConcepto"]; ?></td>
            <td><?php echo $pagoId[$i]["Banco"]; ?></td>
            <td><?php echo $pagoId[$i]["FecPago"]; ?></td>
            <td><b><?php echo $pagoId[$i]["Estatus"]; ?></b></td>
            <td>$ <?php echo number_format($pagoId[$i]["Pagar"], 2, '.', ','); ?></td>
            <td>$ <?php echo number_format($pagoId[$i]["Recargos"], 2, '.', ','); ?>
              <?php if($descuento[0]["IdDescuento"]){ ?>
            <br>(<?php echo $descuento[0]["Porcentaje"]; ?>% en <br> <?php echo $descuento[0]["NomDescuento"]; ?>)
            <br><b>(- $ <?php echo $descuento[0]["Descuento"]; ?>)</b><?php } ?>
            </td>
            <td><b>$ <?php echo number_format($pagoId[$i]["TotalPagado"], 2, '.', ','); ?></b></td>
            </td>
          </tr><?php } } ?>
      <tr style=" background: #D0D0D0;">
        <th colspan="6" style="text-align: right;">Totales:</th>
        <th style="text-align: right;">$ <?php echo number_format($total, 2, '.', ','); ?></th>
      </tr>
    </table>
  </body>
</html>
