<?php session_start();
  include('../hace.php');
  require('../php/clases/class.php');
  $t=new Trabajo();

  $IdAsignacion = $_POST['IdAsignacion'];
  $emision=$t->get_fec_emi($IdAsignacion);
  $actaCalificacion=$t->get_actaCalificacion($IdAsignacion);
  $pa_create=$t->get_parcial_cal($IdAsignacion);
  $datP=$t->get_ofertaId($actaCalificacion[0]["IdEducativa"]);
  $usx=$t->get_usuarioId($_SESSION['IdUsua']);
  $_tix = $emision[0]['Modalidad'];
  $_f = 0;
  if($usx[0]['id_paquete']){
    $paq = $usx[0]['id_paquete'];
    $path = "../assets/firma/".$paq;
    if (file_exists($path)) {
        $_f = 1;
    } else {
        $_f = 0;
    }
  }

  $_ex = 0;
  $prom = 6;
  $grad = $datP[0]["IdGrado"];
  if($grad == 1){
  	$prom = 7;
  } elseif($grad == 2){
  	$prom = 7;
  } elseif($grad == 3){
    $prom = 6;
  } elseif($grad == 4){
    $prom = 6;
  } elseif($grad == 7){
    $prom = 6;
  }

  $cP = 0; $cB1 = 0; $cB2 = 0; $cB3 = 0;
  if($emision[0]['Fecha_impresion']){ $cP = 1;   $cB1 = 1;}
  if($emision[0]['Fec_emi_bim1']){ $cB1 = 1; }
  if($emision[0]['Fec_emi_bim2']){ $cB2 = 1; }
  if($emision[0]['Fec_emi_bim3']){ $cB3 = 1; }

  if($_tix == 'E'){
    $_doxs = "_escolar";
  } else {
    $_doxs = "_ejecutiva";
  }

  
  $x = 1;
  
  if($actaCalificacion[0]["IdEducativa"] == 33){
    $x = 1;
  }
