<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$_cert = $formatos->obtener_datos_certificado($IdUsua);
$dispo = 0;
if($_cert[0]['IdCiclo'] > 0){
  $_formato = $formatos->obtener_lista_materias_persona($IdUsua);
  $dispo = 1;
} else {
  $_formato = $formatos->obtener_lista_materias($IdUsua);
}


$_us = $formatos->usuario_id($IdUsua);

$_mod81 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 81);
$_mod82 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 81);


?>
<div class="btn-group" style="float: left;">
<button onClick="window.open('perfil.php?token=<?php echo time().$IdUsua; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-warning"><i class="fa fa-history"></i> Regresar</button>

<!-- <button onclick="configurar_materias(<?php echo $IdUsua; ?>)" type="button" class="btn btn-info"><i class="fa fa-fw fa-cog"></i> Configurar</button> -->
<?php if(isset($_mod82[0])) { ?>
<button onclick="configurar_calificaciones(<?php echo $IdUsua; ?>)" type="button" class="btn btn-info"><i class="fa fa-fw fa-check-circle"></i> Configurar calificación</button>
<?php } ?>
<?php if(isset($_mod81[0])) { ?>
<button onclick="configurar_quivalencia(<?php echo $IdUsua; ?>)" type="button" class="btn btn-danger"><i class="fa fa-fw fa-cog"></i> Equivalencia</button>
<button onclick="configurar_convalidacion(<?php echo $IdUsua; ?>)" type="button" class="btn btn-primary"><i class="fa fa-fw fa-cog"></i> Convalidación</button>
<?php } ?>
<button onclick="configurar_certificado(<?php echo $IdUsua; ?>)" type="button" class="btn btn-success"><i class="fa fa-fw fa-cog"></i> Configurar impresión</button>

<!-- <button onclick="javascript:window.open('repositorio/formatos/certificadoLicenciatura.php?idToks=<?php echo time() . $IdUsua; ?>');" href="javascript:void(0);" type="button" class="btn btn-info"><i class="fa fa-fw fa-cog"></i> Imprimir Certificado de estudios</button> -->
<?php if(($_us[0]['Grado'] == 1) || ($_us[0]['Grado'] == 2) || ($_us[0]['Grado'] == 3) || ($_us[0]['Grado'] == 4)){ ?>
  <div class="input-group-btn">
<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-fw fa-print"></i> Impresión
<span class="fa fa-caret-down"></span></button>
<ul class="dropdown-menu">
<li><a onclick="javascript:window.open('repositorio/formatos/kardex.php?idToks=<?php echo time() . $IdUsua; ?>');" href="javascript:void(0);" >Kardex</a></li>
<?php if($_us[0]['Grado'] == 3){ ?>
  <?php if(isset($_cert[0]['acta_fecha'])){ ?>
  <li><a onclick="window.open('https://sciudy.s3mwc.com/documentos/actaExamen?idToks=<?php echo $_cert[0]['Code']; ?>','_blank')" href="javascript:void(0);">Acta de examen</a></li>
  <!--<li><a onclick="javascript:window.open('repositorio/formatos/acta_licenciatura.php?idToks=<?php echo $_cert[0]['Code']; ?>');" href="javascript:void(0);">Acta de examen</a></li>-->
  <?php } ?>
<?php if($_us[0]['_certificado'] == 1){ ?>
    <li><a onclick="javascript:window.open('reportes/imprimir/certificadoLicenciatura.php?idToks=<?php echo time() . $IdUsua; ?>');" href="javascript:void(0);">Certificado de estudios</a></li>
    
<?php } } ?>

<?php

if(($_us[0]['Grado'] == 2) || ($_us[0]['Grado'] == 1)){ ?>
<?php if($_us[0]['_certificado'] == 1){ ?>
    <li><a onclick="javascript:window.open('reportes/imprimir/certificadoMaestria.php?idToks=<?php echo time() . $IdUsua; ?>');" href="javascript:void(0);">Certificado de estudios</a></li>
<?php } } ?>


<?php if(($_us[0]['_titulo'] == 1) ||  ($_us[0]['Grado'] == 2) || ($_us[0]['Grado'] == 3)){ ?>
    <li><a onclick="javascript:window.open('repositorio/formatos/titulo.php?idToks=<?php echo $_cert[0]['Code']; ?>');" href="javascript:void(0);">Titulo</a></li>
<?php } ?>

<?php if((isset($_cert[0]['acta_fecha'])) && ($_us[0]['Grado'] == 2)){ ?>
<li><a onclick="window.open('https://sciudy.s3mwc.com/documentos/actaExamen?idToks=<?php echo $_cert[0]['Code']; ?>','_blank')" href="javascript:void(0);">Acta de examen</a></li>
  <!--<li><a onclick="javascript:window.open('repositorio/formatos/acta_maestria.php?idToks=<?php echo $_cert[0]['Code']; ?>');" href="javascript:void(0);">Acta de examen</a></li>-->
  <?php } ?>

</ul>
</div>
<?php } else { ?>
  <button onclick="javascript:window.open('repositorio/formatos/kardexPosgrado.php?idToks=<?php echo time() . $IdUsua; ?>');" href="javascript:void(0);" type="button" class="btn btn-primary"><i class="fa fa-fw fa-print"></i> Kardex de Calificaciones</button>
<?php } ?>

</div><br><br>
<table class="table table-striped">
  <tbody>

    <?php $ci = 0;
    $cf = 0;
    
    for ($x = 0; $x < sizeof($_formato); $x++) {
      if($dispo == 0){ $ci = $_formato[$x]['IdCiclo']; } else { $ci = $_formato[$x]['Grado'];  }

      
      if ($ci <> $cf) { ?>
        <tr>
        <tr>
          <th colspan="4" style="background: #1d3462; color: white;">PERIODO ESCOLAR: 
          <?php if($dispo == 1){
          $cicx = $formatos->obtener_ciclo_impresion($_cert[0]['IdCiclo'],$ci);
          echo $cicx[0]['Ciclo'];
			?>
			<?php } else { ?>
        <?php echo $_formato[$x]['Ciclo']; ?></th>
			<?php } ?>        
        </tr>
        <tr>
          <th>NOMBRE DE LA MATERIA</th>
          <th style="text-align: center;">PROMEDIO</th>
          <th style="text-align: center;">OBSERVACIÓN</th>
          <th></th>
        </tr>
      <?php } ?>
      <tr>
        <td><?php echo $_formato[$x]['CodeModulo']; ?> <?php echo $_formato[$x]['NombreMod']; ?></td>
        <td style="text-align: center;"><?php echo $_formato[$x]['Promedio']; ?></td>
        <td style="text-align: center"><span class="badge bg-red"><?php echo $_formato[$x]['_obs']; ?></span></td>
        
      </tr>
    <?php if($dispo == 0){ $cf = $_formato[$x]['IdCiclo']; } else { $cf = $_formato[$x]['Grado'];  }  
    } ?>
  </tbody>
</table>

