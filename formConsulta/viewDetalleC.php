<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $sql = $db->query("SELECT tblp_foro.IdForo, tblp_foro.Mensaje, tblp_foro.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_foro Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua WHERE tblp_foro.IdActividad = '".$_POST["employee_id"]."' AND tblp_foro.IdAsignacion = '".$_POST["IdAsignacion"]."'");

  $output .= '
  <div class="table-responsive">

    <div class="col-md-12">
    <div class="box box-widget">
      <div class="box-footer box-comments">
      ';
            while($x = $db->recorrer($sql)){
            $output .= '


              <div class="box-comment">
                <img class="img-circle img-sm" src="assets/perfil/'.$x["Foto"].'" alt="User Image">
                <div class="comment-text">
                      <span class="username">
                        '.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"].'
                        <span class="text-muted pull-right">'.tiempo_transcurrido($x["FecCap"]).'</span>
                      </span>'.$x["Mensaje"].'
                </div>
              </div>



            ';
            }
          $output .= '
          </div>
        </div>
        </div>
  </div>';
  echo $output;
}
?>
