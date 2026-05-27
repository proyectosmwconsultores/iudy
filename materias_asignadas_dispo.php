<?php $valor = 3;
$section = "Materias asignadas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de materias asignadas.');
}
$cicloId = $t->get_all_ciclos_actual();
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-qrcode"></i> Materias asignadas al grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Grupo</a></li>
					<li class="active">Materias asignadas</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="materias_asignadas.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-5">
									<div class="form-group">
										<label>Periodo escolar:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_grupo_reg(<?php echo $_SESSION['IdUsua']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($cicloId); $i++) { ?>
													<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> - <?php echo $cicloId[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label>Grupo:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp">
												<option value=""> - Seleccione - </option>
											</select>
											<span class="input-group-btn">
												<button onclick="load_user_lista()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-xs-12">
									<p style="text-align: center; display: none;" id="img_cargar">
										<img src="assets/images/cargando.gif">
									</p>
									<div class="box" id="mi_lista_materias"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div id="dataModalAsig" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-edit"></i> Lista de alumnos en la materia</h4>
					</div>
					<div class="modal-body" id="employee_detailAsig">
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

		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
		<?php include("footer.php"); ?>
	</div>


	<script>
		$(function() {
			$('.select2').select2()

		})

		function load_user_lista() {
			var IdGrupo = document.getElementById("txtClaveGrp").value;
			var IdCiclo = document.getElementById("txtCiclo").value;

			if (!IdCiclo) {
				swal("Error al buscar", "Debe seleccionar el Periodo Escolar.", "error");
				return 0;
			}
			if (!IdGrupo) {
				swal("Error al buscar", "Debe seleccionar el Grupo.", "error");
				return 0;
			}
			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mi_lista_materias").style.display = 'none';
			var Capa = "#mi_lista_materias";
			$(Capa).load("vistas/coordinador/materias_asignadas_disponibles.php", {
				IdCiclo: IdCiclo,
				IdGrupo: IdGrupo
			}, function(response, status, xhr) {
				if (status == "error") {
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
				if (status == "success") {
					document.getElementById("mi_lista_materias").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}
			});

		}

		function cargar_grupo_reg(IdUsua) {
			var IdCiclo = document.getElementById("txtCiclo").value;
			var Tipo = "grpos_materias_asignadas";
			$.post("php/clases/getConsulta.php", {
				Tipo: Tipo,
				IdCiclo: IdCiclo,
				IdUsua: IdUsua
			}, function(data) {
				$("#txtClaveGrp").html(data);
			});
		}

		function relacionar_grp(IdAsignacion,IdCiclo) {
			var IdCampus = 0;
			var IdGrupo = 0;
			$.ajax({
				url: "vistas/coordinador/configurar_materia_grupo.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion, IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo
				},
				success: function(data) {
					$('#employee_detailAsig').html(data);
					$('#dataModalAsig').modal('show');
				}
			});
		}

		function _selCampusId(IdAsignacion,IdCiclo){
			var IdCampus = document.getElementById("_idCampus").value;
			var IdGrupo = 0;
			$.ajax({
				url: "vistas/coordinador/configurar_materia_grupo.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion, IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo
				},
				success: function(data) {
					$('#employee_detailAsig').html(data);
					$('#dataModalAsig').modal('show');
				}
			});
		}

		function _selGrupoId(IdAsignacion,IdCiclo){
			var IdCampus = document.getElementById("_idCampus").value;
			var IdGrupo = document.getElementById("_idGrupo").value;
			$.ajax({
				url: "vistas/coordinador/configurar_materia_grupo.php",
				method: "POST",
				data: {
					IdAsignacion: IdAsignacion, IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo
				},
				success: function(data) {
					$('#employee_detailAsig').html(data);
					$('#dataModalAsig').modal('show');
				}
			});
		}


		$(document).ready(function() {
			$(document).on('click', '.view_users', function() {
				var employee_id = $(this).attr("id");
				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/ver_alumnos_asignacion.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_detailAsig').html(data);
							$('#dataModalAsig').modal('show');
						}
					});
				}
			});
		});


		function asignar_matetria_especial(IdAsignacion, IdCiclo) {
			var IdCampus = document.getElementById("_idCampus").value;
			var IdGrupo = document.getElementById("_idGrupo").value;
			var IdMateria = document.getElementById("_idMateria").value;

			if (IdCampus == "") {
				swal("Error al guardar", "Debe seleccionar el campus.", "error");
				document.getElementById("_idCampus").focus();
				return 0;
			}
			if (IdGrupo == "") {
				swal("Error al guardar", "Debe seleccionar el grupo.", "error");
				document.getElementById("_idGrupo").focus();
				return 0;
			}
			if (IdMateria == "") {
				swal("Error al guardar", "Debe seleccionar la materia.", "error");
				document.getElementById("_idMateria").focus();
				return 0;
			}

			var TipoGuardar = "add_materia_personalizda_grupo";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea asignar esta materia a este grupo con estos alumnos?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
					cancelButtonText: "Cancelar",
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								url: "vistas/coordinador/guardar_datos_coordinador.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdAsignacion: IdAsignacion,
									IdCiclo: IdCiclo,
									IdCampus: IdCampus,
									IdGrupo: IdGrupo,
									IdMateria: IdMateria
								},
								success: function(data) {
									
								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Asignado correctamente", "La materia se ha asignado correctamente al grupo.", "success");
									$.ajax({
										url: "vistas/coordinador/configurar_materia_grupo.php",
										method: "POST",
										data: {
											IdAsignacion: IdAsignacion, IdCampus:IdCampus, IdCiclo:IdCiclo, IdGrupo:IdGrupo
										},
										success: function(data) {
											$('#employee_detailAsig').html(data);
											$('#dataModalAsig').modal('show');
										}
									});
								}
								if (data == 2) {
									swal("Asignado correctamente", "La materia se ha asignado correctamente al grupo.", "error");
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});

					}
				});
		}
	</script>
</body>

</html>