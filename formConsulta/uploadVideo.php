<?php
include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_videos WHERE tblp_videos.IdVideo = '".$_POST["employee_id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);
?>
<link rel="stylesheet" href="main.css">
  <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Nombre: <?php echo $datos91["Titulo"]; ?> </h4>
  </div>

          <div class="principal">
            <form action="" id="form_subir" class="form-horizontal">
              <input id="IdVideo" name="IdVideo" value="<?php echo $datos91["IdVideo"]; ?>" type="hidden"/>
              <input id="IdTipo" name="IdTipo" value="1" type="hidden"/>

              <div class="form-group">
                  <label for="inputEmail4" class="col-sm-2 control-label">Buscar archivo:</label>
                  <div class="col-sm-8">
                    <input type="file" name="archivo" id="archivo" required onchange="validarVideo(this,'archivo');">
                  </div>
                </div>
                <div class="form-group" name="imgLoadDoDoc" id="imgLoadDoDoc" style="display: none;">
                  <div class="col-sm-8" style="text-align: center;">
                      <img src="assets/images/cargando.gif" style=" width: 30%; position: absolute; z-index:99999;">
                  </div>
                </div>




              <div class="barra" id="barra" style="display: none;">
                <div class="barra_azul" id="barra_estado">
                  <span></span>
                </div>
              </div>

<br>
              <div class="box-footer">
                <button name="btnSalir" id="btnSalir" data-dismiss="modal" class="btn btn-default">Salir</button>
                <input name="bntSubir" id="bntSubir" type="button"  onclick="val_upload()" class="btn btn-info pull-right" value="Subir video">
              </div>
            </form>
          </div>
