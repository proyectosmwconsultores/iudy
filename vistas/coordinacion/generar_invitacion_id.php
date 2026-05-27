<?php session_start();
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];
$IdGrupo = $_POST['IdGrupo'];

$porciones = explode("_", $IdGrupo);
$IdGrupo = $porciones[0]; // porción1
$Grado =  $porciones[1]; // porción2

require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$grupos = $formatos->get_grupos_invitacion($IdCiclo, $IdCampus);
$materias = $formatos->get_materias_grupo_id($IdGrupo);
$docente = $formatos->get_docentes();
$coordinador = $formatos->get_coordinadores_lst();



?>

<form class="form-horizontal">
  <div class="box-body">
    
  
    <div class="form-group">
      <label class="col-sm-2 control-label">Grupo:</label>
      <div class="col-sm-10">
        <select class="form-control select2" name="txt_grupo_sel" id="txt_grupo_sel" style="width: 100%;" onchange="recargar_ventana(<?php echo $IdCampus; ?>,<?php echo $IdCiclo; ?>)">
          <option value=""> - Seleccione - </option>
          <?php for ($x = 0; $x < sizeof($grupos); $x++) {
            $_grado = $grupos[$x]["Grado"] + 1;
            ?>
            <option value="<?php echo $grupos[$x]["IdGrupo"]; ?>_<?php echo $_grado; ?>" <?php if ($grupos[$x]["IdGrupo"] == $IdGrupo) { ?>selected="selected" <?php } ?>> <?php echo $_grado; ?>° <?php echo $grupos[$x]["CveGrupo"]; ?> - <?php echo $grupos[$x]["Abreviatura"]; ?> (<?php echo $grupos[$x]["_Dias"]; ?>) </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword3" class="col-sm-2 control-label">Materia:</label>

      <div class="col-sm-10">
      <select class="form-control select2" name="txt_materia_sel" id="txt_materia_sel" style="width: 100%;">
          <option value=""> - Seleccione - </option>
          <?php for ($x = 0; $x < sizeof($materias); $x++) { 
            $asignado = $formatos->get_valida_asignacion($materias[$x]["IdModulo"], $materias[$x]["IdEducativa"], $IdGrupo);
            if(!isset($asignado[0][0])){
            ?>
            <option value="<?php echo $materias[$x]["IdModulo"]; ?>" > <?php echo $materias[$x]["Grado"]; ?>° - <?php echo $materias[$x]["CodeModulo"]; ?> <?php echo $materias[$x]["NombreMod"]; ?></option>
          <?php } } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Docente:</label>
      <div class="col-sm-10">
        <select class="form-control select2" name="txt_docente_sel" id="txt_docente_sel" style="width: 100%;">
          <option value=""> - Seleccione - </option>
          <?php for ($x = 0; $x < sizeof($docente); $x++) { ?>
            <option value="<?php echo $docente[$x]["IdUsua"]; ?>"> <?php echo $docente[$x]["Nombre"]; ?> <?php echo $docente[$x]["APaterno"]; ?> <?php echo $docente[$x]["AMaterno"]; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Coordinador:</label>
      <div class="col-sm-10">
        <select class="form-control select2" name="txt_coordinador_sel" id="txt_coordinador_sel" style="width: 100%;">
          <option value=""> - Seleccione - </option>
          <?php for ($x = 0; $x < sizeof($coordinador); $x++) { ?>
            <option value="<?php echo $coordinador[$x]["IdUsua"]; ?>"> <?php echo $coordinador[$x]["Nombre"]; ?> <?php echo $coordinador[$x]["APaterno"]; ?> <?php echo $coordinador[$x]["AMaterno"]; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Fecha inicial:</label>
      <div class="col-sm-4">
      <input type="text" class="form-control pull-right" id="txt_fecha_ini" name="txt_fecha_ini">
      </div>
      <label class="col-sm-2 control-label">Fecha final:</label>
      <div class="col-sm-4">
      <input type="text" class="form-control pull-right" id="txt_fecha_fin" name="txt_fecha_fin">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button type="button" onclick="generar_invitacion_id(<?php echo $IdCampus; ?>,<?php echo $IdCiclo; ?>)" class="btn btn-info pull-right"><i class="fa fa-fw fa-send"></i> Generar invitación </button>
  </div>
</form>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

<script>
  	$(function() {
			$('#txt_fecha_ini').datepicker({
				autoclose: true
			})
      $('#txt_fecha_fin').datepicker({
				autoclose: true
			})
		})


  $(function() {
			$('.select2').select2()

		})
</script>