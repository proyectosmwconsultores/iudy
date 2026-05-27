<?php $section = "Configurar coordinador académico"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los coordinadores académicos'); }
$lstCoordinadores=$t->get_lstCoord();

if($_GET["token"]){
		$_POST["txtIdUsua"] = $_GET["token"];
}

if($_POST["txtIdUsua"]){
	$lstOferta=$t->get_lstOferta($_POST["txtCampus"]);
}
?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Lista de coordinadores acad&eacute;micos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Configuraci&oacute;n</a></li>
					<li class="active">Coordinadores acad&eacute;micos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adConfigCoordinador.php" method="POST" enctype="multipart/form-data">
						<div class="col-md-12">
							<div class="form-group">
								<label>Coordinador acad&eacute;mico:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-users"></i>
									</div>
									<select class="form-control" name="txtIdUsua" id="txtIdUsua" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCoordinadores);$i++) { ?>
										<option value="<?php echo $lstCoordinadores[$i]["IdUsua"]; ?>"<?php if($_POST["txtIdUsua"]==$lstCoordinadores[$i]["IdUsua"]){ ?>selected="selected"<?php } ?>><?php echo $lstCoordinadores[$i]["Nombre"].' '.$lstCoordinadores[$i]["APaterno"].' '.$lstCoordinadores[$i]["AMaterno"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de ofertas educativas</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Activar</th>
												<th>Rvoe</th>
												<th>Modalidad</th>
												<th>Tipo</th>
												<th>Nombre de la asignaturas</th>
												<th>Zona</th>
												<th>Campus</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($lstOferta);$i++) {
												$ofertaSelec=$t->get_ofertSelecc($lstOferta[$i]["IdEducativa"],$_POST["txtIdUsua"]);

												 ?>
											<tr>
												<td>
													<?php if($ofertaSelec[0]["IdCoordinador"]){ ?>
													<button onclick="desactivarCoordinador(<?php echo $ofertaSelec[0]["IdCoordinador"]; ?>)" title="Desactivar oferta educativa" type="button" class="btn btn-default"><i class="fa fa-circle" style="color: blue;"></i></button>
												<?php } else { ?>
													<button onclick="activarCoordinador(<?php echo $lstOferta[$i]["IdEducativa"]; ?>)" title="Activar oferta educativa" type="button" class="btn btn-default"><i class="fa fa-circle-thin"></i></button>
												<?php } ?>

												</td>
												<td><?php echo $lstOferta[$i]["Rvoe"]; ?></td>
												<td><?php echo $lstOferta[$i]["Modalidad"]; ?></td>
												<td><?php echo $lstOferta[$i]["Ciclo"]; ?></td>
												<td><?php echo $lstOferta[$i]["Nombre"]; ?></td>
												<td><?php echo $lstOferta[$i]["Zona"]; ?></td>
												<td><?php echo $lstOferta[$i]["Campus"]; ?></td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
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
	function activarCoordinador(IdOferta){
		var IdUsua = document.getElementById("txtIdUsua").value;
		var TipoGuardar = "configCoordinador";
		swal({
			title: "\u00BFEst\u00E1 seguro que desea agregar \u00E9sta oferta educativa a este coordinador acad\u00E9mico?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
		function (isConfirm) {
			if(isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				$.ajax({
						 url:"formConsulta/setting.php",
						 method:"POST",
						 data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdOferta:IdOferta},
						 success:function(data){
							parent.location.href='adConfigCoordinador.php?token='+IdUsua;
						 }
				})
				.error(function(data) {
					swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
				});
			}
		});


	}

	function desactivarCoordinador(IdOferta){
		var IdUsua = document.getElementById("txtIdUsua").value;
		var TipoGuardar = "configCoordinadorDesc";
		swal({
			title: "\u00BFEst\u00E1 seguro que desea quitar \u00E9sta oferta educativa de \u00E9ste coordinador acad\u00E9mico?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
		},
		function (isConfirm) {
			if(isConfirm) {
				$(".confirm").attr('disabled', 'disabled');
				$.ajax({
						 url:"formConsulta/setting.php",
						 method:"POST",
						 data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, IdOferta:IdOferta},
						 success:function(data){
									parent.location.href='adConfigCoordinador.php?token='+IdUsua;
						 }
				})
				.error(function(data) {
					swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
				});
			}
		});


	}





  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
