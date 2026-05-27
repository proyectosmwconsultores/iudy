<?php $valor = 3; $section = "Preguntas de la evaluación"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está el el modulo de altas de tipos de evaluaciones'); }

$lstEvaId=$t->get_tipoEvaluacionId(substr($_GET['idToks'],10,10));
$lstPreg=$t->get_lstPreguntas(substr($_GET['idToks'],10,10));

?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?php echo $lstEvaId[0]['Evaluacion']; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"><?php echo $lstEvaId[0]['Evaluacion']; ?></li>
      </ol>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="adPreguntas.php" method="POST" enctype="multipart/form-data">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="box-primary">
                    <div class="box-footer">
                      <h3 class="box-title">Lista de preguntas</h3>
                    </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="box-primary">
                    <div class="box-footer" style=" text-align: right;">
                      <a onClick="window.open('adEvaluacion.php','_self')" href="javascript:void(0);" class="btn btn-app">
                        <i class="fa fa-mail-reply-all"></i> Regresar
                      </a>
                      <a onclick="addModulo(<?php echo substr($_GET['idToks'],10,10); ?>)" href="javascript:void(0);" class="btn btn-app">
                        <i class="fa fa-plus-circle"></i> Crear módulo
                      </a>
                      <a onclick="addPregunta(<?php echo substr($_GET['idToks'],10,10); ?>)" href="javascript:void(0);" class="btn btn-app">
                        <i class="fa fa-plus-circle"></i> Nueva pregunta
                      </a>
                    </div>
                  </div>
              </div>
              <div class="box-body">

                <table class="table table-striped">
                    <?php $mi = 0; $mf = 0;  $h = 0; $bi = 0; $bf = 0;
                    for ($i=0;$i< sizeof($lstPreg);$i++) { $mi = $lstPreg[$i]["IdMod"]; $bi = $lstPreg[$i]["IdBloque"];
                      if($mi <> $mf){ $h = 0; ?>
                        <tr style="background: #3c8dbc; color: black;">
                          <td colspan='4'>
                            <i class="fa fa-fw fa-bookmark-o"></i> <?php echo $lstPreg[$i]["Nombre_mod"]; ?>
                          </td>
                      </tr>
                      <?php }
                      if($bi <> $bf){ ?>
                        <tr style="background: #b5bbc8; color: black;">
                          <td colspan='4'>
                            <i class="fa fa-fw fa-check-circle"></i> <?php echo $lstPreg[$i]["Bloque"]; ?>
                          </td>
                      </tr>
                      <?php } ?>
                    <tr <?php if($lstPreg[$i]["IdEstatus"] == 9){ echo " style='background: red; '"; } ?> >
                      <td><b><?php echo $h = $h + 1; ?>.- </b></td>
                      <td><?php echo $lstPreg[$i]["Pregunta"]; ?></td>
                      <td><?php echo $lstPreg[$i]["Estatus"]; ?></td>
                      <td style="width: 120px;">
                        <button title="Actualizar pregunta" type="button" class="btn bg-navy btn-flat btn-sm" onclick="editPregunta(<?php echo $lstPreg[$i]["IdPregunta"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i></button>
                        <?php if($lstPreg[$i]["_Tipo"] == 1) { ?>
                        <button title="Preguntas" type="button" class="btn bg-maroon btn-flat btn-sm" onclick="addRespuestax(<?php echo $lstPreg[$i]["IdPregunta"]; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-info-circle"></i></button>
                      <?php } ?>
                      </td>
                    </tr>
                  <?php $mf = $lstPreg[$i]["IdMod"]; $bf = $lstPreg[$i]["IdBloque"]; }  ?>
                </table>
              </div>

          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<div id="dataModalModFue"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i>Configuración de la pregunta</h4>
               </div>
               <div class="modal-body" id="employee_detailModFue">
               </div>
          </div>
     </div>
</div>

<div id="dataModalM"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i>Configuración del módulo</h4>
               </div>
               <div class="modal-body" id="employee_mod">
               </div>
          </div>
     </div>
</div>

<div id="dataModal"  class="modal fade">
     <div class="modal-dialog">
          <div class="modal-content">
               <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de las respuestas</h4>
               </div>
               <div class="modal-body" id="employee_detail">
               </div>
          </div>
     </div>
</div>

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
function addPregunta(Tipo){
  var IdMod = 0;
  $.ajax({
       url:"formConsulta/addPregunta.php",
       method:"POST",
       data:{Tipo:Tipo, IdMod:IdMod},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function addModulo(Tipo){
  $.ajax({
       url:"formConsulta/addModulo.php",
       method:"POST",
       data:{Tipo:Tipo},
       success:function(data){
            $('#employee_mod').html(data);
            $('#dataModalM').modal('show');
       }
  });
}

function editPregunta(IdPregunta){
  $.ajax({
       url:"formConsulta/updPregunta.php",
       method:"POST",
       data:{IdPregunta:IdPregunta},
       success:function(data){
            $('#employee_detailModFue').html(data);
            $('#dataModalModFue').modal('show');
       }
  });
}

function addRespuestax(IdPregunta){
  $.ajax({
       url:"formConsulta/addRespuestax.php",
       method:"POST",
       data:{IdPregunta:IdPregunta},
       success:function(data){
            $('#employee_detail').html(data);
            $('#dataModal').modal('show');
       }
  });
}

function addPregtsx_id() {
	var IdMod = document.getElementById("txt_modx").value;
	var Pregunta = document.getElementById("txtNombre").value;
	var TipoP = document.getElementById("txtTipoP").value;
	var Tipo = document.getElementById("Tipo").value;

	if (Pregunta == '') {
		swal("Error al guardar", "Debe escribir la pregunta.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}
	if (TipoP == '') {
		swal("Error al guardar", "Debe seleccionar el tipo de pregunta.", "error");
		document.getElementById("txtNombre").focus();
		return 0;
	}


	swal({
		title: "\u00BFEst\u00E1 seguro que desea agregar esta nueva pregunta?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar",
	},
		function (isConfirm) {
			if (isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				var datos = $('#frm2sFr').serialize();
				// var datos = 'TipoGuardar=' + TipoGuardar + '&IdSemanaDoc=' + IdSemanaDoc + '&Temas=' + Temas + '&IdUsua=' + IdUsua;
				$.ajax({
					type: "POST",
					url: "insertar.php",
					data: datos,
					success: function (data) {

					}
				})
					.done(function (data) {
						if (data == 1) {
							swal("Guardado correctamente", "Los datos se han guardado correctamente.", "success");
							parent.location.href = 'adPreguntas.php?idToks=1614021249' + Tipo;
						}
						if (data == 0) {
							swal("Error al agregar", "No se puede actualizar, verifique sus datos.", "error");
						}
					})
					.error(function (data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
			}

		});
}


</script>
</body>
</html>
