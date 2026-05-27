<?php $section = "Calificaciones"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calificaciones.'); }



$oferta=$t->get_OfertaETodos($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
$asignatura=$t->get_asignatyraU($_POST["txtOferta"],$_POST["txtGrupo"]);
$grupo=$t->get_gtiposraU($_POST["txtOferta"],$_POST["txtModulo"]);
$lstAlumnosCal=$t->get_alumnosCalLst($_POST["txtOferta"],$_POST["txtModulo"],$_POST["txtGrupo"]);


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<form name="frm" id="frm" action="addCalificaciones.php" method="POST" enctype="multipart/form-data">
		<input id="TipoGuardar" name="TipoGuardar" value="asigGrupo" type="hidden"/>
		<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
		<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
		<input id="Alerta" name="Alerta" value="<?php echo $lstAlumnos[0]["Oferta"];?>" type="hidden"/>

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1> Lista de calificaciones</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Lista</a></li>
					<li class="active">Calificaciones</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
            <div class="col-md-4">
							<div class="form-group">
								<label>Oferta:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-book"></i>
									</div>
                  <select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ $scc = $oferta[$i]["Ciclo"]; ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Clave"].' - '.$oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Grupo:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									</div>
                  <select class="form-control" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($grupo);$i++) { ?>
										<option value="<?php echo $grupo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"]==$grupo[$i]["IdGrupo"]){  ?>selected="selected"<?php }?>><?php echo $grupo[$i]["CveGrupo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-4">
							<div class="form-group">
								<label>Asignatura:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									</div>
                  <select class="form-control" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($asignatura);$i++) { ?>
										<option value="<?php echo $asignatura[$i]["IdModulo"]; ?>"<?php if($_POST["txtModulo"]==$asignatura[$i]["IdModulo"]){  ?>selected="selected"<?php }?>><?php echo $asignatura[$i]["CodeModulo"].' - '.$asignatura[$i]["NombreMod"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>





						<div class="col-xs-12">

							<div class="box">
								<div class="box-header">

									<h3 class="box-title">Lista de calificaciones de los alumnos</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<!-- <th>Grupo</th> -->
												<th>Usuario</th>
												<th>Nombre</th>
												<th>Parcial 1</th>
												<th>Parcial 2</th>
												<th>Parcial 3</th>
												<th>Parcial 4</th>
                        <th>Extra 1</th>
												<th>Extra 2</th>
											</tr>
										</thead>
										<tbody id="tbtabl59">
											<?php for ($i=0;$i< sizeof($lstAlumnosCal);$i++) {

												 ?>
											<tr <?php echo $txtT; ?>>
                        <td><?php echo $lstAlumnosCal[$i]["Usuario"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["APaterno"].' '.$lstAlumnosCal[$i]["AMaterno"].' '.$lstAlumnosCal[$i]["Nombre"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["P1"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["P2"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["P3"]; ?></td>
												<td><?php echo $lstAlumnosCal[$i]["P4"]; ?></td>
                        <td><?php echo $lstAlumnosCal[$i]["Ex1"]; ?></td>
                        <td><?php echo $lstAlumnosCal[$i]["Ex2"]; ?></td>

											</tr>
										<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>

				</div>
			</section>
		</div>
	  <?php include("footer.php"); ?>
	</div>



	</form>
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
$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="2"){
			swal("Error al subir", "Ha ocurrido un error, no se puede subir el archivo", "error");
		}
		if(alerta =="1"){
			swal("Guardado", "Registros del grupo guardado correctamente", "success");
		}
		if(alerta =="0"){
			swal("Error al guardar", "No se ha podido guardar los registros", "error");
		}
		if(alerta =="3"){
			swal("Eliminado correctamente", "La lista de usuarios se a eliminado correctamente", "success");
		}
		if(alerta =="8"){
			swal("Grupo cerrado", "El grupo se ha cerrado correctamente son sus nuevos alumnos", "success");
		}
	}
});


  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>

<?php unset($_SESSION['Alerta']);  ?>
