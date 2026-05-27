<?php $valor = 3;
$section = "Contratos docente";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está visualizando laos contratos de docentes');
}
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
$ciclo = $t->get_ciclo_activo();

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Reporte de contratos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Contrato</a></li>
					<li class="active">Docente</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Reporte de contrato de los docentes por rango de fecha</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="repIngresosDia.php" method="POST" enctype="multipart/form-data">
								<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden" />
								<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden" />
								<input id="Numero" name="Numero" value="4" type="hidden" />
								<input id="Nombre" name="Nombre" value="Reporte de facturas" type="hidden" />
								

								<div class="col-md-5">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
											<label>Periodo escolar:</label>
												<div class="input-group">
													<div class="input-group-addon"><i class="fa fa-users"></i></div>
													<select class="form-control select2" name="txt_ciclo" id="txt_ciclo">
														<option value=""> - Seleccione - </option>
														<?php for ($i = 0; $i < sizeof($ciclo); $i++) { ?>
															<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"><?php echo $ciclo[$i]["Tipo"]; ?> - <?php echo $ciclo[$i]["Ciclo"]; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Fecha inicial: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input autocomplete="off" type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box-primary">
										<div class="box-body">
											<div class="form-group">
												<label>Fecha final: </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" autocomplete="off" class="form-control pull-right" id="datepicker2" name="datepicker2">
													<span class="input-group-btn">
														<button type="button" class="btn btn-info btn-flat" onclick="consultar_facturas()"><i class="fa fa-fw fa-search"></i> Consultar</button>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div id="miTablaEvaluacion">
									</div>
								</div>


							</form>
						</div>
					</div>
					<p style="text-align: center; display: none;" id="img_cargar">
						<img src="assets/images/cargando.gif">
					</p>

					<div class="box-body" id="mostrar_ingresos" style="display: none;"></div>

				</div>
			</section>


		</div>

		<div id="dataInfo" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Información del docente</h4>
					</div>
					<div class="modal-body" id="employee_info">
					</div>
				</div>
			</div>
		</div>

		<div id="data_contrato" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Configurar contrato de la materia</h4>
					</div>
					<div class="modal-body" id="employee_contrato">
					</div>
				</div>
			</div>
		</div>

	

		<!-- Mainly scripts -->
		<script src="assets/table/js/jquery-3.1.1.min.js"></script>
		<script src="assets/table/js/bootstrap.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<?php include("footer.php"); ?>
	</div>

	<!-- jQuery 3 -->

	<script>
		$(function() {
			//Date picker
			$('#datepicker1').datepicker({
				autoclose: true
			})
			//Date picker
			$('#datepicker2').datepicker({
				autoclose: true
			})
		})

		function consultar_facturas() {
			var Inicio = document.getElementById("datepicker1").value;
			var Final = document.getElementById("datepicker2").value;
			var IdCiclo = document.getElementById("txt_ciclo").value;
			
			if (IdCiclo == '') {
				swal("Error al buscar", "Debe seleccionar el periodo escolar.", "error");
				document.getElementById("txt_ciclo").focus();
				return 0;
			}
			if (Inicio == '') {
				swal("Error al buscar", "Debe seleccionar la fecha inicial.", "error");
				document.getElementById("datepicker1").focus();
				return 0;
			}
			if (Final == '') {
				swal("Error al guardar", "Debe seleccionar la fecha final.", "error");
				document.getElementById("datepicker2").focus();
				return 0;
			}

			var Capa = "#miTablaEvaluacion";
			$(Capa).load("dashboard/lista_contratos_generados.php", {
				Inicio: Inicio,
				Final: Final, IdCiclo:IdCiclo
			}, function(response, status, xhr) {

				if (status == "error") {
					var msg = "Error!, algo ha sucedido: ";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});
		}

		function cancelar_factura(IdFactura) {
			$.ajax({
				url: "formConsulta/cancelar_factura.php",
				method: "POST",
				data: {
					IdFactura: IdFactura
				},
				success: function(data) {
					$('#employee_fact_cancel').html(data);
					$('#data_fact_cancel').modal('show');
				}
			});
		}

		function generera_contrato_id(IdAsignacion){
  var Monto = document.getElementById("txt_monto_contrato").value;
  var Texto = document.getElementById("txt_texto_contrato").value;
  var IdEstatus = document.getElementById("txt_estatus_contrato").value;
  var Fecha = document.getElementById("txt_fecha_contrato").value;
	

  if (Monto==""){
		swal("Error al guardar", "Debe poner el monto.", "error");
        document.getElementById("txt_monto_contrato").focus();
        return 0;
  }
  if (Texto==""){
		swal("Error al guardar", "Debe escribir el texto.", "error");
        document.getElementById("txt_paternox").focus();
        return 0;
  }

    var TipoGuardar = "generar_contrato_id";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea generar el contrato con estos datatos?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Aceptar',
      cancelButtonText: "Cancelar",
    },
    function (isConfirm) {
      if(isConfirm) {
        $(".confirm").attr('disabled', 'disabled');
        $.ajax({
             url:"formConsulta/setting.php",
             method:"POST",
             data:{TipoGuardar:TipoGuardar, IdAsignacion:IdAsignacion, Monto:Monto, Texto:Texto, IdEstatus:IdEstatus, Fecha:Fecha},
             success:function(data){

               

             }
        })
		.done(function(data) {
			if (data == 1) {
				swal("Generado correctamente", "El contrato se ha generado correctamente.", "success");
				$.ajax({
					url: "formConsulta/generar_contrato.php",
					method: "POST",
					data: {
						IdAsignacion: IdAsignacion
					},
					success: function(data) {
						$('#employee_contrato').html(data);
						$('#data_contrato').modal('show');
					}
				});
			}

			if (data == 0) {
				swal("Error al generar", "No se puede generar el contrato, verifique sus datos.", "error");
			}
		})
		.error(function(data) {
			swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
		});

      }
    });

}
	</script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- Page script -->
</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>