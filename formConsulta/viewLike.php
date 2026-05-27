<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  

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
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">'.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"].'
                <span class="product-description" style="font-size: 12px; font-weight: lighter;">'.tiempo_transcurrido($x["FecCap"]).'</span>
                <span class="product-description" style="color: blue; margin-left: -22px; margin-top: -8px;"><img src="dist/img/like.png"></span>
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
