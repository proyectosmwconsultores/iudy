<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  $IdOferta = $_POST['Oferta'];

  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $rwIdGrado = $datos91["IdGrado"];

  $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.Grado$rwIdGrado IS NOT NULL  AND tblc_conceptos.Tipo ='1'");

  $output .= '
  <form name="frm2" id="frm2" action="closeEstatus.php" method="POST" enctype="multipart/form-data">
  <input id="IdGrado" name="IdGrado" value="'.$rwIdGrado.'" type="hidden"/>
  <div class="table-responsive">
    <table class="table table-bordered">
    
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        '; $valor = 0;
        while($x = $db->recorrer($sql)){
        //while($row=mysql_fetch_array($res1)) {
          $Id = $x["IdConcepto"];
          $precc = $x["Grado$rwIdGrado"];
          if($valor == 0){
            $d1 = $Id;
            $valor = 1;
          } else {
            $d2 = $Id;
          }


            $output .= '


        <div class="col-md-6">
          <div class="form-group">
            <label>'.$x["NomConcepto"].':</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-dollar"></i>
              </div>
              <input disabled type="text" value="'.$precc.'" class="form-control">


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
              <input type="text" value="'.$precc.'" class="form-control" name="txtPrecio-'.$Id.'" id="txtPrecio-'.$Id.'">
            </div>
          </div>
        </div>
        ';
         }
           $output .= '
           <input id="pago1" name="pago1" value="'.$d1.'" type="hidden"/>
           <input id="pago2" name="pago2" value="'.$d2.'" type="hidden"/>
           <div class="col-md-12">
             <div class="form-group">
               <label>Fecha l&iacute;mite de pago:</label>
               <div class="input-group">
                 <div class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                 </div>
                 <input type="text" class="form-control pull-right" id="datepicker3" name="datepicker3">
               </div>
             </div>
           </div>

        <div class="col-md-4">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-success btn-sm" onClick="val_cerrarEstatus()"> CREAR FICHAS DE PAGO Y CERRAR ESTATUS</button>
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
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>
  $(function () {


    		    //Date picker
    		    $('#datepicker3').datepicker({
    		      autoclose: true
    		    })
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
