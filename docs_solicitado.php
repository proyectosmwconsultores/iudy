<?php $valor = 3; $section = "Documentos solicitados"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de documentos solicitados.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file"></i> Documentos solicitados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-file"></i> Documentos</a></li>
					<li class="active">Solicitados</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="docs_solicitado.php" method="POST" enctype="multipart/form-data">
							<!-- <div class="col-md-9">
	              <div class="box-primary">
	                <div class="box-body">
                  </div>
	              </div>
	            </div>

							<div class="col-md-3">
	              <div class="box-primary">
	                <div class="box-body">
										<a class="btn btn-app" href="javascript:void(0);" onclick="add_concepto_n1()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-cog"></i> Configurar fondo
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="validar_pagox()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-tags"></i> Validar pago
	                  </a>
                  </div>
	              </div>
	            </div> -->


							<div class="col-xs-12">
								<div id="panel_gastosx"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<div id="dataModalC" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar constancia </h4>
									 </div>
									 <div class="modal-body" id="employee_detailC">

									 </div>
							</div>
				 </div>
		</div>


		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- AdminLTE App -->

		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
$(document).ready(function(){
	cargar_lista_docs_sol();
});


	function cargar_lista_docs_sol(){
		document.getElementById("panel_gastosx").style.display = 'none';

		document.getElementById("panel_gastosx").style.display = 'block';
		var Capa = "#panel_gastosx";
		$(Capa).load("dashboard/lista_documentos_solicitados.php",{}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}

	function validar_pagox(IdDocumento){
		var Folio = 0;
		$.ajax({
				 url:"formConsulta/validar_pago_solicitud.php",
				 method:"POST",
				 data:{IdDocumento:IdDocumento},
				 success:function(data){
							$('#employee_detailC').html(data);
							$('#dataModalC').modal('show');
				 }
		});
	}

</script>

</body>
</html>
