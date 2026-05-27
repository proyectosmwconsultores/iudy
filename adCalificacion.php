<?php $valor = 3;
$section = "Calificación final";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de calificaciones finales.');
}
$datUs = $t->get_karUser(substr($_GET["tokenId"], 10, 10));

$_mod20 = $t->get_mod_lista_id($_SESSION['IdUsua'], 20);
$_mod23 = $t->get_mod_lista_id($_SESSION['IdUsua'], 23);
$_mod24 = $t->get_mod_lista_id($_SESSION['IdUsua'], 24);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- App css -->

<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Formateria de calificaciones y certificados
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Alumno</a></li>
					<li class="active">Calificación</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
						<!-- general form elements -->
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title"><i class="fa fa-user"></i> Datos del alumno</h3>
							</div>
							<form role="form">
								<input id="IdUsua" name="IdUsua" value="<?php echo substr($_GET["tokenId"], 10, 10); ?>" type="hidden" />
								<div class="box-body">
									<div class="col-md-12">
										<table class="table table-striped">
											<tr>
												<td style="text-align: right;"><b>NOMBRE:</b></td>
												<td><?php echo $datUs[0]["Nombre"] . ' ' . $datUs[0]["APaterno"] . ' ' . $datUs[0]["AMaterno"]; ?></td>
												<td style="text-align: right;"><b>SEXO:</b></td>
												<td><?php echo $datUs[0]["Sexo"]; ?></td>
											</tr>
											<tr>
												<td style="text-align: right;"><b>CARRERA:</b></td>
												<td><?php echo $datUs[0]["Educativa"]; ?></td>
												<td style="text-align: right;"><b>MATRÍCULA:</b></td>
												<td><?php echo $datUs[0]["Usuario"]; ?></td>
											</tr>
										</table>
										<hr><br>
									</div>
									<div class="col-md-12">
										<p style="text-align: center; display: none;" id="img_cargar">
											<img src="assets/images/cargando.gif">
										</p>
										<div id="mostrar_ingresos" style="display: none;"></div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>


		</div>
		<div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Actualizar calificaciones</h4>
					</div>
					<div class="modal-body" id="employee_detailGrp">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalCer" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Datos del certificado de estudios</h4>
					</div>
					<div class="modal-body" id="employee_cer">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalEqui" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar equivalencia</h4>
					</div>
					<div class="modal-body" id="employee_equi">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalConva" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar convalidación</h4>
					</div>
					<div class="modal-body" id="employee_conva">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModalConfig" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar calificaciones</h4>
					</div>
					<div class="modal-body" id="employee_config">
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
		$(document).ready(function() {
			$(document).on('click', '.view_grupo', function() {
				var employee_id = $(this).attr("id");
				if (employee_id != '') {
					$.ajax({
						url: "formConsulta/updCalificacion.php",
						method: "POST",
						data: {
							employee_id: employee_id
						},
						success: function(data) {
							$('#employee_detailGrp').html(data);
							$('#dataModalGrp').modal('show');
						}
					});
				}
			});
		});

		function loadMaterias(IdGrado) {
			var IdUsua = document.getElementById("IdUsua").value;
			var IdOferta = document.getElementById("IdOferta").value;
			var IdCampus = document.getElementById("IdCampus").value;
			var Mat = document.getElementById("Mat").value;

			var TipoGuardar = "loadMaters";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea cargar las materias sin calificaciones?",
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
								IdGrado: IdGrado,
								IdUsua: IdUsua,
								IdOferta: IdOferta,
								IdCampus: IdCampus,
								Mat: Mat
							},
							success: function(data) {

								parent.location.href = 'adCalificacion.php?tokenId=1592526540' + IdUsua + '&Envio=C';
							}
						})

					}

				});
		}

		function delFinal(IdCalificacion) {

			var TipoGuardar = "delFinalM";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar la calificacion de esta materia?",
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
								IdCalificacion: IdCalificacion
							},
							success: function(data) {
								if (data == 1) {
									document.getElementById(IdCalificacion).style.display = "none";
								}
							}
						})

					}

				});
		}


		$(function() {
			$('.select2').select2()
			cargar_lista_calificacion();

		})

		function cargar_lista_calificacion() {
			var IdUsua = document.getElementById("IdUsua").value;

			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mostrar_ingresos").style.display = 'none';
			var Capa = "#mostrar_ingresos";
			$(Capa).load("vistas/alumno/lista_calificaciones.php", {
				IdUsua: IdUsua
			}, function(response, status, xhr) {

				if (status == "error") {
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
					document.getElementById("img_cargar").style.display = 'none';
				}
				if (status == "success") {

					document.getElementById("mostrar_ingresos").style.display = 'block';
					document.getElementById("img_cargar").style.display = 'none';
				}
			});
		}

		function configurar_certificado(IdUsua) {
			$.ajax({
				url: "vistas/formatos/certificado_estudios.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_cer').html(data);
					$('#dataModalCer').modal('show');
				}
			});
		}

		function configurar_quivalencia(IdUsua) {
			$.ajax({
				url: "vistas/formatos/equivalencia.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_equi').html(data);
					$('#dataModalEqui').modal('show');
				}
			});
		}

		function configurar_convalidacion(IdUsua) {
			$.ajax({
				url: "vistas/formatos/convalidacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_conva').html(data);
					$('#dataModalConva').modal('show');
				}
			});
		}

		function configurar_calificaciones(IdUsua) {
			$.ajax({
				url: "vistas/formatos/configurar_calificacion.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_config').html(data);
					$('#dataModalConfig').modal('show');
				}
			});
		}

		function save_promedio_equi(IdUsua, IdEquivalencia) {
			var Prom = "prom_" + IdEquivalencia;
			var Promedio = document.getElementById(Prom).value;

			if ((Promedio == 5) || (Promedio == 6) || (Promedio == 7) || (Promedio == 8) || (Promedio == 9) || (Promedio == 10)) {
				var TipoGuardar = 'sav_prom_equiva';
				$.ajax({
					type: "POST",
					url: "vistas/escolar/guardar_datos_escolar.php",
					data: {
						TipoGuardar: TipoGuardar,
						IdEquivalencia: IdEquivalencia,
						Promedio: Promedio
					},
					success: function(data) {}
				})
			} else {
				swal("Error al guardar", "Debe ingresar un número entero: 5, 6, 7, 8, 9, 10.", "error");
				$.ajax({
					url: "vistas/formatos/equivalencia.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_equi').html(data);
						$('#dataModalEqui').modal('show');
					}
				});
			}

		}

		function save_promedio_conva(IdUsua, IdEquivalencia) {
			var Prom = "prom_" + IdEquivalencia;
			var Promedio = document.getElementById(Prom).value;

			if ((Promedio == 5) || (Promedio == 6) || (Promedio == 7) || (Promedio == 8) || (Promedio == 9) || (Promedio == 10)) {
				var TipoGuardar = 'sav_prom_equiva';
				$.ajax({
					type: "POST",
					url: "vistas/escolar/guardar_datos_escolar.php",
					data: {
						TipoGuardar: TipoGuardar,
						IdEquivalencia: IdEquivalencia,
						Promedio: Promedio
					},
					success: function(data) {}
				})
			} else {
				swal("Error al guardar", "Debe ingresar un número entero: 5, 6, 7, 8, 9, 10.", "error");
				$.ajax({
					url: "vistas/formatos/convalidacion.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_conva').html(data);
						$('#dataModalConva').modal('show');
					}
				});
			}

		}

		function cargar_materias_id(IdUsua) {
			var IdCiclo = document.getElementById("txt_ciclo_sel").value;
			var Grado = document.getElementById("txt_ciclo_selx").value;

			var TipoGuardar = 'agregar_materias_quivalencia';
			if (IdCiclo == '') {
				swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_ciclo_sel").focus();
				return 0;
			}
			if (Grado == '') {
				swal("Error al guardar", "Debe seleccionar el grado.", "error");
				document.getElementById("txt_ciclo_selx").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea cargar las materias de este grado?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdUsua: IdUsua,
									IdCiclo: IdCiclo,
									Grado: Grado
								},
								success: function(data) {}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Cargado correctamente", "Las materias han sido cargado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/equivalencia.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_equi').html(data);
											$('#dataModalEqui').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function cargar_conva_materias_id(IdUsua) {
			var IdCiclo = document.getElementById("txt_ciclo_sel_cova").value;
			var Grado = document.getElementById("txt_ciclo_selx_conva").value;

			var TipoGuardar = 'agregar_materias_convalidacion';
			if (IdCiclo == '') {
				swal("Error al guardar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_ciclo_sel").focus();
				return 0;
			}
			if (Grado == '') {
				swal("Error al guardar", "Debe seleccionar el grado.", "error");
				document.getElementById("txt_ciclo_selx").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea cargar las materias de este grado?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdUsua: IdUsua,
									IdCiclo: IdCiclo,
									Grado: Grado
								},
								success: function(data) {  }
							})
							.done(function(data) {
								if (data == 1) {
									swal("Cargado correctamente", "Las materias han sido cargado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/convalidacion.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_conva').html(data);
											$('#dataModalConva').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function sav_materias_equivalencia(IdUsua, IdAdmin) {
			var Comentario = document.getElementById("txt_comentario_equi").value;
			var Fecha = document.getElementById("equivalencia_fecha").value;

			var TipoGuardar = 'sav_materias_equiv';
			if (Comentario == '') {
				swal("Error al guardar", "Debe escribir un comentario de equivalencia.", "error");
				document.getElementById("txt_comentario_equi").focus();
				return 0;
			}
			if (Fecha == '') {
				swal("Error al guardar", "Debe seleccionar la fecha.", "error");
				document.getElementById("equivalencia_fecha").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea guardar los promedios por equivalencia?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdUsua: IdUsua,
									Comentario: Comentario,
									Fecha: Fecha,
									IdAdmin: IdAdmin
								},
								success: function(data) { }
							})
							.done(function(data) {
								if (data == 1) {
									cargar_lista_calificacion();
									swal("Guardado correctamente", "Los promedios por equivalencia se han guardado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/equivalencia.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_equi').html(data);
											$('#dataModalEqui').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function sav_materias_convalidacion(IdUsua, IdAdmin) {
			var Comentario = document.getElementById("txt_comentario_conva").value;
			var Fecha = document.getElementById("convalidacion_fecha").value;

			var TipoGuardar = 'sav_materias_conva';
			if (Comentario == '') {
				swal("Error al guardar", "Debe escribir un comentario de convalidacion.", "error");
				document.getElementById("txt_comentario_conva").focus();
				return 0;
			}
			if (Fecha == '') {
				swal("Error al guardar", "Debe seleccionar la fecha.", "error");
				document.getElementById("convalidacion_fecha").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea guardar los promedios por convalidacion?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdUsua: IdUsua,
									Comentario: Comentario,
									Fecha: Fecha,
									IdAdmin: IdAdmin
								},
								success: function(data) { }
							})
							.done(function(data) {
								if (data == 1) {
									cargar_lista_calificacion();
									swal("Guardado correctamente", "Los promedios por convalidación se han guardado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/convalidacion.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_conva').html(data);
											$('#dataModalConva').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function eliminar_materia_id(IdUsua, IdEquivalencia) {
			var TipoGuardar = 'del_materia_id';
			
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar esta materia?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdEquivalencia: IdEquivalencia
								},
								success: function(data) {}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "La materia se ha eliminado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/equivalencia.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_equi').html(data);
											$('#dataModalEqui').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function eliminar_materia_id_conva(IdUsua, IdEquivalencia) {
			var TipoGuardar = 'del_materia_id';
			
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar esta materia?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdEquivalencia: IdEquivalencia
								},
								success: function(data) {}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "La materia se ha eliminado correctamente.", "success");
									$.ajax({
										url: "vistas/formatos/convalidacion.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_conva').html(data);
											$('#dataModalConva').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function eliminar_calificacion_id(IdUsua, IdCalificacion) {
			var TipoGuardar = 'del_promedio_materia_id';
			
			swal({
					title: "\u00BFEst\u00E1 seguro que desea eliminar esta calificación?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Aceptar',
				},
				function(isConfirm) {
					if (isConfirm) {
						$(".confirm").attr('disabled', 'disabled');
						$.ajax({
								type: "POST",
								url: "vistas/escolar/guardar_datos_escolar.php",
								data: {
									TipoGuardar: TipoGuardar,
									IdCalificacion: IdCalificacion
								},
								success: function(data) {
									
								}
							})
							.done(function(data) {
								if (data == 1) {
									swal("Eliminado correctamente", "La calificación se ha eliminado correctamente.", "success");
									cargar_lista_calificacion();
									$.ajax({
										url: "vistas/formatos/configurar_calificacion.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_config').html(data);
											$('#dataModalConfig').modal('show');
										}
									});
								}
								if (data == 0) {
									swal("Ha ocurrido un error", "No se ha podido guardar", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
							});
					}

				});
		}

		function sav_datos_certificado(IdUsua) {
		var Fecha = document.getElementById("cer_fecha").value;
		var Folio = document.getElementById("cer_folio").value;
		var Estudios = document.getElementById("cer_estudios").value;
		var Entidad = document.getElementById("cer_entidad").value;
		var Institucion = document.getElementById("cer_institucion").value;
		var Gestion = document.getElementById("cer_gestion").value;
		var Escolar = document.getElementById("cer_escolar").value;
		var Inicio = document.getElementById("cer_inicio").value;
		var Final = document.getElementById("cer_final").value;
		var Cct = document.getElementById("cer_cct").value;
		
		var TipoGuardar = 'sav_datos_certificado';
		if (Fecha == '') {
			swal("Error al guardar", "Debe indicar la fecha de impresión.", "error");
			document.getElementById("cer_fecha").focus();
			return 0;
		}
		if (Folio == '') {
			swal("Error al guardar", "Debe escribir el No. certificado.", "error");
			document.getElementById("cer_folio").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea generar el certificado de estudios con estos datos?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								Fecha: Fecha,
								Folio: Folio,
								Estudios: Estudios,
								Entidad: Entidad,
								Institucion: Institucion,
								Gestion: Gestion,
								Escolar: Escolar,
								Inicio: Inicio,
								Final:Final,
								Cct:Cct
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								 cargar_lista_calificacion();
								swal("Guardado correctamente", "Los datos del certificado se han guardado correctamente.", "success");
								$.ajax({
									url: "vistas/formatos/certificado_estudios.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_cer').html(data);
										$('#dataModalCer').modal('show');
									}
								});
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function sav_datos_titulo(IdUsua) {
		var Inicio = document.getElementById("t_inicio").value;
		var Final = document.getElementById("t_final").value;
		var IdTipo = document.getElementById("txt_tipo_titulo").value;
		var Examen = document.getElementById("t_examen").value;
		var Impresion = document.getElementById("t_impresion").value;
		var No = document.getElementById("t_no").value;
		var Foja = document.getElementById("t_foja").value;
		var Gestion = document.getElementById("t_gestion").value;
		var Escolar = document.getElementById("t_escolar").value;
		
		var TipoGuardar = 'sav_datos_titulo';
		if (Inicio == '') {
			swal("Error al guardar", "Debe indicar la fecha de inicio de carrera.", "error");
			document.getElementById("t_inicio").focus();
			return 0;
		}
		if (Final == '') {
			swal("Error al guardar", "Debe indicar la fecha de fin de carrera.", "error");
			document.getElementById("t_final").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar los datos para el título de estudios?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								Inicio: Inicio,
								Final: Final,
								IdTipo: IdTipo,
								Examen: Examen,
								Impresion: Impresion,
								No: No,
								Foja: Foja,
								Gestion: Gestion,
								Escolar: Escolar
							},
							success: function(data) {
							}
						})
						.done(function(data) {
							if (data == 1) {
								 cargar_lista_calificacion();
								swal("Guardado correctamente", "Los datos del titulo se han guardado correctamente.", "success");
								$.ajax({
									url: "vistas/formatos/certificado_estudios.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_cer').html(data);
										$('#dataModalCer').modal('show');
									}
								});
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function sav_datos_acta_titulo(IdUsua) {
		var Hora = document.getElementById("a_hora").value;
		var Fecha = document.getElementById("a_fecha").value;
		var Aprobo = document.getElementById("a_aprobo").value;
		
		var TipoGuardar = 'sav_datos_acta_titulo';
		if (Hora == '') {
			swal("Error al guardar", "Debe indicar la fecha del acta.", "error");
			document.getElementById("a_hora").focus();
			return 0;
		}
		if (Fecha == '') {
			swal("Error al guardar", "Debe indicar la fecha de del acta.", "error");
			document.getElementById("a_fecha").focus();
			return 0;
		}
		if (Aprobo == '') {
			swal("Error al guardar", "Debe tipo de aprobación.", "error");
			document.getElementById("a_aprobo").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar los datos para el acta de titulación?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								Hora: Hora,
								Fecha: Fecha,
								Aprobo: Aprobo
							},
							success: function(data) {
								
							}
						})
						.done(function(data) {
							if (data == 1) {
								 cargar_lista_calificacion();
								swal("Guardado correctamente", "Los datos del acta de titulación se han guardado correctamente.", "success");
								$.ajax({
									url: "vistas/formatos/certificado_estudios.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_cer').html(data);
										$('#dataModalCer').modal('show');
									}
								});
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function sav_datos_impresion_cert(IdUsua) {
		var IdCiclo = document.getElementById("txt_ciclo_cer").value;

		var TipoGuardar = 'sav_datos_cert_impr';
		if (IdCiclo == '') {
			swal("Error al guardar", "Debe indicar el periodo escolar en la que inicio el alumno.", "error");
			document.getElementById("txt_ciclo_cer").focus();
			return 0;
		}
		
		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar estos datos?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
			},
			function(isConfirm) {
				if (isConfirm) {
					$(".confirm").attr('disabled', 'disabled');
					$.ajax({
							type: "POST",
							url: "vistas/escolar/guardar_datos_escolar.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								IdCiclo: IdCiclo
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								 cargar_lista_calificacion();
								swal("Guardado correctamente", "Los datos del inicio del periodo se han guardado correctamente.", "success");
								$.ajax({
									url: "vistas/formatos/certificado_estudios.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_cer').html(data);
										$('#dataModalCer').modal('show');
									}
								});
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}
	</script>

</body>

</html>