<?php
include('../hace.php');
if(isset($_POST["IdCal"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdCal = $_POST["IdCal"];

  $sql_cal = $db->query("SELECT * FROM tblp_calificacion WHERE tblp_calificacion.IdCalificacion = '$IdCal' ");
  $db->rows($sql_cal);
  $_cal = $db->recorrer($sql_cal);

?>

<div class="box-info">
  <form class="form-horizontal" name="frmx" id="frmx" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-8 control-label">Extraordinario 1:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_extra1" id="txt_extra1" class="form-control" value="<?php echo $_cal['E1']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Asistencia:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_asistencia" id="txt_asistencia" class="form-control" value="<?php echo $_cal['A']; ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-8 control-label">Fata:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_falta" id="txt_falta" class="form-control" value="<?php echo $_cal['F']; ?>">
        </div>
      </div>
      <!-- <div class="form-group">
        <label class="col-sm-8 control-label">Extraordinario 2:</label>
        <div class="col-sm-4">
          <input type="text" name="txt_extra2" id="txt_extra2" class="form-control" value="<?php echo $_cal['E2']; ?>">
        </div>
      </div> -->
      <div class="box-footer">
        <button type="button" onclick="sav_extrax(<?php echo $IdCal; ?>)" class="btn btn-info pull-right">Guardar</button>
      </div>
  </form>
</div>

<?php } ?>
<script>
function sav_extrax(IdCal){

  var Promedio = document.getElementById("txt_extra1").value;
  var Asis = document.getElementById("txt_asistencia").value;
  var Falt = document.getElementById("txt_falta").value;

  if (Promedio){
    if ((Promedio == '5') || (Promedio == '6') || (Promedio == '7') || (Promedio == '8') || (Promedio == '9') || (Promedio == '10') || (Promedio == 'NP')){

    } else {
      swal("Error al guardar", "El promedio final deber un número entero, por ejemplo: 5, 6, 7, 8, 9, 10, NP", "error");
      document.getElementById("txt_extra1").focus();
      document.getElementById("txt_extra1").value='';
      return 0;
    }
  }


  var TipoGuardar = "sav_prom_id";
  $.ajax({
       url:"formConsulta/setting.php",
       method:"POST",
       data:{TipoGuardar:TipoGuardar, IdCal:IdCal, Promedio:Promedio, Asis:Asis, Falt:Falt},
       success:function(data){
         if(data == 1){
           swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
           $.ajax({
       				 url:"formConsulta/calificaciones_extra_all.php",
       				 method:"POST",
       				 data:{IdCal:IdCal},
       				 success:function(data){
       							$('#employee_promx').html(data);
       							$('#dataPromx').modal('show');
       				 }
       		});
           return 0;
         } else {
           swal("Error al guardar", "Ha ocurrido un error no se puede guardar.", "error");
         }
       }
  })

}
</script>
