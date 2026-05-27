<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();


$sql_us = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.idestatus = '1' AND tblh_temporal_conciliar.idestatus = '1' ");
while ($_us = $db->recorrer($sql_us)) {
  $sql_ux = $db->query("SELECT tblc_usuario.IdUsua FROM tblc_usuario WHERE tblc_usuario._alfanumerica = '" . $_us['alfanumerica'] . "'");
  $db->rows($sql_ux);
  $_userx = $db->recorrer($sql_ux);
  if (isset($_userx["IdUsua"])) {
    $_IdUsua = $_userx["IdUsua"];

    $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar._IdUsua = '$_IdUsua', tblh_temporal_conciliar._idestatus = '10' WHERE tblh_temporal_conciliar.IdTemporal = '" . $_us['IdTemporal'] . "' ");
  }
}

$sql_rep = $db->query("SELECT * FROM tblh_temporal_conciliar WHERE tblh_temporal_conciliar.idestatus = '1' ");
while ($_rep = $db->recorrer($sql_rep)) {
  $sql_ux = $db->query("SELECT tblh_temporal_conciliar.IdTemporal FROM tblh_temporal_conciliar  WHERE tblh_temporal_conciliar.Fecha = '" . $_rep['Fecha'] . "' AND tblh_temporal_conciliar.referencia = '" . $_rep['referencia'] . "' AND tblh_temporal_conciliar.alfanumerica = '" . $_rep['alfanumerica'] . "'  AND tblh_temporal_conciliar.autorizacion = '" . $_rep['autorizacion'] . "' AND tblh_temporal_conciliar.IdTemporal <> '" . $_rep['IdTemporal'] . "' AND ((tblh_temporal_conciliar._idestatus = 1) || (tblh_temporal_conciliar._idestatus = 10)) ");
  $db->rows($sql_ux);
  $_userx = $db->recorrer($sql_ux);
  if (isset($_userx["IdTemporal"])) {
    $IdTemporal = $_userx["IdTemporal"];
    $insertar = $db->query("UPDATE tblh_temporal_conciliar SET tblh_temporal_conciliar._idestatus = '28' WHERE tblh_temporal_conciliar.IdTemporal = '" . $_rep['IdTemporal'] . "' ");
  }
}


$sql_lsta = $db->query("SELECT tblh_temporal_conciliar.IdTemporal, tblh_temporal_conciliar.Fecha, tblh_temporal_conciliar.Importe, tblh_temporal_conciliar.sucursal, tblh_temporal_conciliar.referencia,  tblh_temporal_conciliar.alfanumerica, tblh_temporal_conciliar.autorizacion, tblh_temporal_conciliar.idestatus, tblh_temporal_conciliar.ordenante, tblh_temporal_conciliar._idestatus, tblh_temporal_conciliar.idprocedencia, tblh_temporal_conciliar._IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblh_temporal_conciliar Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_temporal_conciliar._IdUsua WHERE tblh_temporal_conciliar.idestatus = '1'");

$sql_proc = $db->query("SELECT tblh_temporal_conciliar.IdTemporal, tblh_temporal_conciliar.Fecha, tblh_temporal_conciliar.Importe, tblh_temporal_conciliar.sucursal, tblh_temporal_conciliar.referencia, tblh_temporal_conciliar.alfanumerica, tblh_temporal_conciliar.autorizacion, tblh_temporal_conciliar.idestatus, tblh_temporal_conciliar.ordenante, tblh_temporal_conciliar._idestatus, tblh_temporal_conciliar.idprocedencia, tblh_temporal_conciliar._IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblh_temporal_conciliar Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_temporal_conciliar._IdUsua WHERE tblh_temporal_conciliar.idestatus = '2' AND tblh_temporal_conciliar._idestatus ='10' ");

$sql_pend = $db->query("SELECT tblh_temporal_conciliar.IdTemporal, tblh_temporal_conciliar.Fecha, tblh_temporal_conciliar.Importe, tblh_temporal_conciliar.sucursal, tblh_temporal_conciliar.referencia, tblh_temporal_conciliar.alfanumerica, tblh_temporal_conciliar.autorizacion, tblh_temporal_conciliar.idestatus, tblh_temporal_conciliar.ordenante, tblh_temporal_conciliar._idestatus, tblh_temporal_conciliar.idprocedencia, tblh_temporal_conciliar._IdUsua, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblh_temporal_conciliar Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_temporal_conciliar._IdUsua WHERE tblh_temporal_conciliar.idestatus = '2' AND tblh_temporal_conciliar._idestatus ='1' ");

