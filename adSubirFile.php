<?php
$section = "Subir archivo"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar una asignaturas'); }
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_fileAsignatura();
		exit;
	}
}

// if($_SESSION['Permisos'] == 9){
// 	$_POST["txtOferta"] = $_SESSION['IdOferta'];
// }

$IdModulo = substr($_GET["IdModulo"], 10, 10);


$moduloId=$t->get_moduloIdE($IdModulo);
$archivos=$t->get_archivosIdE($IdModulo,$moduloId[0]["IdEducativa"]);

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Subir archivos en la asigantura
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Asignaturas</a></li>
        <li class="active">Subir archivos</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><b>NOMBRE:</b> <?php echo $moduloId[0]["CodeModulo"].' / '.$moduloId[0]["NombreMod"]; ?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adSubirFile.php" method="POST" enctype="multipart/form-data">
					  <input id="TipoGuardar" name="TipoGuardar" value="val_adUpdModulo" type="hidden"/>
						<input id="IdModulo" name="IdModulo" value="<?php echo $IdModulo; ?>" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden"/>
						<input id="IdOferta" name="IdOferta" value="<?php echo $moduloId[0]["IdEducativa"]; ?>" type="hidden"/>
						<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>

					<div class="col-md-5">
					  <div class="box-primary">
						  <div class="box-body">
							<div class="form-group">
								<label>Nombre del archivo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del archivo" type="text">
								</div>
							</div>
						  </div>
					  </div>
					</div>
					<div class="col-md-3">
					  <div class="box-primary">
						  <div class="box-body">
							<div class="form-group">
								<label>Tipo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-qrcode"></i>
								  </div>

									<select class="form-control" id="txtTipo" name="txtTipo">
										<option> - Seleccione - </option>
										<option value="Escolar">Escolar</option>
										<option value="No escolar">No Escolar</option>
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
								<label>Buscar archivo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-book"></i>
								  </div>
								  <input class="form-control" id="txtArchivo" name="txtArchivo" type="file">
								</div>
							</div>
						  </div>
					  </div>
					  <!-- /.box -->
					</div>

					<div class="col-md-12" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
					    <div class="box-primary">
						    <div class="box-body">
								<div class="box-footer" style=" text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
								</div>
						    </div>
					    </div>
					</div>




					<div class="col-md-12">
					    <div class="box-primary">
						    <div class="box-body">
								<div class="box-footer" style=" text-align: center;">
									<button type="button" class="btn btn-danger" onClick="window.open('adSelModulos.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-rotate-left"></i> Regresar </button>
		              <button type="button" class="btn btn-success" onClick="val_subAstura()"><i class="fa fa-fw fa-save"></i> Subir archivo </button>
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
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Ajuste</th>
								<th>Nombre</th>
								<th>Tipo</th>
								<th>Fecha de captura</th>
								<th>Ver archivo</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=0;$i< sizeof($archivos);$i++) { ?>
							<tr id="<?php echo $archivos[$i]["IdArchivo"]; ?>">
								<td>
									<button onclick="delFile(<?php echo $archivos[$i]["IdArchivo"]; ?>)" title="Eliminar archivo" type="button" class="btn btn-primary"><i class="fa fa-trash"></i></button>
								</td>
								<td><?php echo $archivos[$i]["Nombre"]; ?></td>
								<td><?php echo $archivos[$i]["Tipo"]; ?></td>
								<td><?php echo $archivos[$i]["FecCap"]; ?></td>
								<td>

									<button title="Ver archivo" onClick="window.open('assets/docs/files/asignatura/<?php echo $archivos[$i]["Link"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-success"><i class="fa fa-file"></i></button>
								</td>

							</tr>
							<?php } ?>
						</tfoot>
					</table>
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
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
