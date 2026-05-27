<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
$IdModulo = $_POST["IdModulo"];

  $sql9 = $db->query("SELECT
tblp_modulo.IdModulo,
tblp_modulo.CodeModulo,
tblp_modulo.Grado,
tblp_modulo.NombreMod,
tblp_educativa.Nombre
FROM
tblp_modulo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa
 WHERE tblp_modulo.IdModulo = '$IdModulo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  ?>
  <form name="frm5Vkb" id="frm5Vkb" action="materiaAvance.php" method="POST" enctype="multipart/form-data">
    <input id="TipoGuardar" name="TipoGuardar" value="matAvance" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">


        <div class="col-md-12">
          <div class="bg-green disabled color-palette" style="padding: 10px;"><span> <?php echo $datos91["Nombre"]; ?></span></div>
          <div class="bg-purple disabled color-palette" style="padding: 10px;"><span> <?php echo $datos91["CodeModulo"].' - '.$datos91["NombreMod"]; ?></span></div><br>

        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Cuatrimestre en el que se implementar&aacute;:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-book"></i>
              </div>
              <select class="form-control select2" style="width: 100%;" name="txtIdGrado" id="txtIdGrado">
                <option value=""> - Seleccione - </option>
                <option value="1" <?php if($datos91["Grado"] == 1){ ?>selected="selected"<?php } ?> > 1er Cuatrimestre</option>
                <option value="2" <?php if($datos91["Grado"] == 2){ ?>selected="selected"<?php } ?> > 2do Cuatrimestre</option>
                <option value="3" <?php if($datos91["Grado"] == 3){ ?>selected="selected"<?php } ?> > 3er Cuatrimestre</option>
                <option value="4" <?php if($datos91["Grado"] == 4){ ?>selected="selected"<?php } ?> > 4to Cuatrimestre</option>
                <option value="5" <?php if($datos91["Grado"] == 5){ ?>selected="selected"<?php } ?> > 5to Cuatrimestre</option>
                <option value="6" <?php if($datos91["Grado"] == 6){ ?>selected="selected"<?php } ?> > 6to Cuatrimestre</option>
                <option value="7" <?php if($datos91["Grado"] == 7){ ?>selected="selected"<?php } ?> > 7mo Cuatrimestre</option>
                <option value="8" <?php if($datos91["Grado"] == 8){ ?>selected="selected"<?php } ?> > 8vo Cuatrimestre</option>
                <option value="9" <?php if($datos91["Grado"] == 9){ ?>selected="selected"<?php } ?> > 9no Cuatrimestre</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>CodeModulo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input class="form-control" type="text" name="txtCode" id="txtCode" value="<?php echo $datos91["CodeModulo"]; ?>">
            </div>
          </div>
        </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" onClick="matAvance()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>
$(function () {
  $('.select2').select2()

})
</script>
