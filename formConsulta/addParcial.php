<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  // $IdPlaneacion = $_POST["IdPlaneacion"];
  $idp = $_SESSION['noPar'];
  ?>
  <form name="frm2iYue" id="frm2iYue" action="addParcial.php" method="POST" enctype="multipart/form-data">
    <input id="IdOferta" name="IdOferta" value="<?php echo $_POST["IdOferta"]; ?>" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="Curso" name="Curso" value="<?php echo $_SESSION["curso"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savParcial" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-7">
          <div class="form-group">
            <label>Nombre de la etiqueta:</label> (Parcial / Módulo / Periodo)
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-black-tie"></i>
              </div>
              <input type="text" class="form-control" id="txtEtiqueta" name="txtEtiqueta">
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <label>Ajuste:</label>
            <div class="input-group">

              <div class="col-sm-12">
                <div class="checkbox">
                  <label>
                    <input name="txtExtra" id="txtExtra" type="checkbox"> Marcar como extraordinario.
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre del tema:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-cc-diners-club"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtTema" name="txtTema">
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Objetivo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-bolt"></i>
              </div>
              <textarea type="text" class="form-control pull-right" id="txtObjetivoP" name="txtObjetivoP"></textarea>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha de inicio:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker1Xp" name="datepicker1Xp">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Fecha final:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker2Xp" name="datepicker2Xp">
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="saveParcial()"><i class="fa fa-fw fa-save"></i> Guardar</button>
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
  $('#datepicker1Xp').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker2Xp').datepicker({
    autoclose: true
  })

  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})

</script>
