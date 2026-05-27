<?php $_v = 2;  $section = "Mi evaluación"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'El usuario ha ingresado a realizar su evaluación.'); }
$IdAsignacion =  $_GET["idAsignacion"];
$porciones = explode("_", $_GET["idLeccion"]);
$IdParcial =  $porciones[0];
$IdSemana =  $porciones[1];
$IdActividad =  $porciones[2];
$IdTarea =  $porciones[3];
$lst_actividad=$contenido->get_lst_actividad($IdActividad);
$id_T = $lst_actividad[0]['IdTipoActividad']; if($id_T == 1){ $ico_ = 'fa fa-edit'; } elseif($id_T == 2){ $ico_ = 'fa fa-comments'; }elseif($id_T == 3){ $ico_ = 'fa fa-upload'; }
$disponible = 1;
$inicio = 0;
$_texto1 = ''; $_texto2 = '';
if($lst_actividad[0]["Ini"]){
$fini = strtotime($lst_actividad[0]["Ini"]);
$ffin = strtotime($lst_actividad[0]["Fin"]);
$hoy = strtotime(date("Y-m-d H:m:s"));

if (($hoy >= $fini) && ($hoy <= $ffin) ){
     $inicio = 1;
     $_texto1 = "<i class='fa fa-check-circle'></i> Evaluación en horario disponible"; $cols1 = 'blue';
   } else {
     $inicio = 0;
     $_texto1 = "<i class='fa fa-times-circle'></i> La evaluación no se encuentra en horario disponible"; $cols1 = 'red';
   }
} else {
  $inicio = 1;
  $_texto1 = "<i class='fa fa-check-circle'></i> Evaluación en horario disponible"; $cols1 = 'blue';
}

 $inicio;
 $datExamenIni=$contenido->get_examIni($IdAsignacion,$IdParcial,$IdActividad,$_SESSION['IdUsua'],$IdTarea);
 if($datExamenIni[0]['Valor'] == 1){
   $_texto2 = "<i class='fa fa-check-circle'></i> Evaluación activada"; $cols2 = 'blue';
 } else {
   $_texto2 = "<i class='fa fa-times-circle'></i> Su usuario no tiene activa la evaluación"; $cols2 = 'red';
 }

 if(($datExamenIni[0]["IdEstatus"] == 12) && ($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){
   $contenido->get_addPregunEx($IdAsignacion,$IdParcial,$IdActividad,$datExamenIni[0]["IdExamenUsua"],$_SESSION['IdUsua'],$IdTarea,$_GET["idLeccion"]);
 }

 if(($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){ $disponible = 2;
    $datPreguntas=$contenido->get_pregunExa($datExamenIni[0]["IdExamenUsua"],$IdAsignacion,$IdActividad);

    $datResP=$contenido->get_RespLusa($datExamenIni[0]["IdExamenUsua"],$IdAsignacion,$IdActividad);

   if($datExamenIni[0]["NoPregunta"]){
     $valorPre = (100 / $datExamenIni[0]["NoPregunta"]);
     $avaPre = ($datResP[0]["Contestadas"] * $valorPre);
   }

   if($datExamenIni[0]["NoPregunta"] == $datResP[0]["Contestadas"]){ $disponible = 3;
    $text = "Haz contestado todas las preguntas";
    $_texto1 = "<i class='fa fa-check-circle'></i> Evaluación realizada"; $cols1 = 'green';
    $_texto2 = "";
   }

 }

 $materia = $t->get_datosModuloD($_GET['idAsignacion']);

   $xmodulo = "Esta en la materia -> ".$materia[0]['NombreMod'];
  $actv = "Mi lección -> examen -> ".$lst_actividad[0]['NomActividad'];
  
  $addIngresos=$t->add_registros($_SESSION['IdUsua'],$xmodulo,'Mi examen',$actv,$_GET['idAsignacion'],$_SESSION['IdUsua'],$IdActividad); 


?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Evaluación: <?php echo $lst_actividad[0]['NomActividad']; ?></h1>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="mi_examen.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idAsignacion" id="idAsignacion" value="<?php echo $_GET["idAsignacion"]; ?>">
        <input type="hidden" name="IdParcial" id="IdParcial" value="<?php echo $IdParcial; ?>">
        <input type="hidden" name="IdSemana" id="IdSemana" value="<?php echo $IdSemana; ?>">
        <input type="hidden" name="IdActividad" id="IdActividad" value="<?php echo $IdActividad; ?>">
        <input type="hidden" name="IdTarea" id="IdTarea" value="<?php echo $IdTarea; ?>">
        <input type="hidden" name="IdLeccion" id="IdLeccion" value="<?php echo $_GET['idLeccion']; ?>">
        <input type="hidden" name="IdUsua" id="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>">
        <div class="row">
        <div class="col-md-3">
          <?php if($IdActividad){ ?>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="font-size: 15px;"><i class="fa fa-fw fa-question-circle"></i> Información</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked" style="font-size: 12px;">
                <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o text-red"></i> Inicia: <?php echo fechaMes($lst_actividad[0]['Ini']).' a las '.substr($lst_actividad[0]['Ini'],10,10); ?></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-calendar-times-o text-yellow"></i> Finaliza: <?php echo fechaMes($lst_actividad[0]['Fin']).' a las '.substr($lst_actividad[0]['Fin'],10,10); ?></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-clock-o text-light-blue"></i> Duración de <?php echo $lst_actividad[0]['Tiempo']; ?> hrs</a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-server text-light-blue"></i> Porcentaje: <?php echo $lst_actividad[0]['Porcentaje']; ?> %</a></li>
                <?php if(isset($datExamenIni[0]["FecIni"])){ ?>
                <li><a href="javascript:void(0);"><i class="fa fa-clock-o text-blue"></i> <?php echo substr($datExamenIni[0]["FecIni"],10,9); ?> a <?php echo substr($datExamenIni[0]["FecFin"],10,9); ?></a></li><?php } ?>
                <li><a href="javascript:void(0);"><i class="fa fa-qrcode text-light-blue"></i> <?php echo $_GET['idLeccion']; ?></a></li>
                <li><a onclick="window.open('miAula.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>&idToks=<?php echo $IdParcial.'_'.$IdSemana.'_'.$IdActividad; ?>','_self')" href="javascript:void(0);"><i class="fa fa-mail-reply-all text-light-black"></i> Regresar a mi unidad</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <?php } ?>
          <!-- /.box -->
        </div>

        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true"><i class="<?php echo $ico_; ?>"></i> <?php echo $lst_actividad[0]['NomActividad']; ?></a></li>

              <li class="pull-right"><a href="javascript:void(0);" style="color: <?php echo $cols2; ?>" class="text-muted"><?php echo $_texto2; ?></a></li>
              <li class="pull-right"><a href="javascript:void(0);" style="color: <?php echo $cols1; ?>" class="text-muted"><?php echo $_texto1; ?></a></li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
                <?php if(($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){ ?>
                <div class="post">
                  <p>Preguntas contestadas: <code><?php echo $datResP[0]["Contestadas"]; ?> de <?php echo $datExamenIni[0]["NoPregunta"]; ?></code></p>
                  <div class="progress progress-sm active">
                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avaPre; ?>%">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </div><?php } ?>
                <?php if(isset($datPreguntas[0])){ for ($i=0;$i< sizeof($datPreguntas);$i++) {
                  $datRespuesta=$contenido->get_respuestaE($datPreguntas[$i]["IdPregunta"]);
                  ?>
                <div class="post">
                  <h3><?php echo $datPreguntas[$i]['Pregunta']; ?></h3>
                  <div class="box-body">
                    <?php if($datPreguntas[$i]["Imagen"]){ ?>
                      <img src="assets/docs/files/<?php echo $datPreguntas[$i]["Anio"]; ?>/<?php echo $datPreguntas[$i]["Mes"]; ?>/<?php echo $datPreguntas[$i]["Imagen"]; ?>" style="width: 100%; border: 2px solid black; margin-bottom: 20px;">
                    <?php } ?>
                    <?php if($datPreguntas[$i]["Tipo"] == "O"){ for ($x=0;$x< sizeof($datRespuesta);$x++) { ?>
                    <a class="btn btn-block btn-social btn-bitbucket" onclick="agregarRespuesta(<?php echo $datPreguntas[$i]["IdResultado"]; ?>,<?php echo $datRespuesta[$x]["IdRespuesta"]; ?>,<?php echo $datPreguntas[$i]["IdPregunta"]; ?>)" href="javascript:void(0);">
                      <i class="fa fa-info-circle"></i> <?php echo $datRespuesta[$x]["Respuesta"]; ?>
                    </a>
                  <?php } } else { ?>
                    <div class="form-group">
                      <label>Escriba su respuesta:</label>
                      <textarea class="form-control" name="txtRespuesta" id="txtRespuesta" rows="3" placeholder="..."></textarea>
                      <button onclick="envio_mirespuesta(<?php echo $datPreguntas[$i]["IdResultado"]; ?>)" type="button" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Enviar mi respuesta</button>
                    </div>
                  <?php } ?>

                  </div>
                </div><?php } }  ?>
                <?php if($disponible == 1){ ?><div class="post"> <img src="assets/images/no_disponible.jpg" style="width: 100%;"> </div><?php } ?>
                <?php if($disponible == 3){ ?><div class="post"> <img src="assets/images/evaluacion_completada.jpg" style="width: 100%;"> </div><?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </section>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>

function agregarRespuesta(IdResultado, IdRespuesta, IdPregunta){
  var IdActividadDoc = document.getElementById("IdActividad").value;
  var IdParcialDoc = document.getElementById("IdParcial").value;
  var IdTarea = document.getElementById("IdTarea").value;
  var IdLeccion = document.getElementById("IdLeccion").value;
  var IdAsignacion = document.getElementById("idAsignacion").value;

  var TipoGuardar = "savExamenRes";
  swal({
    title: "\u00BFEst\u00E1 seguro de enviar estar respuesta como correcta?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Aceptar',
    cancelButtonText: "Cancelar",
  },
  function (isConfirm) {
    if (isConfirm) {
      $(".confirm").attr('disabled', 'disabled');
      var datos = 'IdResultado=' + IdResultado + '&TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta + '&IdPregunta=' + IdPregunta;
      $.ajax({
        type:"POST",
        url:"insertar.php",
        data:datos,
        success:function(data){
        }
      }) //terminas
      .done(function(data) {
        if(data==1){
          swal("Guardado correctamente", "Respuesta guardada correctamente.", "success");
          parent.location.href='mi_examen.php?idAsignacion='+IdAsignacion+'&idLeccion='+IdLeccion;
        }else{
          swal("Error al guardar", "No se puede guardar, verifique sus datos.", "error");
        }
      })
      .error(function(data) {
        swal("Error al guardar 0x11", "No se puede guardar, comuniquese con el desarrollador.", "error");
      });
    }
  });


}

function envio_mirespuesta(IdResultado){
  var Respuesta = document.getElementById("txtRespuesta").value;
  var IdActividadDoc = document.getElementById("IdActividad").value;
  var IdParcialDoc = document.getElementById("IdParcial").value;
  var IdTarea = document.getElementById("IdTarea").value;
  var IdLeccion = document.getElementById("IdLeccion").value;
  var IdAsignacion = document.getElementById("idAsignacion").value;

  if (Respuesta ==''){
      swal("Error al guardar", "Debe escribir su respuesta a esta pregunta.", "error");
      document.getElementById("txtRespuesta").focus();
      return 0;
  }


	var TipoGuardar = "savRespuetsaExs";
	swal({
		title: "\u00BFEst\u00E1 seguro que desea enviar esta respuesta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');
			var datos = 'TipoGuardar=' + TipoGuardar + '&Respuesta=' + Respuesta + '&IdResultado=' + IdResultado;
			$.ajax({
				type:"POST",
				url:"insertar.php",
				data:datos,
				success:function(data){

				}
			})
			.done(function(data) {

        if(data==1){
					swal("Guardado correctamente", "Respuesta ha sido guardado correctamente.", "success");
					parent.location.href='mi_examen.php?idAsignacion='+IdAsignacion+'&idLeccion='+IdLeccion;
				}
				if(data==0){
					swal("Error al publicar", "No se puede publicar, verifique sus datos.", "error");
				}
			})
			.error(function(data) {
				swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
			});
		}
	});
}


</script>
</body>
</html>
