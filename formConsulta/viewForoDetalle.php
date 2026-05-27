<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_actividadesdocente WHERE tblp_actividadesdocente.IdActividadesDocente = '".$_POST["employee_id"]."' AND tblp_actividadesdocente.IdAsignacion = '".$_POST["Id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $output .= '
  <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">'.$datos91["NomActividad"].'</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">';
            $output .= '
            <p>'.$datos91["DesActividad"].'</p>';
          $output .= '
        </div>
      </div>
    </table>
  </div>';
  echo $output;
}
?>
