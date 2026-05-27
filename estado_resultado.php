<?php $valor = 3; $section = "Captura de gastos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de captura de gastos.'); }

$anioMes=$t->get_meses_disponibles();
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-money"></i> Captura de gastos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Captura</a></li>
					<li class="active">Gastos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="captura_gastos.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-7">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<!-- <a class="btn btn-app" href="javascript:void(0);" onclick="activarMod()">
	                    <i class="fa fa-file"></i> Nuevo aca
	                  </a> -->
										<!-- <a class="btn btn-app" href="javascript:void(0);" onclick="add_concepto()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-tags"></i> Concepto
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="add_deptox()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-black-tie"></i> Departamento
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="cap_gasto()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-edit"></i> Capturar movimiento
	                  </a> -->
                  </div>
	              </div>
	            </div>
							<div class="col-md-5">
								<div class="box-primary">
									<div class="form-group">
										<label>Selecione mes:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<select class="form-control" name="txt_aniomes" id="txt_aniomes">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($anioMes);$i++) { ?>
												<option value="<?php echo $anioMes[$i]["AnioMes"]; ?>"><?php echo obtenerAnioMes($anioMes[$i]["AnioMes"]); ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="cargar_mesAnio()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
											</span>
										</div>
									</div>
								</div>
							</div>




							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div class="box" id="panel_gastosx"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>


		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<script>

	function cargar_mesAnio(){
		var AnioMes = document.getElementById("txt_aniomes").value;

		if(AnioMes == ''){
			swal("Error al buscar", "Debe seleccionar el mes.", "error");
			return 0;
		}

		document.getElementById("panel_gastosx").style.display = 'none';

		document.getElementById("panel_gastosx").style.display = 'block';
		var Capa = "#panel_gastosx";
		$(Capa).load("dashboard/reporte_estado_resultado.php",{AnioMes:AnioMes}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}

	function cap_gasto(){
		$.ajax({
				 url:"formConsulta/capturar_gastos.php",
				 method:"POST",
				 data:{},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
	}

	function add_concepto(){
		$.ajax({
				 url:"formConsulta/captura_concepto_gasto.php",
				 method:"POST",
				 data:{},
				 success:function(data){
							$('#employee_detailC').html(data);
							$('#dataModalC').modal('show');
				 }
		});
	}

	function add_deptox(){
		$.ajax({
				 url:"formConsulta/captura_departamento.php",
				 method:"POST",
				 data:{},
				 success:function(data){
							$('#employee_detailD').html(data);
							$('#dataModalD').modal('show');
				 }
		});
	}
</script>

</body>
</html>
