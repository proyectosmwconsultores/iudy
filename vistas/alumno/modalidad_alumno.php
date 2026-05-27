<?php
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$user = $formatos->get_datos_alumno_id($IdUsua);

?>

<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-3 control-label">Tipo de término:</label>
      <div class="col-sm-9">
      <select class="form-control" name="txt_termino_alumno" id="txt_termino_alumno">
            <option value=""> - Seleccione - </option>
            <?php if($user[0]['IdOferta'] == 30){ ?>
              <option value="2" <?php if ($user[0]["Termino"] == 2) { ?>selected="selected" <?php } ?>> Clinica</option>
              <option value="3" <?php if ($user[0]["Termino"] == 3) { ?>selected="selected" <?php } ?>> Organización</option>
              <option value="4" <?php if ($user[0]["Termino"] == 4) { ?>selected="selected" <?php } ?>> Educativa</option>
            <?php } else { ?>
              <option value="1" <?php if ($user[0]["Termino"] == 1) { ?>selected="selected" <?php } ?>> Normal</option>
            <?php } ?>
            
            
          </select>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button onclick="upd_modalidad_alumno(<?php echo $IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-refresh"></i> Actualizar término</button>
  </div>
</form>
