<?php $valor = 1; $section = "Plan de estudio"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los planes de estudio'); }

$oferta=$t->get_OfertaETodos($_SESSION['Permisos'],$_SESSION['IdOferta'],$_SESSION['IdCampus']);
 ?>

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Ofertas educativas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Lista</a></li>
					<li class="active">Licenciaturas</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adAddAlumnoConfig.php" method="POST" enctype="multipart/form-data">
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Actualizar informaci&oacute;n</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Clave</th>
												<th>Tipo</th>
                        <th>Nombre</th>
                        <th>Rvoe</th>
												<th>Vigencia</th>
												<th>Modificar</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($oferta);$i++) { 	$id= $oferta[$i]["IdEducativa"]; $tok = time(); $toks = $tok.$id; ?>
											<tr>
												<td><?php echo $oferta[$i]["Clave"]; ?></td>
												<td><?php echo $oferta[$i]["Tipo"]; ?></td>
                        <td><?php echo $oferta[$i]["Nombre"]; ?></td>
                        <td><?php echo $oferta[$i]["Rvoe"]; ?></td>
												<td><?php echo $oferta[$i]["Vigencia"]; ?></td>
												<td>
													<a onClick="window.open('adUpdOferta.php?IdEducativa=<?php echo $toks; ?>','_self')" href="javascript:void(0);">
														<button title="Editar plan de estudio" type="button" class="btn btn-default"><i class="fa fa-edit"></i></button>
													</a>
												</td>
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
  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
