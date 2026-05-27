<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $porciones = explode("-", $_POST["employee_id"]);
  $IdAsignacion = $porciones[0]; // porción1
  $IdActividadDoc = $porciones[1]; // porción2
  $TipoActividad = $porciones[2]; // porción2


  $sql = $db->query("SELECT
tblp_tareas.IdTarea,
tblp_tareas.IdAsignacion,
tblp_tareas.IdActividadesDocente,
tblp_tareas.Calificacion,
tblp_tareas.IdEditor,
tblp_tareas.Editor,
tblp_tareas.IdParcialDocente,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblp_tareas.Link,
tblp_tareas.Link2,
tblp_tareas.Link3,
tblp_tareas.FecCap
FROM
tblp_tareas
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdAlumno
WHERE
tblp_tareas.IdAsignacion =  '$IdAsignacion' AND tblp_tareas.IdActividadesDocente = '$IdActividadDoc'");


  $output .= '
  <div class="modal-header" style="background: #3C8DBC; color: black; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Personas que interactuaron con la actividad </h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <ul class="products-list product-list-in-box">';
            while($x = $db->recorrer($sql)){
              $link1 = $x["Link"];
              $link2 = $x["Link2"];
              $link3 = $x["Link3"];
              if(($link1) || ($link2) || ($link3)){ $txtLink1 = "Subio un archivo."; }
              if($x["Editor"] == 1){ $txtLink2 = "Utilizo el editor para subir tarea."; }
              if($x["Calificacion"]){ $txtLink3 = "Ya se califico esta actividad. / <b>Puntos obtenidos:</b> ".$x["Calificacion"]; }
            $output .= '
            <li class="item" style="border-bottom: none;">
              <div class="product-img">
                <img src="assets/perfil/'.$x["Foto"].'" alt="Image" class="img-circle img-xs">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title">'.$x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"].'
                ';

                  $output .= '
                  <span class="product-description" style="font-size: 12px; font-weight: lighter;">'.$txtLink1.' '.$txtLink2.' '.$txtLink3.'</span>
                  <span class="product-description" style="font-size: 12px; font-weight: lighter;">'.$x["FecCap"].'</span>
                  ';

                $output .= '
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
