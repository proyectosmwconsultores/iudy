<?php $section = "Configurar evaluacion"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de configuración de evaluación.'); }
if($_SESSION['Permisos']) {

	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_preguntaExamen();
		exit;
	}
 if(!$_GET["idToks"]){ header('Location: inicio.php'); exit(); }
	$AsignacionId=$t->get_nomModulo($_GET["idToks"]);

	$IdActividadDoc = substr($_GET["tok"],10, 10);
	$preguntasExam=$t->get_preguntExamn($_GET["idToks"],$IdActividadDoc,$_GET["p"]);
	$actiEva=$t->get_datosAc($IdActividadDoc);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">
		<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
				<section class="content-header">
					<h1> <?php echo $AsignacionId[0]["NombreMod"];?></h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i><?php echo $AsignacionId[0]["NombreMod"];?></a></li>
						<li class="active"><a href="#">Configurar evaluaci&oacute;n</a></li>
					</ol>
				</section>
				<section class="content">
					<div class="row">
						<form name="frm" class="form-horizontal" id="frm" action="doAddConfigExamen.php" method="POST" enctype="multipart/form-data">
							<input id="IdActividadDoc" name="IdActividadDoc" value="<?php echo $IdActividadDoc; ?>" type="hidden"/>
					    <input id="IdParcialDoc" name="IdParcialDoc" value="<?php echo $_GET["p"]; ?>" type="hidden"/>
					    <input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
					    <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $_GET["idToks"]; ?>" type="hidden"/>
							<input id="Mov" name="Mov" value="<?php if(isset($_GET["Mov"])){ echo $_GET["Mov"]; } ?>" type="hidden"/>
							<div class="col-md-12">
 								<div style="padding: 10px; text-align: center; font-size: 16px;" class="bg-navy color-palette"><span>Nombre de la evaluación: <?php echo $actiEva[0]["NomActividad"]; ?></span></div>

						<div class="box">
							<div class="box-header with-border">
							  <h3 class="box-title">Lista de actividades creadas en la materia</h3>
							</div>
							<div class="box-body">
								<?php if(!isset($preguntasExam[0])){ ?>
								<button type="button" onclick="viewCopiar()" class="btn btn-danger pull-right" style="margin-right: 8px;"> <i class="fa fa-search"></i> Buscar evaluación</button>
							<?php } ?>

							<div class="btn-group">
								<button onclick="fecha_examen(<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-primary"><i class="fa fa-cog"></i> Configurar evaluación</button>
								<?php if($actiEva[0]['IdEstatus'] == 12){ ?>
								<button onclick="crea_preg_eva(<?php echo $IdActividadDoc; ?>)" type="button" class="btn btn-warning"><i class="fa fa-question-circle"></i> Preguntas de la evaluación</button>
								<?php } ?>
							</div>

							</div>

							<div class="box" id="miTablaEvaluacion"> </div>
			  			</div>
							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<div id="dataModalPreg"  class="modal fade" style="padding-left: 1px !important;"> <!--MODAL ME GUSTA-->
         <div class="modal-dialog">
              <div class="modal-content">
                   <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i> Respuestas de la pregunta</h4>
                   </div>
                   <div class="modal-body" id="employee_detailPreg">
                   </div>
              </div>
         </div>
    </div>
		<div id="dataModalViewPc" class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #241D60; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Exámenes disponibles para copiar</h4>
 									</div>
 									<div class="modal-body" id="employee_detailViewPc" style="background: #ecf0f5;">
 									</div>
 						 </div>
 				</div>
 	 </div>
	 <div id="dataModalFE" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title"><i class="fa fa-cog"></i> Configurar evaluación</h4>
								 </div>
								 <div class="modal-body" id="employee_detailFE">
								 </div>
						</div>
			 </div>
	</div>
	<div id="dataModalPE" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
					 <div class="modal-content">
								<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
										 <button type="button" class="close" data-dismiss="modal">&times;</button>
										 <h4 class="modal-title"><i class="fa fa-cog"></i> Preguntas de la evaluación</h4>
								</div>
								<div class="modal-body" id="employee_detailPE">
								</div>
					 </div>
			</div>
 </div>

	<?php include("footer.php"); ?>
	</div>
	<script>

	$(document).ready(function(){
      var IdActividadDoc = document.getElementById("IdActividadDoc").value;

        lista_pregunta_id(IdActividadDoc);

    });


		function lista_pregunta_id(IdActividadDoc){
			var Capa = "#miTablaEvaluacion";

      $(Capa).load("formConsulta/lista_preguna_eva.php",{IdActividadDoc:IdActividadDoc}, function(response, status, xhr) {
        if (status == "error") {
          var msg = "Error!, algo ha sucedido: ";
          $(Capa).html(msg + xhr.status + " " + xhr.statusText);
        }
      });
		}



	  function addRespuesta(IdPregunta){
			var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	    $.ajax({
	         url:"formConsulta/addExamen.php",
	         method:"POST",
	         data:{IdPregunta:IdPregunta,IdActividadDoc:IdActividadDoc},
	         success:function(data){
	              $('#employee_detailPreg').html(data);
	              $('#dataModalPreg').modal('show');
	         }
	    });

	  }

		function del_ex_preg_id(IdPregunta){
		  var IdAsignacion = document.getElementById("IdAsignacion").value;
		  var IdActividadDoc = document.getElementById("IdActividadDoc").value;
		  var IdParcialDoc = document.getElementById("IdParcialDoc").value;
		  var TipoGuardar = "delPreguntaEx";

		  swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar esta pregunta de la evaluación?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function (isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					var datos = 'TipoGuardar=' + TipoGuardar + '&IdPregunta=' + IdPregunta;
					$.ajax({
						type:"POST",
						url:"insertar.php",
						data:datos,
						success:function(data){

						}
					})
					.done(function(data) {

		        if(data==1){
							swal("Eliminado correctamente", "Respuestas eliminadas correctamente.", "success");
		          parent.location.href='doAddConfigExamen.php?idToks='+IdAsignacion+'&tok=1573436374'+IdActividadDoc+'&p='+IdParcialDoc;
						}
						if(data==0){
							swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
						}
					})
					.error(function(data) {
						swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
					});
				}

			});
		}



		function viewCopiar(){
		var IdAsignacion = document.getElementById("IdAsignacion").value;
		var IdActividadDoc = document.getElementById("IdActividadDoc").value;
		var IdParcialDoc = document.getElementById("IdParcialDoc").value;
		$.ajax({
				 url:"formConsulta/viewCopiar.php",
				 method:"POST",
				 data:{IdAsignacion:IdAsignacion,IdActividadDoc:IdActividadDoc,IdParcialDoc:IdParcialDoc},
				 success:function(data){
							$('#employee_detailViewPc').html(data);
							$('#dataModalViewPc').modal('show');
				 }
		});
	}

	function viewCopiarExt(){
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdActividadDoc = document.getElementById("IdActividadDoc").value;
	var IdParcialDoc = document.getElementById("IdParcialDoc").value;
	var IdOferta = 0;
	$.ajax({
			 url:"formConsulta/viewCopiarExt.php",
			 method:"POST",
			 data:{IdAsignacion:IdAsignacion,IdActividadDoc:IdActividadDoc,IdParcialDoc:IdParcialDoc,IdOferta:IdOferta},
			 success:function(data){
						$('#employee_detailViewPc').html(data);
						$('#dataModalViewPc').modal('show');
			 }
	});
}

		function fecha_examen(IdActividadDoc){
			$.ajax({
					 url:"formConsulta/configurar_fecha_examen.php",
					 method:"POST",
					 data:{IdActividadDoc:IdActividadDoc},
					 success:function(data){
								$('#employee_detailFE').html(data);
								$('#dataModalFE').modal('show');
					 }
			});
		}

		function crea_preg_eva(IdActividadDoc){
			var IdAsignacion = document.getElementById("IdAsignacion").value;
			var IdParcialDoc = document.getElementById("IdParcialDoc").value;
			$.ajax({
					 url:"formConsulta/crear_pregunta_eva.php",
					 method:"POST",
					 data:{IdActividadDoc:IdActividadDoc, IdAsignacion: IdAsignacion, IdParcialDoc:IdParcialDoc},
					 success:function(data){
								$('#employee_detailPE').html(data);
								$('#dataModalPE').modal('show');
					 }
			});
		}

		function validar_file_exa(obj, nombre){
	      var uploadFile = obj.files[0];
	      if (!window.FileReader) {
	      	swal("Error", "El navegador no soporta la lectura de archivos.", "error");
	          return;
	      }

	      if (!(/\.(jpg|png)$/i).test(uploadFile.name)) {
	      	swal("Error de archivo", "Porfavor, cargue solamente archivo .jpg | .png", "error");
	          document.getElementById(nombre).value='';
	          document.getElementById(nombre).focus();
	      }
	      else {
	          var img = new Image();
	          if (uploadFile.size > 10000000)
	          {
	          	swal("Error", "El peso del archivo debe ser menos a 10 MB.", "error");
	              document.getElementById(nombre).value='';
	              document.getElementById(nombre).focus();
	          }
	      }
	  }

	</script>
	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	</body>
</html>
<?php


} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
