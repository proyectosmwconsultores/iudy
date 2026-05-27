<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdAs = $_SESSION["IdAsignacion"];

  ?>
  <form name="frm2dHa" id="frm2dHa" action="addActividad.php" method="POST" enctype="multipart/form-data">
    <input id="IdOferta" name="IdOferta" value="<?php echo $_POST["IdOferta"]; ?>" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdParcial" name="IdParcial" value="<?php echo $_POST["IdParcial"]; ?>" type="hidden"/>
    <input id="IdSemana" name="IdSemana" value="<?php echo $_POST["IdSemana"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savFuente" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-12">
          <div class="form-group">
            <label>Fuente de consulta:</label>
              <textarea name="txtDescripcion" id="txtDescripcion" class="textarea" placeholder="Escriba la descripción de la actividad..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="saveFuente()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>

  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap datepicker -->
  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- bootstrap color picker -->
  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
  <!-- bootstrap time picker-->
  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script>
$(function () {
  //Date picker
  $('#datepicker1').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker2').datepicker({
    autoclose: true
  })

  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})
</script>
