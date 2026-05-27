<?php $_v = 61;
$section = "Mis asignaturas";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en visualizando sus asignaturas.');
	unset($_SESSION['IdAsignacion']);
	unset($_SESSION['IdOferta']);
	unset($_SESSION['EstatusAsig']);
	unset($_SESSION['txt']);

	$contratos = $t->get_mis_contratos_pendientes($_SESSION['IdUsua']); 


	?>
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<style>
		#_div:hover {
			filter: opacity(.7);
		}
	</style>

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
		<div class="wrapper">

			<?php include("menuV.php"); ?>
			<div class="content-wrapper">
				<section class="content-header">
					<h1>
						Panel de control
						<small>Mis clases</small>
					</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Mis asignaturas</a></li>
						<li class="active">Panel de control</li>
					</ol>
				</section>
				<section class="content">
				    
				    <div class="alert alert-success alert-dismissible" onclick="captura_informacion(<?php echo $_SESSION['IdUsua']; ?>)" style="cursor: pointer;">
                        <h4><i class="icon fa fa-check"></i> Información general</h4>
                        Haz clic para validar sus datos personales.
                      </div>
              
              
					<?php if(isset($contratos[0])){ ?>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fa fa-edit"></i> Contratos pendientes por firmar </h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
								<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
						<div class="box-body">
							<ul class="products-list product-list-in-box">
								<?php for ($i = 0; $i < sizeof($contratos); $i++) { ?>
									<li class="item" style="cursor: pointer;" onclick="firmar_contrato('<?php echo $contratos[$i]['IdAsignacion']; ?>')">
										<div class="product-img">
											<img src="assets/images/check.jpg" alt="Product Image">
										</div>
										<div class="product-info">
											<a href="javascript:void(0)" class="product-title"><?php echo $contratos[$i]['Educativa']; ?></a>
											<span class="label label-danger pull-right"> PENDIENTE FIRMAR CONTRATO </span></a>
											<span class="product-description"> <?php echo $contratos[$i]['Grado']; ?>° <?php echo $contratos[$i]['NombreMod']; ?> </span>
											<span class="product-description"> <?php echo obtenerFechaCorta($contratos[$i]['FecIni']); ?> al <?php echo obtenerFechaCorta($contratos[$i]['FecFin']); ?> </span>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div><?php } ?>

					<?php if (($_SESSION['Permisos'] == "2") || ($_SESSION['Permisos'] == "1") || ($_SESSION['Permisos'] == "5") || ($_SESSION['Permisos'] == "9")) {
						$moduloA = $t->get_misClases($_SESSION['IdUsua']); ?>
						<div class="row">
							<?php $x = 0;
							$T = "";
							for ($i = 0; $i < sizeof($moduloA); $i++) {
								$x = $x + 1;
								$horario = $t->get_horario($moduloA[$i]["IdAsignacion"]);
								$mstImg = $moduloA[$i]["Fondo"];
								$totalAlumnos = $t->get_totalAlumnos($moduloA[$i]["IdModulo"], $moduloA[$i]["IdAsignacion"]);
								$to = 0;
								$to = $totalAlumnos[0]["Total"]; ?>
								<div class="col-md-4">
									<div class="box box-widget widget-user">
										<div id='_div' <?php if (($moduloA[$i]["contrato"] == 1) && (($moduloA[$i]["aceptado"] == 0))) { ?> onclick="bloqueado()" <?php } else { ?>  onClick="window.open('doMiPlaneacion.php?idToks=<?php echo $moduloA[$i]["IdAsignacion"]; ?>','_self')" <?php } ?> href="javascript:void(0);" class="widget-user-header bg-black" style="background: url('assets/fondo/<?php echo $mstImg; ?>') center center; width: 100%; cursor: pointer; height: 240px;">
										</div>
										<div class="box-footer" style="height: 180px; background: #003A70; color: white;">
											<div class="row">
												<div class="col-sm-12" style="margin-top: -20px; font-size: 14px; text-align: right; height: 40px; ">
													<i class="fa fa-fw fa-book"></i> <?php echo $moduloA[$i]["NomEducativa"]; ?>
												</div>
												<div class="col-sm-12" style="font-size: 14px; text-align: left; height: 40px; ">
													<i class="fa fa-fw fa-bookmark"></i> <?php echo $moduloA[$i]["NombreMod"]; ?>
												</div>
												<div class="col-sm-12" style="font-size: 13px; text-align: center; height: 40px;">
													<i class="fa fa-fw fa-clock-o"></i> <?php for ($h = 0; $h < sizeof($horario); $h++) {
																							if ($h == 2) {
																								echo '<br>';
																							}
																							echo '<b>' . $horario[$h]["Dia"] . '</b> ' . $horario[$h]["HraIni"] . ':' . $horario[$h]["MinIni"] . ' a ' . $horario[$h]["HraFin"] . ':' . $horario[$h]["MinFin"] . ' ';
																						} ?>
												</div>
												<div class="col-sm-12" style="font-size: 13px; text-align: center; height: 24px; ">
													<i class="fa fa-fw fa-calendar-o"></i> <?php echo fechaMes($moduloA[$i]["FecIni"]); ?> al <?php echo fechaMes($moduloA[$i]["FecFin"]); ?> de <?php echo substr($moduloA[$i]["FecFin"], 0, 4); ?>
												</div>
												<div class="col-sm-12" style="font-size: 13px; text-align: center; height: 24px; ">
													<i class="fa fa-fw fa-users"></i> <?php echo $to; ?> alumnos <i class="fa fa-fw fa-fire"></i> Grupo: <?php echo $moduloA[$i]["CveGrupo"]; ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php }  ?>
						</div>
					<?php } ?>
				</section>
			</div>
			<?php include("footer.php"); ?>
		</div>

		<div id="data_contrato" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-edit"></i> Firmar contrato de la materia </h4>
					</div>
					<div class="modal-body" id="employee_contrato">
					</div>
				</div>
			</div>
		</div>

<div id="dataInfo" class="modal fade"> <!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-gears"></i> Informaci贸n del docente</h4>
					</div>
					<div class="modal-body" id="employee_info">
					</div>
				</div>
			</div>
		</div>


		<script>
			function bloqueado() {
				swal("Contrato pendiente", "Primero debe de firmar su contrato de esta materia, favor de revisar en la parte inicial.", "error");
			}

			function firmar_contrato(IdAsignacion) {
				$.ajax({
					url: "formConsulta/firmar_contrato_id.php",
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
			
			function captura_informacion(IdUsua){
		$.ajax({
					url: "formConsulta/informacionDocente.php",
					method: "POST",
					data: {
						IdUsua: IdUsua
					},
					success: function(data) {
						$('#employee_info').html(data);
						$('#dataInfo').modal('show');
					}
				});
	}
	
	
		</script>


		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>

		<!-- AdminLTE for demo purposes -->
		<!-- <script src="dist/js/demo.js"></script> -->
	</body>

	</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>