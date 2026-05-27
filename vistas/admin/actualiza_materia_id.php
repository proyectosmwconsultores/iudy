<?php
  session_start();
  require('../../php/clases/class.System.php');
  $db = new Conexion();
  $IdModulo = $_POST["IdModulo"];

  $sql9 = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.Seriada, tblp_modulo.IdSeriada, tblp_modulo.IdCampus, tblp_modulo.IdEducativa, tblp_modulo.Grado, tblp_modulo.NombreMod, tblp_educativa.Nombre FROM tblp_modulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_modulo.IdEducativa WHERE tblp_modulo.IdModulo = '$IdModulo'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $grado = $datos91["Grado"] + 1;
  $grado2 = $datos91["Grado"] + 2;

  $seriadas = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.Seriada  = '1' AND tblp_modulo.IdCampus = '".$datos91["IdCampus"]."' AND tblp_modulo.IdEducativa = '".$datos91["IdEducativa"]."' AND ((tblp_modulo.Grado >= '$grado') || (tblp_modulo.Grado < '$grado2')) ORDER BY tblp_modulo.NombreMod ASC ");

  ?>
  <form name="frm5Vkb" id="frm5Vkb" action="materiaAvance.php" method="POST" enctype="multipart/form-data">
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">


        <div class="col-md-12">
          <div class="bg-green color-palette" style="padding: 10px; color: red;"><span> <?php echo $datos91["Nombre"]; ?></span></div>
          <div class="bg-purple color-palette" style="padding: 10px; color: black;"><span> <?php echo $datos91["CodeModulo"].' - '.$datos91["NombreMod"]; ?></span></div><br>

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
                <option value="10" <?php if($datos91["Grado"] == 10){ ?>selected="selected"<?php } ?> > 10m Cuatrimestre</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Clave materia:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input class="form-control" type="text" name="txtCode" id="txtCode" value="<?php echo $datos91["CodeModulo"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre de la materia:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <input class="form-control" type="text" name="txtNombre" id="txtNombre" value="<?php echo $datos91["NombreMod"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Materia seriada con:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-qrcode"></i>
              </div>
              <select class="form-control" style="width: 100%;" name="txtSeriada" id="txtSeriada">
                <option value=""> - Seleccione - </option>
                <?php while ($_seriada = $db->recorrer($seriadas)) {  ?>
                <option value="<?php echo $_seriada['IdModulo']; ?>" <?php if($_seriada["IdModulo"] == $datos91["IdSeriada"]){ ?>selected="selected"<?php } ?> > <?php echo $_seriada['NombreMod']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <?php if($datos91["Seriada"] == 1){ ?>
            <button type="button" class="btn bg-navy btn-flat pull-left"><i class="fa fa-check-circle"></i> Materia seriada</button>
            <button type="button" onclick="marcar_seridada(<?php echo $IdModulo; ?>, 0)" class="btn bg-olive btn-flat pull-left"><i class="fa fa-times-circle"></i> Cancelar materia seriada</button>
          <?php } else { ?>
            <button type="button" onclick="marcar_seridada(<?php echo $IdModulo; ?>, 1)" class="btn bg-orange btn-flat pull-left"><i class="fa fa-info-circle"></i> Marcar como materia seriada</button>
          <?php } ?>
          
          <button type="button" class="btn bg-info btn-flat" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn bg-purple btn-flat" onClick="actualizar_materia_id(<?php echo $IdModulo; ?>)"> <i class="fa fa-fw fa-save"></i> Guardar</button>
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
