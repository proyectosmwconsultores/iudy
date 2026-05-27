<?php $valor = 2; $section = "Planeación general"; include("head.php");
	if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de Planeación general'); }

	if($_SESSION['Permisos'] == 9){
		$oferta=$t->get_OfertaCoordinador($_SESSION['IdUsua']);
	} else {
		$oferta=$t->get_OfertaE($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
	}

	if($_GET["IdO"]){ $_POST["txtOferta"] = $_GET["IdO"]; }
	if($_GET["IdA"]){ $_POST["txtModulo"] = $_GET["IdA"]; }

	$moduloId=$t->get_ModuloId($_POST["txtOferta"]);
	$moduloDatos=$t->get_datosModulo($_POST["txtOferta"],$_POST["txtModulo"]);

	$parciales=$t->get_parciales($_POST["txtOferta"],$_POST["txtModulo"]);


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Informaci&oacute;n de la Planeaci&oacute;n general
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Informaci&oacute;n</a></li>
        <li class="active">Planeaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos de la Planeaci&oacute;n</h3>
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
        </div>
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adPlaneacionGral.php" method="POST" enctype="multipart/form-data">
					  <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
					  <input id="IdDatosM" name="IdDatosM" value="<?php echo $moduloDatos[0]["IdDatosM"];?>" type="hidden"/>
					  <input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
					  <input id="Variable" name="Variable" value="<?php echo $_SESSION['Variable'];?>" type="hidden"/>
			            <div class="col-md-5">
									  <div class="box-primary">
										  <div class="box-body">
											<div class="form-group">
												<label>Oferta educativa:</label>
												<div class="input-group">
												  <div class="input-group-addon">
													<i class="fa fa-gears"></i>
												  </div>
												  <select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
													<option value=""> - Seleccione - </option>
													<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
													<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
													<?php } ?>
												  </select>
												</div>
											</div>
										  </div>
									  </div>
									</div>
									<div class="col-md-4">
									  <div class="box-primary">
										  <div class="box-body">
											<div class="form-group">
												<label>Asignatura:</label>
												<div class="input-group">
												  <div class="input-group-addon">
													<i class="fa fa-book"></i>
												  </div>
												  <select class="form-control" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
													<option value=""> - Seleccione - </option>
													<?php for ($i=0;$i< sizeof($moduloId);$i++) { ?>
													<option value="<?php echo $moduloId[$i]["IdModulo"]; ?>"<?php if($_POST['txtModulo']==$moduloId[$i]["IdModulo"]){?>selected="selected"<?php }?>><?php echo $moduloId[$i]["CodeModulo"].' - '.$moduloId[$i]["NombreMod"]; ?></option>
													<?php } ?>
												  </select>
												</div>
											</div>
										  </div>
									  </div>
									</div>
									<?php if($moduloDatos[0]){ ?>
									<div class="col-md-3">
									  <div class="box-primary">
										  <div class="box-body">
												<div class="form-group">
													<a class="btn btn-app"><span class="badge bg-green">Ver</span><i class="fa fa-desktop"></i> Asignatura </a>
													<a class="btn btn-app" onclick="crearParcial()"><span class="badge bg-purple">Nuevo</span><i class="fa fa-edit"></i> Crear parcial</a>
												</div>
										  </div>
									  </div>
									</div><?php } ?>
						</form>
          </div>
					<hr>
					<div class="row">
						<div class="col-md-12">
		          <div class="nav-tabs-custom">
		            <ul class="nav nav-tabs">
									<?php for ($x=0;$x< sizeof($parciales);$x++) { $IdParcial = $parciales[$x]["IdParcial"]; if($IdParcial==1){ $clss = "class='active'"; } else { $clss = "";} ?>
										<li <?php echo $clss; ?>><a href="#activity<?php echo $IdParcial; ?>" data-toggle="tab" aria-expanded="true"> Parcial <?php echo $parciales[$x]["NoParcial"]; ?></a></li>
									<?php } ?>
		            </ul>
		            <div class="tab-content">
									<?php for ($y=0;$y< sizeof($parciales);$y++) { $IdParcial = $parciales[$y]["IdParcial"];
										$semana=$t->get_semana($IdParcial);


										 if($IdParcial==1){ $clssT = "active"; } else { $clssT = "";} ?>
		              <div class="tab-pane <?php echo $clssT; ?>" id="activity<?php echo $IdParcial; ?>">
										<div class="col-md-12">
											<a style="float: right;" class="btn btn-app" onclick="crearSemana(<?php echo $IdParcial; ?>)"><i class="fa fa-edit"></i> Semana</a>
									</div>
									<br><br><br>
									<ul class="timeline timeline-inverse">

									<?php for ($s=0;$s< sizeof($semana);$s++) { $IdSemana = $semana[$s]["IdSemana"];
										$actividades=$t->get_actividadSem($IdParcial,$IdSemana);
										 ?>
                  <li class="time-label">
                        <span class="bg-red">
                          Semana <?php echo $semana[$s]["NoSemana"]; ?>
                        </span>
                  </li>

                  <li>
                    <i class="fa fa-bookmark bg-blue"></i>

                    <div class="timeline-item">
                      <div class="timeline-body">
                        <?php echo $semana[$s]["Temas"]; ?>
												<a onclick="crearActividad(<?php echo $IdParcial; ?>,<?php echo $IdSemana; ?>)" class="btn btn-primary btn-xs">Agregar actividad</a>
                      </div>
                    </div>
                  </li>
									<?php if($actividades[0]){ for ($ac=0;$ac< sizeof($actividades);$ac++) { ?>

									<li>
                    <i class="fa fa-map-signs bg-green"></i>
										<div class="timeline-item">
                      <span class="time"><i class="fa fa-bell"></i> <?php echo $actividades[$ac]["TipoActividad"]; ?></span>

                      <h3 class="timeline-header"><?php echo $actividades[$ac]["NomActividad"]; ?></h3>

                      <div class="timeline-body">
                        <?php echo $actividades[$ac]["DesActividad"]; ?>
                      </div>

                    </div>
                  </li>


								<?php } } } ?>

                  <!-- <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li> -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>


		              </div>
								<?php } ?>

		            </div>
		          </div>
		        </div>

		      </div>
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>

	<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											 <button type="button" class="close" data-dismiss="modal">&times;</button>
											 <h4 class="modal-title">Creaci&oacute;n de parcial</h4>
									</div>
									<div class="modal-body" id="employee_detail">
									</div>
						 </div>
				</div>
	 </div>

	 <div id="dataModalSemana"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Informaci&oacute;n del trabajo de la semana</h4>
 									</div>
 									<div class="modal-body" id="employee_detailSem">
 									</div>
 						 </div>
 				</div>
 	 </div>

	 <div id="dataModalActividad"  class="modal fade"> <!--MODAL ME GUSTA-->
 				<div class="modal-dialog">
 						 <div class="modal-content">
 									<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
 											 <button type="button" class="close" data-dismiss="modal">&times;</button>
 											 <h4 class="modal-title">Creaci&oacute;n de actividad</h4>
 									</div>
 									<div class="modal-body" id="employee_detailAct">
 									</div>
 						 </div>
 				</div>
 	 </div>

  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
	function crearParcial(){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addParcial.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo},
				 success:function(data){
							$('#employee_detail').html(data);
							$('#dataModal').modal('show');
				 }
		});

	}

	function crearSemana(IdParcial){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addSemana.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial},
				 success:function(data){
							$('#employee_detailSem').html(data);
							$('#dataModalSemana').modal('show');
				 }
		});

	}

	function crearActividad(IdParcial,IdSemana){
		var IdOferta = document.getElementById("txtOferta").value;
		var IdModulo = document.getElementById("txtModulo").value;
		$.ajax({
				 url:"formConsulta/addActividad.php",
				 method:"POST",
				 data:{IdOferta:IdOferta,IdModulo:IdModulo,IdParcial:IdParcial,IdSemana:IdSemana},
				 success:function(data){
							$('#employee_detailAct').html(data);
							$('#dataModalActividad').modal('show');
				 }
		});

	}



$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	var variable = document.frm.Variable.value;
	if(alerta){
		if(alerta =="GUARDAR"){
			swal("Guardado", variable + " GUARDADO CON ÉXITO", "success");
		}
		if(alerta =="ACTUALIZAR"){
			swal("Actualizado", variable + " actualizado con exito", "success");
		}
		if(alerta =="ELIMINAR"){
			swal("Eliminado", variable + " ELIMINADO CON ÉXITO", "success");
		}
		if(alerta =="ERROR"){
			swal("Error", variable + " FAVOR DE COMUNICARSE CON EL ADMINISTRADOR", "error");
		}
	}
});
  $(function () {
    //bootstrap WYSIHTML5 - text editor
    $('.textarea').wysihtml5()
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
