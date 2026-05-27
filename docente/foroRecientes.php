<?php session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdUsua = $_SESSION['IdUsua'];

  $sql_foro = $db->query("SELECT
tblp_asignacion.IdAsignacion,
tblp_foro.IdForo,
tblp_foro.IdActividad,
tblp_foro.Mensaje,
tblp_foro.FecCap,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblp_asignacion
Left Join tblp_foro ON tblp_foro.IdAsignacion = tblp_asignacion.IdAsignacion
Inner Join tblc_usuario ON tblc_usuario.IdUsua = tblp_foro.IdUsua
WHERE
tblp_asignacion.IdUsua =  '$IdUsua' AND
tblp_asignacion.IdEstatus =  '8' AND
tblp_asignacion.Tipo =  '2'
ORDER BY
tblp_foro.FecCap DESC LIMIT 5
");

  $noF = 0;

  function obtFecha($fecha){
      $num = date("j", strtotime($fecha));
      $anno = date("Y", strtotime($fecha));
      $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
      $mes = $mes[(date('m', strtotime($fecha))*1)-1];
      return $num.' '.$mes;
    }
  ?>
  <style>
  #ms_j:hover{
  	filter: opacity(0.7);
  }
  </style>


<?php while($foro = $db->recorrer($sql_foro)){ $noF = 1; ?>
  <div class="direct-chat-msg">
    <div class="direct-chat-info clearfix">
      <span class="direct-chat-name pull-left" style="font-size: 11px;"><?php echo $foro['Nombre'].' '.$foro['APaterno'].' '.$foro['AMaterno']; ?></span>
      <span class="direct-chat-timestamp pull-right" style="font-size: 11px;"><?php echo obtFecha($foro['FecCap']).' '.substr($foro['FecCap'], 11,8); ?></span>
    </div>
    <img class="direct-chat-img" src="assets/perfil/<?php echo $foro['Foto']; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
    <div class="direct-chat-text" id='ms_j' onClick="window.open('viewForoId.php?idToks=<?php echo $foro['IdAsignacion']; ?>&Id=<?php echo time().$foro['IdActividad']; ?>&IdF=<?php echo $foro['IdForo']; ?>','_self')" href="javascript:void(0);" style="cursor: pointer; font-size: 12px;">
      <?php
      $numL = strlen($foro['Mensaje']);
      if($numL > 110){
         echo substr($foro['Mensaje'], 0, 110)." <i style='color: #4545ee;'>[Leer mas...]</i>";
      } else {
         echo $foro['Mensaje'];
      } ?>
    </div>
  </div>
<?php }

if($noF == 0){ ?>
  <div style="padding: 15px; border-radius: 30px; text-align: center;" class="bg-navy-active color-palette"><span>No hay comentarios recientes en el foro</span></div>
<?php } ?>
