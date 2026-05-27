<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.php');
$t = new Trabajo();
$recursosId = $t->get_recursosId();
$lst_actividad = $t->lst_actividad($_POST["idToks"]);
?>

<form name="frm" id="frm" action="doAddRecurso.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
  <input id="Mov" name="Mov" type="hidden" />

  <input id="Id" name="Id" value="<?php echo $_POST["idToks"]; ?>" type="hidden" />
  <input id="Tipo" name="Tipo" value="0" type="hidden" />
  <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
  <div class="form-group">
    <label for="inputSkills" class="col-sm-3 control-label">Tipo de recurso:</label>
    <div class="col-sm-9">
      <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
        <option value=""> - Seleccione - </option>
        <?php for ($i = 0; $i < sizeof($recursosId); $i++) { ?>
          <option value="<?php echo $recursosId[$i]["IdTema"]; ?>"><?php echo $recursosId[$i]["Descripcion"]; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputSkills" class="col-sm-3 control-label">Actividad:</label>
    <div class="col-sm-9">
      <select class="form-control" name="txtIdActividad" id="txtIdActividad">
        <option value=""> - Seleccione - </option>
        <?php for ($i = 0; $i < sizeof($lst_actividad); $i++) { ?>
          <option value="<?php echo $lst_actividad[$i]["IdActividadesDocente"]; ?>"><?php echo $lst_actividad[$i]["NomActividad"]; ?> - (<?php echo $lst_actividad[$i]["TipoActividad"]; ?>)</option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputSkills" class="col-sm-3 control-label">Nombre:</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" placeholder="Título" id="txtNombre" name="txtNombre">
    </div>
  </div>


  <div class="form-group" name="imgLoadRecurso" id="imgLoadRecurso" style="display: none;">
    <div class="col-sm-12" style="text-align: center;">
      <img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
    </div>
  </div>
  <div class="form-group" name="video" id="video" style="display: none;">
    <label for="inputSkills" class="col-sm-3 control-label">Incorporar (iframe):</label>
    <div class="col-sm-9">
      <div class="box-body pad">
        <textarea class="form-control" rows="3" name="txtVideo" id="txtVideo" class="textarea" placeholder="Pegue el iframe de lo quiere compartir"></textarea>
      </div>
    </div>
  </div>
  <div class="form-group" name="link" id="link" style="display: none;">
    <label for="inputSkills" class="col-sm-3 control-label">URL (Link):</label>
    <div class="col-sm-9">
      <div class="box-body pad">
        <textarea class="form-control" rows="3" name="txtLink" id="txtLink" class="textarea" placeholder="Pegue el URL que quiere compartir"></textarea>
      </div>
    </div>
  </div>

  <div class="form-group" name="div3" id="div3" style="display: none;">
    <label for="inputSkills" class="col-sm-3 control-label">Buscar:</label>
    <div class="col-sm-9">
      <input type="file" class="form-control" placeholder="Buscar" id="archivo" name="archivo" onchange="ValRecursoPDF(this);">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-6 col-sm-6">
      <button type="button" id="btnRecurso" name="btnRecurso" class="btn btn-primary" onClick="upload_recurso_id()"><i class="fa fa-save"></i> Guardar</button>
    </div>
  </div>
</form>

<script>
  $(document).ready(function() {
    $("select").change(function() {
      var tipo = document.getElementById("txtTipoDoc").value;
      if (tipo == 10) {
        document.getElementById("Tipo").value = '2';
        document.getElementById("link").style.display = 'block';
        document.getElementById("div3").style.display = 'none';
        document.getElementById("video").style.display = 'none';
      } else if ((tipo == 7) || (tipo == 8)) {
        document.getElementById("Tipo").value = '1';
        document.getElementById("div3").style.display = 'none';
        document.getElementById("link").style.display = 'none';
        document.getElementById("video").style.display = 'block';
      } else {
        document.getElementById("Tipo").value = '0';
        document.getElementById("div3").style.display = 'block';
        document.getElementById("link").style.display = 'none';
        document.getElementById("video").style.display = 'none';
      }

      //document.getElementById("div3").style.display = 'none'

    });
  });
</script>