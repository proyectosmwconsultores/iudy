<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];

  $sql_tar = $db->query("SELECT tblp_asignacion.IdAsignacion, tblp_actividadesdocente.IdTipoActividad, tblp_actividadesdocente.NomActividad, tblp_tareas.IdAlumno, tblp_tareas.FecCap, tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.Foto, tblp_actividadesdocente.IdActividadesDocente, tblp_actividadesdocente.Modalidad FROM tblp_asignacion Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdAsignacion = tblp_asignacion.IdAsignacion Left Join tblp_tareas ON tblp_tareas.IdActividadesDocente = tblp_actividadesdocente.IdActividadesDocente Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareas.IdAlumno WHERE tblp_asignacion.IdUsua =  '$IdUsua' AND tblp_asignacion.IdEstatus =  '8' AND tblp_asignacion.Tipo =  '2' AND tblp_actividadesdocente.IdTipoActividad =  '3' AND tblp_tareas.Calificacion IS NULL AND tblp_tareas.FecCap IS NOT NULL");

  $noT = 0;
  function obtFecha($fecha){
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' '.$mes;
  }
  ?>

<?php while($tar = $db->recorrer($sql_tar)){ $noT = 1; ?>
  <li class="item" onClick="window.open('doAddCalificarTarea.php?idToks=<?php echo $tar['IdAsignacion']; ?>&IdToken=<?php echo time().$tar['IdActividadesDocente']; ?>&M=<?php echo $tar['Modalidad']; ?>&IdU=<?php echo $tar['IdAlumno']; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">
    <div class="product-img">
      <img class="img-circle" src="assets/perfil/<?php echo $tar['Foto']; ?>" alt="Foto">
    </div>
    <div class="product-info">
      <a href="javascript:void(0)" class="product-title"><?php echo $tar['Nombre'].' '.$tar['APaterno']; ?>
        <span class="label label-warning pull-right"><?php echo obtFecha($tar['FecCap']).' '.substr($tar['FecCap'], 11,8); ?></span></a>
      <span class="product-description">
            <?php echo $tar['NomActividad']; ?>
          </span>
    </div>
  </li><?php }

if($noT == 0){ ?>
  <div style="padding: 15px; border-radius: 30px; text-align: center;" class="bg-navy-active color-palette"><span>No hay tareas recientes para calificar</span></div>
<?php } ?>
