<?php $section = "Foro";
include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está observando el foro'); }
$IdForo = substr($_GET["Id"], 10, 10);
if($_SESSION['Permisos']) {
	$AsignacionId=$t->get_datosModuloD($_GET["idToks"]);
	$_SESSION['IdOferta'] = $AsignacionId[0]["IdEducativa"];
	$_SESSION['IdAsignacion'] = $_GET["idToks"];
	$ForoAlumnoId=$t->get_datosForoAlumnoId($_GET["idToks"],$IdForo);
	if(($_SESSION['Permisos'] == 3) && ($ForoAlumnoId[0]["IdEstatus"] <> 12)) {
		$addT=$t->get_verificarTarea($_GET["idToks"],$ForoAlumnoId[0]["IdActividadesDocente"],$ForoAlumnoId[0]["IdParcialDocente"],$_SESSION['IdUsua']);
	}
	$_SESSION['EstatusAsig'] = 'A';
 $IdEs = $ForoAlumnoId[0]['IdEstatus'];
?>
<script>
		function recargarTabla(IdForo) {
				if (IdForo == "") {
					document.getElementById("txtHint").innerHTML = "";
					return;
				} else {

					if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else { // code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("getMovSalida").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET","getBlog.php?Tipo=blog&Buscar="+IdForo,true);
					xmlhttp.send();
				}
			}
		</script>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini">
	<div class="wrapper">
	<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
			<section class="content-header">
				<h1><?php echo $AsignacionId[0]["NombreMod"];?></h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i><?php echo substr($AsignacionId[0]["NombreMod"], 0 , 40).' [...]';?></a></li>
					<li class="active">Foro</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<input id="IdForo" name="IdForo" value="<?php echo $IdForo; ?>" type="hidden"/>
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
					<?php
						$IdActividad = $ForoAlumnoId[0]["IdActividadesDocente"];  ?>
						<div class="col-md-12">
							<div class="box box-widget">
								<div class="box-body">
									<h4 class="attachment-heading"><i class="fa fa-fw fa-gg-circle"></i> <?php echo $ForoAlumnoId[0]["NomActividad"]; ?></h4>
									<p><?php echo $ForoAlumnoId[0]["DesActividad"];?></p>
									<p><?php if(isset($ForoAlumnoId[0]["Archivo"])){ ?>
									<dt>Archivo adjunto:</dt>
									<a onClick="window.open('assets/docs/Files/<?php echo $ForoAlumnoId[0]["Archivo"];  ?>','_blank')" href="javascript:void(0);" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Descargar archivo <i class="fa fa-cloud-download"></i></a>
									<?php } ?></p>
									<!-- <div class="table-responsive">
				            <table class="table">
					              <tbody>
					              <tr>
					                <th>Fecha inicial:</th>
													<td><?php echo obtenerFechaEnLetra($ForoAlumnoId[0]["FecIni"]);?></td>
													<th>Fecha final:</th>
													<td><?php echo obtenerFechaEnLetra($ForoAlumnoId[0]["FecFin"]);?></td>
													<td>Puntos:</td>
													<td><?php echo $ForoAlumnoId[0]["Porcentaje"];?></td>
													<th>Parcial <?php echo $ForoAlumnoId[0]["NoParcial"];?> / Semana <?php echo $ForoAlumnoId[0]["NoParcial"];?></th>
					              </tr>
					            </tbody>
										</table>
          				</div> -->

									<?php if($IdEs == 8){ ?>
									<button onclick="cargarReciente()" type="button" class="btn btn-block btn-success btn-sm"><i class="fa fa-fw fa-refresh"></i> Clic para ver comentarios recientes.</button>
								<?php } ?>
									<div id="getMovSalida"></div>
								</div>
							</div>
						</div>
				</div>
			</section>
		</div>
	<?php include("footer.php"); ?>
	</div>
</body>

<div id="dataEva"  class="modal fade">
		<div class="modal-dialog">
				 <div class="modal-content">
							<div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
									 <button type="button" class="close" data-dismiss="modal">&times;</button>
									 <h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Comentarios realizados</h4>
							</div>
							<div class="modal-body" id="employee_eva">
							</div>
				 </div>
		</div>
</div>

<script>

function cargarReciente(){
	var IdForo = document.getElementById("IdForo").value;
	recargarTabla(IdForo);
}
var IdForo = document.getElementById("IdForo").value;
		recargarTabla(IdForo);

		function addComentario(IdComentario){
			document.getElementById(IdComentario).style.display = 'block';
			document.getElementById("btnResp-"+IdComentario).style.display = 'none';
			var IdEnviado = "";
			IdEnviado = "#res-"+IdComentario;
			$('html,body').animate({
                scrollTop: $(IdEnviado).offset().top
            }, 2000);
			 document.getElementById(IdComentario).setAttribute("style", "margin-left: 60px; margin-top: 20px;");
		}

		function addResponder(IdComentario){
			var Respuesta = document.getElementById("txtRespuesta-"+IdComentario).value;
			var IdForo = document.getElementById("IdForo").value;
			var IdUsua = document.getElementById("IdUsua").value;

			if (Respuesta == ""){
				swal("Error al reponder", "Debe escribir su respuesta del comentario", "error");
				document.getElementById("txtRespuesta-"+IdComentario).focus();
				return 0;
			}

			if(IdUsua){
			  $.ajax({
			    type:"POST",
			    url:"formConsulta/addRespuesta.php",
			    data:{IdComentario:IdComentario,IdUsua:IdUsua,IdForo:IdForo,Respuesta:Respuesta},
			    success:function(data){
			    }
			  })
				.done(function(data) {
					if(data==1){
						// swal("Respuesta publicado", "Su respuesta ha sido publicado correctamente.", "success");
						recargarTabla(IdForo)
					}else{
						swal("Error al responder", "No se puede publicar su respuesta.", "error");
					}
				})

			}
		}


		function newRespuesta(IdForo){
			$.ajax({
					 url:"docente/respuestaForo.php",
					 method:"POST",
					 data:{IdForo:IdForo},
					 success:function(data){
								$('#employee_eva').html(data);
								$('#dataEva').modal('show');
					 }
			});
		}


		function mostrarMas1(IdForo){
		  var Boton = "btn1-"+IdForo;
		  document.getElementById(Boton).style.display = 'none';
		  var Capa = "#capa1-"+IdForo;
		  $(Capa).load("mostrarBlog1.php",{IdForo:IdForo}, function(response, status, xhr) {
		      if (status == "error") {
		        var msg = "Error!, algo ha sucedido: ";
		        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
		      }
		    });
		}

		function mostrarMas2(IdForo){

		  var Boton = "btn2-"+IdForo;
		  document.getElementById(Boton).style.display = 'none';
		  var Capa = "#capa2-"+IdForo;
		  $(Capa).load("mostrarBlog2.php",{IdForo:IdForo}, function(response, status, xhr) {
		      if (status == "error") {
		        var msg = "Error!, algo ha sucedido: ";
		        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
		      }
		    });
		}
		function mostrarMas3(IdForo){
		  var Boton = "btn3-"+IdForo;
		  document.getElementById(Boton).style.display = 'none';
		  var Capa = "#capa3-"+IdForo;
		  $(Capa).load("mostrarBlog3.php",{IdForo:IdForo}, function(response, status, xhr) {
		      if (status == "error") {
		        var msg = "Error!, algo ha sucedido: ";
		        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
		      }
		    });
		}

		function mostrarMas4(IdForo){
		  var Boton = "btn4-"+IdForo;
		  document.getElementById(Boton).style.display = 'none';
		  var Capa = "#capa4-"+IdForo;
		  $(Capa).load("mostrarBlog4.php",{IdForo:IdForo}, function(response, status, xhr) {
		      if (status == "error") {
		        var msg = "Error!, algo ha sucedido: ";
		        $(Capa).html(msg + xhr.status + " " + xhr.statusText);
		      }
		    });
		}

		function delMensaje(IdComentario){
			var IdForo = document.getElementById("IdForo").value;

	    swal({
			title: "\u00BFEst\u00E1 seguro que desea eliminar este comentario?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Aceptar',
			cancelButtonText: "Cancelar",
			//closeOnConfirm: false,
			//closeOnCancel: false
		},
	  function (isConfirm) {
			if (isConfirm) {
				var TipoGuardar = "del_comentario";
			  $.ajax({
			       url:"formConsulta/setting.php",
			       method:"POST",
			       data:{TipoGuardar:TipoGuardar, IdComentario:IdComentario},
			       success:function(data){
			        recargarTabla(IdForo)
			       }
			  })
				return true;
			} else {
				return false;
			}
		});
		}

</script>

<!-- <script src="bower_components/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script>
$(function () {

	//bootstrap WYSIHTML5 - text editor
	$('.textarea').wysihtml5()
})
</script> -->
<!-- jQuery 3 -->
<!-- <script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<!-- <script src="bower_components/select2/dist/js/select2.full.min.js"></script> -->

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
<?php
// } else {
// echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
// }
} else {
echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";

} ?>
