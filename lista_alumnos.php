<?php $valor = 3; $section = "Alumnos por grupos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de lista de alumnos por grupo.'); }
$cicloId=$t->get_all_ciclos_actual();
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file-text-o"></i> Lista de alumnos por grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="lista_alumnos.php" method="POST" enctype="multipart/form-data">
							<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
							<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
							<input id="Numero" name="Numero" value="1" type="hidden"/>
							<div class="col-md-5">
								<div class="form-group">
									<label>Periodo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_grupo_reg(<?php echo $_SESSION['IdUsua']; ?>)">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($cicloId);$i++) { ?>
											<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Tipo"]; ?> * <?php echo $cicloId[$i]["Ciclo"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp"> 
											<option value=""> - Seleccione - </option>
										</select>
										<span class="input-group-btn">
											<button onclick="load_user_lista()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
										</span>
									</div>
								</div>
							</div>

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
		$('.select2').select2()

	})

	function load_user_lista(){
		var IdGrupo = document.getElementById("txtClaveGrp").value;
		var IdCiclo = document.getElementById("txtCiclo").value;
		document.getElementById("mi_lista_materias").style.display = 'none';

		if(!IdCiclo){
			swal("Error al buscar", "Debe seleccionar el Periodo Escolar.", "error");
			return 0;
		}
		if(!IdGrupo){
			swal("Error al buscar", "Debe seleccionar el Grupo.", "error");
			return 0;
		}
		document.getElementById("mi_lista_materias").style.display = 'block';
		var Capa = "#mi_lista_materias";
		$(Capa).load("dashboard/lista_alumnos_all.php",{IdCiclo:IdCiclo, IdGrupo:IdGrupo }, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}

	function cargar_grupo_reg(IdUsua){
		var IdCiclo = document.getElementById("txtCiclo").value;
		var Tipo = "grpos_materias_asignadas";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCiclo:IdCiclo, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}


	function modificar_beca(IdUsua, IdCiclo){
		$.ajax({
				 url:"formConsulta/configurar_beca_alumno.php",
				 method:"POST",
				 data:{IdCiclo:IdCiclo,IdUsua:IdUsua},
				 success:function(data){
							$('#employee_promxi').html(data);
							$('#data_promxi').modal('show');
				 }
		});

	}

	function configurar_Docs(IdUsua){
	  $.ajax({
	       url:"formConsulta/configurarDocs.php",
	       method:"POST",
	       data:{IdUsua:IdUsua},
	       success:function(data){
	            $('#employee_detailModFue').html(data);
	            $('#dataModalModFue').modal('show');
	       }
	  });
	}


</script>
</body>
</html>
