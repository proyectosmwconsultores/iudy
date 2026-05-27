<?php $valor = 3; $section = "Actualizar datos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por actualizar un usuario'); }
if($_SESSION['Permisos']) {

	if(isset($_POST["Mov"]) && $_POST["Mov"]=="ReEnviar"){
		$t->add_ReenviarPass();
		exit;
	}

$IdUser = substr($_GET["IdUser"], 10, 10);
	$usuariosId=$t->get_usuarioA($IdUser);
}
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">

  <?php include("menuV.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Datos generales del usuario
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Usuario</a></li>
        <li class="active">Informacion</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Datos del usuario</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
		  <form name="frm" id="frm" action="adUpdUsuario.php" method="POST" enctype="multipart/form-data">
		  <input id="TipoGuardar" name="TipoGuardar" value="val_adUpdUsuario" type="hidden"/>
			<input id="IdCampus" name="IdCampus" value="<?php echo $usuariosId[0]["IdCampus"]; ?>" type="hidden"/>
			<input id="IdUsua" name="IdUsua" value="<?php echo $IdUser; ?>" type="hidden"/>
			<input id="Mov" name="Mov" value="" type="hidden"/>

			<div class="col-md-4">
			  <!-- general form elements -->
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Tipo usuario:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user-circle"></i>
						  </div>
						  <select class="form-control" name="txtTipo" id="txtTipo">
								<option value=""> - Seleccione - </option>
								<option value="1" <?php if($usuariosId[0]["Permisos"] == 1){?>selected="selected"<?php }?> > Administrador general</option>
								<option value="5" <?php if($usuariosId[0]["Permisos"] == 5){?>selected="selected"<?php }?> > Supervisor acad&eacute;mico general </option>
								<option value="6" <?php if($usuariosId[0]["Permisos"] == 6){?>selected="selected"<?php }?>> Finanzas </option>
								<option value="7" <?php if($usuariosId[0]["Permisos"] == 7){?>selected="selected"<?php }?>> Servicios Escolares </option>
								<option value="8" <?php if($usuariosId[0]["Permisos"] == 8){?>selected="selected"<?php }?>> Admisiones </option>
								<option value="9" <?php if($usuariosId[0]["Permisos"] == 9){?>selected="selected"<?php }?>> Dirección de Campus </option>
								<option value="2" <?php if($usuariosId[0]["Permisos"] == 2){?>selected="selected"<?php }?>> Docente </option>
								<option value="4" <?php if($usuariosId[0]["Permisos"] == 4){?>selected="selected"<?php }?>> Tutor </option>
								<option value="3" <?php if($usuariosId[0]["Permisos"] == 3){?>selected="selected"<?php }?>> Alumno </option>

						  </select>
						</div>
					</div>
				  </div>
			  </div>
			  <!-- /.box -->
			</div>

            <div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Nombre:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user"></i>
						  </div>
						  <input class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre" type="text" value="<?php echo $usuariosId[0]["Nombre"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="col-md-4">
			  <!-- general form elements -->
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>A. Paterno:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user"></i>
						  </div>
						  <input class="form-control" id="txtAPaterno" name="txtAPaterno" placeholder="Paterno" type="text" value="<?php echo $usuariosId[0]["APaterno"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			  <!-- /.box -->
			</div>
			<div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>A. Materno:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user"></i>
						  </div>
						  <input class="form-control" id="txtAMaterno" name="txtAMaterno" placeholder="Materno" type="text" value="<?php echo $usuariosId[0]["AMaterno"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Sexo:</label>
						<div class="input-group">
						  <div class="input-group-addon"><i class="fa fa-user"></i></div>
							<select class="form-control" name="txtSexo" id="txtSexo">
							<option value=""> - Seleccione - </option>
							<option value="M" <?php if($usuariosId[0]["Sexo"] == "M"){?>selected="selected"<?php }?>> MUJER </option>
							<option value="H" <?php if($usuariosId[0]["Sexo"] == "H"){?>selected="selected"<?php }?>> HOMBRE </option>
						  </select>
						</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="col-md-4">
			  <!-- general form elements -->
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Teléfono:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-phone"></i>
						  </div>
						  <input class="form-control" id="txtTelefono" name="txtTelefono" data-inputmask='"mask": "(999) 999-9999"' data-mask type="text" value="<?php echo $usuariosId[0]["Telefono"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			  <!-- /.box -->
			</div>
			<div class="col-md-4">
			  <!-- general form elements -->
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Correo:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-envelope"></i>
						  </div>
						  <input class="form-control" id="txtCorreo" name="txtCorreo" placeholder="Enter email" type="email" value="<?php echo $usuariosId[0]["Correo"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div>



			<div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Usuario:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-user-secret"></i>
						  </div>
						  <input class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Enter usuario" type="text" value="<?php echo $usuariosId[0]["Usuario"] ?>">
						</div>
					</div>
				  </div>
			  </div>
			</div>
			<div class="col-md-4">
			  <div class="box-primary">
				  <div class="box-body">
					<div class="form-group">
						<label>Contraseña:</label>
						<div class="input-group">
						  <div class="input-group-addon">
							<i class="fa fa-compass"></i>
						  </div>
						  <input class="form-control" id="txtPass" name="txtPass" placeholder="Enter pass" type="password">
						</div>
					</div>
				  </div>
			  </div>
			</div>


			<div class="col-md-12">
			    <div class="box-primary">
				    <div class="box-body">
						<div class="box-footer" style=" text-align: center;">
							<button type="button" class="btn btn-danger" onClick="window.open('adSelAllUsuarios.php','_self')" href="javascript:void(0);"><i class="fa fa-fw fa-rotate-left"></i> Regresar </button>
							<button type="button" class="btn btn-success" onClick="val_adUpdUsuario()"><i class="fa fa-fw fa-refresh"></i> Actualizar</button>
							<?php if($usuariosId[0]["Correo"]){ ?>
							<button type="button" class="btn btn-info" onClick="val_reePassword()"><i class="fa fa-fw fa-envelope"></i> Re-enviar contraseña</button>
						<?php } ?>

						</div>
				    </div>
			    </div>
			  <!-- /.box -->
			</div>
			</form>
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
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
//Money Euro
    $('[data-mask]').inputmask()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
