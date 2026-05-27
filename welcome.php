<?php $_v = 301;
$valor = 0;
$section = "Bienvenidos";
include("head.php");
//if($_SESSION['IdUsua']) {
$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Esta en la pagina principal');
$menuUser = $espacio->get_menuUsuario($_SESSION['IdUsua']);
$checarEstatus = $t->get_checarEstatus();

// $sff=$t->get_addCampusLst();
// $ff=$t->get_addDatFol();
//  // AGREGAR RECARGOS

$checarGrado = $t->get_checarGrad();
// $contPagos=$espacio->get_newPagos();
//  $checarEstatus=$t->get_checarEstatus();

// $checarSx=$t->get_sexo();
// if($_SESSION["IdUsua"] == 1){
// 	 $checarSx=$t->get_gRPSuSE();
// }
// $checarEstatus=$t->get_checarPagos();
//$cheRec=$t->get_chkRecargo();
unset($_SESSION['IdAsignacion']);
unset($_SESSION['IdOferta']);
unset($_SESSION['EstatusAsig']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script>
	function show_busca_mod(str) {
		if (str == "") {
			document.getElementById("txt_menu").style.display = 'block';
			document.getElementById("txt_resultado").innerHTML = "";
			return;
		} else {
			document.getElementById("txt_menu").style.display = 'none';
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("txt_resultado").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("GET", "getuser.php?Tipo=bus_mod&Buscar=" + str, true);
			xmlhttp.send();
		}
	}
</script>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content">

				<div class="row">
					<div class="col-lg-12 col-xs-12">
						<?php if (!$_SESSION["Correo"]) { ?>
							<div class="alert alert-danger alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-warning"></i> ¡Aviso importante!</h4>
								<p style="font-size: justify;">
									Estimado usuario, se le informa que debe de complementar su infomaci&oacute;n en la
									Plataforma para poder tener acceso a todos los m&oacute;dulos. <button onClick="window.open('updateMiEspacioA.php','_self')" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat margin"><i class="fa fa-fw fa-pencil-square"></i> Complementar</button>
								</p>
							</div> <?php } ?>
					</div>

					<div class="col-lg-12 col-xs-12">
						<div class="alert alert-purple alert-dismissible" style="background: #555299; color: white">
							<button type="button" style="color: yellow;" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4><i class="icon fa fa-search"></i> Buscar módulo:</h4>
							<p>
								<input class="form-control" id="txt_buscar" name="txt_buscar" placeholder="Escriba el nombre del módulo que desea buscar" type="text" onKeyUp="show_busca_mod(this.value)">
							</p>

						</div>
					</div>

					<div id="txt_resultado"> </div>
					<div class="col-lg-12 col-xs-12" id="txt_menu">
						<div class="row">
							<?php $c = 0;
							for ($i = 0; $i < sizeof($menuUser); $i++) {
								if ($menuUser[$i]["Tipo"] == "C") {
									$c = $c + 1;
							?>
									<?php if ($c == 1) { ?><h4 style="margin-left: 15px;" class="page-header">Mis catálogos disponibles</h4><?php } ?>
									<div class="col-lg-3 col-xs-6" onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">

										<div class="small-box bg-<?php echo $menuUser[$i]["Color"]; ?>">
											<div class="inner">
												<h3><?php echo $menuUser[$i]["Code"]; ?></h3>
												<p><?php echo $menuUser[$i]["Nombre"]; ?></p>
											</div>
											<div class="icon">
												<i class="<?php echo $menuUser[$i]["Icono"]; ?>"></i>
											</div>
											<a onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
							<?php }
							} ?>
						</div>


						<div class="row">
							<?php $sx = 0;
							for ($i = 0; $i < sizeof($menuUser); $i++) {
								if ($menuUser[$i]["Tipo"] == "M") {
									$sx = $sx + 1;
							?>
									<?php if ($sx == 1) { ?><h4 style="margin-left: 15px;" class="page-header">Mis m&oacute;dulos disponibles</h4><?php } ?>
									<div class="col-lg-3 col-xs-6" onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">

										<div class="small-box bg-<?php echo $menuUser[$i]["Color"]; ?>">
											<div class="inner">
												<h3><?php echo $menuUser[$i]["Code"]; ?></h3>
												<p><?php echo $menuUser[$i]["Nombre"]; ?></p>
											</div>
											<div class="icon">
												<i class="<?php echo $menuUser[$i]["Icono"]; ?>"></i>
											</div>
											<a onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
							<?php }
							} ?>
						</div>



						<div class="row">

							<?php $nx = 0;
							for ($i = 0; $i < sizeof($menuUser); $i++) {
								if ($menuUser[$i]["Tipo"] == "R") {
									$nx = $nx + 1;
							?>
									<?php if ($nx == 1) { ?>
										<h4 style="margin-left: 15px;" class="page-header">Mis reportes disponibles</h4><?php } ?>
									<div class="col-lg-3 col-xs-6" onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">

										<div class="small-box bg-<?php echo $menuUser[$i]["Color"]; ?>">
											<div class="inner">
												<h3><?php echo $menuUser[$i]["Code"]; ?></h3>
												<p><?php echo $menuUser[$i]["Nombre"]; ?></p>
											</div>
											<div class="icon">
												<i class="<?php echo $menuUser[$i]["Icono"]; ?>"></i>
											</div>
											<a onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
							<?php }
							} ?>
						</div>
						<div class="row">
							<?php $sy = 0;
							for ($i = 0; $i < sizeof($menuUser); $i++) {
								if ($menuUser[$i]["Tipo"] == "A") {
									$sy = $sy + 1;
							?>
									<?php if ($sy == 1) { ?><h4 style="margin-left: 15px;" class="page-header">Mis m&oacute;dulos disponibles para actualizar</h4><?php } ?>
									<div class="col-lg-3 col-xs-6" onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" style="cursor: pointer;">

										<div class="small-box bg-<?php echo $menuUser[$i]["Color"]; ?>">
											<div class="inner">
												<h3><?php echo $menuUser[$i]["Code"]; ?></h3>
												<p><?php echo $menuUser[$i]["Nombre"]; ?></p>
											</div>
											<div class="icon">
												<i class="<?php echo $menuUser[$i]["Icono"]; ?>"></i>
											</div>
											<a onClick="window.open('<?php echo $menuUser[$i]["Link"]; ?>','_self')" href="javascript:void(0);" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
							<?php }
							} ?>
						</div>
					</div>
				</div>
			</section>
		</div>

		<?php include("footer.php"); ?>
	</div>
	
	<!-- welcome modal end -->
	
	<!-- ./wrapper -->

	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
	
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	<!-- <script src="dist/js/pages/dashboard.js"></script> -->
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
</body>

</html>