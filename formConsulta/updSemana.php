<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdSemanaDoc = $_POST["IdSemana"];


$sql9 = $db->query("SELECT * FROM tblp_semanadocente WHERE tblp_semanadocente.IdSemanaDocente = '$IdSemanaDoc' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


  ?>
  <form name="frm2sFar" id="frm2sFar" action="updSemana.php" method="POST" enctype="multipart/form-data">
    <input id="IdSemanaDoc" name="IdSemanaDoc" value="<?php echo $IdSemanaDoc; ?>" type="hidden"/>
    <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $datos91["IdParcialDocente"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updSemana" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-5">
            <div class="form-group">
              <label>Nombre de la etiqueta:</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-black-tie"></i>
                </div>
                <input name="txt_Semana" id="txt_Semana" class="form-control" value="<?php echo $datos91["Etiqueta_semana"]; ?>" >
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="form-group">
              <label>Tema:</label>
                <input name="txt_Tema" id="txt_Tema" class="form-control" value="<?php echo $datos91["Semana"]; ?>" >
            </div>
          </div>
          
          <div class="col-md-12">
            <div class="form-group">
              <label>Objetivo sobre el contenido temático:</label>
                <input name="txt_temax" id="txt_temax" class="form-control" value="<?php echo $datos91["Tematica"]; ?>" >
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label>Subtemas:</label>
                <textarea name="txtTemasXd" id="txtTemasXd" class="textarea_upf" placeholder="Escriba el tema y subtemas de la semana..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $datos91["Temas"]; ?></textarea>
            </div>
          </div>






        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updSemana()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
  <script>
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea_upf').wysihtml5()
  })
  </script>
