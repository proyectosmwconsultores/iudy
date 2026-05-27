<?php $valor = 3; $section = "Asesores"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el buscador de asesores.'); }
$id = substr($_GET["token"], 10,10);

$planeacion=$t->get_datPlaneacion($id);
$infoPlan=$t->get_infoPlan($planeacion[0]["IdAsignacion"]);


$asesor=$t->get_datAsesor($planeacion[0]["IdUsua"]);
if($asesor[0]){
	$asignaturas=$t->get_datAsignaturas($id);
}

if($infoPlan[0]["Modalidad"] == "E"){ $mdT = "Escolarizado"; } elseif($infoPlan[0]["Modalidad"] == "N"){ $mdT = "No-Escolarizado"; } elseif($infoPlan[0]["Modalidad"] == "M"){ $mdT = "Mixto"; }
if($infoPlan[0]["Turno"] == "M"){ $mxR = "Matutino"; } elseif($infoPlan[0]["Turno"] == "V"){ $mxR = "Vespertino"; } elseif($infoPlan[0]["Turno"] == "I"){ $mxR = "Interweek"; }

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
					B&uacute;squeda de planeaciones acad&eacute;micas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-seach"></i> Buscar</a></li>
					<li class="active">Planeaci&oacute;n</li>
				</ol>
			</section>

      <section class="content">
				<form name="frm" id="frm" action="searchPlaneacion.php" method="POST" enctype="multipart/form-data">
					<input id="token" name="token" value="<?php echo $_GET['token'];?>" type="hidden"/>
					<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $planeacion[0]["IdAsignacion"]; ?>" type="hidden"/>
					<input id="IdPlaneacion" name="IdPlaneacion" value="<?php echo $planeacion[0]["IdPlaneacion"]; ?>" type="hidden"/>
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
      <div class="row">

        <div class="col-md-3">
          <div class="box box-primary">
						<a href="javascript:void(0);" class="btn btn-warning btn-block view_buscar"><b><i class="fa fa-fw fa-search"></i> Planeaci&oacute;n</b></a>
            <div class="box-body box-profile">
							<?php if($_GET['token']){ ?>
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $asesor[0]["Foto"]; ?>" alt="User profile picture">
						<?php } else { ?>
							<img class="profile-user-img img-responsive img-circle" src="assets/perfil/hombre.png" alt="User profile picture">
						<?php } ?>

              <h3 class="profile-username text-center"><?php echo $asesor[0]["Nombre"]; ?></h3>

              <p class="text-muted text-center"><?php echo $asesor[0]["APaterno"].' '.$asesor[0]["AMaterno"]; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Estatus</b> <a class="pull-right"><b><?php echo $asesor[0]["Estatus"]; ?></b></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-envelope"></i></b> <a class="pull-right"><?php echo $asesor[0]["Correo"]; ?></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-phone-square"></i></b> <a class="pull-right"><?php echo $asesor[0]["Telefono"]; ?></a>
                </li>
              </ul>
							<?php if($planeacion[0]["IdUsuaAprob"]){ ?>
							<a onClick="window.open('repositorio/pdf/impPlaneacion.php?toks=<?php echo time().$id; ?>','_blank')" href="javascript:void(0);" class="btn btn-info btn-block"><b> <i class="fa fa-fw fa-cloud-download"></i> Descargar Planeaci&oacute;n</b></a>
						<?php } ?>
						<a onClick="noticarPlan()" href="javascript:void(0);" class="btn btn-success btn-block"><b> <i class="fa fa-fw fa-wechat"></i> Notificar</b></a>
            </div>
          </div>

        </div>

        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Informacion general</a></li>
              <li><a href="#timeline" data-toggle="tab">Costos</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
								<div class="box box-widget widget-user-2">
			            <!-- Add the bg color to the header using any of the bg-* classes -->
			            <div class="widget-user-header" style=" background: #fff; color: black;">
			              <div class="widget-user-image">
											<?php if($infoPlan[0]["Publicidad"]) { ?>
			                <img src="assets/images/oferta/<?php echo $infoPlan[0]["Publicidad"]; ?>.png" alt="User Avatar">
											<?php } else { ?>
												<img src="assets/images/oferta/default.png" alt="User Avatar">
											<?php } ?>
			              </div>
			              <!-- /.widget-user-image -->
			              <h3 class="widget-user-username"><?php echo $planeacion[0]["Planeacion"]; ?></h3>
										<h5 class="widget-user-desc"><?php echo $infoPlan[0]["Clave"].' - '.$infoPlan[0]["Nombre"]; ?></h5>
			              <h5 class="widget-user-desc"><?php echo $infoPlan[0]["CodeModulo"].' - '.$infoPlan[0]["NombreMod"]; ?></h5>
			            </div>
			            <div class="box-footer no-padding">
			              <ul class="nav nav-stacked">
			                <li> <a href="#"> <b style="padding-left: 10px;">Campus: <?php echo $infoPlan[0]["Campus"]; ?></b> <span class="pull-left badge bg-aqua"> <i class="fa fa-fw fa-bank"></i> </span></a></li>
			                <li> <a href="#"> <b style="padding-left: 10px;">Modalidad: <?php echo $mdT; ?></b><span class="pull-left badge bg-green"> <i class="fa fa-fw fa-houzz"></i> </span></a></li>
			                <li> <a href="#"> <b style="padding-left: 10px;">Turno: <?php echo $mxR; ?></b><span class="pull-left badge bg-green"> <i class="fa fa-fw fa-houzz"></i> </span></a></li>
			                <li> <a href="#"> <b style="padding-left: 10px;">Grupo: <?php echo $infoPlan[0]["CveGrupo"]; ?> </b> <span class="pull-left badge bg-green"> <i class="fa fa-fw fa-users"></i> </span></a></li>
			              </ul>
			            </div>
			          </div>


              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
								<div class="box box-primary">

            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Costo Hora/Semana/Mes Impartido:</label>
                  <input class="form-control" value="<?php echo $planeacion[0]["Costo"] ?>" id="txtCosto" name="txtCosto" placeholder="Costo Hora/Semana/Mes Impartido" type="text">
                </div>

              </div>
              <!-- /.box-body -->
							<?php   if($_SESSION["Permisos"] == 11){ ?>
              <div class="box-footer">
                <button type="button" onclick="savCosto()"  class="btn btn-info">Guardar costos</button>
              </div>
							<?php } ?>
            </form>
          </div>


								<!-- <div class="box-body table-responsive no-padding">
									<form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label"></label>

                    <div class="col-sm-10">
                      <input class="form-control" id="inputName" placeholder="Name" type="email">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button onclick="savCosto()" type="button" class="btn btn-block btn-info btn-sm">Guardar costos</button>
                    </div>
                  </div>
                </form>


		            </div> -->

              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
		</form>
    </section>
		</div>
		<div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Buscador de Planeaci&oacute;n</h4>
									 </div>
									 <div class="modal-body" id="employee_detail4">

									 </div>
							</div>
				 </div>
		</div>

		<div id="dataModalChat" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #292b33; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Notificaciones de la Planeaci&oacute;n</h4>
									 </div>
									 <div class="modal-body" id="employee_detailChat">

									 </div>
							</div>
				 </div>
		</div>

	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script>

function noticarPlan(){
	var IdAsignacion = document.getElementById("IdAsignacion").value;
	var IdPlaneacion = document.getElementById("IdPlaneacion").value;
	var Tipo = "O";
	$.ajax({
			 url:"formConsulta/chatPlaneacion.php",
			 method:"POST",
			 data:{IdAsignacion:IdAsignacion, IdPlaneacion:IdPlaneacion, Tipo:Tipo},
			 success:function(data){
						$('#employee_detailChat').html(data);
						$('#dataModalChat').modal('show');
			 }
	});
}

$(document).ready(function(){
	var token = document.getElementById("token").value;
	if(token == ''){
		$.ajax({
				 url:"formConsulta/buscarPlaneacion.php",
				 method:"POST",
				 data:{},
				 success:function(data){
							$('#employee_detail4').html(data);
							$('#dataModal4').modal('show');
				 }
		});
	}

})

$(document).ready(function(){
		 $(document).on('click', '.view_buscar', function(){
			 $.ajax({
						url:"formConsulta/buscarPlaneacion.php",
						method:"POST",
						data:{},
						success:function(data){
								 $('#employee_detail4').html(data);
								 $('#dataModal4').modal('show');
						}
			 });
		 });
});


</script>


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClic
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
