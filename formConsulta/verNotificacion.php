<?php session_start();
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();
$IdNotificacion = $_POST["IdNotificacion"];
$IdUsua = $_SESSION['IdUsua'];

$notificacion = $db->query("SELECT
tblp_tareascomentarios.IdComentario,
tblp_tareascomentarios.Comentario,
tblp_tareascomentarios.FecCap,
tblp_tareascomentarios.IdUsua_envia,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto,
tblp_actividadesdocente.NomActividad,
tblp_modulo.NombreMod
FROM
tblp_tareascomentarios
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_tareascomentarios.IdUsua_envia
Left Join tblp_actividadesdocente ON tblp_actividadesdocente.IdActividadesDocente = tblp_tareascomentarios.IdActividad
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_actividadesdocente.IdModulo
WHERE
tblp_tareascomentarios.IdComentario =  '$IdNotificacion'");
$db->rows($notificacion);
$notti = $db->recorrer($notificacion);
$dateObject = new DateTime($notti['FecCap']);
$hora = $dateObject->format('h:i A');

$insertar = $db->query("UPDATE tblp_tareascomentarios SET tblp_tareascomentarios.Visto = '0' WHERE tblp_tareascomentarios.IdComentario =  '$IdNotificacion'");

$sql8 = $db->query("SELECT Count(tblp_tareascomentarios.IdComentario) AS Total FROM tblp_tareascomentarios WHERE tblp_tareascomentarios.IdUsua_recibe =  '$IdUsua' AND tblp_tareascomentarios.Visto =  '1' GROUP BY tblp_tareascomentarios.IdUsua ");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$Total = $datos81["Total"];
if($Total){ $Total = $Total; } else { $Total = 0; }

  ?>
  <input type="hidden" name="txtT" id="txtT" value="<?php echo $Total; ?>">
  <div class="box box-widget">
    <div class="box-header with-border">
      <div class="user-block">
        <img class="img-circle" src="assets/perfil/<?php echo $notti['Foto']; ?>" alt="User Image">
        <span class="username"><a href="#"><?php echo $notti['Nombre'].' '.$notti['APaterno'].' '.$notti['AMaterno']; ?></a></span>
        <span class="description"><?php echo obtenerFechaEnLetra($notti['FecCap']) ?>, <?php echo $hora; ?> - (<?php echo tiempo_transcurrido($notti['FecCap']) ?>)</span>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="attachment-block clearfix">
        <p><b><i class="fa fa-fw fa-bookmark"></i> </b><?php echo $notti['NombreMod']; ?></p>
        <p><b><i class="fa fa-fw fa-edit"></i> </b><?php echo $notti['NomActividad']; ?></p>
      </div>
      <hr>
      <strong><i class="fa fa-fw fa-twitch"></i> Comentario</strong><br>
      <?php echo $notti['Comentario']; ?>
    </div>
  </div>
<script>
$(document).ready(function(){
  var Total = document.getElementById("txtT").value;
  document.getElementById('all_not').innerHTML = Total;

});
</script>
