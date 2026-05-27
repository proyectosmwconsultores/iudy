<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];
$IdCiclo = $_POST["IdCiclo"];

?>


<form role="form">
  <div class="box-body">


    <div class="form-group">
      <label>Observaciones de la inscripcion especial:</label>
      <textarea name="txt_comen_seg" id="txt_comen_seg" class="form-control" rows="3" placeholder="Comentario adicional ..."></textarea>
    </div>

  </div>

  <div class="box-footer">
    <button type="button" class="btn btn-block btn-info" onclick="add_inscripcion_especial(<?php echo $IdUsua; ?>,<?php echo $IdCiclo; ?>,<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-save"></i> Generar inscripción</button>
  </div>
</form>
