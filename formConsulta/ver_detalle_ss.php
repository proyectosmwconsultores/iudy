<?php
session_start();
require('../php/clases/class.System.php');
require('../hace.php');
$db = new Conexion();
$IdAviso = $_POST["IdAviso"];


$sql9 = $db->query("SELECT tbla_aviso_servicio.IdAviso,
tbla_aviso_servicio.Titulo,
tbla_aviso_servicio.Inicio,
tbla_aviso_servicio.Final,
tbla_aviso_servicio.Texto,
tblc_periodo_ps.Periodo
FROM
tbla_aviso_servicio
Left Join tblc_periodo_ps ON tblc_periodo_ps.IdPeriodo = tbla_aviso_servicio.IdCiclo
WHERE tbla_aviso_servicio.IdAviso = '$IdAviso' ");
$db->rows($sql9);
$datos91 = $db->recorrer($sql9);


?>

<form name="frm2s_Far" id="frm2s_Far" action="updSemana.php" method="POST" enctype="multipart/form-data">
  <div class="box box-primary" style="border-top: none;">
    <div class="box-body">
      <div class="box-header with-border">
        <div class="user-block">
          <img class="img-circle" src="assets/images/campus/logo_campus.png" alt="User Image">
          <span class="username"><a href="#"><?php echo $datos91['Titulo']; ?> </a></span>
          <span class="description"><?php echo $datos91['Periodo']; ?></span>
        </div>
      </div>
      <div class="box-body">
        <?php echo $datos91['Texto']; ?>
      </div>
      <span class="pull-right text-muted">Convocatoria disponible: <?php echo obtenerFechaCorta($datos91['Inicio']); ?> al <?php echo obtenerFechaCorta($datos91['Final']); ?></span>
    </div>
    
  </div>
</form>