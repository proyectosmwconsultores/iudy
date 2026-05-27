<?php
$IdUsua = substr($_POST['IdUsua'], 10, 10);
require('../../php/clases/consulta_class.php');
$consul = new Consultas();

$_vigencia = $consul->get_vigencia_id($IdUsua);
$_user = $consul->get_alumno_id($IdUsua);
$plan = $consul->get_oferta_id($_user[0]['IdOferta']);

?>
<link href="https://fonts.cdnfonts.com/css/arial-nova" rel="stylesheet">

<div class="box-primary">
  <div class="box-body box-profile" style="text-align: center; height: 404px;" id="imagen">
    <p>
      <img src="assets/images/campus/credencial_alumno.jpg" style="width: 100%;">
    </p>
    <div style="width: 100%; height: 90px; text-align: right; margin-top: -470px; ">
      <p style="font-size: 11px; color: white; height: 90px; writing-mode: vertical-rl; display: inline; transform: rotate(180deg); margin-left: -0px;"><?php echo $_user[0]['_folio']; ?></p>
      
    </div>
    <div style="width: 100%; height: 120px; text-align: right; margin-top: 7px; text-align: center;">
    <img src="assets/perfil/<?php echo $_user[0]['Foto']; ?>" style="width: 120px; height: 120px; border-radius: 60px;">
    </div>
    <div style="width: 100%; height: 40px; text-align: right; margin-top: 20px; text-align: center;">
      <p style="color: #133759; font-size: 16px; font-family: Arial Nova;">
      <b><?php echo $_user[0]['Nombre']; ?></b>
      </p>
      <p style="color: #133759; font-size: 16px; font-family: Arial Nova; margin-top: -15px">
      <b><?php echo $_user[0]['APaterno'].' '.$_user[0]['AMaterno']; ?></b>
      </p>
    </div>
    <div style="width: 100%; height: 42px; text-align: right; margin-top: 10px; text-align: center;">
      <p style="color: #133759; font-size: 14px; font-family: Arial Nova;">
      <?php echo $plan[0]['Nombre']; ?>
      </p>
    </div>
    <div style="width: 100%; height: 20px; text-align: right; margin-top: 1px; text-align: left;">
      <p style="color: #fff; font-size: 13px; font-family: Arial Nova; margin-left: 133px;">
      <b><?php echo $_user[0]['Usuario']; ?></b>
      </p>
    </div>
    <div style="width: 100%; height: 20px; text-align: right; margin-top: 1px; text-align: left;">
      <img src="<?php echo $_user[0]['_ubicacion']; ?>" style="width: 70px; height: 70px; border-radius: 5px; margin-top:22px; margin-left: 10px;">
    </div>
    <div style="width: 100%; height: 20px; text-align: right; margin-top: 1px; text-align: left;">
      <p style="margin-left: 100px; font-size: 12px; font-family: Arial Nova;"><b>VIGENCIA:</b></p>
      <p style="margin-left: 100px; font-size: 12px; font-family: Arial Nova; margin-top:-10px;"><?php if(isset($_vigencia[0])){ echo $_vigencia[0]['Ciclo']; } else { echo "--------";} ?></p>
    </div>
  </div>
  
</div>
