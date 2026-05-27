<?php $section = "Foro"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está observando el foro'); }
	if(!$_SESSION['IdAsignacion']){
		$_SESSION['IdAsignacion'] = $_GET["Id"];
	}

	if(!$_SESSION['EstatusAsig']){
		$_SESSION['EstatusAsig'] = $_GET["T"];
	}
//unset($_SESSION['IdAsignacion']);

if($_SESSION['Permisos']=="3" || $_SESSION['Permisos']=="2") {
	$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
	$_SESSION['IdOferta'] = $AsignacionId[0]["IdEducativa"];
	if($AsignacionId[0]["NombreMod"]) {
	$ForoAlumno=$t->get_datosForoAlumno($_SESSION['IdAsignacion']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
				<h1><?php echo $AsignacionId[0]["NombreMod"];?></h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
					<li class="active">Foro</li>
				</ol>


			</section>


			<section class="content">
				<div class="row">
					<?php if($ForoAlumno[0]){ ?>
						<?php for ($i=0;$i< sizeof($ForoAlumno);$i++) {
						$IdActividad = $ForoAlumno[$i]["IdActividad"];
						$ForoTotalComent=$t->get_datosForoTotComent($ForoAlumno[$i]["IdActividad"]);
						$ForoTotalRespuesta=$t->get_foroRespuestas($ForoAlumno[$i]["IdActividad"]); ?>
						<div class="col-md-12">

							<div class="box box-widget">
								<div class="box-header with-border">
									<div class="user-block">
										<img class="img-circle" src="assets/perfil/<?php echo $ForoAlumno[$i]["Foto"];?>" alt="User Image">
										<span class="username"><a href="#"><?php echo $ForoAlumno[$i]["Nombre"].' '.$ForoAlumno[$i]["APaterno"].' '.$ForoAlumno[$i]["AMaterno"];?></a></span>
										<span class="description">Publicado <?php echo tiempo_transcurrido($ForoAlumno[$i]["FecCap"]); ?></span>
									</div>
									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body" style="">
									<h4 class="attachment-heading"><i class="fa fa-fw fa-gg-circle"></i> <?php echo $ForoAlumno[$i]["TituloActividad"]; ?></h4>
									<p><?php echo $ForoAlumno[$i]["Descripcion"];?></p>
									<button <?php if($ForoLikeActivo[0]['IdLike']){ ?> style="color: blue;" <?php } ?> name="txtLike-<?php echo $IdActividad; ?>" id="txtLike-<?php echo $IdActividad; ?>" onclick="val_like(<?php echo $IdActividad; ?>, <?php echo $_SESSION['IdUsua']; ?>)" type="button" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up"></i> Me gusta</button>
									<button onClick="window.open('viewForoId.php?Id=<?php echo $ForoAlumno[$i]["IdActividad"]; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-default btn-xs"><i class="fa fa-commenting"></i> Comentar</button>
									<span style="font-size: 13px;" class="pull-right text-muted">
										<a class="btn btn-info btn-xs view_data" href="javascript:void(0);" name="view" value="view" id=<?php echo $ForoAlumno[$i]["IdActividad"]; ?> > <i class="fa fa-thumbs-up"></i> <?php echo $ForoTotalLike[0]['TotalLike']; ?> </a>
										 <?php if($ForoTotalComent[0]['TotalComent']) { ?> &diams; <a  class="btn btn-info btn-xs" href="javascript:void(0);" name="coment" value="coment" id=<?php echo $ForoAlumno[$i]["IdActividad"]; ?> > <i class="fa fa-commenting"></i> <?php echo $sum = $ForoTotalComent[0]['TotalComent'] + $ForoTotalRespuesta[0]["Suma"]; ?> </a><?php } ?>
									 </span>
								</div>

								<div class="box-footer" style="">
									<form name="frm" id="frm" action="viewForo.php" method="POST" enctype="multipart/form-data">
										<input id="TipoGuardar" name="TipoGuardar" value="val_viewForo" type="hidden"/>
										<input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>

									</form>
								</div>
							</div>
						</div>
						<?php } ?>


				<?php } else { ?>
					<div class="col-md-12">
						<div class="box box-widget">
							<div class="box-header with-border">
								<div class="user-block">
									<img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Image">
									<span class="username"><a href="#">No hay publicaciones</a></span>
									<span class="description"></span>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				</div>

			</section>
			<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
			      <div class="modal-dialog">
			           <div class="modal-content">
			                <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
			                     <button type="button" class="close" data-dismiss="modal">&times;</button>
			                     <h4 class="modal-title">Personas que le dieron me gusta</h4>
			                </div>
			                <div class="modal-body" id="employee_detail">
			                </div>
			           </div>
			      </div>
			 </div>

			 <div id="dataModalC" class="modal fade"> <!--MODAL ME GUSTA-->
 			      <div class="modal-dialog">
 			           <div class="modal-content">
 			                <div class="modal-header" style="background: #449F43; color: white; font-size: 16px;">
 			                     <button type="button" class="close" data-dismiss="modal">&times;</button>
 			                     <h4 class="modal-title">Personas que comentaron en esta publicación</h4>
 			                </div>
 			                <div class="modal-body" id="employee_detailC">
 			                </div>
 			           </div>
 			      </div>
 			 </div>
		</div>
	<?php include("footer.php"); ?>
	</div>
</body>


<script>
 $(document).ready(function(){
      $(document).on('click', '.view_data', function(){
           var employee_id = $(this).attr("id");
					 var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewLike.php",
                     method:"POST",
                     data:{employee_id:employee_id,IdAsignacion:IdAsignacion},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });

			$(document).on('click', '.view_coment', function(){
           var employee_id = $(this).attr("id");
					 var IdAsignacion = document.getElementById("Id").value;
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewDetalleC.php",
                     method:"POST",
                     data:{employee_id:employee_id,IdAsignacion:IdAsignacion},
                     success:function(data){
                          $('#employee_detailC').html(data);
                          $('#dataModalC').modal('show');
                     }
                });
           }
      });
 });

 </script>


 <script src="bower_components/jquery/dist/jquery.min.js"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
 <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
 <script>
   $.widget.bridge('uibutton', $.ui.button);
 </script>
 <!-- Bootstrap 3.3.7 -->
 <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->

 <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
 <!-- datepicker -->
 <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
 <!-- AdminLTE App -->
 <script src="dist/js/adminlte.min.js"></script>
 <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
 <script src="dist/js/pages/dashboard.js"></script>
 <!-- AdminLTE for demo purposes -->
 <script src="dist/js/demo.js"></script>

</body>
</html>
<?php } else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
