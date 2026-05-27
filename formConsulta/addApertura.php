<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $Tipo = $_POST["Tipo"];
  $IdCiclo = $_POST['employee_id'];

  $sql = $db->query("SELECT * FROM tblc_apertura WHERE tblc_apertura.IdCiclo = '$IdCiclo' AND tblc_apertura.Tipo = '$Tipo'");

?>
  <div class="box-info">
            <form class="form-horizontal" name="frm" id="frm" action="addSubPeriodo.php" method="POST" enctype="multipart/form-data">
              <input id="IdCiclo" name="IdCiclo" value="<?php echo $IdCiclo; ?>" type="hidden"/>
            <input id="Tipo" name="Tipo" value="<?php echo $Tipo; ?>" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Seleccione parcial:</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="txtParcial" id="txtParcial">
                      <option value="">- Seleccione -</option>
                      <option value="1">Parcial 1</option>
                      <?php if($Tipo == "E"){ ?>
                      <option value="2">Parcial 2</option>
                      <option value="3">Parcial 3</option>
                      <option value="4">Parcial 4</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Fecha final:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" placeholder="Mes final" id="datepicker4" name="datepicker4">
                  </div>
                </div>



              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info pull-right" onclick="addApertura()">Agregar</button>
              </div>
            </form>
          </div>

          <table class="table table-striped">
                <tbody>
                  <tr>
                    <th>#</th>
                    <th>Parcial</th>
                    <th>Fecha</th>
                </tr>
              <?php while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td><button onclick="delApertura(<?php echo $x["IdApertura"]; ?>, <?php echo $IdCiclo ?>)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td>Parcial <?php echo $x["NoParcial"]; ?></td>
                  <td><?php echo obtenerFechaEnLetra($x["Fecha"]); ?></td>
                </tr>
                <?php } ?>
              </tbody></table>
          <?php
}
?>

<script>

  $(function () {

    $('#datepicker4').datepicker({
      autoclose: true
    })

  })
</script>
