<?php $mnAl = 5; $section = "Mi equipo"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visuallizando si ya está asignado a algún equipo'); }
if($_SESSION['Permisos']=="3") {
$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$recursosA=$t->get_recursosApoyo($_SESSION['IdAsignacion']);
$miEquipo=$t->get_miEquipo($_SESSION['IdAsignacion'],$_SESSION["IdUsua"]);
$miEquipoDet=$t->get_miEquipoDet($_SESSION['IdAsignacion'],$miEquipo[0]["Equipo"]);
if($AsignacionId[0]["NombreMod"]) {
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
	  <?php include("menuV.php"); ?>
	  <div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo $AsignacionId[0]["NombreMod"];?>
		  </h1>
		  <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
				<li class="active"><a href="#">Mi equipo</a></li>
		  </ol>
		</section>
		<section class="content">
		  <div class="row">
				<div class="col-md-12">

              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Mi equipo</h3>
                  <div class="box-tools pull-right">
                    <span class="label label-danger">Miembros</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
								<?php if($miEquipoDet[0]) { ?>
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
										<?php for ($i=0;$i< sizeof($miEquipoDet);$i++) { ?>
										<li>
                      <img width="50px"src="assets/perfil/<?php echo $miEquipoDet[$i]["Foto"]; ?>" alt="Image">
                      <a class="users-list-name" href="#"><?php echo $miEquipoDet[$i]["Nombre"].' '.$miEquipoDet[$i]["APaterno"].' '.$miEquipoDet[$i]["AMaterno"]; ?></a>
                    </li>
									<?php } ?>
                  </ul>
                </div>
							<?php } else { ?> <br>
								<h2 style=" text-align: center; color: red;">No esta en ningún equipo</h1><br>
							<?php } ?>
              </div>
            </div>
		  </div>
		</section>
	  </div>
	  <?php include("footer.php"); ?>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php
 unset($_SESSION['Alerta']); unset($_SESSION['Variable']);
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
}
 } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
