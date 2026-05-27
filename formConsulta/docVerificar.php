<?php
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdUsua = $_POST["employee_id"];
  $output = '';

  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql9 = $db->query("SELECT * FROM tblp_servicio WHERE tblp_servicio.IdUsua =  '$IdUsua'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwNomPrograma = $datos91["NomPrograma"];
  $rwNomDependencia = $datos91["NomDependencia"];
  $rwPeriodo = $datos91["Periodo"];
  $rwRegistro = $datos91["Registro"];
  $rwFecImp = $datos91["FecImpresion"];

  $output .= '
  <form class="form-horizontal" name="frm" id="frm" action="docVerificar.php" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Programa:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtNomPrograma" name="txtNomPrograma" type="text" value="'.$rwNomPrograma.'">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Instituci&oacute;n:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtNomDependencia" name="txtNomDependencia" type="text" value="'.$rwNomDependencia.'">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Periodo:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtPeriodo" name="txtPeriodo" type="text" value="'.$rwPeriodo.'">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Registro No:</label>
                  <div class="col-sm-10">
                    <input class="form-control" id="txtRegistro" name="txtRegistro" type="text" value="'.$rwRegistro.'">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Fecha para Impresi&oacute;n:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="'.$rwFecImp.'">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-info pull-right" onClick="val_clServicio()">Guardar</button>
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
