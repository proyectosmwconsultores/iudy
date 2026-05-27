<?php $section = "Horario personalizado";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando el reporte de horario personalizado');
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
					Reporte de alumnos con horario personalizado
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Horario</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="repBajas.php" method="POST" enctype="multipart/form-data">
					<div class="box box-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
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
			document.getElementById("panel_baja_alumnos").style.display = 'block';
			var Capa = "#panel_baja_alumnos";
			$(Capa).load("vistas/coordinador/alumnos_horario_personalizado.php", {
				IdCampus: IdCampus
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		}

		function del_alumnoIdx(IdUsua, IdCiclo, IdCampus) {
			$.ajax({
				url: "formConsulta/upd_eliminarAlumno.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					IdCiclo: IdCiclo,
					IdCampus: IdCampus
				},
				success: function(data) {
					$('#employee_detail_del').html(data);
					$('#dataModal_del').modal('show');
				}
			});
		}
	</script>
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>