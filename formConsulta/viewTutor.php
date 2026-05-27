<?php
include('../hace.php');
require('../php/clases/class.System.php');
if(isset($_POST["employee_id"])){
  $output = '';
  $IdAsignacion = $_POST["employee_id"];
  $db = new Conexion();
  $sql = $db->query("SELECT tblp_asignacion.IdAsignacion, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblc_usuario.Tipo =  '4' AND tblp_asignacion.IdAsignacion =  '$IdAsignacion'");

  //$sql1="";
  //$res1=mysql_query($sql1,Conectar::con());
  $output .= '
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <ul class="products-list product-list-in-box">';
            while($x = $db->recorrer($sql)){
            $output .= '
            <li class="item" style="border-bottom: none;">
              <div class="product-img">
                <img src="assets/perfil/'.$x["Foto"].'" alt="Image" class="img-circle">
              </div>
              <div class="product-info" style=" margin-top: 10px;">
                <a style="color: black;" href="javascript:void(0)" class="product-title">'.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"].'
              </div>
            </li>';
            }
          $output .= '
          </ul>
        </div>
      </div>
    </table>
  </div>';
  echo $output;
}
?>
