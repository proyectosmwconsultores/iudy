<?php $valor = 3; $section = "Generar matriculas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de generar matrículas.'); }

$campusId=$t->get_campusPermiso($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-qrcode"></i> Módulo para generar Matrículas / No. Control
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Generar</a></li>
					<li class="active">Matrículas / No.Control</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="ad_generar_matricula.php.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-4">
								<div class="box-primary">
									<div class="form-group">
										<label>Campus:</label>
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-bank"></i>
											</div>
											<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="cargar_grupo(<?php echo $_SESSION['IdUsua']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
												<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-8">
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
											<button onclick="cargar_lista_mat()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i>Buscar</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div class="box" id="panel_alumnos_matricula"></div>
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

	function cargar_grupo(IdUsua){
		var IdCampus = document.getElementById("txtCampus").value;
		var Tipo = "get_lst_grupos_id_campus";
		$.post("php/clases/getConsulta.php", { Tipo:Tipo, IdCampus:IdCampus, IdUsua:IdUsua }, function(data){
			$("#txtClaveGrp").html(data);
		});
	}

	function cargar_lista_mat(){

		document.getElementById("panel_alumnos_matricula").style.display = 'none';
		document.getElementById("btn_img").style.display = "block";


		var IdCampus = document.getElementById("txtCampus").value;
		var IdGrupo = document.getElementById("txtClaveGrp").value;


		if(!IdCampus){
			swal("Error al buscar", "No ha seleccionado el Campus.", "error");
			document.getElementById("btn_img").style.display = "none";
			return 0;
		}
		if(!IdGrupo){
			swal("Error al buscar", "No ha seleccionado el grupo.", "error");
			document.getElementById("btn_img").style.display = "none";
			return 0;
		}


		var Capa = "#panel_alumnos_matricula";
		$(Capa).load("dashboard/generar_matriculas_alumnos.php",{IdCampus:IdCampus, IdGrupo:IdGrupo }, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_alumnos_matricula").style.display = 'block';
	}

	function genera_matrxx(IdSeriacion,IdGrupo,IdCampus,IdOferta){
		var Consecutivo = document.getElementById("txt_mat").value;

      var TipoGuardar = "gen_beca_grp";
    	swal({
    		title: "\u00BFEst\u00E1 seguro que desea generar las matriculas de este grupo?",
    		type: "warning",
    		showCancelButton: true,
    		confirmButtonColor: '#DD6B55',
    		confirmButtonText: 'Aceptar',
    		cancelButtonText: "Cancelar",
    	},
    	function (isConfirm) {
    		if (isConfirm) {
    			$(".confirm").attr('disabled', 'disabled');
          $.ajax({
               url:"formConsulta/setting.php",
               method:"POST",
               data:{TipoGuardar:TipoGuardar, IdSeriacion:IdSeriacion, IdGrupo:IdGrupo, IdCampus:IdCampus, IdOferta:IdOferta, Consecutivo:Consecutivo},
               success:function(data){

               }
          })
    			.done(function(data) {
            if(data==1){
              swal("Generado correctamente", "Las matrículas del grupo se han generado correctamente, favor de revisar.", "success");
              cargar_lista_mat();
    				}

    				if(data==0){
    					swal("Error al actualizar", "No se puede actualizar, verifique sus datos.", "error");
    				}
    			})
    			.error(function(data) {
    				swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
    			});
    		}

    	});
	}

</script>
</body>
</html>
