<?php
include('../hace.php');
if(isset($_POST["IdOferta"])){
  $output = '';
  $IdOferta =  $_POST["IdOferta"];
  $IdCampus =  $_POST["IdCampus"];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT IdGrado FROM tblp_educativa WHERE tblp_educativa.IdEducativa =  '$IdOferta'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $IdGrado = $datos91["IdGrado"];

  $sql = $db->query("SELECT * FROM tblp_grupo WHERE tblp_grupo.Tipo = 'Abierto' AND tblp_grupo.IdOferta = '$IdOferta' AND tblp_grupo.IdCampus = '$IdCampus'");
?>


  <form name="frm" id="frm" action="addGrupo.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Clave grupo que desea cerrar:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-gears"></i>
              </div>
              <select class="form-control" name="txtGrupoCer" id="txtGrupoCer" >
                <option value=""> - Seleccione - </option>
                <?php while($x = $db->recorrer($sql)){ ?>
                <option value="<?php echo $x["IdGrupo"]; ?>"  ><?php echo $x["CveGrupo"]; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>&nbsp;</label>
            <div class="input-group">
              <button type="button" class="btn btn-block btn-danger" onClick="val_cerrarGrupo()"> CERRAR GRUPO</button>
            </div>
          </div>
        </div>
        </div>
      </div>
    </table>
  </div>
  </form>
<?php } ?>
