<?php
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();

$sql8 = $db->query("SELECT Count(tblp_asignacion.IdUsua) AS Total FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Fecha_impresion IS NOT NULL  AND tblp_asignacion.Salon =  '0' GROUP BY tblp_asignacion.Salon");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$Total = $datos81["Total"];

$sql_acta = $db->query("SELECT
tblh_bajausuario.IdBaja,
tblh_bajausuario.IdUsua,
tblh_bajausuario.IdEstatus,
tblh_bajausuario.Comentario,
tblh_bajausuario.FecCap,
tblh_bajausuario.IdCiclo,
tblh_bajausuario.IdMotivo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Foto
FROM
tblh_bajausuario
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblh_bajausuario.IdUsua
WHERE tblc_usuario.Permisos = '3' AND ((tblc_usuario.IdEstatus = '19') || (tblc_usuario.IdEstatus = '15') || (tblc_usuario.IdEstatus = '14'))
ORDER BY
tblh_bajausuario.FecCap DESC
LIMIT 50
");
  ?>

  <li class="header">Se muestran las 50 bajas más recientes </li>
  <li>
  <ul class="menu">
    <?php while($_acta = $db->recorrer($sql_acta)){ ?>
    <li>
    <a onClick="ver_baja_id(<?php echo $_acta['IdBaja']; ?>)" href="javascript:void(0);">
    <div class="pull-left">
    <img src="assets/perfil/<?php echo $_acta['Foto']; ?>" class="img-circle" alt="User Image">
    </div>
    <h4 style="font-size: 11px;">
    <?php echo $_acta['Nombre'].' '.$_acta['APaterno']; ?>

    </h4>
    <p><?php echo $_acta['Comentario']; ?></p>
      <small style="font-size: 10px;"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_acta['FecCap']); ?></small>
    </a>
    </li>
  <?php } ?>
  </ul>
  </li>
  
