<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];

  $sql = $db->query("SELECT
tblp_saldo.IdSaldo,
tblp_saldo.Monto,
tblp_saldo.Descripcion,
tblp_saldo.Fecha,
tblp_saldo.Tipo,
tblp_saldo.Comentario
FROM
tblp_saldo
 WHERE tblp_saldo.IdUsua = '$IdUsua'");

 $sql2 = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdUsua = '$IdUsua' AND tblh_detallepagos.TipoPago = '2' ORDER BY tblh_detallepagos.FecCap DESC"); ?>
  <form class="form-horizontal" name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
        <!-- <div class="box-body"> -->
          <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                  <tr>
                    <th>Descripción del pago</th>
                    <th>Fecha</th>
                    <th style="text-align: right; width: 100px;">Monto</th>
                </tr>
                <?php $sum= 0; while($x = $db->recorrer($sql)){  $idP = $x["IdSaldo"];
                  ?>
                <tr>
                  <td><?php echo $x["Descripcion"]; ?></td>
                  <td><?php echo $x["Fecha"]; ?></td>
                  <td style="text-align: right;"><?php if($x["Fecha"] == "Egreso"){ echo "+"; } ?> $ <?php echo number_format($x["Monto"], 2, '.', ','); ?></td>
                </tr>
              <?php $sum = ($x["Monto"] + $sum); } ?>
              <tr>
                <td colspan="2" style="text-align: right;"><b>Total deuda:</b></td>
                <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></b></td>
              </tr>
              </tbody></table>
        <table class="table table-striped" style="font-size: 12px;">
              <tbody>
                <tr>
                  <th></th>
                  <th>Fecha</th>
                  <th>Comentario</th>
                  <th style="text-align: right;">Imagen</th>
              </tr>
              <?php $s= 0; while($y = $db->recorrer($sql2)){
                ?>
              <tr>
                <td><b><?php echo $s = ($s + 1); ?>.- </b></td>
                <td><?php echo $y["FecCap"]; ?></td>
                <td><?php echo $y["Comentario"]; ?></td>
                <td style="text-align: right;"> <button onClick="window.open('assets/docs/comprobantes/<?php echo $y["Anio"]; ?>/<?php echo $y["Mes"]; ?>/<?php echo $y["Archivo"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-xs"><i class="fa fa-fw fa-paperclip"></i> Ver archivo</button></td>
              </tr>
            <?php  } ?>
            </tbody></table>


      </div>
    </table>
  </div>

  </form>
