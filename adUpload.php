<?php
$section = "Subir archivo"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de subir libros de consulta y antología'); }
if(isset($_GET["id"])){ $_POST["txtOferta"] = $_GET["id"]; }
$lstOferta=$t->get_lstOTodos();
$lstMateria=$t->get_ModuloId($_POST["txtOferta"],1);

$lstDocs=$t->get_docsSubidsX($_POST["txtOferta"]);
if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadDocsMx"){
		$t->add_fileDocsMx();
		exit;
	}
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Subir archivos libros de consulta, planeación.
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Documentos</a></li>
        <li class="active">Subir archivos</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="adUpload.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="<?php echo $_GET['Mov']; ?>" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
						<div class="col-md-7">
							<div class="box-primary">
								<div class="form-group">
									<label>Oferta educativa:</label>
									<div class="input-group">
										<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
										</div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstOferta);$i++) { ?>
											<option value="<?php echo $lstOferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$lstOferta[$i]["IdEducativa"]){ ?>selected="selected"<?php }?>><?php echo $lstOferta[$i]["Nombre"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="box-primary">
								<div class="form-group">
									<label>Asignatura:</label>
									<div class="input-group">
										<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
										</div>
										<select class="form-control" name="txtModulo" id="txtModulo">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstMateria);$i++) { ?>
											<option value="<?php echo $lstMateria[$i]["IdModulo"]; ?>"<?php if($_POST["txtModulo"]==$lstMateria[$i]["IdModulo"]){ ?>selected="selected"<?php }?>><?php echo $lstMateria[$i]["CodeModulo"].' '.$lstMateria[$i]["NombreMod"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
						  <div class="box-primary">
								<div class="form-group">
									<label>Modalidad:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtModalidad" id="txtModalidad">
											<option value=""> - Seleccione - </option>
												<option value="E">Escolar</option>
												<option value="N">No Escolar</option>
												<option value="M">Ambos</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>
						<div class="col-md-3">
						  <div class="box-primary">
								<div class="form-group">
									<label>Tipo documento:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtTema" id="txtTema">
											<option value=""> - Seleccione - </option>
												<option value="9">Libro de consulta</option>
												<option value="10">Planeación</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>
					<div class="col-md-5">
					  <div class="box-primary">
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
					<div class="col-md-8">
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
					<div class="col-md-4">
						<div class="box-primary">
							<div class="box-body">
							<div class="box-footer" style=" text-align: right;">
								<button type="button" class="btn btn-success" onClick="val_subDoscMx()"><i class="fa fa-fw fa-save"></i> Subir archivo </button>
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

          </div>
          <!-- /.row -->
        </div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Ajuste</th>
								<th>Tipo</th>
								<th>Nombre</th>
								<th>Asignatura</th>
								<th>Fecha de captura</th>
								<th>Ver archivo</th>
							</tr>
						</thead>
						<tbody>
							<?php for ($i=0;$i< sizeof($lstDocs);$i++) {
								$mo = $lstDocs[$i]["Tipo"]; if($mo == "E") { $mod = "Escolar"; } elseif($mo == "N") { $mod = "No Escolar"; } else { $mod = "Ambos"; }
								 ?>
							<tr id="<?php echo $lstDocs[$i]["IdLibro"]; ?>">
								<td>
									<button onclick="delFileDocsXX(<?php echo $lstDocs[$i]["IdLibro"]; ?>)" title="Eliminar archivo" type="button" class="btn btn-primary"><i class="fa fa-trash"></i></button>
								</td>
								<td><?php echo $lstDocs[$i]["Descripcion"]; ?><br><?php echo $mod; ?><br><?php echo $semc; ?></td>
								<td><?php echo $lstDocs[$i]["Nombre"]; ?></td>
								<td><?php echo $lstDocs[$i]["CodeModulo"].' - '.$lstDocs[$i]["NombreMod"]; ?></td>
								<td><?php echo $lstDocs[$i]["FecCap"]; ?></td>
								<td>
									<button title="Ver archivo" onClick="window.open('assets/docs/libro/<?php echo $lstDocs[$i]["Oferta"]; ?>/<?php echo $lstDocs[$i]["Link"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn btn-success"><i class="fa fa-file"></i></button>
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
