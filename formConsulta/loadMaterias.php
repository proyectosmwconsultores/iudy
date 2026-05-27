<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $porciones = explode("-", $_POST["employee_id"]);
  $IdGrupo =  $porciones[0]; // porción1
  $IdCiclo =  $porciones[1]; // porción2

  $sql = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_modulo.IdEducativa,
tblp_modulo.Grado
FROM
tblp_grupo
Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.IdCampus
WHERE
tblp_grupo.IdGrupo =  '$IdGrupo'
GROUP BY tblp_modulo.Grado");

$sql2 = $db->query("SELECT
tblk_materias.IdMateria,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod,
tblp_modulo.Grado
FROM
tblk_materias
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblk_materias.IdModulo WHERE
tblk_materias.IdGrupo = '$IdGrupo'  AND tblk_materias.IdCiclo = '$IdCiclo'");


  ?>
  <form name="frm2TYjS" id="frm2TYjS" action="loadMaterias.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
    <input id="TipoGuardar" name="TipoGuardar" value="loadMatrs" type="hidden"/>
    <input id="Cargar" name="Cargar" value="<?php echo $_POST["employee_id"]; ?>" type="hidden"/>
    <input id="IdCicloX" name="IdCicloX" value="<?php echo $IdCiclo; ?>" type="hidden"/>
    <input id="IdGrupoX" name="IdGrupoX" value="<?php echo $IdGrupo ?>" type="hidden"/>

              <div class="box-body">
                <table class="table table-striped">
                <tbody><tr>
                  <th>CodeMateria</th>
                  <th>Materia</th>
                </tr>
                <?php $dx = 0;  while($x = $db->recorrer($sql2)){ $dx = 1; ?>
                <tr>
                  <td><?php echo $x["CodeModulo"]; ?></td>
                  <td><?php echo $x["NombreMod"]; ?></td>
                </tr>
              <?php } ?>
              </tbody></table>
              <?php if($dx == 0){ ?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Grado:</label>
                  <div class="col-sm-8">
                    <div class="input-group input-group-sm">
                      <select class="form-control select2" name="txtGradoX" id="txtGradoX">
                        <option value=""> - Seleccione - </option>
                        <?php while($x = $db->recorrer($sql)){ ?>
                        <option value="<?php echo $x["Grado"]; ?>"<?php if($_POST["txtGradoX"]==$x["Grado"]){ ?>selected="selected"<?php }?>>Grado <?php echo $x["Grado"]; ?></option>
                        <?php } ?>
                      </select>

                          <span class="input-group-btn">
                            <button onclick="carMaterias()" type="button" class="btn btn-info btn-flat">Cargar materias</button>
                          </span>
                    </div>

                  </div>
                </div><?php } ?>
              </div>
        </form>
  <?php
}
?>
