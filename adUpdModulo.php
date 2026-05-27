<?php
$section = "Actualizar asignatura"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar una asignaturas'); }
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_Modulo();
		exit;
	}
}

// if($_SESSION['Permisos'] == 9){
// 	$_POST["txtOferta"] = $_SESSION['IdOferta'];
// }

$IdModulo = substr($_GET["IdModulo"], 10, 10);



$oferta=$t->get_OfertaE($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
$moduloId=$t->get_moduloIdE($IdModulo);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Actualizar datos de la asignatura
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignaturas</a></li>
        <li class="active">Actualizar asignatura</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos de la asignatura</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adUpdModulo.php" method="POST" enctype="multipart/form-data">
					  <input id="TipoGuardar" name="TipoGuardar" value="val_adUpdModulo" type="hidden"/>
						<input id="IdModulo" name="IdModulo" value="<?php echo $IdModulo; ?>" type="hidden"/>
						<input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION['Permisos']; ?>" type="hidden"/>
						<input id="IdOferta" name="IdOferta" value="<?php echo $_POST['txtOferta']; ?>" type="hidden"/>

					<div class="col-md-6">
					  <div class="box-primary">
						  <div class="box-body">
							<div class="form-group">
								<label>No:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input disabled class="form-control" id="txtCode" name="txtCode" placeholder="Code" type="text" value="<?php echo $moduloId[0]["Code"]; ?>">
								</div>
							</div>
						  </div>
					  </div>
					  <!-- /.box -->
					</div>
					<div class="col-md-6">
					  <div class="box-primary">
						  <div class="box-body">
							<div class="form-group">
								<label>IdAsignatura:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input disabled class="form-control" id="txtCode" name="txtCode" placeholder="Code" type="text" value="<?php echo $moduloId[0]["CodeModulo"]; ?>">
								</div>
							</div>
						  </div>
					  </div>
					  <!-- /.box -->
					</div>

					<div class="col-md-12">
					  <div class="box-primary">
						  <div class="box-body">
							<div class="form-group">
								<label>Nombre de la asignatura:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-book"></i>
								  </div>
								  <input class="form-control" id="txtModulo" name="txtModulo" placeholder="Nombre" type="text" value="<?php echo $moduloId[0]["NombreMod"]; ?>">
								</div>
							</div>
						  </div>
					  </div>
					</div>


					<div class="col-md-12">
					    <div class="box-primary">
						    <div class="box-body">
								<div class="box-footer" style=" text-align: center;">
									<button type="button" class="btn btn-danger" onClick="window.open('adSelModulos.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-rotate-left"></i> REGRESAR </button>
		              <button type="button" class="btn btn-success" onClick="val_adUpdModulo()"><i class="fa fa-fw fa-refresh"></i> ACTUALIZAR </button>
								</div>
						    </div>
					    </div>
					  <!-- /.box -->
					</div>
					</form>
					<br><br><br><br>
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
