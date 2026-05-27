<?php $_v = 52; $section = "Mis asignaturas"; include("head.php");
if($_SESSION['IdUsua']) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en visualizando sus asignaturas.');
		$diaIngreso=$espacio->get_ingresoDia();

unset($_SESSION['IdAsignacion']);
unset($_SESSION['IdOferta']);
unset($_SESSION['EstatusAsig']);


$fol=  $infoPerfil[0]["Folio"];
if($_SESSION["Permisos"] == 3) { $_evx = 0;
	$avis=$espacio->get_chkAvisos($_SESSION['IdGrupo']);
	$adeudo=$espacio->get_chk_pagos_pendientes($_SESSION['IdUsua']);
	$pagP=$espacio->get_chkEncuenta($_SESSION['IdUsua']);
	if($pagP){
		$_evx = 1;
		$_hoy = date("Y-m-d");
		if($_hoy > $pagP[0]['FecFin']){
			header('Location: viewEvaluacion.php');
			exit();
		}
	}

	
	// if(($adeudo[0]) && (($infoPerfil[0]['IdGrado'] == 3) || ($infoPerfil[0]['IdGrado'] == 4) || ($infoPerfil[0]['IdGrado'] == 1) || ($infoPerfil[0]['IdGrado'] == 2))){
	// 	$fecLim = $infoPerfil[0]['FecLimite'];
	// 	$vax = 0;
	// 	if(isset($fecLim)){
	// 		$_hhoy = date("Y-m-d");
	// 		if($fecLim >= $_hhoy){
	// 			$vax = 1;
	// 		} else { $vax =  0;}
	// 	}

	// 	if($vax == 0){
	// 		header('Location: misPagos.php');
	// 		exit();
	// 	}
		
	// }

	if ($adeudo[0]['Total'] >= 1) {
		header('Location: misPagos.php?x=x');
		exit();
	}

}

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">

		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['IdEstatus'] == 50){ include("formConsulta/msjEstatus.php"); } ?>
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
				<?php
					$moduloA=$t->get_mis_clases($_SESSION['IdUsua']); ?>
					<div class="row">
					<?php $x = 0; $T=""; for ($i=0;$i< sizeof($moduloA);$i++) { $x = $x + 1;
						$horario=$t->get_horario($moduloA[$i]["IdAsignacion"]);
						$mstImg = $moduloA[$i]["Fondo"]; ?>
					<div class="col-md-4">
	          <div class="box box-widget widget-user">
	            <div <?php if($_SESSION['IdEstatus'] == 8){ ?> onClick="window.open('miContenido.php?idAsignacion=<?php echo $moduloA[$i]["IdAsignacion"]; ?>','_self')" <?php } else { ?> onclick="bloqueado()" <?php } ?> href="javascript:void(0);" class="widget-user-header bg-black" style="background: url('assets/fondo/<?php echo $mstImg; ?>') center center; height: 200px; width: 100%; cursor: pointer;"></div>
	            <div class="box-footer" style="height: 150px; background: #003A70; color: white;">
	              <div class="row">
									<div class="col-sm-12" style="margin-top: -20px; font-size: 14px; text-align: left; height: 40px; ">
										<img class="img-responsive img-circle img-sm" src="assets/perfil/<?php echo $moduloA[$i]["Foto"]; ?>" alt="Alt Text">
										<div class="img-push"><label style="margin-top: 5px;"><?php echo $moduloA[$i]["Nombre"].' '.$moduloA[$i]["APaterno"].' '.$moduloA[$i]["AMaterno"]; ?></label></div>
 									</div>
									<div class="col-sm-12" style="font-size: 14px; text-align: left; height: 40px; ">
										<i class="fa fa-fw fa-bookmark"></i> <?php echo $moduloA[$i]["NombreMod"]; ?>
 									</div>
									<div class="col-sm-12" style="font-size: 12px; text-align: left; height: 30px;"> <i class="fa fa-fw fa-clock-o"></i>
										<?php
										for ($h=0;$h< sizeof($horario);$h++) { if($h == 2){ echo '<br>'; }
 										 echo '<b>'.$horario[$h]["Dia"].'</b> '.$horario[$h]["HraIni"].':'.$horario[$h]["MinIni"].' a '.$horario[$h]["HraFin"].':'.$horario[$h]["MinFin"].' ';
 									 }
										?>
									</div>
									<div class="col-sm-12" style="font-size: 12px; text-align: left; height: 30px;">
										<i class="fa fa-fw fa-calendar"></i> <?php echo fechaMes($moduloA[$i]["FecIni"]); ?> al <?php echo fechaMes($moduloA[$i]["FecFin"]); ?> de <?php echo substr($moduloA[$i]["FecFin"],0,4); ?>
									</div>
	              </div>
	            </div>
	          </div>
	        </div>
				<?php }  ?>
				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
									<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title"><i class="fa fa-qrcode"></i> Código de la clase</h4>
									</div>
								 <div class="modal-body" id="employee_detail3">
								 </div>
						</div>
			 </div>
	</div>
	<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
									<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title"><i class="fa fa-users"></i> Lista de alumnos de la clase</h4>
									</div>
								 <div class="modal-body" id="employee_Grp">
								 </div>
						</div>
			 </div>
	</div>
	<script>
	$(document).ready(function(){
			 $(document).on('click', '.view_code', function(){
						var employee_id = $(this).attr("id");
						if(employee_id != '')
						{
								 $.ajax({
											url:"formConsulta/viewCode.php",
											method:"POST",
											data:{employee_id:employee_id},
											success:function(data){
													 $('#employee_detail3').html(data);
													 $('#dataModal3').modal('show');
											}
								 });
						}
			 });
	});

	$(document).ready(function(){
			 $(document).on('click', '.view_grupo', function(){
						var employee_id = $(this).attr("id");
						if(employee_id != '')
						{
								 $.ajax({
											url:"formConsulta/viewMiClase.php",
											method:"POST",
											data:{employee_id:employee_id},
											success:function(data){
													 $('#employee_Grp').html(data);
													 $('#dataGrp').modal('show');
											}
								 });
						}
			 });
	});

	function bloqueado(){
		swal("Error al ingresar", "Su cuenta esta bloqueda temporalmente.", "error");
	}
	</script>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
