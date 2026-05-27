<?php $section = "Conciliar pagos";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de conciliar pagos');
}

if (isset($_POST["Mov"]) && $_POST["Mov"] == "subExcel") {
	$t->add_excel_conciliar_banco();
	exit;
}
?>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-upload"></i> Conciliar pagos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Pagos</a></li>
					<li class="active">Conciliar pagos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="finanzas_conciliar_pagos.php" method="POST" enctype="multipart/form-data">
								<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden" />
								<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden" />
								<input id="Mov" name="Mov" value="" type="hidden" />
								<input id="Alerta" name="Alerta" value="<?php if (isset($_SESSION['Alerta'])) { echo $_SESSION['Alerta']; } ?>" type="hidden" />
								<?php  if(($_SESSION['IdUsua'] == 1) || ($_SESSION['IdUsua'] == 709) || ($_SESSION['IdUsua'] == 1485)){ ?>
								<div class="col-md-4">
									<div class="form-group">
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Buscar archivo <b>excel(.xls)</b>:</label>
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-file-excel-o"></i>
											</div>
											<input accept=".xls, .xlsx, .csv" type="file" class="form-control" name="txtArchivo" id="txtArchivo" onchange="validarExcel(this,'txtArchivo');">
											<span class="input-group-btn">
												<button type="button" class="btn bg-navy btn-flat" onClick="sub_excel_banco()" style="float: right; margin-right: 5px;"><i class="fa fa-cloud-upload"></i> Subir excel</button>
											</span>
										</div>
									</div>
								</div><?php  } ?>

								<div class="col-xs-12">
									<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none;">
										<div class="col-sm-12" style="text-align: center;">
											<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
										</div>
									</div>

									<div class="box" id="lista_pagos_proceso">

									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php include("footer.php"); ?>
	</div>
	<div id="data_fact_gene" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Generar factura</h4>
						</div>

						<div class="modal-body" id="employee_fact_gene">
						</div>
					</div>
				</div>
			</div>

	<div id="data_promxi" class="modal fade">
		<!--MODAL ME GUSTA-->
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><i class="fa fa-cog"></i> Conciliar pago</h4>
				</div>
				<div class="modal-body" id="employee_promxi">
				</div>
			</div>
		</div>
	</div>
	<div id="data_facx" class="modal fade"> <!--MODAL ME GUSTA-->
	       <div class="modal-dialog">
	            <div class="modal-content">
	                 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
	                      <button type="button" class="close" data-dismiss="modal">&times;</button>
	                      <h4 class="modal-title"><i class="fa fa-fw fa-child"></i> Datos de facturación</h4>
	                 </div>
	                 <div class="modal-body" id="employee_facx">
	                 </div>
	            </div>
	       </div>
	  </div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
	$(document).ready(function() {
		vista_lista_pagos();
	});

	function vista_lista_pagos() {
		var Capa = "#lista_pagos_proceso";
		$(Capa).load("vistas/finanzas/pagos_proceso_validacion.php", {}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}

	$(document).ready(function() {
		var alerta = document.frm.Alerta.value;
		if (alerta) {
			if (alerta == "2") {
				swal("Error al subir", "Ha ocurrido un error, no se puede subir el archivo", "error");
			}
			if (alerta == "1") {
				swal("Guardado correctamente", "Registros del grupo guardado correctamente", "success");
			}
			if (alerta == "0") {
				swal("Error al guardar", "No se ha podido guardar los registros", "error");
			}
			if (alerta == "3") {
				swal("Eliminado correctamente", "La lista de usuarios se a eliminado correctamente", "success");
			}
			if (alerta == "8") {
				swal("Error al guardar", "No se ha podigo guardar los registros del archivo excel", "error");
			}
		}
	});

	function sub_excel_banco() {
		var IdBanco = 3;
		var Archivo = document.getElementById("txtArchivo").value;
		if (Archivo == "") {
			swal("Error al guardar", "Debe seleccionar el archivo excel.", "error");
			document.getElementById("txtArchivo").focus();
			return 0;
		}

		swal({
				title: "\u00BFEst\u00E1 seguro que desea subir este archivo de excel?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					document.getElementById("imgLoadPagos").style.display = 'block';
					document.frm.Mov.value = 'subExcel';
					document.frm.submit();
					return true;
				} else {
					return false;
				}
			});
	}

	function proceso_cobrar(IdTemporal, IdUsua) { 
		var Indicador = 1;
		$.ajax({
			url: "vistas/finanzas/procesar_pago.php",
			method: "POST",
			data: {
				IdTemporal: IdTemporal,
				IdUsua: IdUsua,
				Indicador: Indicador
			},
			success: function(data) {
				$('#employee_promxi').html(data);
				$('#data_promxi').modal('show');
			}
		});
	}

	function usuario_seleccionado_id(IdTemporal,IdUsua){
		var Indicador = 1;
		$.ajax({
			url: "vistas/finanzas/procesar_pago.php",
			method: "POST",
			data: {
				IdTemporal: IdTemporal,
				IdUsua: IdUsua,
				Indicador: Indicador
			},
			success: function(data) {
				$('#employee_promxi').html(data);
				$('#data_promxi').modal('show');
			}
		});
	}

	function procesar_filtro1() {
		var TipoGuardar = 'procesar_filtro_1';
		swal({
				title: "\u00BFEst\u00E1 seguro que desea procesar esta lista de pagos?",
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
							type: "POST",
							url: "vistas/finanzas/sav_datos_finanzas.php",
							data: {
								TipoGuardar: TipoGuardar
							},
							success: function(data) {

							}
						})
						.done(function(data) {
							if (data == 1) {
								swal("Procesado correctamente", "La lista de pagos se ha procesado correctamente para su seguimiento.", "success");
								vista_lista_pagos();
							} else {
								swal("Ha ocurrido un error", "No se puede procesar la lista de pagos.", "error");
								vista_lista_pagos();
							}
						})
						.error(function(data) {
							swal("Error al mostrar 0x15", "No se puede agregar, comuniquese con el desarrollador", "error");
						});
				} else {
					document.getElementById("frm").reset();
				}
			});
	}

	function generar_factura_id(IdUsua, NoFolio) {
			$.ajax({
				url: "vistas/facturar/generar_factura_id.php",
				method: "POST",
				data: {
					IdUsua: IdUsua,
					NoFolio: NoFolio
				},
				success: function(data) {
					$('#employee_fact_gene').html(data);
					$('#data_fact_gene').modal('show');
				}
			});
		}

		function datos_factura_id(IdUsua){
		$.ajax({
				url:"vistas/finanzas/datos_factura_id.php",
				method:"POST",
				data:{IdUsua:IdUsua},
				success:function(data){
							$('#employee_facx').html(data);
							$('#data_facx').modal('show');
				}
		});
	}

	function eliminar_pago(IdTemporal){
		var TipoGuardar = "eliminar_registro_id";
		swal({
				title: "\u00BFEst\u00E1 seguro que desea quitar de la lista este pago?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: '#DD6B55',
				confirmButtonText: 'Aceptar',
				cancelButtonText: "Cancelar",
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
							type: "POST",
							url: "vistas/finanzas/sav_datos_finanzas.php",
							data: {
								TipoGuardar: TipoGuardar,
								IdTemporal:IdTemporal
							},
							success: function(data) {
								document.frm.submit();
					return true;
							}
						})

					
				} else {
					return false;
				}
			});
	}
</script>
</body>

</html>

<?php unset($_SESSION['Alerta']);  ?>