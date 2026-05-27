<?php
date_default_timezone_set('America/Mexico_City');
  $Fecha=date("Y-m-d");
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Analitica-$Fecha.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");
  // include("../php/estructura/session.php");
  // include("../php/estructura/validationlogin.php");
  // require('../php/clases/class.php');
  // $t=new Trabajo();
  //
  //    $IdOferta = $_GET["IdO"];
  //    $IdEstatus = $_GET["IdE"];
  //   $configuracion=$t->get_configuracion();
  //   $lstAnalitica=$t->get_expAnalitica($IdOferta, $IdEstatus);

  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdOferta = $_GET["IdO"];
  $IdEstatus = $_GET["IdE"];
  if($IdEstatus == 1){
    $cond = " tblp_pagos.IdEstatus = '1' AND tblp_pagos.Recargos IS NULL ";
    $titl = "pagos por realizarse en tiempo o por ser Inscripciones";
  } elseif ($IdEstatus == 2) {
    $cond = " tblp_pagos.IdEstatus = '2'";
    $titl = "pagos enviados a Control Escolar";
  } elseif ($IdEstatus == 3) {
    $cond = " tblp_pagos.IdEstatus = '3'";
    $titl = "pagos en proceso de revisión por Control Escolar";
  } elseif ($IdEstatus == 4) {
    $cond = " tblp_pagos.IdEstatus = '1' AND tblp_pagos.Recargos IS NOT NULL ";
    $titl = "pagos con recargos";
  }
  $sql = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdDescuento, tblp_pagos.Pagar, tblp_pagos.Recargos, tblp_pagos.IdEstatus, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblp_pagos.FecLimPago, tblc_usuario.Foto,tblc_conceptos.NomConcepto FROM tblp_pagos Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_pagos.IdUsua Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto WHERE tblp_pagos.IdOferta =  '$IdOferta' AND $cond ");


   //$sql = $db->query("");


?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
    <style type="text/css"> .uno{ text-align: center; } </style>
  </head>
  <body>
    <table style=" color: #0073b7; font-size: 16px; font-family: Arial Narrow, Century Gothic,sans-serif;">
      <tr><td style="text-align: center;" colspan="5"><b>Plataforma de Educación en Línea</b></td></tr>
      <tr><td style="text-align: center;" colspan="5"><b>Reporte de <?php echo $titl; ?>  </b></td></tr>


    </table>
    <br>
    <table border="1" style=" color: black; font-size: 12px; font-family: Arial Narrow,Century Gothic,sans-serif;">
      <tr style=" background: #709ffe;">
        <th>#</th>
        <th>Nombre</th>
        <th>Concepto</th>
        <th>Fec. Limite</th>
        <th>Total</th>
      </tr>
      <?php while($x = $db->recorrer($sql)){ $IdDescuentox =  $x["IdDescuento"];
        if($IdDescuentox){
          $sql9 = $db->query("SELECT tblp_descuento.IdDescuento, tblp_descuento.Porcentaje, tblp_descuento.Descuento, tblp_descuento.FecDescuento, tblc_tipodescuento.NomDescuento FROM tblp_descuento Left Join tblc_tipodescuento ON tblc_tipodescuento.IdTipoDescuento = tblp_descuento.IdTipoDescuento WHERE tblp_descuento.IdDescuento = '$IdDescuentox' AND tblp_descuento.Estatus = '8'");
          $db->rows($sql9);
          $datos91 = $db->recorrer($sql9);
          $des = $datos91["Descuento"];

        } else {
          $des = 0;
        }

        $total =  $x["Pagar"] + $x["Recargos"];
        $sumTotal = $sumTotal + $total - $des;
        ?>
      <tr>
        <td style="text-align: center;"><?php echo $i+1; ?></td>
        <td style="text-align: center;"><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?></td>
        <td style="text-align: center;"><?php echo $x["NomConcepto"]; ?></td>
        <td style="text-align: center;"><?php echo $x["FecLimPago"]; ?></td>
        <td style="text-align: center;">$ <?php echo number_format($total, 2, '.', ','); ?></td>

      </tr><?php $f = $f  + $total; } ?>
      <tr style=" background: #9FAFB9;">
        <th colspan="4">Total:</th>
        <th>$ <?php echo number_format($f, 2, '.', ','); ?></th>
      </tr>

    </table>
    <br><br>

  </body>
</html>
