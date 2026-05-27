<?php $valor = 3; $section = "Captura de alumnos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de captura de alumnos.'); }

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file-text-o"></i> Captura de alumno
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Captura</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="lista_alumnos.php" method="POST" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div class="box" id="mi_lista_materias"></div>
							</div>
						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<!-- jQuery 3 -->
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->

<script>
	$(function () {
		var IdCampus = 0;
		var IdCiclo = 0;
		var Tipo = 'X';
		load_user_lista(IdCampus, IdCiclo, Tipo);
	})

	function load_user_lista(IdCampus, IdCiclo, Tipo){
		document.getElementById("mi_lista_materias").style.display = 'block';
		var Capa = "#mi_lista_materias";
		$(Capa).load("vistas/escolar/captura_nuevo_alumno.php",{ IdCampus:IdCampus, IdCiclo:IdCiclo, Tipo:Tipo }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
	}

	function sel_tipo(){
		var IdCampus = 0;
		var IdCiclo = 0;
		var Tipo = document.getElementById("txt_tipo").value;
		load_user_lista(IdCampus,IdCiclo, Tipo);
	}

	function sel_campus(IdCiclo, Tipo){
		var IdCampus = document.getElementById("txt_campus").value;
		load_user_lista(IdCampus,IdCiclo, Tipo);
	}

	function sel_ciclo(IdCampus, Tipo){
		var IdCiclo = document.getElementById("txt_ciclo").value;
		load_user_lista(IdCampus,IdCiclo, Tipo);
	}

</script>
</body>
</html>
