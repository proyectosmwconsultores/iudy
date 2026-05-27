<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdPlan = $_POST['employee_id'];
  $sql = $db->query("SELECT
tblp_plantemas.IdTema,
tblp_plantemas.Tema,
tblp_plantemas.Cuatrimestre,
tblp_plantemas.Complejidad,
tblc_abreviatura.Abreviatura
FROM
tblp_plantemas
Left Join tblc_abreviatura ON tblc_abreviatura.Id = tblp_plantemas.Cuatrimestre WHERE tblp_plantemas.IdPlan = '$IdPlan' ORDER BY
tblp_plantemas.Cuatrimestre ASC");

$sql9 = $db->query("SELECT * FROM tblp_plan WHERE tblp_plan.IdPlan = '$IdPlan'");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$IdOferta = $datos91["IdOferta"];

?>
  <div class="box-info">
            <form class="form-horizontal" name="frmT5" id="frmT5" action="addTemas.php" method="POST" enctype="multipart/form-data">
              <input id="IdPlan" name="IdPlan" value="<?php echo $IdPlan; ?>" type="hidden"/>
              <input id="IdOferta" name="IdOferta" value="<?php echo $IdOferta; ?>" type="hidden"/>
              <input id="TipoGuardar" name="TipoGuardar" value="addTemas" type="hidden"/>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Tendencias y temas actuales:</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" id="txtTemas" name="txtTemas">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 control-label">Cuatrimestre:</label>
                  <div class="col-sm-6">
                    <select class="form-control" name="txtCuatri" id="txtCuatri">
                      <option value=""> - Seleccione - </option>
                      <option value="1"> 1er cuatrimestre </option>
                      <option value="2"> 2do cuatrimestre </option>
                      <option value="3"> 3er cuatrimestre </option>
                      <option value="4"> 4to cuatrimestre </option>
                      <option value="5"> 5to cuatrimestre </option>
                      <option value="6"> 6to cuatrimestre </option>
                      <option value="7"> 7mo cuatrimestre </option>
                      <option value="8"> 8vo cuatrimestre </option>
                      <option value="9"> 9no cuatrimestre </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 control-label">Complejidad:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="txtComplejidad" id="txtComplejidad">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 control-label">Departamento que apoya el proyecto:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="txtDepartamento" id="txtDepartamento">
                  </div>
                </div>

              </div>
              <div class="box-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-info pull-right" onclick="addTemas()"><i class="fa fa-fw fa-save"></i> Agregar </button>
              </div>
            </form>
          </div>

          <table class="table table-striped">
                <tbody>
                  <tr>
                    <th></th>
                    <th>Tendencias y temas actuales</th>
                    <th>Cuatrimestre</th>
                    <th>Complejidad</th>
                </tr>
                <?php while($x = $db->recorrer($sql)){ ?>
                <tr>
                  <td><button onclick="delTemas(<?php echo $x["IdTema"]; ?>,<?php echo $IdPlan; ?>)" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-trash"></i></button></td>
                  <td><?php echo $x["Tema"]; ?></td>
                  <td><?php echo $x["Cuatrimestre"].$x["Abreviatura"]; ?> Cuatrimestre</td>
                  <td><?php echo $x["Complejidad"]; ?></td>
                </tr>
                <?php } ?>
              </tbody></table>
          <?php
}
?>
