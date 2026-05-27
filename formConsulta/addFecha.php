<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
   $IdAsignacion = $_POST["employee_id"];

  $sql = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdAsignacion = '$IdAsignacion' ORDER BY tblp_parcialdocente.NoParcial ASC");

  ?>
  <form name="frm2" id="frm2" action="addActividad.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion; ?>" type="hidden"/>
  <table class="table table-condensed">
      <tr>
        <th>Parcial</th>
        <th>Inicia parcial</th>
        <th>Finaliza parcial</th>
        <th>Fecha final para<br>subir calificaciones</th>
        <th>-</th>
      </tr>
    <?php while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td>Parcial <?php echo $x["NoParcial"]; ?></td>
                  <td><?php echo $x["FecIni"]; ?></td>
                  <td><?php echo $x["FecFin"]; ?></td>
                  <td><input type="text" class="form-control pull-right" value="<?php echo $x["Fecha"]; ?>" id="datepicker1-<?php echo $x["IdParcialDocente"]; ?>" name="datepicker1-<?php echo $x["IdParcialDocente"]; ?>"></td>
                  <td>
                    <button type="button" onclick="addFechaFin(<?php echo $x["IdParcialDocente"]; ?>)" class="btn btn-primary" href="javascript:void(0);" style="float: center;"><i class="fa fa-save"></i></button>
                  </td>
                </tr>
              <?php } ?>


              </tbody></table>
        </form>
  <?php
}
?>
<!-- <script>
$(function () {
  //Date picker
  $('#datepicker1').datepicker({
    autoclose: true
  })

})
</script> -->