?>
  <input id="Grado" name="Grado" value="<?php echo $datP[0]["IdGrado"]; ?>" type="hidden"/>

  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-file-text-o"></i> Captura de calificación final</h3>
    <p class="margin" style="text-align: right;">
      <code><i style="color: red;"  class="fa fa-fw fa-warning"></i> Calificación mínima aprobatoria: <?php echo $prom; ?></code>
      <code><i style="color: red;"  class="fa fa-fw fa-warning"></i> No se presento: NP</code>
    </p>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
        <tr>
          <th>#</th>
          <th>NOMBRE DEL ALUMNO</th>
          <?php  $xc = 1; $noPx = 0; for ($pa=0;$pa< sizeof($pa_create);$pa++) { $noPx = ($noPx + 1); ?>
          <th style="text-align: center; cursor: pointer; "><?php echo $pa_create[$pa]['Titulo']; ?> <br><b>(CLIC EN CADA <br>BOTON PARA GUARDAR)</b></th>
          <?php } ?>
          <?php if($x == 1){ ?>
          <th style="text-align: center; width: 200px;">PROMEDIO FINAL</th>
          <?php } ?>
          <?php if($grad == 3){ ?><th style="text-align: center; width: 40px;">EX</th><?php } ?>
        </tr>
        <?php $pr1 = 0; for ($i=0;$i< sizeof($actaCalificacion);$i++) { ?>
          <tr <?php if($actaCalificacion[$i]["IdEstatus"] <> 8){ echo "style='color: red'"; } ?>>
            <td><b><?php echo $i + 1; ?>.- </b></td>
            <td><?php echo $actaCalificacion[$i]["APaterno"].' '.$actaCalificacion[$i]["AMaterno"].' '.$actaCalificacion[$i]["Nombre"]; ?></td>
            <?php if(isset($pa_create[0]['Titulo'])){ if(isset($actaCalificacion[$i]["Parcial1"])){ $pr1 = $actaCalificacion[$i]["Parcial1"]; } else { $pr1 = 0; } ?>
            <td style="text-align: center;">
              <input id="IdModAF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
              <div class="input-group input-group-sm">
                <span style="width: 60px;" class="input-group-addon"><?php echo number_format($pr1, 1, '.', ','); ?></span>
                <input style="text-align: center; " value="<?php echo $actaCalificacion[$i]["ParcialF1"]; ?>" type="text" name="txtCalF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF1-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
                <?php if(($_SESSION['Permisos'] == 2) && ($cB1 == 0)){ ?>
                <span class="input-group-btn">
                  <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>,<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,1,<?php echo $_SESSION['IdUsua']; ?>)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
                </span><?php } ?>
              </div>
            </td><?php } ?>
            <?php if(isset($pa_create[1]['Titulo'])){ $pr2 = $actaCalificacion[$i]["Parcial2"];  ?>
            <td style="text-align: center;">
              <input id="IdModAF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
              <div class="input-group input-group-sm">
                <span style="width: 60px;" class="input-group-addon"><?php echo number_format($pr2, 1, '.', ','); ?></span>
                <input style="text-align: center; " value="<?php echo $actaCalificacion[$i]["ParcialF2"]; ?>" type="text" name="txtCalF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF2-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
                <?php if(($_SESSION['Permisos'] == 2) && ($cB2 == 0)){ ?>
                <span class="input-group-btn">
                  <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>,<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,2,<?php echo $_SESSION['IdUsua']; ?>)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
                </span><?php } ?>
              </div>
            </td>
            <?php } ?>
            <?php if(isset($pa_create[2]['Titulo'])){ $pr3 = $actaCalificacion[$i]["Parcial3"];  ?>
            <td style="text-align: center;">
              <input id="IdModAF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" name="IdModAF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" value="<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>" type="hidden"/>
              <div class="input-group input-group-sm">
                <span style="width: 60px;" class="input-group-addon"><?php echo number_format($pr3, 1, '.', ','); ?></span>
                <input style="text-align: center;" value="<?php echo $actaCalificacion[$i]["ParcialF3"]; ?>" type="text" name="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
                <?php if(($_SESSION['Permisos'] == 2) && ($cB3 == 0)){ ?>
                <span class="input-group-btn">
                  <button type="button" onclick="savCalificacion(<?php echo $actaCalificacion[$i]["IdModuloAlumno"]; ?>,<?php echo $actaCalificacion[$i]["IdUsua"]; ?>,3,<?php echo $_SESSION['IdUsua']; ?>)" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i></button>
                </span><?php } ?>
              </div>
            </td>
            <?php } ?>
            <?php if($x == 1){ ?>
            <td style="text-align: center;">
              <div class="input-group input-group-sm">
                <?php if((!$actaCalificacion[$i]["Promedio"]) && ($actaCalificacion[$i]["IdEstatus"] == 8)){ $xc = 0; } ?>
                <span style="width: 60px;" class="input-group-addon"><?php echo $actaCalificacion[$i]["Promedio"]; ?></span>
                <input disabled style="text-align: center; width: 100px;" value="<?php echo $actaCalificacion[$i]["Promedio_final"]; ?>" type="text" name="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" id="txtCalF3-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" class="form-control" >
              </div>
            </td>
            <?php } ?>
            <?php if(($grad == 3) || ($grad == 4) && ($x == 1)){ ?>
              <td style="text-align: center;">
                <div class="input-group input-group-sm">
                  <?php if($_SESSION['Permisos'] == 2){ ?>
                  <span class="input-group-btn">
                    <?php if($actaCalificacion[$i]["Promedio_final"]) {
                      if($actaCalificacion[$i]["Promedio_final"] < $prom){
                      if($actaCalificacion[$i]["Extra1"] == 1){ $_ex = 1; ?>
                        <button href="javascript:void(0);"  type="button" class="btn btn-info btn-xs pull-center" title="Extraordinario activado"> <i class="fa fa-fw fa-check-circle"></i></button>
                      <?php } else { ?>
                        <button id="btnActivar-<?php echo $actaCalificacion[$i]["IdUsua"]; ?>" onclick="actExtraAlumno(<?php echo $actaCalificacion[$i]["IdUsua"]; ?>)" href="javascript:void(0);"  type="button" class="btn btn-danger btn-xs pull-center"> <i class="fa fa-fw fa-database"></i> Ex1</button>
                    <?php } } } ?>
                   </span><?php } ?>
                </div>
              </td>
            <?php } ?>
        </tr>
      <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $vc = 0; if(($_ex == 1) && (($grad == 3) || ($grad == 4))){
    $actaExtra1=$t->get_acta_datExtra($IdAsignacion,1);
    ?>
  <hr>
  <div class="box-header">
    <h3 class="box-title"><i class="fa fa-fw fa-users"></i> Alumnos que tendrán que realizar el extraordinario</h3>
  </div>

  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
        <tr>
          <th style="width: 50px;">#</th>
          <th style="width: 120px;">NO. CONTROL</th>
          <th>NOMBRE DEL ALUMNO</th>
          <th style="text-align: center; width: 200px;">PROMEDIO FINAL</th>
        </tr>
        <?php  for ($e1=0;$e1< sizeof($actaExtra1);$e1++) { ?>
          <tr>
            <td><b><?php echo $vc = ($vc + 1); ?>.- </b></td>
            <td><?php echo $actaExtra1[$e1]["Usuario"]; ?></td>
            <td><?php echo $actaExtra1[$e1]["APaterno"].' '.$actaExtra1[$e1]["AMaterno"].' '.$actaExtra1[$e1]["Nombre"]; ?></td>

            <td style="text-align: center;">
              <input id="id_valExt<?php echo '1-'.$actaExtra1[$e1]["IdUsua"]; ?>" name="id_valExt<?php echo '1-'.$actaExtra1[$e1]["IdUsua"]; ?>" value="<?php echo $actaExtra1[$e1]["IdModuloAlumno"]; ?>" type="hidden"/>

              <div class="input-group input-group-sm">
                <input style="text-align: center;" value="<?php echo $actaExtra1[$e1]["E1"]; ?>" type="text" name="promExtr<?php echo '1-'.$actaExtra1[$e1]["IdUsua"]; ?>" id="promExtr<?php echo '1-'.$actaExtra1[$e1]["IdUsua"]; ?>" class="form-control">
                <?php if(($_SESSION['Permisos'] == 2) && (!$emision[0]['Fec_extra'])){ ?>
                <span class="input-group-btn">
                  <button type="button" onclick="savExtra(<?php echo $actaExtra1[$e1]["IdUsua"]; ?>,1)" class="btn btn-success btn-flat"><i class="fa fa-fw fa-save"></i></button>
                </span><?php } ?>
              </div>
            </td>
        </tr>
      <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
<?php } ?>

<div class="box-body">
  <div class="table-responsive">
<div class="bg-navy color-palette" style="padding: 10px;"><span style="color: yellow;"> <i class="fa fa-fw fa-check-circle"></i> Emisión de documentos</span></div>
<table class="table table-striped">
  <tbody>
    <tr>
      <th style="width: 180px;">Nombre del documento</th>
      <th style="width: 180px;">Fecha de emisión</th>
      <th style="width: 60px;">Descargar</th>
    </tr>
    <?php if(isset($pa_create[0]['Titulo'])){ ?>
    <tr>
      <td><i class='fa fa-fw fa-file-pdf-o'></i> Calificación <?php echo $pa_create[0]['Titulo']; ?></td>
      <td><?php if($emision[0]['Fec_emi_bim1']){ echo "<i class='fa fa-fw fa-calendar-check-o'></i> ".obtenerFechaEnLetra($emision[0]['Fec_emi_bim1']); } else { ?>
        <input style="width: 80%;" type="text" class="form-control" id="txt_fecha1" name="txt_fecha1">
        <span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
          <button onclick="sav_fecha_emi(1)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
        </span>
      <?php } ?></td>
      <td><?php if($emision[0]['Fec_emi_bim1']){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=1');" href="javascript:void(0);" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta</button>
        <button onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=1');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Asistencia</button>
        <?php if($_f == 1){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=1&f=1');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con firma</button>
      <?php } } ?>
      </td>
    </tr><?php } ?>
    <?php if(isset($pa_create[1]['Titulo'])){ ?>
    <tr>
      <td><i class='fa fa-fw fa-file-pdf-o'></i> Calificación <?php echo $pa_create[1]['Titulo']; ?></td>
      <td><?php if($emision[0]['Fec_emi_bim2']){ echo "<i class='fa fa-fw fa-calendar-check-o'></i> ".obtenerFechaEnLetra($emision[0]['Fec_emi_bim2']); } else { ?>
        <input style="width: 80%;" type="text" class="form-control" id="txt_fecha2" name="txt_fecha2">
        <span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
          <button onclick="sav_fecha_emi(2)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
        </span>
      <?php } ?></td>
      <td><?php if($emision[0]['Fec_emi_bim2']){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=2');" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta</button>
        <button onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=2');" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Asistencia</button>
        <?php if($_f == 1){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=2&f=1');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con firma</button>
      <?php } } ?>
      </td>
    </tr>
    <?php } ?>
    <?php if(isset($pa_create[2]['Titulo'])){ ?>
    <tr>
      <td><i class='fa fa-fw fa-file-pdf-o'></i> Calificación <?php echo $pa_create[2]['Titulo']; ?></td>
      <td><?php if($emision[0]['Fec_emi_bim3']){ echo "<i class='fa fa-fw fa-calendar-check-o'></i> ".obtenerFechaEnLetra($emision[0]['Fec_emi_bim3']); } else { ?>
        <input style="width: 80%;" type="text" class="form-control" id="txt_fecha3" name="txt_fecha3">
        <span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
          <button onclick="sav_fecha_emi(3)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
        </span>
      <?php } ?></td>
      <td><?php if($emision[0]['Fec_emi_bim3']){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=3');" type="button" class="btn bg-olive btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta</button>
        <button onclick="javascript:window.open('repositorio/portafolio/asistencia_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=3');" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Asistencia</button>
        <?php if($_f == 1){ ?>
        <button onclick="javascript:window.open('repositorio/portafolio/acta_licenciatura<?php echo $_doxs; ?>.php?tokenId=<?php echo $IdAsignacion; ?>&tok=3&f=1');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con firma</button>
      <?php } } ?>
      </td>
    </tr>
    <?php } ?>
    <tr>
      <td><i class='fa fa-fw fa-file-pdf-o'></i> Acta de calificación final</td>
      <td><?php if($emision[0]['Fecha_impresion']){ echo "<i class='fa fa-fw fa-calendar-check-o'></i> ".obtenerFechaEnLetra($emision[0]['Fecha_impresion']) ; } else { ?>
        <input style="width: 80%;" type="text" class="form-control" id="txt_fecha5" name="txt_fecha5">
        <span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
          <button onclick="sav_fecha_emi(5)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
        </span>
      <?php } ?></td>
      <td>
        <?php if($emision[0]['Fecha_impresion']){ ?>
          <button onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $IdAsignacion; ?>&x=1');" href="javascript:void(0);" type="button" title="Descargar acta de calificación" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta calificación</button>
          <?php if(($grad == 1) || ($grad == 2)){ ?>
          <button onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_asis.php?tokenId=<?php echo $IdAsignacion; ?>&x=1');" href="javascript:void(0);" type="button" title="Descargar acta de calificación" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con asistencia</button>
          <?php } ?>
          <?php if($_f == 1){ ?>
          <!-- <button onclick="javascript:window.open('repositorio/portafolio/reporte_acta.php?tokenId=<?php echo $IdAsignacion; ?>&x=1&f=1');" href="javascript:void(0);" title="Descargar acta de calificación con firma digital" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con firma</button> -->
        <?php } ?>
        <button onclick="cargar_mi_acta()" href="javascript:void(0);" type="button" class="btn bg-purple btn-flat btn-xs" title="Subir acta de calificación firmada"><i class='fa fa-fw fa-upload'></i> Acta</button>
        <?php  } ?>
      </td>
    </tr>
    <?php if($vc){ ?>
    <tr>
      <td><i class='fa fa-fw fa-file-pdf-o'></i> Acta de calificación final con extraordinario</td>
      <td><?php if($emision[0]['Fec_extra']){ echo "<i class='fa fa-fw fa-calendar-check-o'></i> ".obtenerFechaEnLetra($emision[0]['Fec_extra']) ; } else { ?>
        <input style="width: 80%;" type="text" class="form-control" id="txt_fecha4" name="txt_fecha4">
        <span class="input-group-btn" style="float: right; margin-right: 80px; margin-top: -34px;">
          <button onclick="sav_fecha_emi(4)" type="button" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Guardar</button>
        </span>
      <?php } ?></td>
      <td>
        <?php if($emision[0]['Fec_extra']){ ?>
          <button onclick="javascript:window.open('repositorio/portafolio/acta_calificacion_final.php?tokenId=<?php echo $IdAsignacion; ?>');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta</button>
          <?php if($_f == 1){ ?>
          <!-- <button onclick="javascript:window.open('repositorio/portafolio/reporte_acta.php?tokenId=<?php echo $IdAsignacion; ?>&f=1');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat btn-xs"><i class='fa fa-fw fa-download'></i> Acta con firma</button> -->
        <?php } } ?>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
</div>
</div>
<input type="hidden" value="<?php echo $xc; ?>" name="_disponix" id="_disponix">


<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>

$(function () {
	$('#txt_fecha1').datepicker({
		autoclose: true
	})
  $('#txt_fecha2').datepicker({
		autoclose: true
	})
  $('#txt_fecha3').datepicker({
		autoclose: true
	})
  $('#txt_fecha4').datepicker({
		autoclose: true
	})
  $('#txt_fecha5').datepicker({
		autoclose: true
	})
})
function savCalificacion(IdModuloAlumno,IdUsua,Parcial,IdAdmin){
  var ModAlum = "IdModAF"+Parcial+"-"+IdUsua;
  var CalAlum = "txtCalF"+Parcial+"-"+IdUsua;
  var IdModA = document.getElementById(ModAlum).value;
  var Calif = document.getElementById(CalAlum).value;
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var TipoGuardar = "sav_cal_udech"; 

  if (Calif==''){
    swal("Error al guardar", "Debe escribir la calificaci\u00F3n final.", "error");
      document.getElementById(CalAlum).focus();
      document.getElementById(CalAlum).value0 = '';
      return 0;
  }

  if ((Calif == 5) || (Calif == 6) || (Calif == 7) || (Calif == 8) || (Calif == 9) || (Calif == 10)){
    } else {
      swal("Error al guardar", "El promedio final debe de ser un numero entero. \n Ejemplo: 5, 6, 7, 8, 9, 10", "error");
        document.getElementById(CalAlum).focus();
        cargar_calificacionx(IdAsignacion);
        return 0;
    }

  $.ajax({
        url:"formConsulta/setting.php",
        method:"POST",
        data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, Parcial:Parcial, IdUsua:IdUsua, IdModuloAlumno:IdModuloAlumno, IdAdmin:IdAdmin},
        success:function(data){ 
           
          if(data == 1){
            swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
            cargar_calificacionx(IdAsignacion);
            // parent.location.href='doSelActa.php';
          }
        }
   })
}

function savPromedio(IdUsua){
  var Boton = "btnP-"+IdUsua;
  var ModAlum = "IdModP-"+IdUsua;
  var CalAlum = "txtPromx-"+IdUsua;

  var IdModA = document.getElementById(ModAlum).value;
  var Calif = document.getElementById(CalAlum).value;

  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var Grado = document.getElementById("Grado").value;

  var TipoGuardar = "savPromedio";
  if (Calif==''){
    swal("Error al guardar", "Debe escribir el promedio final de la materia.", "error");
      document.getElementById(CalAlum).focus();
      return 0;
  }

  if((Grado == 1) || (Grado == 2) || (Grado == 3)){
    if ((Calif == 5) || (Calif == 6) || (Calif == 7) || (Calif == 8) || (Calif == 9) || (Calif == 10) || (Calif == 'NP')){
    } else {
      swal("Error al guardar", "Debe escribir el promedio final de la materia. \n Ejemplo: 5, 6, 7, 8, 9, 10", "error");
        document.getElementById(CalAlum).focus();
        return 0;
    }
  }

  $.ajax({
        url:"formConsulta/setting.php",
        method:"POST",
        data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, IdUsua:IdUsua},
        success:function(data){
          if(data == 1){
            swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
            cargar_calificacionx(IdAsignacion);
          }
        }
   })
}

