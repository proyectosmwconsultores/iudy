<?php
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();

$sql8 = $db->query("SELECT Count(tblp_asignacion.IdUsua) AS Total FROM tblp_asignacion WHERE tblp_asignacion.Tipo =  '2' AND tblp_asignacion.Fecha_impresion IS NOT NULL  AND tblp_asignacion.Salon =  '0' GROUP BY tblp_asignacion.Salon");
$db->rows($sql8);
$datos81 = $db->recorrer($sql8);
$Total = $datos81["Total"];

$sql_acta = $db->query("SELECT
  tblp_asignacion.IdUsua,
tblp_asignacion.Id,
tblp_asignacion._fecEnvio,
tblp_asignacion.Salon,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.Foto,
tblp_modulo.NombreMod
FROM
tblp_asignacion
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
WHERE
tblp_asignacion.Tipo =  '2' AND
tblp_asignacion.Fecha_impresion IS NOT NULL
ORDER BY
tblp_asignacion._fecEnvio DESC LIMIT 10 ");
  ?>

  <li class="header">Tiene <?php echo $Total; ?> nuevas actas de calificación</li>
  <li>
  <ul class="menu">
    <?php while($_acta = $db->recorrer($sql_acta)){ ?>
    <li>
    <a onClick="mostrar_acta(<?php echo $_acta['Id']; ?>)" href="javascript:void(0);">
    <div class="pull-left">
    <img src="assets/perfil/<?php echo $_acta['Foto']; ?>" class="img-circle" alt="User Image">
    </div>
    <h4 style="font-size: 11px;">
    <?php echo $_acta['Nombre'].' '.$_acta['APaterno']; ?>

    </h4>
    <p style=" font-size: 11px; <?php if($_acta['Salon'] == 1){ echo 'text-decoration: line-through; color: blue;'; } ?> "><?php echo $_acta['NombreMod']; ?></p>
      <small style="font-size: 10px;"><i class="fa fa-clock-o"></i> <?php echo tiempo_transcurrido($_acta['_fecEnvio']); ?></small>
    </a>
    </li>
  <?php } ?>
  </ul>
  </li>
  <li class="footer"><a onClick="window.open('lista_acta_calificaciones.php','_self')" href="javascript:void(0);">Ver todas las acta de calificaciones</a></li>
