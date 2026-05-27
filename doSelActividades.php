<?php $section = "Tareas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado las tareas'); }
if($_SESSION['Permisos']) {
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
if($AsignacionId[0]["NombreMod"]) {
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<link rel='stylesheet prefetch' href='assets/fancy/css/ybgpzy.css'>
<!--<link rel="stylesheet" href="assets/fancy/css/style.css">-->
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
			  <h1>
				<?php echo $AsignacionId[0]["NombreMod"];?>
			  </h1>
			  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
				<li class="active">Tareas</li>
			  </ol>
			</section>
			<form name="frm" id="frm" action="doSelActividades.php" method="POST" enctype="multipart/form-data">
				<input id="Id" name="Id" value="<?php echo $_SESSION['IdAsignacion']; ?>" type="hidden"/>
			<section class="content">
				<div class="row">
					<?php if($Actividades[0]=="" || $Actividades[0]["Estatus"]==""){ ?>
					<div class="col-md-12">
			          <div class="box box-widget">
			            <div class="box-header with-border">
			              <div class="user-block">
			                <img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Image">
			                <span class="username"><a href="#">No hay tareas</a></span>
			                <span class="description"></span>
			              </div>
			            </div>
			          </div>
			        </div>
			        <?php } ?>


					<?php for ($i=0;$i< sizeof($Actividades);$i++) { if($Actividades[$i]["Estatus"]) { if($Actividades[$i]["TipoActividad"]=="Examen") { $texto1 = "Este"; } else { $texto1 = "Esta";} ?>
					<div class="col-md-12">
			          <div class="box box-widget">
			            <div class="box-header with-border">
			              <div class="user-block">
			                <img class="img-circle" src="assets/perfil/<?php echo $Actividades[$i]["Foto"]; ?>" alt="User Image">
			                <span class="username"><a href="#"><?php echo $Actividades[$i]["Nombre"].' '.$Actividades[$i]["APaterno"].' '.$Actividades[$i]["AMaterno"]; ?></a></span>
			                <span class="description">Publicado <?php echo tiempo_transcurrido($Actividades[$i]["FecCap"]); ?></span>
			              </div>
			              <div class="box-tools">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			              </div>
			            </div>
			            <div class="box-body">
										<div class="box box-solid">
											<div class="box-header with-border">
											<?php if($Actividades[$i]["Estatus"]=="Finalizado") { ?>
											  <i style="color: red" class="fa fa-fw fa-bell-slash"></i>
											  <h3 style="color: red" class="box-title">El tiempo de <?php echo $texto1." <label style=' text-transform: lowercase; font-weight: none; '>".$Actividades[$i]["TipoActividad"]."</label>"; ?> ha terminado</h3>
											<?php } elseif ($Actividades[$i]["Estatus"]=="Activo") { ?>
											  <i style="color: #3c8dbc" class="fa fa-bell-o"></i>
											  <h3 style="color: #3c8dbc" class="box-title"><?php echo $texto1." <label style=' text-transform: lowercase; font-weight: none; '>".$Actividades[$i]["TipoActividad"]."</label>"; ?> esta en tiempo</h3>
											<?php } ?>
											</div>
											<div class="box-body">
												  <dl class="dl-horizontal">
													<dt><?php echo $Actividades[$i]["TipoActividad"]; ?>:</dt>
													<dd><?php echo $Actividades[$i]["TituloActividad"]; ?></dd>
													<dt>Fecha inicial:</dt>
													<dd><?php echo obtenerFechaEnLetra($Actividades[$i]["FecIni"]); ?></dd>
													<dt>Fecha final:</dt>
													<dd><?php echo obtenerFechaEnLetra($Actividades[$i]["FecFin"]); ?></dd><br>
													<dt>Modalidad:</dt>
													<dd><?php echo $Actividades[$i]["Modalidad"]; ?>
														<button type="button" class="btn btn-primary view_data" href="javascript:void(0);" name="view" value="view" href="javascript:;" id="<?php echo $Actividades[$i]["NoActividad"]; ?>" style="float: right;"><i class="fa fa-eye"></i> Ver detalle</button>
													</dd>
												  </dl>
											</div>
										</div>
			            </div>
			          </div>
			        </div>
			        <?php } } ?>



				</div>
			</section>
		</form>
			<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-body" id="employee_detail">
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
				var Id = document.getElementById("Id").value;
           var employee_id = $(this).attr("id");
           if(employee_id != '')
           {
                $.ajax({
                     url:"formConsulta/viewForoDetalle.php",
                     method:"POST",
                     data:{employee_id:employee_id,Id:Id},
                     success:function(data){
                          $('#employee_detail').html(data);
                          $('#dataModal').modal('show');
                     }
                });
           }
      });
 });
 </script>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src='assets/fancy/js/ybgpzy.js'></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
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
