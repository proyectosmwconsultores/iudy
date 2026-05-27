<?php $valor = 3; $section = "Captura de gastos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de captura de gastos.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
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
							<div class="col-md-5">
	              <div class="box-primary">
	                <div class="box-body">
										<a class="btn btn-app" href="javascript:void(0);" onclick="add_concepto_n1()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-tags"></i> Concepto N1
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="add_concepto_n2()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-tags"></i> Concepto N2
	                  </a>
										<!-- <a class="btn btn-app" href="javascript:void(0);" onclick="pago_docente()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-users"></i> Pago de docentes
	                  </a> -->
										<a class="btn btn-app" href="javascript:void(0);" onclick="add_partida()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-tags"></i> Partida
	                  </a>
										<a class="btn btn-app" href="javascript:void(0);" onclick="cap_gasto()" title="Captura de un nuevo gasto">
	                    <i class="fa fa-dollar"></i> Gasto
	                  </a>
                  </div>
	              </div>
	            </div>


							<div class="col-xs-12">
								<div class="box" id="panel_ultimos_gastos"></div>

							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<div id="dataModal_4" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Captura de movimientos</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_4">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal_7" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Captura de pago de docente</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_7">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal_G" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-folder-open-o"></i> Configurar ofertas educativas</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_G">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal_Ed" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Editar gasto generado</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_Ed">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal_C" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar monto de pagos</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_C">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModal_Cx" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar monto de pagos individuales</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_Cx">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModalC" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de nuevo concepto de gasto Nivel 1</h4>
									 </div>
									 <div class="modal-body" id="employee_detailC">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModalC2" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de nuevo concepto de gasto Nivel 2</h4>
									 </div>
									 <div class="modal-body" id="employee_detailC2">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModalPa" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Partida</h4>
									 </div>
									 <div class="modal-body" id="employee_detailPa">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataModalD" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Captura de nuevo departamento</h4>
									 </div>
									 <div class="modal-body" id="employee_detailD">

									 </div>
							</div>
				 </div>
		</div>


		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>-->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<!-- AdminLTE App -->
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
	$(function () {
		cargar_ultimo_gasto();
		//$('.select2').select2()

		$('#txtFecIni').datepicker({
	    autoclose: true
	  })

		$('#txtFecFin').datepicker({
	    autoclose: true
	  })

	})

	function mostrar_planes(IdGasto){
		$.ajax({
				 url:"formConsulta/configurar_planes_oferta.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detail_G').html(data);
							$('#dataModal_G').modal('show');
				 }
		});
	}

	function editar_gasto_id(IdGasto){
		$.ajax({
				 url:"formConsulta/editar_gastos_id.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detail_Ed').html(data);
							$('#dataModal_Ed').modal('show');
				 }
		});
	}
	function configurar_pag(IdGasto){
		$.ajax({
				 url:"formConsulta/configurar_monto_oferta.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detail_C').html(data);
							$('#dataModal_C').modal('show');
				 }
		});
	}

	function configurar_pag_ind(IdGasto){
		$.ajax({
				 url:"formConsulta/configurar_monto_oferta_id.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detail_Cx').html(data);
							$('#dataModal_Cx').modal('show');
				 }
		});
	}

	function del_gasto_id(IdGasto){
		var TipoGuardar = "del_gasto_id";
		swal({
		title: "\u00BFEst\u00E1 seguro que desea eliminar este gasto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Aceptar',
		cancelButtonText: "Cancelar"
	},
	function (isConfirm) {
		if (isConfirm) {
			$(".confirm").attr('disabled', 'disabled');

			$.ajax({
						url:"formConsulta/setting.php",
						method:"POST",
						data:{TipoGuardar:TipoGuardar,IdGasto:IdGasto},
						success:function(data){

						}
			 })
			 .done(function(data) {
				 if(data==1){
					 swal("Eliminado correctamente", "El gasto se ha eliminado correctamente.", "success");
					 cargar_ultimo_gasto();
				 }
				 if(data==0){
					 swal("Error al eliminar", "No se puede eliminar, verifique sus datos.", "error");
				 }
			 })
			 .error(function(data) {
				 swal("Error al agregar 0x136", "No se puede agregar, comuniquese con el desarrollador.", "error");
			 });
		} else {
			return false;
		}
	});
	}

	function cargar_ultimo_gasto(){
		document.getElementById("panel_ultimos_gastos").style.display = 'none';
		document.getElementById("panel_ultimos_gastos").style.display = 'block';
		var Capa = "#panel_ultimos_gastos";
		$(Capa).load("dashboard/reporte_gastos_ultimo_gasto.php",{ }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}


	function cap_gasto(){
		var IdPermiso = 0;
		var IdGasto = 0;
		var IdConcepto = 0;
		$.ajax({
				 url:"formConsulta/capturar_gastos.php",
				 method:"POST",
				 data:{IdGasto:IdGasto, IdPermiso:IdPermiso, IdConcepto:IdConcepto},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
	}

	function pago_docente(){
		var IdGasto = 0;
		var IdAsignacion = 0;
		var Inicio = 0;
		$.ajax({
				 url:"formConsulta/capturar_gastos_docente.php",
				 method:"POST",
				 data:{IdGasto:IdGasto, IdAsignacion:IdAsignacion, Inicio:Inicio},
				 success:function(data){
							$('#employee_detail_7').html(data);
							$('#dataModal_7').modal('show');
				 }
		});
	}

	function add_concepto_n1(){
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

	function add_concepto_n2(){
		var IdGasto = 0;
		$.ajax({
				 url:"formConsulta/captura_concepto_gasto_n2.php",
				 method:"POST",
				 data:{IdGasto:IdGasto},
				 success:function(data){
							$('#employee_detailC2').html(data);
							$('#dataModalC2').modal('show');
				 }
		});
	}

	function add_partida(){
		var IdPartida = 0;
		$.ajax({
				 url:"formConsulta/captura_partida.php",
				 method:"POST",
				 data:{IdPartida:IdPartida},
				 success:function(data){
							$('#employee_detailPa').html(data);
							$('#dataModalPa').modal('show');
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
