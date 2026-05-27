<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $sql9 = $db->query("SELECT * FROM tblp_videos WHERE tblp_videos.IdVideo = '".$_POST["employee_id"]."'");
  $db->rows($sql9);
  $datos91 = $db->recorrer($sql9);

  $output .= '
  <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Nombre: '.$datos91["Titulo"].'</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">';
        if(($datos91["Tipo"] == "mp4") || ($datos91["Tipo"] == "mp3")){
        $output .= '



        <video src="assets/docs/Videos/'.$datos91["Link"].'" controls width="100%" height="80%"></video>';
 } else {
          $output .= '
          <h4>Atenci&oacute;n</h4>
          <p>
          No se puede reproducir el video, por el tipo de formato, en este caso usted puede descargar el video en el siguiente enlace.
          </p>

              <hr>
              <p style="text-align: center;">
              <a class="btn btn-app"  href="assets/docs/Videos/'.$datos91["Link"].'">
                <span class="badge bg-red"><i class="fa fa-fw fa-cloud-download"></i></span>
                <i class="fa fa-file-video-o"></i> Descargar video
              </a>
              </p>

        '; }
          $output .= '
        </div>
      </div>
    </table>
  </div>';
  echo $output;
}
?>
