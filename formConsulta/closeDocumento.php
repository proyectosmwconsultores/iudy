<?php
include('../hace.php');
if(isset($_POST["employee_id"])){

  $IdDocumento = $_POST["employee_id"];
  $output = '';

  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql = $db->query("SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '1'");

  // require('../php/clases/system.php');
  // $sql1="SELECT * FROM tblc_estatus WHERE tblc_estatus.Fase1 = '1'";
  // $res1=mysql_query($sql1,Conectar::con());

  // $sql2="SELECT * FROM tblc_formapago";
  // $res2=mysql_query($sql2,Conectar::con());


  //$row=mysql_fetch_array($res1);
  $output .= '
  <form name="frm" id="frm" action="closeComprobacion.php" method="POST" enctype="multipart/form-data">
  <input id="IdDocumento" name="IdDocumento" value="'.$IdDocumento.'" type="hidden"/>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">


        <div class="col-md-12">
          <div class="form-group">
            <label>Seleccione Estatus:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <select class="form-control" name="txtEstatus" id="txtEstatus">
                <option value=""> - Seleccione - </option>
                ';
                while($x = $db->recorrer($sql)){
                //while($row=mysql_fetch_array($res1)) {
                  $Id = $x["IdEstatus"];
                  $Nom = $x["Estatus"];
                    $output .= '

                <option class="form-control"  value="'.$Id.'"> '.$Nom.' </option>
                ';
                 }
                   $output .= '
              </select>

            </div>
          </div>
        </div>





        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-danger" onClick="val_docComprobacion()"> GUARDAR CAMBIOS</button>
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
