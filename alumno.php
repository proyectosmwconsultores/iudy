<?php $valor = 3; $section = "Alumnos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el buscador de alumnos'); }
if(isset($_GET["token"])){
	$id = substr($_GET["token"], 10,10);
	$alumno=$t->get_alumnId($id);
	$docente=$t->get_docentId($alumno[0]['id_usua']);

	$datKardex = $t->get_datKardexId($id);

}
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
					Perfil de alumno
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Perfil</a></li>
					<li class="active">Alumno</li>
				</ol>
			</section>

      <section class="content">
				<form name="frm" id="frm" action="alumno.php" method="POST" enctype="multipart/form-data">
					<input id="token" name="token" value="<?php if(isset($_GET['token'])){ echo $_GET['token']; }?>" type="hidden"/>
					<input id="Mov" name="Mov" value="" type="hidden"/>
      	<div class="row">

        <div class="col-md-4">
          <div class="box box-primary">
						<a href="javascript:void(0);" class="btn btn-info btn-block view_buscar"><b><i class="fa fa-fw fa-search"></i> B&uacute;squeda de alumno</b></a>

            <div class="box-body box-profile">
							<?php if(isset($_GET['token'])){ ?>
              <img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $alumno[0]["Foto"]; ?>" alt="User profile picture" style="width:100px; height: 100px;">
						<?php } else { ?>
							<img class="profile-user-img img-responsive img-circle" src="assets/perfil/nuevo.png" alt="User profile picture">
						<?php } ?>
						<?php if(isset($_GET['token'])){  ?>
              <h3 class="profile-username text-center"><?php echo $alumno[0]["Nombre"]; ?></h3>

              <p class="text-muted text-center"><?php echo $alumno[0]["APaterno"].' '.$alumno[0]["AMaterno"]; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Estatus</b> <a class="pull-right"><b><?php echo $alumno[0]["Estatus"]; ?></b></a>
                </li>
                <li class="list-group-item">
                  <b>Matr&iacute;cula</b> <a class="pull-right"><?php echo $alumno[0]["Usuario"]; ?></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-envelope"></i></b> <a class="pull-right"><?php echo $alumno[0]["Correo"]; ?></a>
                </li>
                <li class="list-group-item">
                  <b><i class="fa fa-fw fa-phone-square"></i></b> <a class="pull-right"><?php echo $alumno[0]["Telefono"]; ?></a>
                </li>
								<?php if(($_SESSION["PerXS"] == "p2Dr0$") && ($_SESSION["Permisos"] == 1)) { ?>
								<li class="list-group-item">
                  <b onclick="mostrarPass()" style="cursor: pointer;"><i class="fa fa-fw fa-eye"></i></b> <a class="pull-right">
										<div class="form-group" style="margin-top: -7px;">
											<input type="password" class="form-control" id="txtP1" value="               ">
                  		<input type="text" class="form-control" id="txtP2" value="<?php echo $alumno[0]['Code']; ?>" style="display: none; text-align: right;">
                </div>
									</a>
                </li><?php } ?>
              </ul>
						<?php } ?>



							<?php if((isset($_GET['token'])) && ($alumno[0]["IdEstatus"] == 50)) { ?>
								<a style="text-align: left;" onclick="activarAlumno(<?php echo $id; ?>)" href="javascript:void(0);" class="btn btn-danger btn-block"><b><i class="fa fa-black-tie"></i> Activar alumno</b></a>
							<?php } ?>

								<?php if($_SESSION["IdUsua"] == 3379){ ?>
									<a style="text-align: left;" onclick="addPermisos()" href="javascript:void(0);" class="btn btn-success btn-block"><b><i class="fa fa-unlock"></i> Permisos</b></a>
									<a style="text-align: left;" onClick="window.open('adCalificacion.php?tokenId=<?php echo time().$id; ?>&Envio=P','_self')" href="javascript:void(0);"  class="btn btn-danger btn-block"><b><i class="fa fa-qrcode"></i> Kardex de calificación</b></a>
							<?php } ?>

            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Informaci&oacute;n general</a></li>
							<li><a href="#timeline" data-toggle="tab">Kardex</a></li>
              <!-- <li><a href="#timeline2" data-toggle="tab">Pagos aprobados</a></li> -->
            </ul>
						<?php if(isset($_GET['token'])){ ?>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
								<div class="box box-widget widget-user-2">
			            <div class="widget-user-header" style=" background: #fff; color: black;">
			              <div class="widget-user-image">
												<img src="assets/images/oferta/default.png" alt="User Avatar">
			              </div>
			              <h3 class="widget-user-username"><?php echo $alumno[0]["Campus"]; ?></h3>
			              <h5 class="widget-user-desc"><?php echo $alumno[0]["NomEducativa"]; ?></h5>
			            </div>
			            <div class="box-footer no-padding">
			              <ul class="nav nav-stacked">
											<li> <a href="#"> <b style="padding-left: 10px;">Docente actual:  </b> <?php echo $docente[0]["Nombre"].' '.$docente[0]["APaterno"].' '.$docente[0]["AMaterno"]; ?><span class="pull-left badge bg-purple"> <i class="fa fa-fw fa-user"></i> </span></a></li>
											<li> <a href="#"> <b style="padding-left: 10px;">Grupo actual: </b> <?php echo $alumno[0]["CveGrupo"]; ?> <span class="pull-left badge bg-green"> <i class="fa fa-fw fa-users"></i> </span></a></li>

			              </ul>
			            </div>
			          </div>
              </div>
              <div class="tab-pane" id="timeline">
								<div class="post">
									<?php if($datKardex[0]){ $ofeI = 0; $ofeF = 0; ?>
									<table class="table table-striped">
										<tbody>
											<?php
												for ($i=0;$i< sizeof($datKardex);$i++) {
													 $ofeI = $datKardex[$i]["IdEducativa"];
												   ?>
												<?php if($ofeI <> $ofeF){ ?>
												<tr style="background: #aeaaaa; color: #000; ">
													<th colspan="4"><?php echo $datKardex[$i]["Nombre"]; ?></th>
												</tr>
												<tr style="background: #e1dede; color: #000; ">
													<th>Code</th>
													<th>Materia</th>
													<th>Grupo</th>
													<th>Promedio</th>
												</tr> <?php } ?>
												<tr>
													<td><?php echo $datKardex[$i]["IdAsignacion"]; ?></td>
													<td><?php echo $datKardex[$i]["NombreMod"]; ?></td>
													<td><?php echo $datKardex[$i]["CveGrupo"]; ?></td>
													<td><?php echo $datKardex[$i]["Promedio"]; ?></td>

												</tr>
										<?php $ofeF = $datKardex[$i]["IdEducativa"]; } ?>
									</tbody></table><?php } ?>
								</div>

              </div>
            </div>
					<?php } ?>
          </div>
        </div>
      </div>
		</form>
    </section>
		</div>
		<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Activar alumno</h4>
									 </div>
									 <div class="modal-body" id="employee_Grp">

									 </div>
							</div>
				 </div>
		</div>





	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script>


function activarAlumno(IdUsua){
	var IdCampus = 0;
	$.ajax({
			 url:"reportes/activarAlumno.php",
			 method:"POST",
			 data:{IdUsua:IdUsua, IdCampus:IdCampus},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});
}

function mostrarPass(){
	document.getElementById('txtP1').style.display = 'none';
	document.getElementById('txtP2').style.display = 'block';
}
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
<!-- UPDATE tblc_usuario SET APaterno ='.', AMaterno = '.', Cargo = 'Alumno', Pass_php = '1b4da008bc584dc7c39c70ef38ce5cc3891631542502d6675e943fd533e49dca5688d62eed6957aa389d6400572b270de1bdf720d358f4fdee045c8953073552', FecAlta = '2021-03-04', Permisos = '3', Foto = 'nuevo.png', COde = 'edu-cecis', IdEstatus = '31', IdOferta = '2', IdCampus = '1', Grado = '4', IdPuesto = '1', NEducativo = '10' WHERE Documentos = 'EDE'  -->
