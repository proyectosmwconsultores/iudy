<?php $_v = 31; $section = "Mi portal"; include("head.php");
if($_SESSION['IdUsua']) {
		$addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Esta en la pagina principal de mi portal');
		if($_SESSION["Permisos"] == 2) {
		$avis=$espacio->get_chkAvisosDoc($_SESSION['IdCampus']);

		if(!$infoPerfil[0]['Semblanza']){
			header('Location: miEspacio.php?dat=8');
			exit();
		}

	}
?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content">
				<div class="row">

					<div class="col-md-8">
						<?php if(isset($_GET['toks']) && ($_GET['toks'] == 9)){ ?>
						<div class="bg-red-active color-palette" style="padding: 10px; "><span style="color: yellow;"><i class="fa fa-fw fa-warning"></i> Nota: ha ingresado a una página no disponible.</span></div>
						<br><?php } ?>
				<div class="bg-purple-active color-palette" style="padding: 10px;"><span><i class="fa fa-fw fa-bell"></i> Avisos</span></div>
					<div class="nav-tabs-custom" style="height: 295px;">
						<div class="box-body">
              <ul class="products-list product-list-in-box">
								<?php for ($i=0;$i< sizeof($avis);$i++) {
									if($avis[$i]["Tipo"] == "I"){ $imgF = $avis[$i]["Archivo"]; } else { $imgF = "avisos.jpg"; }
									 ?>
                <li class="item" onclick="mostrarAviso(<?php echo $avis[$i]["IdAviso"]; ?>)" style="cursor: pointer;">
                  <div class="product-img">
                    <img src="assets/images/avisos/<?php echo $imgF; ?>" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"><?php echo $avis[$i]["Titulo"]; ?> <span class="label label-warning pull-right"><?php echo substr($avis[$i]["FecCap"], 0,10); ?></span>
                    <span class="product-description"> <?php echo $avis[$i]["Aviso"]; ?> </span>
                  </div>
                </li>
								<?php } ?>
              </ul>
            </div>
			</div>
			<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-purple">
              <div class="widget-user-image">
                <img class="img-circle" src="assets/perfil/<?php echo $_SESSION['Foto']; ?>" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?php echo $_SESSION['NombreUser']; ?></h3>
              <h5 class="widget-user-desc">Docente</h5>
            </div>
						<div class="mailbox-read-message" style="text-align: justify;">
              <?php echo $infoPerfil[0]['Semblanza']; ?>
							<br>
							<button onClick="window.open('miEspacio.php','_self')" href="javascript:void(0);" style="cursor: pointer; " type="button" class="btn btn-success btn-xs"><i class="fa fa-flag"></i> Semblanza</button>
            </div>
          </div>
	        </div>
        <div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <strong><i class="fa fa-fw fa-warning"></i> Tareas recientes sin calificar</strong>
            </div>
						<div class="box-body">
							<p style="text-align: center;" id='p_img'>
								<img src="assets/images/cargando.gif">
							</p>
              <ul class="products-list product-list-in-box" id="panel_tareas">
              </ul>
            </div>
          </div>
					<div class="box box-primary">
            <div class="box-header with-border">
              <strong><i class="fa fa-fw fa-wechat"></i> Comentarios recientes en el foro</strong>
            </div>
						<div class="box-body">
							<p style="text-align: center;" id='f_img'>
								<img src="assets/images/cargando.gif">
							</p>
              <div class="direct-chat-messages" id="panel_foro"> </div>
            </div>
          </div>
        </div>
      </div>
			</section>
		</div>
<div id="dataEva"  class="modal fade">
		 <div class="modal-dialog">
					<div class="modal-content">
							 <div class="modal-header" style="background: #555299 ; color: white; font-size: 16px;">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Datos del aviso</h4>
							 </div>
							 <div class="modal-body" id="employee_eva">
							 </div>
					</div>
		 </div>
</div>
	  <?php include("footer.php"); ?>
	</div>
<!-- ./wrapper -->
<script>
$(document).ready(function(){
	tareasPendientes();
	foro();
});

function tareasPendientes(){
	var div = "panel_tareas";
	$("#panel_tareas").load("docente/tareasRecientes.php",{}, function(response, status, xhr) {
		if (status == "error") { swal("Error al cargar tareas", "No se puede cargar las tareas recientes sin calificar.", "error");
			var msg = "Error!, algo ha sucedido: no se puede cargar las tareas recientes.";
			$("#panel_tareas").html(msg + xhr.status + " " + xhr.statusText);
		}
		document.getElementById("p_img").style.display = "none";
	});
}

function foro(){
	var div = "panel_foro";
	$("#panel_foro").load("docente/foroRecientes.php",{}, function(response, status, xhr) {
		if (status == "error") { swal("Error al cargar foro", "No se puede cargar los comentarios recientes.", "error");
			var msg = "Error!, algo ha sucedido: no se puede cargar los comentarios recientes.";
			$("#panel_foro").html(msg + xhr.status + " " + xhr.statusText);
		}
		document.getElementById("f_img").style.display = "none";
	});
}
</script>

<script>
	function mostrarAviso(IdAviso){
		$.ajax({
				 url:"formConsulta/viewAviso.php",
				 method:"POST",
				 data:{IdAviso:IdAviso},
				 success:function(data){
							$('#employee_eva').html(data);
							$('#dataEva').modal('show');
				 }
		});
	}
</script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script><!-- Sparkline -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php } else {
	echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
