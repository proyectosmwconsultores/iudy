<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  $IdOferta = $_POST['Oferta'];
  $IdUsua = $_POST['employee_id'];

  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql = $db->query("SELECT tblc_docalumnos.IdDocAlumno, tblc_docalumnos.FecCap, tblc_tipodocumento.NomDocumento, tblc_estatus.Estatus FROM tblc_docalumnos Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docalumnos.IdTipoDocumento Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_docalumnos.Estatus WHERE tblc_docalumnos.IdUsua =  '$IdUsua' AND tblc_docalumnos.Estatus =  '5'");
  // $db->rows($sql9);
  // $datos91 = $db->recorrer($sql9);
  // $rwIdGrado = $datos91["IdGrado"];
  //
  // $sql = $db->query("SELECT * FROM tblc_conceptos WHERE tblc_conceptos.Grado$rwIdGrado IS NOT NULL  AND tblc_conceptos.Tipo ='1'");

  $output .= '
  <form name="frm2" id="frm2" action="closeEstatus.php" method="POST" enctype="multipart/form-data">
  <input id="IdGrado" name="IdGrado" value="'.$rwIdGrado.'" type="hidden"/>
  <div class="table-responsive">
  <b>Documentos no aprobados:</b>
  <table class="table table-condensed">
          <tbody>
          ';
          while($x = $db->recorrer($sql)){
              $output .= '
          <tr>
            <td><button type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-times-circle"></i></button></td>
            <td>'.$x["NomDocumento"].'</td>
            <td>'.$x["Estatus"].'</td>
          </tr>
          ';
        }
          $output .= '

        </tbody></table>


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
