<?php $section = "Reporte de alumnos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando el reporte de alumnos graduados');
}

$campusId = $t->get_campusPermiso($_SESSION["IdUsua"]);
$cicloId = $t->get_all_ciclos();


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Reporte de alumnos terminados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repBajas.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">

								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-gears"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($campusId); $i++) { ?>
													<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="cargar_lista_bajas()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Buscar</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="box">
										<div class="box-body">
											<p style="text-align: center; display: none;" id="img_cargar">
												<img src="assets/images/cargando.gif">
											</p>
											<div class="table-responsive" id="panel_baja_alumnos">


											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</div>

				</form>
			</section>
		</div>
		<div id="dataModal_del" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar estatus del alumno en la Plataforma</h4>
					</div>
					<div class="modal-body" id="employee_detail_del">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalIni" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Lista de alumnos</h4>
					</div>
					<div class="modal-body" id="employee_detailIni">

					</div>
				</div>
			</div>
		</div>
		<div id="dataModalRep" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Lista de alumnos reprobados</h4>
					</div>
					<div class="modal-body" id="employee_detailRep">

					</div>
				</div>
			</div>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

		<!-- Custom and plugin javascript -->
		<!-- <script src="assets/table/js/scriptAgregado1.js"></script> -->

		<?php include("footer.php"); ?>
	</div>


	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
	<script>
		function cargar_lista_bajas() {
			var IdCampus = document.getElementById("txtCampus").value;
			
			if (!IdCampus) {
				swal("Error al buscar", "No seleccionado el Campus.", "error");
				return 0;
			}
			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("panel_baja_alumnos").style.display = 'none';
			var Capa = "#panel_baja_alumnos";
			$(Capa).load("dashboard/alumnos_graduados_campus.php", {
				IdCampus: IdCampus
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					document.getElementById("panel_baja_alumnos").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}

			});
		}

		function mostrar_lista_user(IdCampus, IdCiclo, IdRvoe, IdEstatus) {
			$.ajax({
				url: "vistas/reportes/lista_alumnos_rvoe_estatus.php",
				method: "POST",
				data: {
					IdCampus: IdCampus,
					IdCiclo: IdCiclo,
					IdRvoe: IdRvoe,
					IdEstatus: IdEstatus
				},
				success: function(data) {
					$('#employee_detailIni').html(data);
					$('#dataModalIni').modal('show');
				}
			});
		}

		function mostrar_lista_user_reprobados(IdCampus, IdCiclo, IdRvoe) {
			$.ajax({
				url: "vistas/reportes/lista_alumnos_rvoe_reprobados.php",
				method: "POST",
				data: {
					IdCampus: IdCampus,
					IdCiclo: IdCiclo,
					IdRvoe: IdRvoe
				},
				success: function(data) {
					$('#employee_detailRep').html(data);
					$('#dataModalRep').modal('show');
				}
			});
		}
	</script>
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>