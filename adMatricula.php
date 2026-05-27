<?php  $section = "Configurar matricula"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está por configurar matriculas'); }

if(isset($_GET["O"])){ $_POST["txtOferta"] = $_GET["O"]; }
if(isset($_GET["G"])){ $_POST["txtGrupo"] = $_GET["G"]; }


$oferta=$t->get_OfertaETodos();
$grupo=$t->get_lstGrpMatr($_POST["txtOferta"]);
$lstAlumnos=$t->get_lstAlumnsMx($_POST["txtOferta"],$_POST["txtGrupo"]);

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuraci&oacute;n de matr&iacute;culas y/o No. Control
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Control escolar</a></li>
					<li class="active">Kardex de calificaciones</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adMatricula.php" method="POST" enctype="multipart/form-data">
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="TipoGuardar" name="TipoGuardar" value="addMatricula" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="9" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de matrículas por grupo" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-3">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<?php if(($_POST["txtOferta"]) && ($_POST["txtGrupo"])) { ?>
										<a class="btn btn-app" onClick="val_addMatr()" href="javascript:void(0);">
	                    <i class="fa fa-map-signs"></i> Genera matr&iacute;culas
	                  </a><?php } ?>
                  </div>
	              </div>
	            </div>



	            <div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Oferta educativa:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
											<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
												<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){ $Tipo = $oferta[$i]["Tipo"]  ?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
												<?php } ?>
											</select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>
							<?php $tipoOf=$t->get_tipoOftz($Tipo); ?>
							<input id="txtTipo" name="txtTipo" value="<?php echo $tipoOf[0]["Descripcion"]; ?>" type="hidden"/>
							<div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Grupo:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
											<select class="form-control" name="txtGrupo" id="txtGrupo" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($grupo);$i++) { ?>
											<option value="<?php echo $grupo[$i]["IdGrupo"]; ?>"<?php if($_POST["txtGrupo"]==$grupo[$i]["IdGrupo"]){ $noCiclo = $lstAlumnos[$i]["SemCua"];  $ciclo = $lstAlumnos[$i]["Ciclo"]; $IdOferta= $lstAlumnos[$i]["IdOferta"];   ?>selected="selected"<?php }?>><?php echo $grupo[$i]["CveGrupo"].'-'.$grupo[$i]["Grupo"]; ?></option>
											<?php } ?>
										  </select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>

	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Matr&iacute;cula</th>
														<th>Nombre</th>
														<th>A. Paterno</th>
														<th>A. Materno</th>
														<th>Correo</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($lstAlumnos);$i++) { ?>
													<tr>
														<td><?php echo $lstAlumnos[$i]["Matricula"]; ?></td>
														<td><?php echo $lstAlumnos[$i]["Nombre"]; ?></td>
														<td><?php echo $lstAlumnos[$i]["APaterno"]; ?></td>
														<td><?php echo $lstAlumnos[$i]["AMaterno"]; ?></td>
														<td><?php echo $lstAlumnos[$i]["Correo"]; ?></td>
													</tr>
													<?php } ?>
												</tfoot>
											</table>
										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>

	    </form>
    </section>

		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
