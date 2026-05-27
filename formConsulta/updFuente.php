<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdFuente = $_POST["IdFuente"];
$IdPlaneacion = $_POST["IdPlaneacion"];



$sql9 = $db->query("SELECT * FROM tblp_fuentedocente WHERE tblp_fuentedocente.IdFuente = '$IdFuente' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


  ?>
  <form name="frm2sFer" id="frm2sFer" action="updFuente.php" method="POST" enctype="multipart/form-data">
    <input id="IdFuente" name="IdFuente" value="<?php echo $IdFuente; ?>" type="hidden"/>
    <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $datos91["IdParcialDocente"]; ?>" type="hidden"/>
    <input id="TipoGuardar" name="TipoGuardar" value="updFuente" type="hidden"/>
    <input id="Permisos" name="Permisos" value="<?php echo $_SESSION["Permisos"]; ?>" type="hidden"/>
    <input id="IdUsua" name="IdUsua" value="<?php echo $datos91["IdUsua"]; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $datos91["IdAsignacion"]; ?>" type="hidden"/>
    <input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $IdPlaneacion; ?>" type="hidden"/>

  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <div class="col-md-12">
            <div class="form-group">
              <label>Fuente de consulta:</label>
                <textarea name="txtFuenteA" id="txtFuenteA" class="textarea" placeholder="Escriba el tema y subtemas de la semana..." style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $datos91["Fuente"]; ?></textarea>
            </div>
          </div>






        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-fw fa-times-circle"></i> Cancelar</button>
          <button type="button" class="btn btn-primary pull-right" onClick="updFuente()"> <i class="fa fa-fw fa-refresh"></i> Actualizar</button>
        </div>
      </div>
    </table>
  </div>

  </form>
  <script>
  $(function () {

    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
  </script>