function savExtra(IdUsua,Extra){ 
  var IdModAlum = "id_valExt"+Extra+'-'+IdUsua;
  var PromExtr1 = "promExtr"+Extra+'-'+IdUsua;

  var IdModA = document.getElementById(IdModAlum).value;
  var Calif = document.getElementById(PromExtr1).value;

  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var Grado = document.getElementById("Grado").value;

  var TipoGuardar = "savExtra";
  if (Calif==''){
    swal("Error al guardar", "Debe escribir el promedio final del extraordinario.", "error");
      document.getElementById(PromExtr1).focus();
      return 0;
  }


  if((Grado == 1) || (Grado == 2) || (Grado == 3)){
    if ((Calif == 5) || ((Calif == 6)) ||  (Calif == 7) || (Calif == 8) || (Calif == 9)){
    } else {
      swal("Error al guardar", "Debe escribir el promedio final del extraordinario. \n Ejemplo: 5, 6, 7, 8, 9", "error");
        document.getElementById(PromExtr1).focus();
        return 0;
    }
  }

  $.ajax({
        url:"formConsulta/setting.php",
        method:"POST",
        data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Calif:Calif, IdModA:IdModA, IdUsua:IdUsua, Extra:Extra},
        success:function(data){
           //alert(data);
          if(data == 1){
            swal("Guardado correctamente", "Calificaci\u00F3n guardada correctamente.", "success");
            cargar_calificacionx(IdAsignacion);
          }
        }
   })
}

function sav_fecha_emi(Campo){
  var IdAsignacion = document.getElementById("IdAsignacion").value;
  var Fecha = document.getElementById("txt_fecha"+Campo).value;
  var Disponix = document.getElementById("_disponix").value;
  
  if (Disponix==0){
    swal("Error al generar", "Favor de revisar, no se han guardado todos los promedios finales de los alumnos.", "error");
      return 0;
  } 
  
  if (Fecha==''){
    swal("Error al guardar", "Debe seleccionar la fecha de emisión del documento.", "error");
      document.getElementById("txt_fecha").focus();
      return 0;
  }
  var TipoGuardar = "sav_fec_emix";
  $.ajax({
        url:"formConsulta/setting.php",
        method:"POST",
        data:{TipoGuardar:TipoGuardar,IdAsignacion:IdAsignacion, Fecha:Fecha, Campo:Campo},
        success:function(data){ 
          if(data == 1){
            swal("Generado correctamente", "El documento ya se encuentra disponible para descargar.", "success");
            cargar_calificacionx(IdAsignacion);
          }
        }
   })
}



</script>
