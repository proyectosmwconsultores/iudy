<?php $valor = 3; $section = "Calendario de suspensión"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calendario de suspensión.'); }

$anio=$t->get_anios();

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-calendar"></i> Calendario de suspensión de clases
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Calendario</a></li>
					<li class="active">Suspensión de clases</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="ad_rep_trayectoria_cal.php" method="POST" enctype="multipart/form-data">
							<div class="col-md-6">
								<div class="box-primary">
									<a class="btn btn-app" href="javascript:void(0);" onclick="add_dia_sus()" title="Crear un nuevo plan de concepto de pago">
	                    <i class="fa fa-calendar"></i> Día de suspensión
	                  </a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Año:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-fw fa-key"></i>
										</div>
										<select class="form-control select2" name="txtAnio" id="txtAnio">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($anio);$i++) { ?>
											<option value="<?php echo $anio[$i]["IdAnio"]; ?>"><?php echo $anio[$i]["Anio"]; ?></option>
											<?php } ?>
										</select>
										<span class="input-group-btn">
											<button onclick="cargar_calendario()" type="button" class="btn btn-info btn-flat"> <i class="fa fa-fw fa-search"></i>Buscar</button>
										</span>
									</div>
								</div>
							</div>

							<div class="col-xs-12">
								<div class="col-xs-12" style="position: absolute; z-index:0; text-align: center; display: none;" id="btn_img">
									<img src="assets/images/procesando.gif">
								</div>
								<div class="box" id="panel_lista_calendario"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>
		<div id="dataModal_4" class="modal fade bs-example-modal-lg">
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configurar día de suspensión</h4>
									 </div>
									 <div class="modal-body" id="employee_detail_4">

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

	function cargar_calendario(){

		var Anio = document.getElementById("txtAnio").value;

		if(Anio == ''){
			swal("Error al buscar", "No ha seleccionado el año.", "error");
			return 0;
		}

		document.getElementById("panel_lista_calendario").style.display = 'none';

		var Capa = "#panel_lista_calendario";
		$(Capa).load("dashboard/calendario_dias_suspension.php",{Anio:Anio}, function(response, status, xhr) {
			if (status == "error") { alert(status);
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_lista_calendario").style.display = 'block';
	}

	function add_dia_sus(){
		$.ajax({
				 url:"formConsulta/configurar_suspension.php",
				 method:"POST",
				 data:{},
				 success:function(data){
							$('#employee_detail_4').html(data);
							$('#dataModal_4').modal('show');
				 }
		});
	}

	function del_dia_s(IdSuspension){
		var TipoGuardar = "del_mot_suspx";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea eliminar este día de suspensión?",
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
             data:{TipoGuardar:TipoGuardar, IdSuspension:IdSuspension},
             success:function(data){

             }
        })
        .done(function(data) {
          if(data==1){
            swal("Eliminado correctamente", "El día de suspensión se ha eliminado correctamente.", "success");
						cargar_calendario();
  				}

  			})
        .error(function(data) {
  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
  			});

      }
    });
	}

</script>
</body>
</html>
