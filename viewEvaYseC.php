<?php $mnAl = 2; $section = "Mi espacio"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está consultando la informacion general del curso'); }
$IdActividadDoc = substr($_GET["Id"],10,10);
$IdParcialDoc = substr($_GET["IdP"],10,10);
$IdTarea = substr($_GET["IdT"],10,10);
$IdUsua = $_SESSION["IdUsua"];
$IdAsig = $_SESSION["IdAsignacion"];
$inicio = 0;
$actiEva=$t->get_datosAc($IdActividadDoc);
$fini = $actiEva[0]["Ini"];

if($fini){
  $fini = strtotime($actiEva[0]["Ini"]);
  $ffin = strtotime($actiEva[0]["Fin"]);
  $hoy = strtotime(date("Y-m-d H:m:s"));

  if (($hoy >= $fini) && ($hoy <= $ffin) ){
     $inicio = 1;
   } else {
     $inicio = 0;
   }
} else {
  $inicio = 1;
}

$datExamenIni=$t->get_examIni($IdAsig,$IdParcialDoc,$IdActividadDoc,$IdUsua,$IdTarea);


if(($datExamenIni[0]["IdEstatus"] == 12) && ($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){
  $addPreguntas=$t->get_addPregunEx($IdAsig,$IdParcialDoc,$IdActividadDoc,$datExamenIni[0]["IdExamenUsua"],$IdUsua,$IdTarea);
}

if(($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){
$datPreguntas=$t->get_pregunExa($datExamenIni[0]["IdExamenUsua"],$IdAsig,$IdActividadDoc);
$datPreC=$t->get_pregList($datExamenIni[0]["IdExamenUsua"],$IdAsig,$IdActividadDoc);
$datResP=$t->get_RespLusa($datExamenIni[0]["IdExamenUsua"],$IdAsig,$IdActividadDoc);

if($datPreC[0]["Preguntas"]){
  $valorPre = (100 / $datPreC[0]["Preguntas"]);
  $avaPre = ($datResP[0]["Contestadas"] * $valorPre);
}

if($datPreC[0]["Preguntas"] == $datResP[0]["Contestadas"]){
 $text = "Haz contestado todas las preguntas";
}

}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
    <section class="content-header">
      <h1>
        Evaluaci&oacute;n - <?php echo $inicio; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $AsignacionId[0]["NombreMod"];?></a></li>
        <li class="active">Informaci&oacute;n</li>
      </ol>
    </section>
    <?php if(($datExamenIni[0]["Valor"] == 1) && ($inicio == 1)){ ?>
      <section class="invoice">
        <form name="frm" class="form-horizontal" id="frm" action="viewEvaYseC.php" method="POST" enctype="multipart/form-data">
          <input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden"/>
          <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $IdParcialDoc; ?>" type="hidden"/>
          <input id="IdTarea" name="IdTarea" value="<?php echo $IdTarea; ?>" type="hidden"/>

          <div class="row">
            <div class="col-xs-12">

              <h2 class="page-header">
                <i class="fa fa-globe"></i> <?php echo $actiEva[0]["NomActividad"].' - '.$IdAsig.'_'.$IdActividadDoc; ?>
                <small class="pull-right">Inicio el examen: <?php echo $datExamenIni[0]["FecIni"]; ?></small>
              </h2>
              <?php if($actiEva[0]["Ini"]){ ?>
              <div class="bg-purple color-palette" style="padding: 10px; font-weight: bold; font-size: 18px;">
                <span>Inicio de evaluación: <?php echo obtenerFechaEnLetra($datExamenIni[0]["FecIni"]); ?> a partir de las <?php echo substr($datExamenIni[0]["FecIni"], 11, 10); ?> hasta las <?php echo substr($datExamenIni[0]["FecFin"], 11, 10); ?></span>
              </div><?php } ?>
              <br>
            </div>
            <h4>Avance de preguntas contestadas: <?php echo $datResP[0]["Contestadas"]; ?> de <?php echo $datPreC[0]["Preguntas"]; ?></h4>
            <div class="progress progress-sm active">
              <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avaPre; ?>%">
                <span class="sr-only">20% Complete</span>
              </div>
            </div>

          </div>

      <div class="row">
        <h1 style="text-align: center; "><?php if($text){ echo $text; } ?></h1>
        <?php for ($i=0;$i< sizeof($datPreguntas);$i++) {
          $datRespuesta=$t->get_respuestaE($datPreguntas[$i]["IdPregunta"]);
          ?>
        <div class="col-xs-12 table-responsive">
          <p class="lead"><?php echo $datPreguntas[$i]["Pregunta"]; ?></p>
          <table class="table table-striped">
            <thead>
              <?php if($datPreguntas[$i]["Imagen"]){ ?>
                <img src="assets/images/examen/<?php echo $datPreguntas[$i]["Imagen"]; ?>" width="100%">
              <?php } ?>
              <?php if($datPreguntas[$i]["Tipo"] == "O"){ for ($x=0;$x< sizeof($datRespuesta);$x++) { ?>
            <tr>
              <th width="100px;">
                <button onclick="agregarRespuesta(<?php echo $datPreguntas[$i]["IdResultado"]; ?>,<?php echo $datRespuesta[$x]["IdRespuesta"]; ?>)" type="button" class="btn btn-default"><i class="fa fa-fw fa-check-circle"></i></button>
              </th>
              <th>
                <?php echo $x + 1; ?>)  <?php echo $datRespuesta[$x]["Respuesta"]; ?>
              </th>

            </tr><?php } } else { ?>
              <tr>
                <th><p class="lead"><b>Escriba su respuesta:</b> </p></th>
              </tr>
              <tr>
                <th>
                  <textarea class="form-control" name="txtRespuesta" id="txtRespuesta"></textarea>
                </th>

              </tr>
              <tr>
                <th><button onclick="envioRespuesta(<?php echo $datPreguntas[$i]["IdResultado"]; ?>)" type="button" class="btn btn-primary pull-right"><i class="fa fa-send"></i> Responder</button></th>
              </tr>
            <?php } ?>
            </thead>

          </table>
        </div>
      <?php } ?>
      </div>


</form>

    </section>
  <?php } else { ?>
    <section class="invoice">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> <?php echo $actiEva[0]["NomActividad"].' - '.$IdAsig.'_'.$IdActividadDoc;; ?>
          <small class="pull-right" style="color: blue;"><b>No disponible</b></small>
        </h2>
      </div>
      <br><br><br>

      <div class="col-md-12">
        <?php if($actiEva[0]["Ini"]){ ?>
        <div class="bg-red-active color-palette" style="padding: 10px; font-weight: bold; font-size: 18px;">
          <span>Fecha de la evaluación: <?php echo obtenerFechaEnLetra($actiEva[0]["Ini"]); ?> a partir de las <?php echo substr($actiEva[0]["Ini"], 11, 10); ?> hasta el día <?php echo obtenerFechaEnLetra($actiEva[0]["Fin"]); ?> hasta las <?php echo substr($actiEva[0]["Fin"], 11, 10); ?></span>
        </div><?php } ?>
        <br><br>
          <div class="box box-widget widget-user-2">
            <div class="widget-user-header bg-purple">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Avatar">
              </div>
              <h3 class="widget-user-username">Evaluación no disponible</h3>
              <h5 class="widget-user-desc">Su evaluación no esta activo.</h5>
            </div>
          </div>
        </div>

        <br><br>

    </div>
  </section>
  <?php } ?>
  </div>

  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<script>
  function agregarRespuesta(IdResultado, IdRespuesta){
    var IdActividadDoc = document.getElementById("IdActividadDoc").value;
    var IdParcialDoc = document.getElementById("IdParcialDoc").value;
    var IdTarea = document.getElementById("IdTarea").value;

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
        var datos = 'IdResultado=' + IdResultado + '&TipoGuardar=' + TipoGuardar + '&IdRespuesta=' + IdRespuesta;
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
            parent.location.href='viewEvaYseC.php?Id=8752342637'+IdActividadDoc+'&IdP=3647589753'+IdParcialDoc+'&IdT=8630253762'+IdTarea;
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
</script>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>


</body>
</html>
