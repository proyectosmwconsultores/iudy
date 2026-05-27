<?php
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdPago = $_POST["employee_id"];
  $IdGrupo = $_POST["IdGrupo"];
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_pagos WHERE tblp_pagos.IdPago = '$IdPago'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwEstatus = $datos91["IdEstatus"];
  $rwIdFormaPag = $datos91["IdFormaPago"];
  $rwPagar = $datos91["Pagar"];
  $rwRecargo = $datos91["Recargos"];
  $tot = $rwPagar + $rwRecargo;

  $Id = $_POST['Oferta'];

  $sql1 = $db->query("SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '1'");
  $sql2 = $db->query("SELECT * FROM tblc_formapago");


  //$row=mysql_fetch_array($res1);
  $output .= '
  <form name="frm" id="frm" action="closeComprobacion.php" method="POST" enctype="multipart/form-data">
  <input id="IdPago" name="IdPago" value="'.$IdPago.'" type="hidden"/>
  <input id="Pagar" name="Pagar" value="'.$rwPagar.'" type="text"/>
  <input id="Recargo" name="Recargo" value="'.$rwRecargo.'" type="text"/>
  <input id="Total" name="Total" value="'.$tot.'" type="text"/>
  <input id="montoDesc" name="montoDesc" value="0" type="text"/>
  <input id="IdGrupo" name="IdGrupo" value="'.$IdGrupo.'" type="text"/>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">


        <div class="col-md-6">
          <div class="form-group">
            <label>Seleccione Estatus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value=""> - Seleccione - </option>
                ';
                while($x1 = $db->recorrer($sql1)){
                //while($row=mysql_fetch_array($res1)) {
                  $Id = $x1["IdEstatus"];
                  $Nom = $x1["Estatus"];
                  if($Id == $rwEstatus){ $cond = " selected='selected'"; } else { $cond = ""; }
                    $output .= '

                <option class="form-control"  value="'.$Id.'" "'.$cond.'" > '.$Nom.' </option>

                ';
                 }
                   $output .= '
              </select>

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Seleccione Tipo de Pago:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtForma" id="txtForma">
                <option value=""> - Seleccione - </option>
                ';
                while($x2 = $db->recorrer($sql2)){
                //while($row2=mysql_fetch_array($res2)) {
                  $IdForma = $x2["IdFormaPago"];
                  $Pago = $x2["Descripcion"];
                  if($IdForma == $rwIdFormaPag){ $cond = " selected='selected'"; } else { $cond = ""; }

                    $output .= '

                <option class="form-control"  value="'.$IdForma.'" "'.$cond.'"> '.$Pago.' </option>
                ';
                 }
                   $output .= '
              </select>

            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Opci&oacute;n para descuento:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtDescuento" id="txtDescuento">
                <option value="1"> - Seleccione - </option>
                ';
                while($x3 = $db->recorrer($sql3)){
                //while($row3=mysql_fetch_array($res3)) {
                  $IdDescuento = $x3["IdDescuento"];
                  $Descuento = $x3["NomDescuento"];


                    $output .= '

                <option class="form-control"  value="'.$IdDescuento.'" > '.$Descuento.' </option>
                ';
                 }
                   $output .= '
              </select>

            </div>
          </div>
        </div>

        <div class="col-md-6" id="divDescuento" name="divDescuento" style="display: none;">
          <div class="form-group">
            <label>Descuento en %:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-money"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtPorcentaje" name="txtPorcentaje" onchange="val_number(this,txtPorcentaje), calcular(this,txtPorcentaje)" >
            </div>
          </div>
        </div>

        <div class="col-md-3" id="divTotal" name="divTotal" style="display: none;">
          <div class="form-group">
            <label>Monto:</label>
            <div class="input-group">
              <input type="text" disabled class="form-control pull-right" id="txtConcepto" name="txtConcepto" value="'.$rwPagar.'" >
            </div>
          </div>
        </div>
        <div class="col-md-3" id="divRecargo" name="divRecargo" style="display: none;">
          <div class="form-group">
            <label>Recargo:</label>
            <div class="input-group">
              <input type="text" disabled class="form-control pull-right" id="txtRecargo" name="txtRecargo" value="'.$rwRecargo.'">
            </div>
          </div>
        </div>
        <div class="col-md-3" id="divMontoDes" name="divMontoDes" style="display: none;">
          <div class="form-group">
            <label>Descuento:</label>
            <div class="input-group">
              <input type="text" disabled class="form-control pull-right" id="txtMontoDesc" name="txtMontoDesc">
            </div>
          </div>
        </div>
        <div class="col-md-3" id="divPagar" name="divPagar" style="display: none;">
          <div class="form-group">
            <label>Total Pagar:</label>
            <div class="input-group">
              <input type="text" disabled class="form-control pull-right" id="txtTotal" name="txtTotal" value="'.$tot.'" >
            </div>
          </div>
        </div>


       <div class="col-md-12">
         <div class="form-group">
           <label>Comentario:</label>
           <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-commenting"></i>
             </div>
             <input type="text" class="form-control pull-right" id="txtComentario" name="txtComentario">
           </div>
         </div>
       </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-danger" onClick="val_cerrarComprb()"> GUARDAR CAMBIOS</button>
            </div>
          </div>
        </div>

        </div>
      </div>
    </table>
  </div>
  </form>';
  echo $output;
}
?>

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

<script>
$("#txtDescuento").change(function () {
          var IdDescuento = document.getElementById("txtDescuento").value;
          if(IdDescuento != 1){
            document.getElementById("divDescuento").style.display = 'block';
            document.getElementById("divPagar").style.display = 'block';
            document.getElementById("divRecargo").style.display = 'block';
            document.getElementById("divMontoDes").style.display = 'block';
            document.getElementById("divTotal").style.display = 'block';
          } else {
            document.getElementById("divDescuento").style.display = 'none';
            document.getElementById("divPagar").style.display = 'none';
            document.getElementById("divRecargo").style.display = 'none';
            document.getElementById("divMontoDes").style.display = 'none';
            document.getElementById("divTotal").style.display = 'none';
          }
        });


        function calcular(valor,nombre)
        {
        //$('#txtBtn').attr("disabled", true);
        var numero = valor.value;



        var recargo = parseFloat(document.getElementById("Recargo").value);
          var Pagar = parseFloat(document.getElementById("Pagar").value);

          var descuento = 0;
          var totalRec = 0;
          var convPorcentaje = 0;
          var suma = 0;

          convPorcentaje = (numero * 0.01)
          descuento = (recargo * convPorcentaje);
          totalRec = recargo - descuento;
          suma = Pagar + totalRec;


          document.getElementById("txtMontoDesc").value = descuento;
          document.getElementById("montoDesc").value = descuento;
          document.getElementById("txtTotal").value = suma;
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
