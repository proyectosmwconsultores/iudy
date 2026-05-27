<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];
  $sql9 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua' ");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
  ?>
  <form name="frm2" class="form-horizontal" id="frm2" action="addGrado.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
    <div class="col-md-12">
      <div class="form-group">
        <label>Mi semblanza:</label>
          <textarea name="txtSemblanza" id="txtSemblanza" class="textarea" placeholder="Escriba su semblanza, si asi lo desea..." style="width: 100%; height: 280px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $datos91["Semblanza"]; ?></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" onClick="saveSemblanza()">Guardar</button>
    </div>


  </form>
<script>
$(function () {
  //bootstrap WYSIHTML5 - text editor
  $('.textarea').wysihtml5()
})
</script>
