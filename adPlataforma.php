<?php $valor = 9; $section = "Configurar plataforma"; include("head.php");
if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en configuración de la plataforma'); }
$Usuarios=$t->get_usuariosAlm();
$estatus=$t->get_estatusUser();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadPub"){
	$t->add_uploadPubl();
	exit;
}
if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadLogo"){
	$t->add_uploadLogo();
	exit;
}
if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadIcono"){
	$t->add_uploadIcono();
	exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="uploadMateria"){
	$t->add_uploadMateria();
	exit;
}
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>Configuraci&oacute;n general de la plataforma educativa</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configuraci&oacute;n</a></li>
					<li class="active">Plataforma educativa</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
						<form name="frm" id="frm" action="adPlataforma.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
							<input id="Mov" name="Mov" value="" type="hidden"/>


						<div class="col-md-4">
		          <div class="box box-widget">
		            <div class="box-header with-border">
		              <div class="user-block">
		                <img class="img-circle" src="assets/perfil/<?php echo $_SESSION["Foto"]; ?>" alt="User Image">
		                <span class="username"><a href="#"><?php echo $configuracion[1]["Descripcion"]; ?></a></span>
		                <span class="description">Imagen de publicidad</span>
		              </div>
		              <div class="box-tools">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		              </div>
		            </div>
		            <div class="box-body">
		              <div class="box-body">
										<label for="exampleInputEmail1">Imagen de publicidad:</label>
										<div class="form-group">
											<div class="input-group input-group-sm">
												<input type="hidden" class="form-control" name="publicidad" id="publicidad" value="3">
		                		<input type="file" class="form-control" name="txtPublicidad" id="txtPublicidad">
		                    <span class="input-group-btn">
		                      <button type="button" class="btn btn-info btn-flat" onclick="val_loadPubliX()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
		                    </span>
	              			</div><br><br>
		                  <img src="assets/images/portada.jpg" width="100%">
		                </div>
		              </div>
		            </div>
								<div class="box-body">
		              <div class="box-body">
										<label for="exampleInputEmail1">Logo: (300 * 100 px)</label>
										<div class="form-group">
											<div class="input-group input-group-sm">
												<input type="hidden" class="form-control" name="logo" id="logo" value="4">
		                		<input type="file" class="form-control" name="txtLogo" id="txtLogo">
		                    <span class="input-group-btn">
		                      <button type="button" class="btn btn-info btn-flat" onclick="val_loadLogo()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
		                    </span>
	              			</div><br><br>
											<p style="text-align: center; ">
			                  <img src="assets/images/campus/logo_campus.png" width="150px">
											</p>
		                </div>
		              </div>
		            </div>
								<div class="box-body">
		              <div class="box-body">
										<label for="exampleInputEmail1">Icono: (200 * 200 px)</label>
										<div class="form-group">
											<div class="input-group input-group-sm">
												<input type="hidden" class="form-control" name="icono" id="icono" value="5">
		                		<input type="file" class="form-control" name="txtIcono" id="txtIcono">
		                    <span class="input-group-btn">
		                      <button type="button" class="btn btn-info btn-flat" onclick="val_loadIcono()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
		                    </span>
	              			</div><br><br>
											<p style="text-align: center;">
			                  <img src="assets/images/campus/icono.png" width="150px">
											</p>
		                </div>
		              </div>
		            </div>
								<!-- <div class="box-body">
		              <div class="box-body">
										<label for="exampleInputEmail1">Icono de materias: (200 * 200 px)</label>
										<div class="form-group">
											<div class="input-group input-group-sm">
												<input type="hidden" class="form-control" name="materia" id="materia" value="24">
		                		<input type="file" class="form-control" name="txtMateria" id="txtMateria">
		                    <span class="input-group-btn">
		                      <button type="button" class="btn btn-info btn-flat" onclick="val_loadMateria()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
		                    </span>
	              			</div>
		                  <img src="assets/images/<?php echo $configuracion[23]["Descripcion"]; ?>" width="200px">
		                </div>
		              </div>
		            </div> -->
		          </div>
		        </div>
						<div class="col-md-8">
							<div class="box box-widget">
								<div class="box-header with-border">
									<div class="user-block">
										<img class="img-circle" src="assets/perfil/<?php echo $_SESSION["Foto"]; ?>" alt="User Image">
										<span class="username"><a href="#">Informaci&oacute;n general</a></span>
										<span class="description">Informaci&oacute;n general para mostrar en la plataforma</span>
									</div>
									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
								</div>
								<div class="box-body">
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-4 control-label">Institución:</label>
											<div class="col-sm-7">
												<input class="form-control" name="txtSistema" id="txtSistema" type="text" value="<?php echo $configuracion[11]["Descripcion"]; ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,txtSistema,'12')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Correo:</label>
											<div class="col-sm-7">
												<input class="form-control" name="txtCorreo" id="txtCorreo"  type="text" value="<?php echo $configuracion[7]["Descripcion"]; ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,txtCorreo,'8')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Lema:</label>
											<div class="col-sm-7">
												<input class="form-control" name="txtLema" id="txtLema" type="text" value="<?php echo $configuracion[21]["Descripcion"]; ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,txtLema,'22')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Ciudad:</label>
											<div class="col-sm-7">
												<input class="form-control" name="txtCiudad" id="txtCiudad" type="text" value="<?php echo $configuracion[19]["Descripcion"]; ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,txtCiudad,'20')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Dirección:</label>
											<div class="col-sm-7">
												<input class="form-control" name="txtDireccion" id="txtDireccion" type="text" value="<?php echo $configuracion[12]["Descripcion"]; ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,txtDireccion,'13')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-4 control-label">Fecha cierre de plataforma:</label>
											<div class="col-sm-7">
												<input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1" value="<?php echo $configuracion[33]["Descripcion"] ?>">
											</div>
											<div class="col-sm-1">
												<button type="button" onclick="saveConfig(this,datepicker1,'34')" class="btn btn-danger pull-right"><i class="fa fa-fw fa-refresh"></i></button>
											</div>
										</div>
									</div>

								</div>
							</div>

							<div class="box box-info">
								<div class="box-header with-border">
									<div class="user-block">
										<img class="img-circle" src="assets/images/crm_global_university.png" alt="User Image">
										<span class="username"><a href="#">CRM GLOBAL UNIVERSITY</a></span>
										<span class="description">Configurar mi Plataforma al CRM Global University.</span>
									</div>
								</div>
            <form class="form-horizontal">
							<input type="hidden" class="form-control" id="dominio" name="dominio" value="https://demo.mwcomenius.com.mx/">
              <div class="box-body">
								<span class="help-block" style="text-align: justify;"><i class="fa fa-check"></i> Para poder realizar una conexión con la Plataforma CRM Global University, necesita el nombre del <b>dominio del CRM Global University</b> y su <b>clave de acceso</b>.</span>

								<br>
								<div style="text-align: center; position: absolute;">

								<img src="assets/images/cargando.gif" style='display: none;'>
							</div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Nombre del dominio:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" id="txtCRM" name="txtCRM" value="<?php if(isset($configuracion[36]["Descripcion"])){ echo $configuracion[36]["Descripcion"]; } ?>">
										<span class="help-block" style="font-size: 13px; color: red;"><b style="color: blue;">Ejemplo:</b> https://nombredominio.com.mx/</span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Clave de acceso:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" id="txtCode" name="txtCode" value="<?php if(isset($configuracion[36]["Texto"])){ echo $configuracion[36]["Texto"]; } ?>">
                  </div>
                </div>
              </div>
              <div class="box-footer">
								<?php if($configuracion[36]["Estatus"] == 'A'){ ?>
									<button type="button" class="btn btn-danger pull-right"><i class="fa fa-fw fa-lock"></i>Conexión aprobada</button>
								<?php } else { ?>
								<button type="button" onclick="validarEnlace()" class="btn btn-info pull-right"><i class="fa fa-fw fa-save"></i>Guardar conexión</button>
								<?php } ?>
              </div>
            </form>
          </div>

						</div>

					</form>
      </div>
    </section>

		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>

		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- API -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="php/api/js/controlador.js"></script>

<!-- AdminLTE App -->

<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
$(function () {

	//Date picker
	$('#datepicker1').datepicker({
		autoclose: true
	})


})
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
