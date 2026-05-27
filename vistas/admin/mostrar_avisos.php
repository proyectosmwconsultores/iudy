<?php
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdUsua  = $_POST['IdUsua'];
$avis_war = $db->query("SELECT tbla_aviso_detalle.IdDetalle, tbla_aviso_detalle.IdAviso, tbla_aviso_detalle.IdUsua, tbla_aviso_detalle.IdEstatus, tbla_aviso.Mensaje, tbla_aviso.Usuario, tbla_aviso.Archivo, tbla_aviso.Tipo, tbla_aviso.FecCap FROM tbla_aviso_detalle Left Join tbla_aviso ON tbla_aviso.IdAviso = tbla_aviso_detalle.IdAviso WHERE tbla_aviso_detalle.IdUsua =  '$IdUsua' ORDER BY tbla_aviso.FecCap DESC  LIMIT 2 ");

$sql_datos = $db->query("SELECT tblc_usuario.Correo, tblc_usuario.Grado, tblc_usuario.Celular FROM tblc_usuario WHERE tblc_usuario.Idusua = '$IdUsua' ");
$db->rows($sql_datos);
$dat_usr = $db->recorrer($sql_datos);
$cel = $dat_usr['Celular'];
$grad = $dat_usr['Grado'];
$perfil = 0;
$grax = 0;
if ($cel) { $perfil = 1; }
if ($grad == 4) { $grax = 1; }


$msj_pag = 0;
$sql_prox = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.Fecha FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdEstatus =  '1' ORDER BY tblp_pagos.Fecha ASC LIMIT 1");
$db->rows($sql_prox);
$dat_pag = $db->recorrer($sql_prox);
$pag = $dat_pag['Fecha'];
if($pag){
  //$hoy = date("2023-01-18");
  $hoy = date("Y-m-d");
  $fecha1 = new DateTime($hoy);
  $fecha2 = new DateTime($pag);
  $diff = $fecha1->diff($fecha2);

  $dias = ($diff->invert == 1) ? '-' . $diff->days : $diff->days;
  $texto = '';
  if ($dias <= 8) { $msj_pag = 1;
    $texto = "Estimado usuario, su próximo pago será el día ".obtenerFecha($pag).'.';
    $color = "#00a65a";
  }
  if ($dias == 1) { $msj_pag = 1;
    $texto = "Estimado usuario, su <b style='color: blue;'>fecha límite de pago es mañana</b> evite recargos.";
    $color = "#00c0ef";
  }
  if ($dias == 0) { $msj_pag = 1;
    $texto = "Estimado usuario, su <b style='color: blue;'>fecha límite de pago es hoy</b> evite recargos.";
    $color = "#f39c12";
  }
  if ($dias < 0) { $msj_pag = 1;
    $texto = "Estimado usuario, la fecha límite de pago fue el ".obtenerFecha($pag).", favor de revisar el monto a <b style='color: yellow;'>pagar con su recargo</b> correspondiente.";
    $color = "#dd4b39";
  }

  
}



?>

<iframe class="w-100 border-0" src="https://embed.lottiefiles.com/animation/31548"></iframe>
<p style="text-align: center; color: #1d3462; "><i class="fa fa-bell"></i> <b>¡Mis avisos!</b></p>
<?php
while ($xy = $db->recorrer($avis_war)) {
?>
  <div id=<?php echo $xy['IdDetalle']; ?>>
    <div class="direct-chat-messages" style='cursor: pointer;'>
      <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
          <span class="direct-chat-name pull-left"><?php echo $xy['Usuario']; ?></span>
          <span class="direct-chat-timestamp pull-right"><?php echo $xy['FecCap']; ?></span>
        </div>
        <img class="direct-chat-img" src="assets/images/campus/icono.png" alt="Message User Image">
        <div  onclick="_mostrar_aviso_id(<?php echo $xy['IdAviso']; ?>,<?php echo $xy['IdDetalle']; ?>)" class="direct-chat-text" style="text-align: justify; font-size: 12px;">
          <?php echo $xy['Mensaje']; ?> <b style='color: blue;'>(Clic aquí)</b>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<div class="direct-chat-messages">
  <?php if($msj_pag == 1){ ?>
  <div class="direct-chat-msg" onClick="window.open('misPagos.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
    <div class="direct-chat-info clearfix">
      <span class="direct-chat-name pull-left">Área de finanzas</span>
      <span class="direct-chat-timestamp pull-right"></span>
    </div>
    <img class="direct-chat-img" src="assets/images/iconos/_pago.gif" alt="Message User Image">
    <div class="direct-chat-text" style="background: <?php echo $color; ?>; border-color: #dd4b39; color: #fff; text-align: justify; font-size: 12px; border-left-color: #dd4b39;">
      <?php echo $texto; ?>
      <?php if($dias == 0){ ?>
      <p style="text-align: center;">
      <img class="direct-chat-img" src="assets/images/iconos/_hoy.gif" alt="Hoy">
      </p><?php } ?>
    </div>
  </div>
  <?php } ?>
  <?php if ($perfil == 0) { ?>
    <!-- <div class="direct-chat-msg right" onClick="window.open('misDatos.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
      <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-right">Control Escolar</span>
      </div>
      <img style="width: 50px; height: 50px;" class="direct-chat-img" src="assets/images/iconos/_perfil.gif" alt="Message User Image">
      <div class="direct-chat-text" style="text-align: justify; font-size: 12px;">
        Estimado usuario, favor de actualizar sus datos personales.
      </div>
    </div> -->
  <?php } ?>
  <?php if($grax == 0){ ?>
  <!-- <div class="direct-chat-msg right" onClick="window.open('misTramites.php','_self')" href="javascript:void(0);" style="cursor: pointer;">
    <div class="direct-chat-info clearfix">
      <span class="direct-chat-name pull-right">Finanzas</span>
    </div>
    <img style="width: 50px; height: 50px;" class="direct-chat-img" src="assets/images/iconos/_beca.gif" alt="Message User Image">
    <div class="direct-chat-text" style="background: #3c8dbc; border-color: #3c8dbc; color: #fff; text-align: justify; font-size: 12px; border-left-color: #3c8dbc;">
      Estimado usuario, favor de revisar su convenio de beca.
    </div>
  </div> -->
  <?php } ?>
</div>

<?php
function obtenerFecha($fecha){
  $num = date("j", strtotime($fecha));
  $anno = date("Y", strtotime($fecha));
  $mes = array('ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
  $mes = $mes[(date('m', strtotime($fecha))*1)-1];
  return $num.' de '.$mes.' de '.$anno;
}
?>