<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql9 = $db->query("SELECT * FROM tblp_parcialdocente WHERE tblp_parcialdocente.IdParcialDocente = '".$_POST["IdParcial"]."' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  $NoParcial = $datos91["NoParcial"];
  $Tipo = $datos91["Tipo"];

  ?>
  <form name="frm2sGr" id="frm2sGr" action="addSemana.php" method="POST" enctype="multipart/form-data">
    <input id="IdOferta" name="IdOferta" value="<?php echo $_POST["IdOferta"]; ?>" type="hidden"/>
    <input id="IdModulo" name="IdModulo" value="<?php echo $_POST["IdModulo"]; ?>" type="hidden"/>
    <input id="IdParcial" name="IdParcial" value="<?php echo $_POST["IdParcial"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="savSemana" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
        <div class="col-md-5">
          <div class="form-group">
            <label>Nombre de la etiqueta:</label> (Semana / Unidad)
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-black-tie"></i>
              </div>
              <input name="txtSemana" id="txtSemana" class="form-control" placeholder="Semana 1..." >
            </div>
          </div>
        </div>

        <div class="col-md-7">
          <div class="form-group">
            <label>Tema de la unidad:</label>
              <input name="txtTema" id="txtTema" class="form-control" placeholder="Tema..." >
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Objetivo sobre el contenido temático:</label>
              <input name="txtTematico_" id="txtTematico_" class="form-control" placeholder="Tema..." >
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>Subtemas:</label>
              <textarea name="txtTemas" id="txtTemas" class="textarea1" placeholder="Escriba el tema y subtemas de la semana..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary  pull-right" onClick="saveSemana()"> <i class="fa fa-fw fa-save"></i> Guardar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
<script>
$(function () {
  //bootstrap WYSIHTML5 - text editor
  $('.textarea1').wysihtml5()
})
</script>
