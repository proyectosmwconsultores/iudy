<?php
include('../hace.php');
if(isset($_POST["employee_id"])){
  $output = '';
  require('../php/clases/class.System.php');
  $db = new Conexion();

  $IdAsignacion = $_POST["IdAsignacion"];
  $IdActividadDoc = $_POST["employee_id"];

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

?>
  <div class="modal-header" style="background: #3C8DBC; color: black; font-size: 16px;">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Resumen de la actividad.</h4>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none;">
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            <?php $vb= 0;
            while($x = $db->recorrer($sql)){ $vb= 1;
              $link1 = $x["Link"];
              $link2 = $x["Link2"];
              $link3 = $x["Link3"];
              if(($link1) || ($link2) || ($link3)){ $txtLink1 = "<b style='color: blue;'>Subio un archivo.</b>"; } else { $txtLink1 = "No subio archivo.";}
              
              if($x["Calificacion"]){ $txtLink3 = "Ya se calificó esta actividad.<br> <b style='color: black;'>Puntos obtenidos:</b> ".$x["Calificacion"]; } else { $txtLink3 = "No ha calificado la actividad."; }
          ?>
            <li class="item" style="border-bottom: none;">
              <div class="product-img">
                <img src="assets/perfil/<?php echo $x["Foto"]; ?>" alt="Image" class="img-circle img-xs">
              </div>
              <div class="product-info">
                <a href="javascript:void(0)" class="product-title"><?php echo $x["Nombre"].' '.$x["APaterno"].' '.$x["AMaterno"]; ?>
                  <span class="product-description" style="font-size: 12px; font-weight: lighter;"><?php echo $txtLink1.' '.$txtLink2.' '.$txtLink3; ?></span>
                  <span class="product-description" style="font-size: 12px; font-weight: lighter;"><?php echo $x["FecCap"]; ?></span>

              </div>
            </li>
            <?php
            }
          ?>
          </ul>

          <?php if($vb== 0){ ?>
          <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Atenci&oacute;n</h4>
                Esta actividad no ha sido activada por el asesor acad&eacute;mico.
              </div>
            <?php } ?>
        </div>
      </div>
    </table>
  </div>
  <?php
}
?>
