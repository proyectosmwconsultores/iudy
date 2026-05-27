<?php $section = "Curso"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por seleccionar usuarios para el curso.'); }
if(isset($_GET["IdCurso"])){
	$_SESSION["IdCurso"] = $_GET["IdCurso"];
}
	$campusId=$t->get_campusId();
	if(isset($_POST["txtTipo"]) && (isset($_POST["txtCampus"]))){
			$usuariosLst=$t->get_usersLst($_POST["txtTipo"],$_POST["txtCampus"]);
	}
	$campusId=$t->get_campusId();

	$IdAsignacion=$t->get_idAsig($_SESSION["IdCurso"]);
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de usuarios
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Usuarios</a></li>
					<li class="active">configurar curso</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adCursoGrupo.php" method="POST" enctype="multipart/form-data">
						<input id="IdCampus" name="IdCampus" value="<?php echo $_SESSION["IdCampus"]; ?>" type="hidden"/>
						<input id="IdModulo" name="IdModulo" value="<?php echo $_GET["IdModulo"]; ?>" type="hidden"/>
						<input id="IdAsignacion" name="IdAsignacion" value="<?php echo $IdAsignacion[0]["IdAsignacion"]; ?>" type="hidden"/>
						<input id="IdEducativa" name="IdEducativa" value="<?php echo $IdAsignacion[0]["IdEducativa"]; ?>" type="hidden"/>
						<input id="Modulo" name="Modulo" value="<?php echo $IdAsignacion[0]["IdModulo"]; ?>" type="hidden"/>
						<?php if($IdAsignacion[0]["IdEstatus"] == 12){ ?>
						<div class="col-md-5">
							<div class="form-group">
								<label>Tipo de usuario: </label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user-circle"></i>
									</div>
									<select class="form-control" name="txtTipo" id="txtTipo">
										<option value=""> - Seleccione - </option>
										<option value="1" <?php if($_POST["txtTipo"] == 1){?>selected="selected"<?php }?> > Administrador general</option>
										<option value="5" <?php if($_POST["txtTipo"] == 5){?>selected="selected"<?php }?> > Supervisor acad&eacute;mico general </option>
										<option value="6" <?php if($_POST["txtTipo"] == 6){?>selected="selected"<?php }?> > Supervisor acad&eacute;mico de zona </option>
										<option value="7" <?php if($_POST["txtTipo"] == 7){?>selected="selected"<?php }?> > Supervisor acad&eacute;mico de campus </option>
										<!-- <option value="8" <?php if($_POST["txtTipo"] == 8){?>selected="selected"<?php }?>> Supervisor acad&eacute;mico online </option> -->
										<option value="9" <?php if($_POST["txtTipo"] == 9){?>selected="selected"<?php }?>> Coordinador acad&eacute;mico </option>
										<option value="10" <?php if($_POST["txtTipo"] == 10){?>selected="selected"<?php }?>> Control interno </option>
										<option value="11" <?php if($_POST["txtTipo"] == 11){?>selected="selected"<?php }?>> Corporativo </option>
										<option value="12" <?php if($_POST["txtTipo"] == 12){?>selected="selected"<?php }?>> Colaborador </option>
										<option value="2" <?php if($_POST["txtTipo"] == 2){?>selected="selected"<?php }?>> Asesor acad&eacute;mico </option>
										<option value="4" <?php if($_POST["txtTipo"] == 4){?>selected="selected"<?php }?>> Tutor </option>
										<option value="3" <?php if($_POST["txtTipo"] == 3){?>selected="selected"<?php }?>> Alumno </option>
									</select>
								</div>
							</div>
						</div>


						<div class="col-md-5">
							<div class="form-group">
								<label>Campus:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtCampus" id="txtCampus">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
										<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>:.</label>
								<div class="input-group">
									<button type="button" class="btn btn-primary" onclick="document.frm.IdModulo.value='ReEnviar';document.frm.submit();">Buscar</button>
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de usuarios</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Ajuste</th>
												<th>Nombre</th>
												<th>Tel&eacute;fono</th>
												<th>Correo</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($usuariosLst);$i++) {
											//	$id= $moduloId[$i]["IdModulo"]; $tok = time(); $toks = $tok.$id;
											$exist=$t->get_userAgregado($usuariosLst[$i]["IdUsua"],$IdAsignacion[0]["IdModulo"],$IdAsignacion[0]["IdAsignacion"]);
												?>
											<tr>
												<td>
													<?php if($exist[0]["IdUsua"]){ ?>
														<button id="btndel1-<?php echo $usuariosLst[$i]["IdUsua"]; ?>" onclick="delCurso(<?php echo $usuariosLst[$i]["IdUsua"]; ?>)" title="Editar datos" type="button" class="btn btn-default"><i class="fa fa-check-circle"></i></button>
														<button style="display: none;" id="btnadd1-<?php echo $usuariosLst[$i]["IdUsua"]; ?>" onclick="addCurso(<?php echo $usuariosLst[$i]["IdUsua"]; ?>)" title="Editar datos" type="button" class="btn btn-default"><i class="fa fa-times-circle"></i></button>
													<?php } else { ?>
														<button id="btnadd1-<?php echo $usuariosLst[$i]["IdUsua"]; ?>" onclick="addCurso(<?php echo $usuariosLst[$i]["IdUsua"]; ?>)" title="Editar datos" type="button" class="btn btn-default"><i class="fa fa-times-circle"></i></button>
														<button style="display: none;" id="btndel1-<?php echo $usuariosLst[$i]["IdUsua"]; ?>" onclick="delCurso(<?php echo $usuariosLst[$i]["IdUsua"]; ?>)" title="Editar datos" type="button" class="btn btn-default"><i class="fa fa-check-circle"></i></button>
													<?php } ?>
												</td>
												<td><?php echo $usuariosLst[$i]["Nombre"].' '.$usuariosLst[$i]["APaterno"].' '.$usuariosLst[$i]["AMaterno"]; ?></td>
												<td><?php echo $usuariosLst[$i]["Telefono"]; ?></td>
												<td><?php echo $usuariosLst[$i]["Correo"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					<?php } else {
						$usuariosC=$t->get_usersLstC($_SESSION["IdCurso"],$IdAsignacion[0]["IdAsignacion"]);
						?>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de usuarios activos en el curso</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Tipo usuario</th>
												<th>Campus</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($usuariosC);$i++) {
												?>
											<tr>
												<td><?php echo $usuariosC[$i]["Nombre"].' '.$usuariosC[$i]["APaterno"].' '.$usuariosC[$i]["AMaterno"]; ?></td>
												<td><?php echo $usuariosC[$i]["Cargo"]; ?></td>
												<td><?php echo $usuariosC[$i]["Campus"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					<?php } ?>

					</form>
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
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
