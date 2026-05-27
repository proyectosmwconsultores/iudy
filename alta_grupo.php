<?php $valor = 3;
$section = "Creación de grupo";
include("head.php");
if ($_SESSION['IdUsua']) {
	$addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en el módulo de creacion de grupo.');
}
$cicloId = $t->get_all_ciclos_tipo();
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-cog"></i> Crear claves de grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Grupo</a></li>
					<li class="active">Claves</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<form name="frm" id="frm" action="alta_grupo.php" method="POST" enctype="multipart/form-data">
								<div class="col-xs-12">
									<div id="mi_lista_materias"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>




		<div id="dataModalFir" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-users"></i> Configuraci&oacute;n de firmantes</h4>
					</div>
					<div class="modal-body" id="employee_detailFir">
					</div>
				</div>
			</div>
		</div>

		<div id="data_promxi" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-cog"></i> Configurar beca del alumno</h4>
					</div>
					<div class="modal-body" id="employee_promxi">
					</div>
				</div>
			</div>
		</div>

		<div id="dataModalGrp" class="modal fade">
			<!--MODAL ME GUSTA-->
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de grupo</h4>
					</div>
					<div class="modal-body" id="employee_detailGrp">
					</div>
				</div>
			</div>
		</div>
		<div id="dataDocsx" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Crear clave de grupo</h4>
					</div>

					<div class="modal-body" id="employee_docsx">
					</div>
				</div>
			</div>
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
		$(function() {
			var Tipo = 'X';
			var IdCiclo = 0;
			cargar_grupo_reg(Tipo, IdCiclo);
			$('.select2').select2()

		})

		function crear_grupo(IdCiclo) {
			IdCampus = 0;
			IdOferta = 0;
			$.ajax({
				url: "vistas/escolar/crea_grupo.php",
				method: "POST",
				data: {
					IdCampus: IdCampus,
					IdOferta: IdOferta,
					IdCiclo: IdCiclo
				},
				success: function(data) {
					$('#employee_docsx').html(data);
					$('#dataDocsx').modal('show');
				}
			});
		}

		function cargar_grupo_reg(Tipo, IdCiclo) {
			document.getElementById("mi_lista_materias").style.display = 'none';
			document.getElementById("mi_lista_materias").style.display = 'block';
			var Capa = "#mi_lista_materias";
			$(Capa).load("vistas/escolar/rep_clave_grupo.php", {
				IdCiclo: IdCiclo, Tipo:Tipo
			}, function(response, status, xhr) {
				if (status == "error") { //alert(status);
					var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
					$(Capa).html(msg + xhr.status + " " + xhr.statusText);
				}
			});

		}

		function sel_tipo_perxy(Tipo){
			var IdCiclo = 0;
			cargar_grupo_reg(Tipo, IdCiclo);
		}

		function cargar_periodo_escolar(Tipo){
			var IdCiclo = document.getElementById("txtCiclo").value;
			cargar_grupo_reg(Tipo, IdCiclo);
		}


		function modificar_beca(IdUsua, IdCiclo) {
			$.ajax({
				url: "formConsulta/configurar_beca_alumno.php",
				method: "POST",
				data: {
					IdCiclo: IdCiclo,
					IdUsua: IdUsua
				},
				success: function(data) {
					$('#employee_promxi').html(data);
					$('#data_promxi').modal('show');
				}
			});

		}

		function mostra_datos_grp(employee_id) {
			$.ajax({
				url: "vistas/escolar/actualizar_grupo.php",
				method: "POST",
				data: {
					employee_id: employee_id
				},
				success: function(data) {
					$('#employee_detailGrp').html(data);
					$('#dataModalGrp').modal('show');
				}
			});
		}
	</script>
</body>

</html>