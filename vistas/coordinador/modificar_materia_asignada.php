<?php
$IdMod = $_POST['IdMod'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$materias = $formatos->obtener_materias_rvoe($IdMod);
$_mod = $formatos->obtener_datos_materia_asignada($IdMod);



?>

<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-3 control-label">Materia asignada:</label>
      <div class="col-sm-9">
        <input type="text"class="form-control" disabled value="<?php echo $_mod[0]['CodeModulo'].' '.$_mod[0]['NombreMod']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Docente:</label>
      <div class="col-sm-9">
        <input type="text" name="cer_periodo" disabled id="cer_periodo" class="form-control" value="<?php echo $_mod[0]['Nombre'].' '.$_mod[0]['APaterno'].' '.$_mod[0]['AMaterno']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Materia según RVOE:</label>
      <div class="col-sm-9">
      <select class="form-control" name="txt_modulo_rve" id="txt_modulo_rve">
            <option value=""> - Seleccione - </option>
            <?php for ($i = 0; $i < sizeof($materias); $i++) {  ?>
              <option value="<?php echo $materias[$i]["IdModulo"]; ?>" <?php if ($_mod[0]["_idModulo"] == $materias[$i]["IdModulo"]) { ?>selected="selected" <?php } ?>> <?php echo $materias[$i]["CodeModulo"]; ?> - <?php echo $materias[$i]["NombreMod"]; ?> </option>
            <?php } ?>
          </select>
      </div>
    </div>
  </div>

  <div class="box-footer">
    <button onclick="upd_materia_asig_mod(<?php echo $IdMod; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-refresh"></i> Actualizar materia asignada</button>
  </div>
</form>
