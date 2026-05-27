<?php $section = "Agregar calificaciones";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de subir calificaciones.');
}
$lstAlumnosCal = $t->get_alumnos_cal_prom();

if (isset($_POST["Mov"]) && $_POST["Mov"] == "subCalx") {
	$t->add_subir_cal_excel();
	exit;
}

$ciclo = $t->get_ciclo_activo();
?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1><i class="fa fa-fw fa-cloud-upload"></i> Subir calificaciones </h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Subir</a></li>
					<li class="active">Calificaciones</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<form name="frm" id="frm" action="subir_calificacion_excel.php" method="POST" enctype="multipart/form-data">
							<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden" />
							<input id="Mov" name="Mov" type="hidden" />

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Ciclo escolar inicial:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-qrcode"></i>
											</div>
											<select class="form-control" name="txtCiclo" id="txtCiclo">
												<option value=""> - Seleccione - </option>
												<?php for ($i = 0; $i < sizeof($ciclo); $i++) { ?>
													<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Tipo"]; ?> - <?php echo $ciclo[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Buscar archivo <b>excel(.xls)</b>:</label>
										<div class="input-group">
											<input type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
											<span class="input-group-btn">
												<button type="button" class="btn btn-info btn-flat" onClick="val_addCal_omks()">Subir excel</button>
												<!-- <button type="button" class="btn bg-olive btn-flat" onclick="window.open('assets/carga_calificacion.xls','_blank')" href="javascript:void(0);" style="margin-right: 5px;"><i class="fa fa-clipboard"></i> Layout</button> -->
											</span>
										</div>
									</div>
								</div>



								<!-- <div class="col-md-3">
									<div class="form-group">
										<label>Movimiento:</label>
										<div class="input-group">
											<?php if (isset($lstAlumnosCal[0])) { ?>
												<button type="button" class="btn btn-danger" onClick="val_delCalExc()" style="float: right; margin-right: 5px;"><i class="fa fa-trash"></i> Eliminar</button>
												<?php if (isset($_POST["txtModulo"])) { ?>
													<button type="button" class="btn btn-success" onClick="val_save_excel_ok()" style="float: right; margin-right: 5px;"><i class="fa fa-lock"></i> Guardar ok</button>
											<?php }
											} ?>
											<!-- <button type="button" class="btn btn-success" onClick="val_addCal()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir</button> 
										</div>
									</div>
								</div> -->

								<div class="col-xs-12">
									<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
										<div class="col-sm-12" style="text-align: center;">
											<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
										</div>
									</div>

									<div class="box">
										<div class="box-header">
											<h3 class="box-title"><i class="fa fa-fw fa-database"></i> Lista de calificaciones en proceso de alta</h3>
										</div>
										<div class="box-body">
											<table class="table table-bordered table-striped" style="font-size: 12px;">
												<thead>
													<tr>
														<!-- <th>Grupo</th> -->
														<th></th>
														<th>MATRICULA</th>
														<th>NOMBRE DEL ALUMNO</th>
														<th style="text-align: center;">PROMEDIO</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i = 0; $i < sizeof($lstAlumnosCal); $i++) { ?>
														<tr id="<?php echo $lstAlumnosCal[$i]["IdUsua"]; ?>">
															<td>
																<?php if ($lstAlumnosCal[$i]["IdUsua"]) { ?>
																	<button onclick="del_calificaciones_id(<?php echo $lstAlumnosCal[$i]["IdUsua"]; ?>)" type="button" class="btn bg-orange btn-flat"><i class="fa fa-trash"></i></button>
																	<button onclick="ver_calificaciones(<?php echo $lstAlumnosCal[$i]["IdUsua"]; ?>)" type="button" class="btn bg-purple btn-flat"><i class="fa fa-cog"></i></button>
																<?php } ?>
															</td>
															<td><?php echo $lstAlumnosCal[$i]["Usuario"]; ?></td>
															<td><?php echo $lstAlumnosCal[$i]["APaterno"] . ' ' . $lstAlumnosCal[$i]["AMaterno"] . ' ' . $lstAlumnosCal[$i]["Nombre"]; ?></td>
															<td style="text-align: center;"><?php echo $lstAlumnosCal[$i]["Gral"]; ?></td>
														</tr>
													<?php } ?>
													</tfoot>
											</table>
										</div>
									</div>
								</div>

							</div>
						</form>
					</div>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>

	<div id="data_promxi" class="modal fade"> <!--MODAL ME GUSTA-->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-cog"></i> Verificar las calificaciones del alumno</h4>
				</div>
				<div class="modal-body" id="employee_promxi">
				</div>
			</div>
		</div>
	</div>

	</form>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
	function val_addCal_omks() {

		var TipoGuardar = 'sub_ex_cal_final';
		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar estas calificaciones?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},

			function(isConfirm) {
				if (isConfirm) {
					//document.getElementById("imgLoadPagos").style.display = 'block';
					document.frm.Mov.value = 'subCalx';
					document.frm.submit();
					return true;
				} else {
					return false;
				}
			});

	}

	function ver_calificaciones(IdUsua) {
		$.ajax({
			url: "dashboard/lista_calificaciones_alumnos.php",
			method: "POST",
			data: {
				IdUsua: IdUsua
			},
			success: function(data) {
				$('#employee_promxi').html(data);
				$('#data_promxi').modal('show');
			}
		});
	}

	function sav_calificacion_gral(IdUsua,IdAdmin) {
		var TipoGuardar = "sav_prom_alumno_id";

		swal({
				title: "\u00BFEst\u00E1 seguro que desea guardar las calificaciones de este alumno?",
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
							url: "vistas/escolar/guardar_datos_escolar.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua,
								IdAdmin:IdAdmin
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Guardado correctamente", "Las calificaciones del alumno se han guardado correctamente.", "success");
								parent.location.href = 'subir_calificacion_excel.php';
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar las calificaciones", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function mover_materia(IdProm, IdCiclo, IdUsua, Valor) {
		var TipoGuardar = "mov_materia_periodo";

		swal({
				title: "\u00BFEst\u00E1 seguro que desea mover de periodo escolar esta materia?",
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
							url: "vistas/escolar/guardar_datos_escolar.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdProm: IdProm,
								IdCiclo: IdCiclo,
								IdUsua: IdUsua,
								Valor: Valor
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Guardado correctamente", "La calificación de la materia se ha movido correctamente.", "success");
								$.ajax({
									url: "dashboard/lista_calificaciones_alumnos.php",
									method: "POST",
									data: {
										IdUsua: IdUsua
									},
									success: function(data) {
										$('#employee_promxi').html(data);
										$('#data_promxi').modal('show');
									}
								});
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar las calificaciones", "error");
							}
						})
						.error(function(data) {
							swal("Error al agregar 0x130", "No se puede agregar, comuniquese con el desarrollador.", "error");
						});
				}

			});
	}

	function del_calificaciones_id(IdUsua) {
		var TipoGuardar = "del_prom_alumno_id";

		swal({
				title: "\u00BFEst\u00E1 seguro que desea eliminar las calificaciones de este alumno?",
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
							url: "vistas/escolar/guardar_datos_escolar.php",
							method: "POST",
							data: {
								TipoGuardar: TipoGuardar,
								IdUsua: IdUsua
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Eliminado correctamente", "Las calificaciones del alumno se han eliminado correctamente.", "success");
								parent.location.href = 'subir_calificacion_excel.php';
							}
							if (data == 0) {
								swal("Ha ocurrido un error", "No se ha podido guardar las calificaciones", "error");
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

<?php unset($_SESSION['Alerta']);  ?>