<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];

  $sql_doc1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.AMaterno, tblc_usuario.APaterno, tblc_usuario.Foto FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo =  '2' ");
  $db->rows($sql_doc1);
  $datos91 = $db->recorrer($sql_doc1);
  ?>

  <div class="box-body">
    <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-info">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username"><?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?></h3>
              <h5 class="widget-user-desc">Docente</h5>
            </div>
            <div class="box-footer no-padding">
              <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-info-circle"></i>

              <h3 class="box-title">Semblanza</h3>
            </div>
            <div class="box-body">
              <blockquote>
                <p style="text-align: justify;">Mi semblanza.</p>
              </blockquote>
            </div>
          </div>
            </div>
          </div>
  </div>
