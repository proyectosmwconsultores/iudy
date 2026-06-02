<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();

$alumno = $formatos->get_datos_alumno_id($IdUsua);
$disx = 0;
if($alumno[0]['IdGrado'] == 7){
  $disx = 1;
} else {
  $disx = 2;
}

$_mod = $formatos->get_mod_lista($_SESSION['IdUsua'], 1);
$_mod9 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 9);
$_mod54 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 54);
$_mod60 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 60);
$_mod62 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 62);
$_mod63 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 63);
$_mod69 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 69);
$_mod72 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 72);
$_mod73 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 73);
$_mod76 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 76);
$_mod85 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 85);
$_mod90 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 90);

$_icno = "fa fa-fw fa-warning";
if(($alumno[0]['IdEstatus'] == 61) || ($alumno[0]['IdEstatus'] == 62) || ($alumno[0]['IdEstatus'] == 55)){
  $_icno = "fa fa-fw fa-graduation-cap";
}
?>

<a href="javascript:void(0);" class="btn btn-info btn-block view_buscar"><b><i class="fa fa-fw fa-search"></i> B&uacute;squeda de alumno</b></a>
<div class="box-body box-profile">
  <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $alumno[0]["Foto"]; ?>" alt="User profile picture" style="width:100px; height: 100px;">

  <h3 class="profile-username text-center"><?php echo $alumno[0]["Nombre"]; ?></h3>

  <p class="text-muted text-center"><?php echo $alumno[0]["APaterno"] . ' ' . $alumno[0]["AMaterno"]; ?></p>
  
  <p class="text-muted text-center" style="color: red; cursor: pointer;">
  <?php if ((isset($_mod76[0])) && (($alumno[0]['IdEstatus'] == 8) || ($alumno[0]['IdEstatus'] == 55) || ($alumno[0]['IdEstatus'] == 61) || ($alumno[0]['IdEstatus'] == 62))) { ?>
  <?php if($alumno[0]["IdOferta"] == 30){ ?>
  <b onclick="modificar_modalidad(<?php echo $IdUsua; ?>)"><i class='fa fa-fw fa-check-circle'></i> Terminación: 
  <?php if($alumno[0]["Termino"] == '1'){ echo " * * * * * * * "; } elseif($alumno[0]["Termino"] == '2'){ echo "Clinica"; } elseif($alumno[0]["Termino"] == '3'){ echo "Organizacional"; } elseif($alumno[0]["Termino"] == '4'){ echo "Educativa"; } else { echo "Normal"; } ?> </b></p>
  <?php } ?>
  <?php } ?>
  <?php if ($alumno[0]['IdEstatus'] <> 60) { ?>
    <ul class="list-group list-group-unbordeblue">
      <li class="list-group-item">
        <b><?php if ($alumno[0]['IdEstatus'] == 8) {
              echo "Estatus:";
            } else { ?><i style="color: red;" class="<?php echo $_icno; ?>"></i><?php } ?></b> <a class="pull-right"><b style="font-size: 12px;"><?php echo $alumno[0]["Estatus"]; ?></b></a>
      </li>
      <li class="list-group-item">
        <b>Matr&iacute;cula</b> <a class="pull-right"><?php echo $alumno[0]["Matricula"]; ?></a>
      </li>
      <?php

      if (isset($_mod17[0])) { ?>
        <li class="list-group-item">
          <b onclick="mostrarPass()" style="cursor: pointer;"><i class="fa fa-fw fa-eye"></i></b> <a class="pull-right">
            <div class="form-group" style="margin-top: -7px;">
              <input type="password" class="form-control" id="txtP1" value="               ">
              <input type="text" class="form-control" id="txtP2" value="<?php echo $alumno[0]['Code']; ?>" style="display: none; text-align: right;">
            </div>
          </a>
        </li><?php } ?>
    </ul>
  <?php }  ?>
  <?php if ($alumno[0]['Estatus'] == 'En proceso') { ?>
    <a style="text-align: left;" onClick="window.open('addAddSeguimiento.php','_self')" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-mail-reply-all"></i> Regresar al seguimiento</a>
  <?php } ?>

  <?php
  if ($alumno[0]['Estatus'] <> 'En proceso') {

    for ($m = 0; $m < sizeof($_mod); $m++) {
      if ($_mod[$m]['Tipo'] == 'L') { ?>
        <a style="text-align: left;" onClick="window.open('<?php echo $_mod[$m]['Link']; ?><?php echo time() . $IdUsua; ?>','_self')" href="javascript:void(0);" class="btn btn-success btn-block"><i class="fa fa-qrcode"></i> <?php echo $_mod[$m]['Nombre']; ?></a>
      <?php } else { ?>
        <a style="text-align: left;" onclick="<?php echo $_mod[$m]['Link']; ?>" href="javascript:void(0);" class="btn btn-success btn-block"><i class="fa fa-qrcode"></i> <?php echo $_mod[$m]['Nombre']; ?></a>
      <?php } ?>
    <?php } ?>
    <a style="text-align: left;" onclick="window.open('adCaptura.php?idToks=<?php echo time() . $IdUsua; ?>&Ub=Px','_self')" href="javascript:void(0);" class="btn btn-warning btn-block"><i class="fa fa-edit"></i> Editar perfil</a>
    
      <a style="text-align: left;" onclick="del_alumnoId()" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-cog"></i> Estatus del alumno</a>
    

    <?php 
    
    if ((isset($_mod9[0])) && ($alumno[0]['IdEstatus'] == 8) && ($disx == 2)) { ?>
      <a style="text-align: left;" onclick="changeGrupo(<?php echo $alumno[0]["IdCampus"]; ?>,<?php echo $alumno[0]["IdEducativa"]; ?>)" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-black-tie"></i> Cambiar grupo</a>
      <a style="text-align: left;" onclick="changePlantelGrupo(<?php echo $alumno[0]['IdCampus']; ?>)" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-home"></i> Cambio plantel</a>
      
    <?php } ?>
    
    <?php if ((isset($_mod60[0])) && ($alumno[0]['IdEstatus'] == 8) && ($disx == 2)) { ?>
      <a style="text-align: left;" onclick="horario_personalizado_especial(<?php echo $IdUsua; ?>)" href="javascript:void(0);" class="btn btn-warning btn-block"><i class="fa fa-briefcase"></i> Materia personalizada </a>
    <?php } ?>
    <?php if ((isset($_mod63[0])) && ($alumno[0]['IdEstatus'] == 8) && ($disx == 1)) { ?>
      <a style="text-align: left;" onclick="configurar_curso(<?php echo $IdUsua; ?>)" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-briefcase"></i> Cursos, diplomados</a>
    <?php } ?>
    <?php if($alumno[0]['IdGrado'] == 3){ ?>
    <?php if ((isset($_mod69[0])) && (($alumno[0]['IdEstatus'] == 8)) || ($alumno[0]['IdEstatus'] == 55) || ($alumno[0]['IdEstatus'] == 61) || ($alumno[0]['IdEstatus'] == 62)) {  ?>
      <a style="text-align: left;" onclick="window.open('practica_profesional.php?IdUsua=<?php echo time() . $IdUsua; ?>','_self')" href="javascript:void(0);" class="btn btn-success btn-block"><i class="fa fa-odnoklassniki"></i> Práctica profesional</a>
    <?php }  ?>
    <?php if ((isset($_mod73[0])) && (($alumno[0]['IdEstatus'] == 8)) || ($alumno[0]['IdEstatus'] == 55) || ($alumno[0]['IdEstatus'] == 61) || ($alumno[0]['IdEstatus'] == 62)) { ?>
      <a style="text-align: left;" onclick="window.open('servicio_social.php?IdUsua=<?php echo time() . $IdUsua; ?>','_self')" href="javascript:void(0);" class="btn btn-info btn-block"><i class="fa fa-odnoklassniki"></i> Servicio social</a>
    <?php }  ?>
    <?php }  ?>

    <?php if ((isset($_mod62[0])) && (($alumno[0]['IdEstatus'] == 8)) || ($alumno[0]['IdEstatus'] == 55) || ($alumno[0]['IdEstatus'] == 61) || ($alumno[0]['IdEstatus'] == 62)) { ?>
      <a style="text-align: left;" onclick="datos_acceso_user(<?php echo $IdUsua; ?>)" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-expeditedssl"></i> Datos de acceso</a>
      <a style="text-align: left;" onclick="trayectoria_id(<?php echo $IdUsua; ?>)" href="javascript:void(0);" class="btn btn-primary btn-block"><i class="fa fa-gears"></i> Trayectoria</a>
    <?php } ?>
    <?php if ((isset($_mod72[0])) && ($alumno[0]['IdEstatus'] == 8)) { ?>
      <a style="text-align: left;" onclick="addNewPago()" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-expeditedssl"></i> Agregar pago</a>
    <?php } ?>
    <?php if ((isset($_mod85[0])) && ($alumno[0]['IdEstatus'] == 8)) { ?>
      <a style="text-align: left;" onclick="mi_credencial_id()" href="javascript:void(0);" class="btn btn-danger btn-block"><i class="fa fa-expeditedssl"></i> Credencial</a>
    <?php } ?>
    <?php if ((isset($_mod90[0])) && ($alumno[0]['IdEstatus'] == 8) && ($disx == 1)) { ?>
      <a style="text-align: left;" onclick="changePlantelGrupoDiplomado(<?php echo $alumno[0]['IdCampus']; ?>)" href="javascript:void(0);" class="btn btn-success btn-block"><i class="fa fa-home"></i> Cambio grupo diplomado</a>
    <?php } ?>
  <?php }  ?>
</div>