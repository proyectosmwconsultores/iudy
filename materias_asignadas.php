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
		<div id="dataModalHor" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-clock-o"></i> Configuraci&oacute;n de horario de la asignatura</h4>
					</div>
					<div class="modal-body" id="employee_detailHor">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalEdi" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-edit"></i> Editar asignación de materia</h4>
					</div>
					<div class="modal-body" id="employee_detailEdi">
					</div>
				</div>
			</div>
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

		<div id="dataModalEv" class="modal fade bs-example-modal-lg"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-edit"></i> Configuración de encuesta</h4>
					</div>
					<div class="modal-body" id="employee_detailEv">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalCP" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-gears"></i> Copiar planeación existente en la plataforma</h4>
					</div>
					<div class="modal-body" id="employee_detailCP">
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
			$(Capa).load("vistas/coordinador/materias_asignadas_grp.php", {
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


		$(document).ready(function() {
			$(document).on('click', '.view_horario', function() {
				var employee_id = $(this).attr("id");
				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/addHorario.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_detailHor').html(data);
							$('#dataModalHor').modal('show');
						}
					});
				}
			});
		});

		$(document).ready(function() {
			$(document).on('click', '.view_editar', function() {
				var employee_id = $(this).attr("id");
				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/editar_asignacion.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_detailEdi').html(data);
							$('#dataModalEdi').modal('show');
						}
					});
				}
			});
		});

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

		$(document).ready(function() {
			$(document).on('click', '.view_del', function() {
				var employee_id = $(this).attr("id");
				var TipoGuardar = "delAsignacion";

				swal({
						title: "\u00BFEst\u00E1 seguro que desea eliminar esta asignaci\u00F3n de materia a este asesor?",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: '#DD6B55',
						confirmButtonText: 'Aceptar',
						cancelButtonText: "Cancelar",
					},
					function(isConfirm) {
						if (isConfirm) {
							$(".confirm").attr('disabled', 'disabled');
							var datos = 'TipoGuardar=' + TipoGuardar + '&employee_id=' + employee_id;
							$.ajax({
									type: "POST",
									url: "insertar.php",
									data: datos,
									success: function(data) {

									}
								})
								.done(function(data) {

									if (data == 1) {
										swal("Eliminado correctamente", "La asignación ha sido eliminado correctamente.", "success");
										load_user_lista();
									}

									if (data == 0) {
										swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
									}
								})
								.error(function(data) {
									swal("Error al agregar 0x138", "No se puede eliminar, comuniquese con el desarrollador.", "error");
								});
						}
					});
			});
		});

		$(document).ready(function() {
			$(document).on('click', '.view_evaluacion', function() {
				var employee_id = $(this).attr("id");

				$.ajax({
					url: "formConsulta/vista_evualuacion.php",
					method: "POST",
					data: {
						employee_id: employee_id
					},
					success: function(data) {
						$('#employee_detailEv').html(data);
						$('#dataModalEv').modal('show');
					}
				});
			});
		});

		$(document).ready(function() {
			$(document).on('click', '.view_copiar', function() {
				var employee_id = $(this).attr("id");
				//var IdAsignacion = document.getElementById("Id").value;
				if (employee_id != '') {
					var materia = 0;
					$.ajax({
						url: "formConsulta/copiar_planeacion.php",
						method: "POST",
						data: {
							employee_id: employee_id,
							materia: materia
						},
						success: function(data) {
							$('#employee_detailCP').html(data);
							$('#dataModalCP').modal('show');
						}
					});
				}
			});
		});

		function cargar_materia_datos(employee_id, materia) {
			$.ajax({
				url: "formConsulta/copiar_planeacion.php",
				method: "POST",
				data: {
					employee_id: employee_id,
					materia: materia
				},
				success: function(data) {
					$('#employee_detailCP').html(data);
					$('#dataModalCP').modal('show');
				}
			});
		}


		function upd_asignacion_id(IdAsignacion) {
			var IdDocente = document.getElementById("txt_IdUsua").value;
			var IdCoordi = document.getElementById("txt_coordi").value;
			var Ini = document.getElementById("datepicker1x").value;
			var Fin = document.getElementById("datepicker2x").value;

			if (IdDocente == "") {
				swal("Error al guardar", "Debe seleccionar el docente.", "error");
				document.getElementById("txt_IdUsua").focus();
				return 0;
			}
			if (IdCoordi == "") {
				swal("Error al guardar", "Debe seleccionar el coordinador académico.", "error");
				document.getElementById("txt_coordi").focus();
				return 0;
			}
			if (Ini == "") {
				swal("Error al guardar", "Debe seleccionar la fecha inicial.", "error");
				document.getElementById("datepicker1x").focus();
				return 0;
			}
			if (Fin == "") {
				swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
				document.getElementById("datepicker2x").focus();
				return 0;
			}

			var TipoGuardar = "upd_materia_asigx";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea actualizar los datos de esta asignación de materia?",
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
								url: "formConsulta/setting.php",
								method: "POST",
								data: {
									TipoGuardar: TipoGuardar,
									IdAsignacion: IdAsignacion,
									IdDocente: IdDocente,
									IdCoordi: IdCoordi,
									Ini: Ini,
									Fin: Fin
								},
								success: function(data) {

								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Actualizado correctamente", "Los datos de la asignacón se ha actualizado correctamente.", "success");
									load_user_lista();
									$.ajax({
										url: "formConsulta/editar_asignacion.php",
										method: "POST",
										data: {
											employee_id: IdAsignacion
										},
										success: function(data) {
											$('#employee_detailEdi').html(data);
											$('#dataModalEdi').modal('show');
										}
									});
								}
							})
							.error(function(data) {
								swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
							});

					}
				});
		}
		
		 function actualizar_lista_alumnos(IdAsignacion){
          var TipoGuardar = "upd_asignacion";
               swal({
                    title: "\u00BFEst\u00E1 seguro que desea actualizar la lista de alumnos?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: "Cancelar",
               },
               function (isConfirm) {
                    if (isConfirm) {
                         $(".confirm").attr('disabled', 'disabled');

                         $.ajax({
                                        url:"formConsulta/setting.php",
                                        method:"POST",
                                        data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion},
                                        success:function(data){

                                             swal("Actualizazdo", "Actualizazdo, favor de revisar.", "info");
                                        }
                         })

                    }

               });
     }
     
	</script>
</body>

</html>