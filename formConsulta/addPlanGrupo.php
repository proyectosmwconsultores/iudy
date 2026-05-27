<?php
session_start();
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();



  $IdPlan = $_POST['employee_id'];
  $sql9 = $db->query("SELECT * FROM tblp_plan WHERE tblp_plan.IdPlan =  '$IdPlan'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdCampus = $datos91["IdCampus"];
  $IdOferta = $datos91["IdOferta"];
  $IdCiclo = $datos91["IdCiclo"];
  $Modalidad = $datos91["Modalidad"];
  $IdEstatus = $datos91["IdEstatus"];
  $FecAprob = $datos91["FecAprob"];


  $sql = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.FecCap,
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Turno,
tblp_grupo.Modalidad,
tblp_grupo.IdCampus,
tblp_grupo.IdOferta,
tblc_ciclo.Ciclo
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_ciclogrupo.IdCiclo WHERE
 tblc_ciclogrupo.IdCiclo = '$IdCiclo' AND tblp_grupo.IdCampus = '$IdCampus' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.Modalidad = '$Modalidad'
");

?>

  <div class="box-info">
            <form class="form-horizontal" name="frmT5" id="frmT5" action="addPlanGrupo.php" method="POST" enctype="multipart/form-data">
              <input id="IdPlan" name="IdPlan" value="<?php echo $IdPlan; ?>" type="hidden"/>
            <input id="TipoGuardar" name="TipoGuardar" value="addPlanAsig" type="hidden"/>

<h4><b style="color: red;">NOTA:</b> debe seleccionar el grupo en donde se implentará el plan de proyecto.</h4>

              <div class="box-body">
                <table class="table table-striped">
                <tbody>
                  <tr>
                  <th style="width: 10px"></th>
                  <th>Grupo</th>
                  <th>Descripci&oacute;n</th>
                  <th>Ciclo</th>
                </tr>
                <?php while($x = $db->recorrer($sql)){ $IdG = $x["IdGrupo"];
                  $sql6 = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.IdGrupo =  '$IdG'");
                  $db->rows($sql6);
                  $datos61 = $db->recorrer($sql6);
                  $IdPlanX = $datos61["IdPlan"];


                   ?>
                <tr>
                  <td>
                    <?php if($IdPlanX) {
                      if($IdPlanX == $IdPlan){ ?>
                          <button onclick="del_grupoPlan(<?php echo $IdG; ?>, <?php echo $IdPlan; ?>)" type="button" class="btn btn-block btn-success btn-xs"><i class="fa fa-fw fa-check-circle"></i></button>
                      <?php } else { ?>
                        <button type="button" class="btn btn-block btn-info btn-xs"><i class="fa fa-fw fa-check-circle"></i></button>
                      <?php } ?>

                  <?php } else { ?>
                    <button onclick="add_grupoPlan(<?php echo $IdG; ?>, <?php echo $IdPlan; ?>)" type="button" class="btn btn-block btn-dafault btn-xs"><i class="fa fa-fw fa-times-circle"></i></button>
                  <?php } ?>
                  </td>
                  <td><?php echo $x["CveGrupo"]; ?></td>
                  <td><?php echo $x["Descripcion"]; ?></td>
                  <td><?php echo $x["Ciclo"]; ?></td>

                </tr><?php } ?>
              </tbody></table>
              </div>

              <?php if($IdEstatus == 3){ ?>
              <div class="form-group">
                <label class="col-sm-6 control-label">Estatus del plan de proyecto:</label>
                <div class="col-sm-6">
                  <select class="form-control" name="txtEstatusX" id="txtEstatusX">
                    <option value=""> - Seleccione - </option>
                    <option value="4" >Aprobado</option>
                  </select>

                </div>
                <div class="col-sm-12">
                  <button onclick="aprobarPlan(<?php echo $IdPlan; ?>,<?php echo $_SESSION["IdUsua"]; ?>)" type="button" style="float: right;" class="btn btn-success btn-flat"> <i class="fa fa-fw fa-save"></i> Guardar</button>
                </div>

              </div><?php } else { ?>
                <div class="form-group">
                  <label class="col-sm-6 control-label">Estatus del plan de proyecto:</label>
                  <label class="col-sm-6 control-label">Aprobado / <?php echo $FecAprob; ?></label>



                </div>
              <?php  } ?>

            </form>
          </div>

          <?php
}
?>
