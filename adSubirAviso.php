<?php
$section = "Subir aviso"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en le modulo de avisos'); }
$lstDocs=$t->get_docsAvisos();
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="GuardarDocs"){
		$t->add_fileAvisos();
		exit;
	}
}


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
        Subir aviso
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Aviso</a></li>
        <li class="active">Subir archivos</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adSubirAviso.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
						<div class="col-md-3">
						  <div class="box-primary">
								<div class="form-group">
									<label>Usuario:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtUsuario" id="txtUsuario">
											<option value=""> - Seleccione - </option>
											<option value="2">Profesores</option>
											<option value="3">Alumnos</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-3">
						  <div class="box-primary">
								<div class="form-group">
									<label>Tipo:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtTipo" id="txtTipo">
											<option value=""> - Seleccione - </option>
												<option value="I">Imagen</option>
												<option value="A">PDF</option>
												<option value="V">Video</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>

					<div class="col-md-6">
					  <div class="box-primary">
							<div class="form-group">
								<label>Título del aviso:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input class="form-control" id="txtTitulo" name="txtTitulo" type="text">
								</div>
							</div>
					  </div>
					</div>
					<div class="col-md-4">
					  <div class="box-primary">
							<div class="form-group">
								<label>Nombre del aviso:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-list-alt"></i>
								  </div>
								  <input class="form-control" id="txtNombre" name="txtNombre" type="text">
								</div>
							</div>
					  </div>
					</div>

					<div class="col-md-6">
					  <div class="box-primary">
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
					  <!-- /.box -->
					</div>
					<div class="col-md-2">
						<div class="box-primary">
							<div class="box-body">
							<div class="box-footer" style=" text-align: right;">
								<button type="button" class="btn btn-success" onClick="val_subAvisosDocs()"><i class="fa fa-fw fa-save"></i> Subir aviso </button>
							</div>
							</div>
						</div>
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
								<th>Usuario</th>
								<th>Titulo</th>
								<th>Aviso</th>
								<th>Fecha de captura</th>
								<th>Ver archivo</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=0;$i< sizeof($lstDocs);$i++) { $mo = $lstDocs[$i]["Permisos"]; if($mo == "2") { $uss = "Profesor"; } else { $uss = "Alumnos"; } ?>
							<tr id="<?php echo $lstDocs[$i]["IdAviso"]; ?>">
								<td>
									<button onclick="delFileAviso(<?php echo $lstDocs[$i]["IdAviso"]; ?>)" title="Eliminar aviso" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									<?php if($mo == 3){ ?>
									<button onclick="confGpr(<?php echo $lstDocs[$i]["IdAviso"]; ?>)" title="Configurar" type="button" class="btn btn-success"><i class="fa fa-refresh"></i></button>
								<?php } else { ?>
									<button onclick="confAsesor(<?php echo $lstDocs[$i]["IdAviso"]; ?>)" title="Configurar" type="button" class="btn btn-success"><i class="fa fa-refresh"></i></button>
								<?php } ?>
								</td>
								<td><?php echo $uss; ?></td>
								<td><?php echo $lstDocs[$i]["Titulo"]; ?></td>
								<td><?php echo $lstDocs[$i]["Aviso"]; ?></td>
								<td><?php echo $lstDocs[$i]["FecCap"]; ?></td>
								<td>
									<button title="Ver archivo" onClick="window.open('assets/images/avisos/<?php echo $lstDocs[$i]["Archivo"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-success"><i class="fa fa-file"></i></button>
								</td>

							</tr>
							<?php } ?>
						</tfoot>
					</table>
				</div>
      </div>
    </section>
  </div>
  <?php include("footer.php"); ?>
</div>

<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
		 <div class="modal-dialog">
					<div class="modal-content">
							 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Configuraciones generales</h4>
							 </div>
							 <div class="modal-body" id="employee_Grp">

							 </div>
					</div>
		 </div>
</div>


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>

function confGpr(IdAviso){
	var IdCampus = 1;
	var IdOferta = 0;
	$.ajax({
			 url:"formConsulta/avisoGrupo.php",
			 method:"POST",
			 data:{IdAviso:IdAviso,IdCampus:IdCampus,IdOferta:IdOferta},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});
}

function confAsesor(IdAviso){
	$.ajax({
			 url:"formConsulta/avisoAsesor.php",
			 method:"POST",
			 data:{IdAviso:IdAviso},
			 success:function(data){
						$('#employee_Grp').html(data);
						$('#dataGrp').modal('show');
			 }
	});
}

</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
