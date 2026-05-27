<?php session_start();
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();
$IdBaja = $_POST["IdBaja"];


$notificacion = $db->query("SELECT
tblh_bajausuario.IdBaja,
tblh_bajausuario.Comentario,
tblh_bajausuario.FecCap,
tblh_bajausuario.IdUsua,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblc_estatus.Estatus,
Motiv.Estatus AS Motivo,
tblp_seguimiento.Comentario_control,
tblp_seguimiento.Comentario_usuario,
Admin.Nombre AS CNombre,
Admin.APaterno AS CPaterno,
Admin.AMaterno AS CMaterno,
Admin.Foto AS CFoto,
tblc_permiso.Permiso
FROM
tblh_bajausuario
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_bajausuario.IdUsua
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblh_bajausuario.IdEstatus
Left Join tblc_estatus AS Motiv ON Motiv.IdEstatus = tblh_bajausuario.IdMotivo
Left Join tblp_seguimiento ON tblp_seguimiento.IdUsua = tblh_bajausuario.IdUsua AND tblp_seguimiento.IdCiclo = tblh_bajausuario.IdCiclo
Left Join tblc_usuario AS Admin ON Admin.IdUsua = tblp_seguimiento.IdUsua_admin
Left Join tblc_permiso ON tblc_permiso.IdPermiso = Admin.Permisos
WHERE tblh_bajausuario.IdBaja = '$IdBaja'");
$db->rows($notificacion);
$notti = $db->recorrer($notificacion);
$dateObject = new DateTime($notti['FecCap']);
$hora = $dateObject->format('h:i A');

?>
<input type="hidden" name="txtT" id="txtT" value="<?php echo $Total; ?>">
<div class="box box-widget">
  <div class="box-header with-border">
    <div class="user-block">
      <img class="img-circle" src="assets/perfil/<?php echo $notti['Foto']; ?>" alt="User Image">
      <span class="username"><a href="#"><?php echo $notti['Nombre'] . ' ' . $notti['APaterno'] . ' ' . $notti['AMaterno']; ?></a></span>
      <span class="description"><?php echo $notti['Estatus']; ?> / <?php echo $notti['Motivo']; ?></span>
    </div>
  </div>
  <div class="box-footer box-comments">
    <div class="box-comment">

      <img class="img-circle img-sm" src="assets/perfil/<?php echo $notti['CFoto']; ?>" alt="User Image">
      <div class="comment-text">
        <span class="username">
        <?php echo $notti['CNombre'] . ' ' . $notti['CPaterno'] . ' ' . $notti['CMaterno']; ?>
          <span class="text-muted pull-right"><?php echo obtenerFechaEnLetra($notti['FecCap']) ?>, <?php echo $hora; ?> - (<?php echo tiempo_transcurrido($notti['FecCap']) ?>)</span>
        </span>
        <?php echo $notti['Comentario']; ?>
      </div>
    </div>
  </div>
  <button onclick="window.open('perfil.php?token=<?php echo time().$notti['IdUsua']; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-flat">Ir al perfil del alumno</button>
</div>