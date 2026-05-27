<?php session_start();
  require('../php/clases/class.System.php');
  include('fecha.php');
  $db = new Conexion();
  $idAsignacion = $_POST["idAsignacion"];

  $sql1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_modulo.NombreMod, tblp_asignacion.IdModulo, tblp_asignacion.IdUsua, tblp_educativa.Nombre, tblp_modulo.CodeModulo, tblp_asignacion.FecIni, tblp_asignacion.Fondo, tblp_asignacion.FecFin FROM tblp_asignacion Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa WHERE tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo =  '2'");
  $db->rows($sql1);
  $datos11 = $db->recorrer($sql1);

  $sql_doc1 = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_asignacion.IdUsua, tblc_usuario.Nombre, tblc_usuario.AMaterno, tblc_usuario.APaterno, tblc_usuario.Semblanza, tblc_usuario.Foto FROM tblp_asignacion Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua WHERE tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo =  '2' ");
  $db->rows($sql_doc1);
  $datos91 = $db->recorrer($sql_doc1);

  $sql_pre = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblc_campus.Campus,
tblp_educativa.Nombre,
tblp_modulo.NombreMod,
tblp_modulo.Objetivo,
tblp_asignacion.Fondo
FROM
tblp_asignacion
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_asignacion.IdCampus
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.IdAsignacion =  '$idAsignacion' AND tblp_asignacion.Tipo = '2' ");
$db->rows($sql_pre);
$datos_p = $db->recorrer($sql_pre);
  ?>

  <div class="box-body">
    <div class="box box-widget widget-user">
	            <div class="widget-user-header bg-black" style="background: url('assets/fondo/<?php echo $datos11['Fondo']; ?>') center center; width: 100%; cursor: pointer;">
	              <h3 class="widget-user-username"><?php echo $datos_p['Campus']; ?></h3>
	              <h5 class="widget-user-desc"><?php echo $datos_p['Nombre']; ?></h5>
								<h5 class="widget-user-desc"><?php echo $datos_p['NombreMod']; ?></h5>
	            </div>
	          </div>
            <div class="box box-widget widget-user-2">
              <div class="box-footer no-padding">
                <ul class="nav nav-pills nav-stacked">
                  <li><a href="#"><i class="fa fa-calendar"></i> Inicia el día <?php echo obtenerFechaEnLetra($datos11["FecIni"]); ?></a></li>
                  <li><a href="#"><i class="fa fa-calendar"></i> Finaliza el día <?php echo obtenerFechaEnLetra($datos11["FecFin"]); ?></a></li>
                </ul>
              </div><br><?php if(isset($datos_p['Objetivo'])){ ?>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <i class="fa fa-info-circle"></i>
                  <h3 class="box-title">Objetivo:</h3>
                </div>
                <div class="box-body">
                  <blockquote>
                    <p style="text-align: justify;"><?php echo $datos_p['Objetivo']; ?></p>
                  </blockquote>
                </div>
              </div><?php } ?>
            </div>


  </div>
  <div class="box-body">
    <div class="box box-widget widget-user">
            <div class="widget-user-header bg-black" style="background: url('assets/fondo/img_1.jpg') center center;">
              <h3 class="widget-user-username"><?php echo $datos91["Nombre"].' '.$datos91["APaterno"].' '.$datos91["AMaterno"]; ?></h3>
              <h5 class="widget-user-desc">Docente</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="assets/perfil/<?php echo $datos91["Foto"]; ?>" alt="User Avatar">
            </div><br>
						<div class="box-body" style="text-align: justify;">
              <!-- post text -->
              <p><?php echo $datos91["Semblanza"]; ?></p>
              <!-- <span class="pull-right text-muted">45 Me gusta - 2 comentarios</span> -->
            </div>
          </div>
  </div>
