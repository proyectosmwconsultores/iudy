<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = substr($_POST["Token"], 10, 10);
  $pag = '';
  $totaFil = '';

  $sql = $db->query("SELECT tblp_saldo.IdSaldo, tblp_saldo.Monto, tblp_saldo.Descripcion, tblp_saldo.Fecha, tblp_saldo.Tipo, tblp_saldo.Comentario FROM tblp_saldo WHERE tblp_saldo.IdUsua = '$IdUsua'");

  $sql2x = $db->query("SELECT * FROM tblh_detallepagos WHERE tblh_detallepagos.IdUsua = '$IdUsua' AND tblh_detallepagos.TipoPago = '2' ORDER BY tblh_detallepagos.FecCap DESC");

  $sql2 = $db->query("SELECT * FROM tblc_formapago");
  $sqlB = $db->query("SELECT * FROM tblc_bancos WHERE tblc_bancos.Tipo = '2'");

  $sql9 = $db->query("SELECT tblc_usuario.IdOferta, tblc_usuario.IdCampus FROM tblc_usuario WHERE tblc_usuario.IdUsua =  '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdOferta = $datos91["IdOferta"];
  $IdCampus = $datos91["IdCampus"];

  $sql_banco = $db->query("SELECT tblc_bancos_setting.IdBanco, tblc_bancos.Banco FROM tblc_bancos_setting Left Join tblc_bancos ON tblc_bancos.IdBanco = tblc_bancos_setting.IdBanco WHERE tblc_bancos_setting.IdCampus =  '$IdCampus' AND tblc_bancos_setting.IdOferta =  '$IdOferta' GROUP BY tblc_bancos_setting.IdBanco ");
  $sql_ban_proc = $db->query("SELECT * FROM tblc_banco_procedencia WHERE tblc_banco_procedencia.Tipo ='1' ORDER BY tblc_banco_procedencia.Banco ASC");

  ?>
  <form role="form" name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="valor_banco" name="valor_banco" value="0" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savBeca" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
          <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                  <tr>
                    <th>Descripción del pago</th>
                    <th>Fecha</th>
                    <th style="text-align: right; width: 100px;">Monto</th>
                </tr>
                <?php $idP = 0; $sum = 0; while($x = $db->recorrer($sql)){  $idP = $x["IdSaldo"];
                  ?>
                <tr>
                  <td><?php echo $x["Descripcion"]; ?></td>
                  <td><?php echo $x["Fecha"]; ?></td>
                  <td style="text-align: right;"><?php if($x["Fecha"] == "Egreso"){ echo "+"; } ?> $ <?php echo number_format($x["Monto"], 2, '.', ','); ?></td>
                </tr>
              <?php $sum = ($x["Monto"] + $sum); } ?>
              <tr>
                <td colspan="2" style="text-align: right;"><b>TOTAL DEUDA:</b></td>
                <td style="text-align: right; background: yellow;"><b>$ <?php echo number_format($sum, 2, '.', ','); ?></td>
              </tr>
              </tbody></table>
               <input id="IdPago" name="IdPago" value="<?php echo $idP; ?>" type="hidden"/>
              <input id="txtTPagado" class="form-control" name="txtTPagado" value="<?php echo $pag; ?>" type="hidden"/>
        <?php

         if($sum != 0){  ?>
        <div class="col-md-6">
          <div class="form-group">
            <label>Estatus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value=""> - Seleccione - </option>
                <option value="37"> ABONO</option>
                <option value="38"> PAGO COMPLETO </option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Seleccione tipo de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtForma" id="txtForma" onchange="sel_tipo_xpago()">
                <option value=""> - Seleccione - </option>
                <?php
                while($x2 = $db->recorrer($sql2)){
                  $IdForma = $x2["IdFormaPago"];
                  $Pago = $x2["Descripcion"];
                  ?>
                <option class="form-control"  value="<?php echo $IdForma ?>" > <?php echo $Pago; ?> </option>
                <?php
              } ?>

              </select>

            </div>
          </div>
        </div>
        <input type="hidden" class="form-control" name="txt_banco" id="txt_banco" value="2">
        <div style="display: none; " id='div_banco_p'>
        <div class="col-md-6">
          <div class="form-group">
            <label>Banco de procedencia:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-file"></i>
              </div>
              <select class="form-control" name="txt_procedencia" id="txt_procedencia">                  <?php
                while($_banc_proc = $db->recorrer($sql_ban_proc)){  ?>
                <option class="form-control"  value="<?php echo $_banc_proc['IdProcedencia'] ?>" > <?php echo $_banc_proc['Banco']; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha de pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">

            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Total pagar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input id="txtTPagar" class="form-control" name="txtTPagar" value="<?php echo $totaFil; ?>" type="hidden"/>
              <input id="txtPago" class="form-control" name="txtPago" value="<?php echo $totaFil; ?>" type="text"/>

            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Comentario:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-wechat"></i>
              </div>
              <input class="form-control" id="txtComentario" name="txtComentario" type="text">
            </div>
          </div>
        </div>


        <div class="col-md-12">
          <div class="form-group">
              <button type="button" class="btn btn-block btn-info" onclick="val_saldoIni(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>)"> Guardar cambios</button>
          </div>
        </div>
      <?php } ?>

      </div>
    </table>

    <table class="table table-striped" style="font-size: 12px;">
          <tbody>
            <tr>
              <th></th>
              <th>Fecha</th>
              <th>Comentario</th>
              <th style="text-align: right;">Imagen</th>
          </tr>
          <?php $v = 0; while($s = $db->recorrer($sql2x)){
            ?>
          <tr>
            <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
            <td><?php echo $s["FecCap"]; ?></td>
            <td><?php echo $s["Comentario"]; ?></td>
            <td style="text-align: right;"> <button onClick="window.open('assets/docs/comprobantes/<?php echo $s["Anio"]; ?>/<?php echo $s["Mes"]; ?>/<?php echo $s["Archivo"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-xs"><i class="fa fa-fw fa-paperclip"></i> Ver archivo</button></td>
          </tr>
        <?php  } ?>
        </tbody></table>
  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>



//
// $(document).ready(function(){
//   $("#txtForma").change(function () {
//      var Forma = parseFloat(document.getElementById("txtForma").value);
//      if((Forma == 2) || (Forma == 3)){
//         document.getElementById("BancoId").style.display = "block";
//      }
//      else{
//        document.getElementById("BancoId").style.display = "none";
//      }
//
//
//   });
// });

  $(function () {

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

  })

  function sel_tipo_xpago(){

    var tipoPago = document.getElementById("txtForma").value;
    if(tipoPago == 1){
      document.getElementById("div_banco_p").style.display = 'none';
      document.getElementById("valor_banco").value = '0';
    } else {
      document.getElementById("div_banco_p").style.display = 'block';
      document.getElementById("valor_banco").value = '1';
    }
  }
</script>
