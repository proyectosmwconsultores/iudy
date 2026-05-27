<?php $valor = 3; $section = "Nueva foto de perfil"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de calendario de materias asignadas.'); }

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-user"></i> Nuevas fotos de perfil para validar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Foto de perfil</a></li>
					<li class="active">Validar</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
          <div class="box-body">
					<div class="row">
						<form name="frm" id="frm" action="fotos_perfil.php" method="POST" enctype="multipart/form-data">
							<div class="col-xs-12">
								<div class="box" id="panel_lista_perfil"></div>
							</div>

						</form>
					</div>
				</div>
					</div>
			</section>
		</div>

		<div id="dataProm" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
										<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title"><i class="fa fa-cog"></i> Veriicar foto de perfil</h4>
										</div>
									 <div class="modal-body" id="employee_prom">
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
		cargar_calendario();
		$('.select2').select2()

	})

	function cargar_calendario(){
		document.getElementById("panel_lista_perfil").style.display = 'none';

		var Capa = "#panel_lista_perfil";
		$(Capa).load("dashboard/lts_fotos_perfil.php",{}, function(response, status, xhr) {
			if (status == "error") {
				var msg = "Error!, no se ha podido cargar la lista, favor de presionar la tecla F5.";
				$(Capa).html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		document.getElementById("panel_lista_perfil").style.display = 'block';
	}

	function ver_foto_perfil(IdUsua){
		$.ajax({
				 url:"formConsulta/viewPerfil.php",
				 method:"POST",
				 data:{IdUsua:IdUsua},
				 success:function(data){
							$('#employee_prom').html(data);
							$('#dataProm').modal('show');
				 }
		});
	}

	function val_img_p(IdUsua, Valor){
		var TipoGuardar = "upd_foto_perfil";
    swal({
      title: "\u00BFEst\u00E1 seguro que desea realizar este movimiento?",
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
             data:{TipoGuardar:TipoGuardar, IdUsua:IdUsua, Valor:Valor},
             success:function(data){

             }
        })
        .done(function(data) {

          if(data==1){
            swal("Guardado correctamente", "Proceso ejecutado correctamente.", "success");
						$('#dataProm').modal('hide');
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
