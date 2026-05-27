<?php

include('../hace.php');

  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();


  $sql9 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '".$_POST["employee_id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $sql8 = $db->query("SELECT * FROM tblp_tareas WHERE tblp_tareas.IdAsignacion = '".$_POST["IdAsignacion"]."' AND tblp_tareas.IdActividadesDocente = '".$_POST["employee_id"]."' AND tblp_tareas.IdAlumno= '".$_POST["IdUsua"]."'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);

//

?>

<link rel="stylesheet" href="main.css">

       <h4 class="modal-title"><?php echo $datos91["NomActividad"]; ?> </h4>


          <div class="principal">
            <form action="" id="form_subir" class="form-horizontal">
              <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $_POST["employee_id"]; ?>" type="hidden"/>
              <input id="IdTipo" name="IdTipo" value="3" type="hidden"/>
              <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_POST["IdAsignacion"]; ?>" type="hidden"/>
              <input id="IdUsua" name="IdUsua" value="<?php echo $_POST["IdUsua"]; ?>" type="hidden"/>


              <div class="form-group">
                  <label for="inputEmail4" class="col-sm-3 control-label">Buscar imagen:</label>
                  <div class="col-sm-9">
                    <input type="file" name="archivo" id="archivo" required onchange="uploadImg(this,'archivo');">
                  </div>
                </div>





              <div class="barra" id="barra" style="display: none;">
                <div class="barra_azul" id="barra_estado">
                  <span></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="chkLink11" name="chkLink11" >
                      <?php if($datos81["Link"]) { echo "<b style= 'color: red'>(1) Ocupado</b>"; } else { echo "<b>(1) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="chkLink22" name="chkLink22" >
                      <?php if($datos81["Link2"]) { echo "<b style= 'color: red'>(2) Ocupado</b>"; } else { echo "<b>(2) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="chkLink33" name="chkLink33" >
                      <?php if($datos81["Link3"]) { echo "<b style= 'color: red'>(3) Ocupado</b>"; } else { echo "<b>(3) Libre</b>"; } ?>
                    </label>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-body"><br>
                    <div class="form-group">
                    <label>Descripci&oacute;n de la imagen a subir:</label>
                    <textarea class="form-control" rows="3" name="txtImgDes" id="txtImgDes" placeholder="Describa la imagen y/o motivo a subir la imagen ..."></textarea>
                  </div>
                  </div>
                </div>
                </div>

<br>
              <div class="box-footer">
                <button name="btnSalir" id="btnSalir" data-dismiss="modal" class="btn btn-danger"> Cancelar</button>
                <input name="bntSubir" id="bntSubir" type="button"  onclick="val_uploadTareaImg()" class="btn btn-primary pull-right" value="Subir imagen">
              </div>
            </form>
          </div>
          <script>
            function verificarFile(){
              alert('holaa');
            }
          </script>
