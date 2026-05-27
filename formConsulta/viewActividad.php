<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  $porciones = explode("-", $_POST["employee_id"]);
  $IdAsignacion = $porciones[0];
  $NoActividad = $porciones[1];
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_actividad WHERE tblp_actividad.NoActividad = '$NoActividad' AND tblp_actividad.IdAsignacion = '$IdAsignacion'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $output .= '
  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">'.$datos91["TituloActividad"].'</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">';
            $output .= '
            <p>'.$datos91["Descripcion"].'</p>';
          $output .= '
        </div>
      </div>
    </table>
  </div>';
  echo $output;
}
?>
