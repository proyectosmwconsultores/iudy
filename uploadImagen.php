<?php
$section = "Subir imagen"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de subir imagens de libros de consulta y antología'); }
if(isset($_GET["idO"])){ $_POST["txtOferta"] = $_GET["idO"]; }
if(isset($_GET["idT"])){ $_POST["txtTema"] = $_GET["idT"]; }
if(isset($_GET["idM"])){ $_POST["txtModalidad"] = $_GET["idM"]; }

if($_SESSION['Permisos']) {
	if(isset($_POST["Mov"]) && $_POST["Mov"]=="uplDocsMx"){
		$t->add_upDocsMx();
		exit;
	}
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Subir archivos libros de consulta, planeación.
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bars"></i> Documentos</a></li>
        <li class="active">Subir archivos</li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
					  <form name="frm" id="frm" action="uploadImagen.php" method="POST" enctype="multipart/form-data">
							<input id="Mov" name="Mov" value="<?php echo $_GET['Mov']; ?>" type="hidden"/>
						<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
						<div class="col-md-4">
							<div class="box-primary">
								<div class="form-group">
									<label>Tipo oferta:</label>
									<div class="input-group">
										<div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
										</div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<option value="1" <?php if($_POST["txtOferta"]==1){ ?>selected="selected"<?php }?>>Doctorado</option>
											<option value="2" <?php if($_POST["txtOferta"]==2){ ?>selected="selected"<?php }?>>Maestría</option>
											<option value="3" <?php if($_POST["txtOferta"]==3){ ?>selected="selected"<?php }?>>Licenciatura</option>
											<option value="6" <?php if($_POST["txtOferta"]==6){ ?>selected="selected"<?php }?>>Bachillerato</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
						  <div class="box-primary">
								<div class="form-group">
									<label>Tipo documento:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtTema" id="txtTema" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<option value="9" <?php if($_POST["txtTema"]==9){ ?>selected="selected"<?php }?>>Libro de consulta</option>
												<option value="10" <?php if($_POST["txtTema"]==10){ ?>selected="selected"<?php }?>>Planeación</option>
										</select>
									</div>
							  </div>
						  </div>
						</div>
						<?php if($_POST["txtTema"] == 10){ ?>
						<div class="col-md-4">
						  <div class="box-primary">
								<div class="form-group">
									<label>Modalidad:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-qrcode"></i>
									  </div>
										<select class="form-control" name="txtModalidad" id="txtModalidad" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
												<option value="E" <?php if($_POST["txtModalidad"]=="E"){ ?>selected="selected"<?php }?>>Escolar</option>
												<option value="N" <?php if($_POST["txtModalidad"]=="N"){ ?>selected="selected"<?php }?>>No Escolar</option>
										</select>
									</div>
							  </div>
						  </div>
						</div><?php } ?>
					<div class="col-md-8">
					  <div class="box-primary">
							<div class="form-group">
								<label>Buscar archivo:</label>
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-book"></i>
								  </div>
								  <input class="form-control" id="txtArchivo" name="txtArchivo" type="file">
								</div>
						  </div>
					  </div>
					  <!-- /.box -->
					</div>
					<div class="col-md-4">
						<div class="box-primary">
							<div class="box-body">
							<div class="box-footer" style=" text-align: right;">
								<button type="button" class="btn btn-success" onClick="val_uplImgMod()"><i class="fa fa-fw fa-save"></i> Subir archivo </button>
							</div>
							</div>
						</div>
					</div>

					<div class="col-md-12" name="imgLoadDoAlum" id="imgLoadDoAlum" style="display: none;">
					    <div class="box-primary">
						    <div class="box-body">
								<div class="box-footer" style=" text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
								</div>
						    </div>
					    </div>
					</div>

					</form>

          </div>
          <!-- /.row -->
        </div>
				<div class="box-body">
					<ul class="mailbox-attachments clearfix">
						<?php if(($_POST["txtTema"] == 9) || ($_POST["txtTema"] == 10)){



							function listarArchivos( $path ){
				          // Abrimos la carpeta que nos pasan como parámetro
				          $dir = opendir($path);
				          // Leo todos los ficheros de la carpeta
				          while ($elemento = readdir($dir)){
				              // Tratamos los elementos . y .. que tienen todas las carpetas
				              if( $elemento != "." && $elemento != ".."){ $xx = substr($elemento, 0,6); ?>
												<li>
													<div style="cursor: pointer;" class="mailbox-attachment-info view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $elemento; ?>">
														<a class="mailbox-attachment-name"><i class="fa fa-image"></i> <?php echo $elemento;  ?></a>
													</div>
												</li>
				              <? }
				          }
				      }

							if($_POST["txtTema"] == 10){
								$grado = $_POST["txtOferta"];
								$tema = $_POST["txtTema"];
								$moda = $_POST["txtModalidad"];
								if($moda){
										$directorio= "./assets/images/modulo/$grado/$tema/$moda/";
										listarArchivos($directorio);
								}
							} else {
								$grado = $_POST["txtOferta"];
								$tema = $_POST["txtTema"];
								$directorio= "./assets/images/modulo/$grado/$tema/";
					      listarArchivos($directorio);
							}
							 ?>
						<?php } ?>


              </ul>
				</div>
      </div>
    </section>

  </div>

	<div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
       <div class="modal-dialog">
            <div class="modal-content">
                 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Vista previa de la imagen</h4>
                 </div>
                 <div class="modal-body" id="employee_detailGrp">
                 </div>
            </div>
       </div>
  </div>

  <?php include("footer.php"); ?>
</div>



<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_grupo', function(){
					var employee_id = $(this).attr("id");
					var Oferta = document.getElementById("txtOferta").value;
					var Tema = document.getElementById("txtTema").value;
					if(Tema == 10){
							var Modalidad = document.getElementById("txtModalidad").value;
					} else {
						var Modalidad = "";
					}


					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/verImagenMod.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta, Tema:Tema, Modalidad:Modalidad},
										success:function(data){
												 $('#employee_detailGrp').html(data);
												 $('#dataModalGrp').modal('show');
										}
							 });
					}
		 });
});

  $(function () {
    $('#example1').DataTable()
  })
</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php unset($_SESSION['Alerta']); unset($_SESSION['Variable']); ?>
