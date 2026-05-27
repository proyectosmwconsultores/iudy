<?php $valor = 3; $section = "Registro de escolaridad"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calificaciones finales.'); }
$cicloId=$t->get_all_ciclos();
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-file-text-o"></i> Generar el registro de escolaridad
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Registro de escolaridad</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="registro_escolaridad.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
								<div class="form-group">
									<label>Periodo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_grupo_reg(<?php echo $_SESSION['IdUsua']; ?>)">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($cicloId);$i++) { ?>
											<option value="<?php echo $cicloId[$i]["IdCiclo"]; ?>"><?php echo $cicloId[$i]["Ciclo"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
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
											<button onclick="load_materias_x()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-search"></i> Consultar</button>
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




		<div id="dataModalFir" class="modal fade"> <!--MODAL ME GUSTA-->
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

	function load_materias_x(){
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
		$(Capa).load("dashboard/rep_registro_escolaridad.php",{IdCiclo:IdCiclo, IdGrupo:IdGrupo }, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});

	}

	function cargar_grupo_reg(IdUsua){
		var IdCiclo = document.getElementById("txtCiclo").value;
		var Tipo = "cargar_grupo_reg";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCiclo:IdCiclo, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}

	$(document).ready(function(){
       $(document).on('click', '.view_firma', function(){
            var employee_id = $(this).attr("id");
            if(employee_id != '')
            {
                 $.ajax({
                      url:"formConsulta/addFirmas.php",
                      method:"POST",
                      data:{employee_id:employee_id},
                      success:function(data){
                           $('#employee_detailFir').html(data);
                           $('#dataModalFir').modal('show');
                      }
                 });
            }
       });
  });

</script>
</body>
</html>