$sql_fact = $db->query("SELECT tblp_foliospago.NoFolio, tblp_foliospago.FecCap, tblp_foliospago.FecPago, tblp_foliospago.IdPago, tblp_foliospago.IdEstatus, tblp_foliospago.Factura, tblp_foliospago.IdUsua, Sum(tblp_foliospago.Monto) AS Monto, tblp_foliospago.IdForma, tblc_formapago.Descripcion, tblp_pagos.DocFactura, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno FROM tblp_foliospago Left Join tblc_formapago ON tblc_formapago.IdFormaPago = tblp_foliospago.IdForma Left Join tblp_pagos ON tblp_pagos.IdPago = tblp_foliospago.IdPago Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foliospago.IdUsua WHERE tblp_foliospago.Factura =  '1' AND tblp_foliospago._idtemporal IS NOT NULL GROUP BY tblp_foliospago.NoFolio ");

// $_mens = 1500;
// $idCiclo = 14;

// $sql_us = $db->query("SELECT tblc_usuario.IdUsua, tblc_usuario.id_ciclo_ini, tblc_usuario.Grado FROM tblc_usuario WHERE tblc_usuario.Permisos =  '3' AND tblc_usuario.IdEstatus =  '8' AND tblc_usuario.IdCampus =  '4' AND tblc_usuario.Grado =  '3'");
// while ($_us = $db->recorrer($sql_us)) {
//   $_IdUsua = $_us["IdUsua"];

//   $sql_ux = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Monto, tblp_pagos.IdConcepto FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '" . $_us['IdUsua'] . "' GROUP BY tblp_pagos.IdConcepto ");
//   $db->rows($sql_ux);
//   $_userx = $db->recorrer($sql_ux);
//   $IdPago = $_userx["IdPago"];
//   if($IdPago){
//    $_con = $_userx['IdConcepto'];
//    $_mont = $_userx['Monto'];

//   if ($_con == 2) {
//     $_col = 0;
//     $_porx = $_mens / $_mont;
//     $_col = ($_porx * 100);
//     $cal1 = (100 - $_col);
//     $insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$_IdUsua' AND tblp_beca.IdConcepto = '2'");
//     $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo) VALUES ('$_IdUsua','2','$cal1',NOW(),'1','8','1000','$idCiclo')");
//   }

//   if ($_con == 3) {
//     $_col = 0;
//     $_porx = $_mens / $_mont;
//     $_col = ($_porx * 100);
//     $cal1 = (100 - $_col);
//     $insertar = $db->query("DELETE FROM tblp_beca WHERE tblp_beca.IdUsua = '$_IdUsua' AND tblp_beca.IdConcepto = '3' ");
//     $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo) VALUES ('$_IdUsua','2','$cal1',NOW(),'1','8','1000','$idCiclo')");
//   }
//   }
// }

if(($IdUsua == 1) || ($IdUsua == 709)){
?>

<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> 1/3 Vista previa de alumnos los alumnos en proceso de validación de pagos subidos recientemente.</h3>
</div>
<?php } ?>
<div class="box-body">
  <table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>REF.</th>
        <th>ALFANUMERICA</th>
        <th>AUTO.</th>
        <th>ORDENANTE</th>
        <th>IMPORTE</th>
      </tr>
    </thead>
    <tbody>
      <?php $sum = 0;
      $i = 0;
      while ($_user = $db->recorrer($sql_lsta)) {
        if ($_user["_idestatus"] == 1) {
          $color = "style='color: black;'";
        } elseif ($_user["_idestatus"] == 10) {
          $color = "style='color: blue;'";
        } elseif ($_user["_idestatus"] == 28) {
          $color = "style='color: red;'";
        }
      ?>
        <tr>
          <td><?php echo $i = $i + 1; ?>.- </td>
          <td><?php echo $_user["Fecha"]; ?></td>
          <td><?php echo $_user["referencia"]; ?></td>
          <td><?php echo $_user["alfanumerica"]; ?></td>
          <td><?php echo $_user["autorizacion"]; ?></td>
          <td <?php echo $color; ?>>
            <?php if ($_user["_idestatus"] == 1) {
              echo "<i style='color: black;' title='No se ha identificado al alumno.' class='fa fa-fw fa-question-circle'></i> ";
            } elseif ($_user["_idestatus"] == 10) {
              echo "<i title='Alumno identificado para procesar su pago.' style='color: blue;' class='fa fa-fw fa-check-circle'></i> ";
            } elseif ($_user["_idestatus"] == 28) {
              echo "<i title='Los datos de pago de este alumnos ya se encuentran registrados.' style='color: red;' class='fa fa-fw fa-warning'></i> ";
            } ?>
            <?php if ($_user["_IdUsua"]) {
              echo $_user["Nombre"] . ' ' . $_user["APaterno"] . ' ' . $_user["AMaterno"];
            } else {
              echo $_user["ordenante"];
            } ?>
          </td>
          <td <?php if ($_user["_idestatus"] == 28) {
                echo "style='text-decoration:line-through; color: red;'";
              } ?>>$ <?php echo number_format($_user["Importe"], 2, '.', ','); ?> </td>
        </tr>
      <?php $sum = ($sum + $_user["Importe"]);
      } ?>
      <tr>
        <td colspan="6" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></b> </td>
      </tr>
      </tfoot>
  </table>
  <?php if ($i) { ?>
    <p style="text-align: center;">
      <button onclick="procesar_filtro1()" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-check-circle"></i> Procesar lista de pagos</button>
    </p><?php } ?>

