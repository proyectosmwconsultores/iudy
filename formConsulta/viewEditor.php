<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdTarea = $_POST["employee_id"];
  $IdParcial = $_POST["IdParcial"];
  $IdActividadDoc = $_POST["IdActividadDoc"];
  $TipoCalificar = $_POST["TipoCalificar"];


  $sql2 = $db->query("SELECT * FROM tblp_editor WHERE tblp_editor.IdTarea = '$IdTarea' AND tblp_editor.IdParcialDocente = '$IdParcial' AND tblp_editor.IdActividadesDocente = '$IdActividadDoc'");
  $db->rows($sql2);
  $datos21 = $db->recorrer($sql2);

  ?>
  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Información de la actividad</h4>
  </div>
  <section class="content">
    <form name="frm" id="frm" action="viewEditor.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_SESSION["IdAsignacion"]; ?>" type="hidden"/>
    <div class="row">


      <div class="col-md-12">
          <div class="box box-solid">
            <div class="box-body">
              <?php echo $datos21["Texto"]; ?>
            </div>
            <?php if($datos21["IdEstatus"] == 2) { ?> <p><b>Esta actividad ha sido enviada por el alumno para su revisión.</b></p><?php } ?>
            <?php if($datos21["IdEstatus"] == 25) { ?> <p><b>Esta actividad ha sido regresada al alumno con las anotaciones correspondientes.</b></p><?php } ?>
            <?php if($datos21["IdEstatus"] == 4) { ?> <p><b>Esta actividad ha sido aceptada para obtener una calificación.</b></p><?php } ?>
            <button onClick="window.open('doEditor.php?toks=<?php echo time().$datos21["IdEditor"]; ?>&T=<?php echo $TipoCalificar; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-xs">Abrir editor de texto <?php echo $x["NoParcial"]; ?></button>


          </div>

        </div>

    </div>
  </form>



      </section>
