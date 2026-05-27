<?php
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];


$sql_notificaciones = $db->query("SELECT
tblp_tareascomentarios.IdComentario,
tblp_tareascomentarios.FecCap,
tblp_tareascomentarios.Visto,
tblp_tareascomentarios.IdActividad,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblp_tareascomentarios.IdTarea,
tblp_actividadesdocente.NomActividad
FROM tblp_tareascomentarios Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareascomentarios.IdUsua_envia Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareascomentarios.IdActividad
WHERE tblp_tareascomentarios.IdUsua_recibe = '$IdUsua'
ORDER BY tblp_tareascomentarios.FecCap DESC
 ");
  ?>
<li>
  <ul class="menu">
    <?php while($_notificaciones = $db->recorrer($sql_notificaciones)){ ?>
    <li><!-- start message -->
      <a onclick="ver_notificacion(<?php echo $_notificaciones['IdComentario']; ?>)" href="javascript:void(0);">
        <div class="pull-left">
          <img src="assets/perfil/<?php echo $_notificaciones['Foto']; ?>" class="img-circle" alt="User Image">
        </div>
        <h4>
          <p style="font-size: 12px;"><?php echo $_notificaciones['Nombre'].' '.$_notificaciones['APaterno']; ?></p>
          <?php if($_notificaciones['Visto'] == 1){ ?>
          <small><i style="color: blue; font-size:12px;" class="fa fa-fw fa-eye"></i></small>
          <?php } else { ?>
          <small><i style="color: green; font-size:12px;" class="fa fa-check-square-o"></i></small>
          <?php } ?>
        </h4>
        <p style="margin-top: -10px;"><?php echo $_notificaciones['NomActividad']; ?></p>
        <small style="float: right;"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_notificaciones['FecCap']); ?></small>
      </a>
    </li><?php } ?>
  </ul>
</li>
<!-- <li class="footer"><a href="#">See All Messages</a></li> -->
