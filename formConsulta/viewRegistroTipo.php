<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $FecIni = substr($_POST["employee_id"], 0, 10);
 $FecFin = substr($_POST["employee_id"], 11, 10);

   $Tipo = substr($_POST["employee_id"], 22, 1);
  $sql = $db->query("SELECT tblh_log.IdLog, tblh_log.FecIng, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Cargo, tblc_usuario.Foto FROM tblh_log Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_log.IdUsua WHERE tblh_log.Fecha BETWEEN  '$FecIni' AND '$FecFin' AND tblc_usuario.Permisos='$Tipo'");

  $output .= '
  <div class="modal-header" style="background: #3C8DBC; color: black; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Personas que ingresaron en el mes de '.obtenerAnioMes($FecIni).'</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <ul class="products-list product-list-in-box">';
            while($x = $db->recorrer($sql)){
            $output .= '
            <li class="item" style="border-bottom: none;">
              <div class="product-img">
                <img src="assets/perfil/'.$x["Foto"].'" alt="Image" class="img-circle img-xs">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">'.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"].'
                <span class="product-description" style="font-size: 12px; font-weight: lighter;">'.$x["Cargo"].'</span>
                <span class="product-description" style="font-size: 12px; font-weight: lighter;">'.$x["FecIng"].'</span>
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