</div>
<!-- Paso de conciliar para alumnos reconocidos automaticamente -->
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> 2/3 Alumnos que se pueden conciliar de manera automática.</h3>
</div>
<div class="box-body">
  <table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>REF.</th>
        <th>ALFANUMERICA</th>
        <th>AUTO.</th>
        <th>ORDENANTE</th>
        <th>IMPORTE</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $sum_pro = 0;
      $i2 = 0;
      while ($_process = $db->recorrer($sql_proc)) {  ?>
        <tr>
          <td><?php echo $i2 = $i2 + 1; ?>.- </td>
          <td><?php echo $_process["Fecha"]; ?></td>
          <td><?php echo $_process["referencia"]; ?></td>
          <td style="color: blue; cursor: pointer;" onclick="proceso_cobrar(<?php echo $_process["IdTemporal"]; ?>,<?php echo $_process["_IdUsua"]; ?>)"><?php echo $_process["alfanumerica"]; ?></td>
          <td><?php echo $_process["autorizacion"]; ?></td>
          <td <?php if ($_process["_idestatus"] == 1) {
                echo "style='color: red;'";
              } elseif ($_process["_idestatus"] == 10) {
                echo "style='color: blue;'";
              } ?>><?php echo $_process["Nombre"] . ' ' . $_process["APaterno"] . ' ' . $_process["AMaterno"]; ?></td>
          <td>$ <?php echo number_format($_process["Importe"], 2, '.', ','); ?> </td>
          <td>
          <?php  if(($_SESSION['IdUsua'] == 1) || ($_SESSION['IdUsua'] == 709)){ ?>
          <button onclick="eliminar_pago(<?php echo $_process["IdTemporal"]; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-trash-o"></i></button>
          <?php } ?>
          </td>
        </tr>
      <?php $sum_pro = ($sum_pro + $_process["Importe"]);
      } ?>
      <tr>
        <td colspan="6" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sum_pro, 2, '.', ','); ?></b> </td>
      </tr>
      </tfoot>
  </table>
  <?php if ($i2) { ?>
    <p style="text-align: center;">
      <button onclick="procesar_filtro1()" type="button" class="btn bg-orange btn-flat btn-sm"><i class="fa fa-fw fa-check-circle"></i> Conciliar pagos</button>
    </p><?php } ?>
</div>
<!-- Paso de conciliar para alumnos sin reconocer automaticamente -->
<div class="box-header">
  <h3 class="box-title"><i class="fa fa-fw fa-bookmark"></i> 3/3 Pagos de alumnos sin identificar para conciliar de manera personalizada.</h3>
</div>
<div class="box-body">
  <table class="table table-bordered table-striped" style="font-size: 12px;">
    <thead>
      <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>REF.</th>
        <th>ALFANUMERICA</th>
        <th>AUTO.</th>
        <th>ORDENANTE</th>
        <th>IMPORTE</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php $sum_pend = 0;
      $i3 = 0;
      while ($_pendix = $db->recorrer($sql_pend)) {  ?>
        <tr>
          <td><?php echo $i3 = $i3 + 1; ?>.- </td>
          <td><?php echo $_pendix["Fecha"]; ?></td>
          <td><?php echo $_pendix["referencia"]; ?></td>
          <td style="color: blue; cursor: pointer;" onclick="proceso_cobrar(<?php echo $_pendix["IdTemporal"]; ?>,<?php echo $_pendix["_IdUsua"]; ?>)"><?php echo $_pendix["alfanumerica"]; ?></td>
          <td><?php echo $_pendix["autorizacion"]; ?></td>
          <td <?php if ($_pendix["_idestatus"] == 1) {
                echo "style='color: red;'";
              } elseif ($_pendix["_idestatus"] == 10) {
                echo "style='color: blue;'";
              } ?>>
            <?php if ($_pendix["_IdUsua"]) {
              echo $_pendix["ordenante"];
            } else {
              echo $_pendix["ordenante"];
            } ?></td>
          <td>$ <?php echo number_format($_pendix["Importe"], 2, '.', ','); ?> </td>
          <td>
          <?php  if(($_SESSION['IdUsua'] == 1) || ($_SESSION['IdUsua'] == 709)){ ?>
          <button onclick="eliminar_pago(<?php echo $_pendix["IdTemporal"]; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-fw fa-trash-o"></i></button>
          <?php } ?>
          </td>
        </tr>
      <?php $sum_pend = ($sum_pend + $_pendix["Importe"]);
      } ?>
      <tr>
        <td colspan="6" style="text-align: right;"><b>TOTAL:</b></td>
        <td style="background: yellow;"><b>$ <?php echo number_format($sum_pend, 2, '.', ','); ?></b> </td>
      </tr>
      </tfoot>
  </table>
</div>
