<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $IdAlumno = $_POST["employee_id"];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdAlumno'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwIdOferta = $datos91["IdOferta"];

  $sql8 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$rwIdOferta'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdGrado = $datos81["IdGrado"];
  $sql = $db->query("SELECT tblc_conceptos.IdConcepto, tblc_conceptos.NomConcepto, tblc_conceptos.Grado$IdGrado FROM tblc_conceptos WHERE tblc_conceptos.Tipo = '1'");

  $sql2 = $db->query("SELECT tblp_pagos.IdPago, tblc_conceptos.NomConcepto, tblp_pagos.FecLimPago, tblp_pagos.Pagar, tblp_descuento.Descuento, tblp_descuento.Porcentaje FROM tblp_pagos Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_pagos.IdConcepto Left Join tblp_descuento ON tblp_descuento.IdDescuento = tblp_pagos.IdDescuento AND tblp_descuento.IdPago = tblp_pagos.IdPago WHERE tblp_pagos.IdUsua = '$IdAlumno' ");

  ?>
  <form name="frm2" id="frm2" action="pagoIngreso.php" method="POST" enctype="multipart/form-data">
    <input id="IdAlumno" name="IdAlumno" value="<?php echo $IdAlumno; ?>" type="hidden"/>
    <input id="DesGenerado" name="DesGenerado" value="0" type="hidden"/>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-8">
          <div class="form-group">
            <label>Seleccione concepto:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtConcepto" id="txtConcepto">
                <option value=""> - Seleccione - </option>
                <?php
                while($x = $db->recorrer($sql)){ ?>
                <option class="form-control"  value="<?php echo $x["IdConcepto"].'-'.$x[2]; ?>" > <?php echo $x["NomConcepto"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>Pagar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtPagar" value="0" name="txtPagar" onchange="cambioMonto(this,txtPagar)" >
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Desc. en beca %:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtPorcentaje" value="0" name="txtPorcentaje" onchange="val_calDescuento(this,txtPorcentaje,txtPagar), calcular(this,txtPorcentaje)" >
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Total descuento:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" disabled class="form-control pull-right" id="txtDescuento" name="txtDescuento" value="0" >
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Total pagar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input type="text" disabled class="form-control pull-right" id="txtTotalPagar" name="txtTotalPagar" value="0">
            </div>
          </div>
        </div>


        <div class="col-md-6">
        <div class="form-group">
          <label>Fecha l&iacute;mite de pago:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
          </div>
        </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" onClick="val_addPagoNvo()">Generar pago</button>
          <button type="button" class="btn btn-primary" onClick="val_closePagoNvo()">Cerrar pago inicial</button>
        </div>
      </div>
    </table>
    <table class="table table-hover">
                <tbody><tr>
                  <th>Concepto</th>
                  <th>Fec. L&iacute;mite</th>
                  <th>Monto</th>
                  <th>Descuento</th>
                  <th>Total pagar</th>
                </tr>
                <?php   while($x = $db->recorrer($sql2)){ $i = 0; $des = ($x["Pagar"] - $x["Descuento"]); ?>
                <tr>
                  <td><?php echo $x["NomConcepto"]; ?></td>
                  <td><?php echo $x["FecLimPago"]; ?></td>
                  <td>$ <?php echo number_format($x["Pagar"], 2, '.', ','); ?></td>
                  <td>$ <?php echo number_format($x["Descuento"], 2, '.', ','); ?></td>
                  <td>$ <?php echo number_format($des, 2, '.', ','); ?></td>
                </tr><?php  } ?>
              </tbody></table>
  </div>

  </form>
  <?php } ?>


<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1
<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script language="javascript">
      $(document).ready(function(){
        $("#txtConcepto").change(function () {
          var IdConcepto = document.getElementById("txtConcepto").value;
              var res = IdConcepto.split("-");
              var IdAlumno = res[0];
              var Monto = res[1];
              document.getElementById("txtPagar").value = Monto;
              document.getElementById("txtTotalPagar").value = Monto;
              document.getElementById("txtPorcentaje").value = 0;
              calDescuento(IdConcepto,Porcentaje);
        });
      });



      function calDescuento(IdConcepto,Porcentaje){
        if(IdConcepto == 0){
          document.getElementById("txtPorcentaje").value = 0;
          swal("Error al calcular descuento", "Debe seleccionar el tipo de concepto", "info");
        } else {
          var jsdescuento = 0;
          var jsporcentaje = 0;
          var jstotDescu = 0;
          var jssumtotal = 0;
          var jsResultado = 0;

          jsporcentaje = (Porcentaje * 0.01);
          var Monto = parseFloat(document.getElementById("txtPagar").value);
          jsdescuento = (Monto * jsporcentaje);   // CALCULA EL MONTO A DESCONTAR
          jstotDescu = Monto - jsdescuento;
          document.getElementById("txtDescuento").value = jsdescuento;
          document.getElementById("DesGenerado").value = jsdescuento;
          document.getElementById("txtTotalPagar").value = jstotDescu;
        }
      }
    </script>
<script>




        function calcular(valor,nombre)
        {
          //$('#txtBtn').attr("disabled", true);
          var numero = valor.value;
          if(!numero){
            numero = 0;
            document.getElementById("txtPorcentaje").value = "0";
          }

          var IdConcepto = parseFloat(document.getElementById("txtConcepto").value);
          if(!IdConcepto){ IdConcepto = 0; }
          calDescuento(IdConcepto,numero);
        }

        function cambioMonto(valor,nombre)
        {
          var numero = valor.value;
            document.getElementById("txtPorcentaje").value = "0";
            document.getElementById("txtDescuento").value = "0";
            document.getElementById("DesGenerado").value = "0";
            document.getElementById("txtTotalPagar").value = numero;
        }



  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()



    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
