<?php $valor = 3;
$section = "Seguimiento servicio social";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de seguimiento de servicio social.');
}
$practi = $t->get_all_servicio();
$IdEstatus = 3;
$perm = $_SESSION['Permisos'];
if($perm == 7){ $IdEstatus = 3; }
if($perm == 9){ $IdEstatus = 2; }
if($perm == 1){ $IdEstatus = 3; }
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file-text-o"></i> Seguimiento de servicio social
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Seguimiento</a></li>
					<li class="active">Alumno</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="docs_alumnos.php" method="POST" enctype="multipart/form-data">
								<div class="col-md-4">

								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Convocatorias de servicio social:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-fw fa-key"></i>
											</div>
											<select class="form-control" name="txt_aviso_x" id="txt_aviso_x">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($practi); $i++) { ?>
													<option value="<?php echo $practi[$i]["IdPeriodo"]; ?>"><?php echo $practi[$i]["Periodo"]; ?> - <?php echo $practi[$i]["Anio"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
												<button onclick="load_user_beca(<?php echo $IdEstatus; ?>)" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
											</span>
										</div>
									</div>
								</div>

								<div class="col-xs-12">
									<p style="text-align: center; display: none;" id="img_cargar">
										<img src="assets/images/cargando.gif">
									</p>
									<div id="mi_lista_materias"></div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>

		<div id="dataModalModFue" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar documentos</h4>
					</div>
					<div class="modal-body" id="employee_detailModFue">
					</div>
				</div>
			</div>
		</div>
		<div id="dataModa" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar de horario de asesorias</h4>
					</div>
					<div class="modal-body" id="employee_moda">
					</div>
				</div>
			</div>
		</div>

		

		<div id="data_practica" class="modal fade bs-example-modal-lg">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-flag"></i> Servicio social</h4>
					</div>
					<div class="modal-body" id="employee_practica">
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
		<!-- <script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script> -->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>													
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

		function load_user_beca(IdEstatus) {
			var IdAviso = document.getElementById("txt_aviso_x").value;
			
			if (!IdAviso) {
				swal("Error al buscar", "Debe seleccionar la convocatoria del servicio social.", "error");
				return 0;
			}
			document.getElementById("img_cargar").style.display = 'block';
			document.getElementById("mi_lista_materias").style.display = 'none';
			var Capa = "#mi_lista_materias";
			$(Capa).load("vistas/servicio/seguimiento_practicas_profesionales.php", {
				IdAviso: IdAviso,
				IdEstatus:IdEstatus
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

		function cargar_grupo_reg() {
			var IdCiclo = document.getElementById("txtCiclo").value;
			var Tipo = "cargar_grupo_reg";
			$.post("php/clases/getConsulta.php", {
				Tipo: Tipo,
				IdCiclo: IdCiclo
			}, function(data) {
				$("#txtClaveGrp").html(data);
			});
		}

		function configurar_Docs(IdUsua) {
			$.ajax({
				url: "formConsulta/configurarDocs.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_detailModFue').html(data);
					$('#dataModalModFue').modal('show');
				}
			});
		}

		function configurar_seguimiento(IdUsua) {
			$.ajax({
				url: "vistas/desarrollo/configurar_horario.php",
				method: "POST",
				data: {
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_moda').html(data);
					$('#dataModa').modal('show');
				}
			});
		}

		function save_horario_ases(IdUsua) {
			var IdCiclo = document.getElementById("txtCiclo").value;
			var IdDocente = document.getElementById("txt_idDocente").value;
			var TipoGuardar = 'sav_horario_asesoria';
			if (IdDocente == '') {
				swal("Error al guardar", "Debe seleccionar el docente.", "error");
				document.getElementById("txt_user_id").focus();
				return 0;
			}

			swal({
					title: "\u00BFEst\u00E1 seguro que desea agregar este nuevo horario de asesoria a este docente?",
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
							url: "vistas/desarrollo/sav_desarrollo.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								IdDocente: IdDocente,
								IdCiclo: IdCiclo
							},
							success: function(data) {
								swal("Guardado correctamente", "El asesor de ha asignado correctamente.", "error");
								$.ajax({
									url: "vistas/desarrollo/configurar_horario.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_moda').html(data);
										$('#dataModa').modal('show');
									}
								});

							}
						});
					}

				});
		}

		function del_horario_id(IdAsesor, IdUsua) {
			var TipoGuardar = 'del_horario_asesoria';
			swal({
					title: "\u00BFEst\u00E1 seguro que desea quitar a este asesor de este horario asignado?",
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
							url: "vistas/desarrollo/sav_desarrollo.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdAsesor: IdAsesor
							},
							success: function(data) {
								$.ajax({
									url: "vistas/desarrollo/configurar_horario.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_moda').html(data);
										$('#dataModa').modal('show');
									}
								});
							}
						});
					}

				});
		}

		function save_modalidad(IdUsua, IdCiclo, IdGrupo, IdCalendario, IdTitulacion) {
			var TipoGuardar = "obten_mod_ttulacion";
			swal({
					title: "\u00BFEst\u00E1 seguro que desea continuar con este proceso de obtener su titulación para el alumno?",
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
									IdUsua: IdUsua,
									IdTitulacion: IdTitulacion,
									IdCiclo: IdCiclo,
									IdGrupo: IdGrupo,
									IdCalendario: IdCalendario
								},
								success: function(data) {
									//alert(data);
								}
							})
							.done(function(data) {
								if (data == 1) {
									var IdCiclo = 0;
									swal("Generado correctamente", "El proceso de obtención de grado se ha generado correctamente.", "success");
									$.ajax({
										url: "vistas/desarrollo/configurar_horario.php",
										method: "POST",
										data: {
											IdUsua: IdUsua
										},
										success: function(data) {
											$('#employee_moda').html(data);
											$('#dataModa').modal('show');
										}
									});
								}

								if (data == 0) {
									swal("Error al generar", "No se puede generar, verifique sus datos.", "error");
								}
							})
							.error(function(data) {
								swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
							});

					}

				});
		}

		function inscripcion_practica(IdUsua, IdAviso, IdDetalle) {
			var Tipo = 2;
				$.ajax({
					url: "vistas/servicio/inscripcion_alumno.php",
					method: "POST",
					data: {
						IdUsua: IdUsua,
						IdAviso:IdAviso,
						IdDetalle:IdDetalle,
						Tipo: Tipo
					},
					success: function(data) {
						$('#employee_practica').html(data);
						$('#data_practica').modal('show');
					}
				});
			}
	</script>
</body>

</html>