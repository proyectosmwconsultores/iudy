<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdParcialDoc = $_POST["IdParcial"];
$idp = $_SESSION['noPar'];
$sql9 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '$IdParcialDoc' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);
$IdAs =  $datos91["IdAsignacion"];

  ?>
  <form name="frm2arTe" id="frm2arTe" action="updParcial.php" method="POST" enctype="multipart/form-data">
    <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $IdParcialDoc; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updParcial" type="hidden"/>

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
              <input type="text" class="form-control" id="txt_Titulo" name="txt_Titulo" value="<?php echo $datos91["Titulo"]; ?>">
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
                    <input name="txt_Extra" id="txt_Extra" type="checkbox" <?php if($datos91["Tipo"] == 'E'){ echo "checked"; } ?>> Marcar como extraordinario.
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label>Nombre del tema general:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-cc-diners-club"></i>
              </div>
              <input type="text" class="form-control pull-right" id="txtTema" name="txtTema" value="<?php echo $datos91["Tema"]; ?>">
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
              <textarea type="text" class="form-control pull-right" id="txtObjetivoX" name="txtObjetivoX"><?php echo $datos91["Objetivo"]; ?></textarea>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Inicio parcial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker1XpU" name="datepicker1XpU" value="<?php echo $datos91["FecIni"]; ?>">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Final parcial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker2XpU" name="datepicker2XpU" value="<?php echo $datos91["FecFin"]; ?>">
            </div>
          </div>
        </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updParcial()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
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
  $('#datepicker1XpU').datepicker({
    autoclose: true
  })
//Date picker
  $('#datepicker2XpU').datepicker({
    autoclose: true
  })


})

</script>
