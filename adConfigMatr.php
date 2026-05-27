<?php $valor = 3; $section = "Lista de usuarios sin matriculas"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado los alumnos sin matriculas'); }
$Usuarios=$t->get_usuariosSinM();

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
if(isset($_POST["Mov"]) && $_POST["Mov"]=="GuardarMat"){
  $espacio->add_matIndividual($_POST["IdUsua"]);
  exit;
}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Configuraci&oacute;n de matr&iacute;culas por alumnos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Usuarios</a></li>
					<li class="active">Lista</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adConfigMatr.php" method="POST" enctype="multipart/form-data">
				<input id="IdUsua" name="IdUsua" value="" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="9" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte alumnos sin matricula" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				<input id="Tipo" name="Tipo" value="Man" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-12">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
                  </div>
	              </div>
	            </div>







	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example" class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>Ajuste</th>
														<th>Matr&iacute;cula</th>
														<th>Nombre</th>
														<th>Teléfono</th>
														<th>Correo</th>
														<th>Oferta educativa</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($Usuarios);$i++) { $Id = $Usuarios[$i]["IdUsua"]; ?>
													<tr>
														<td>

															<button onclick="document.frm.Mov.value='GuardarMat';document.frm.IdUsua.value='<?php echo $Id; ?>';document.frm.submit();" title="Configurar matr&iacute;cula" type="button" class="btn btn-success"><i class="fa fa-gg "></i>Aplicar matr&iacute;cula</button>
														</td>
														<td><?php echo $Usuarios[$i]["Matricula"]; ?></td>
														<td><?php echo $Usuarios[$i]["Nombre"].' '.$Usuarios[$i]["APaterno"].' '.$Usuarios[$i]["AMaterno"]; ?></td>
														<td><?php echo $Usuarios[$i]["Telefono"]; ?></td>
														<td><?php echo $Usuarios[$i]["Correo"]; ?></td>
														<td><?php echo $Usuarios[$i]["NomEducativa"]; ?></td>
													</tr>
													<?php } ?>
												</tfoot>
											</table>
										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>

	    </form>
    </section>

		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>
    <script src="assets/table/js/plugins/dataTables/datatables.min.js"></script>
    <!-- Custom and plugin javascript -->
		<script src="assets/table/js/scriptAgregado1.js"></script>

	  <?php include("footer.php"); ?>
	</div>
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_data', function(){
					var employee_id = $(this).attr("id");

					document.getElementById("IdUsua").value = employee_id;
					if(employee_id != '')
					{
							 $.ajax({
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail').html(data);
												 $('#dataModal').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="0"){
			swal("Error al subir", "No se ha podido subir el archivo al servidor.", "error");
		}
		if(alerta =="1"){
			swal("Guardado correctamente", "Datos guardado correctamente y notificado al usuario.", "success");
		}
		if(alerta =="2"){
			swal("Error al guardar", "No se ha podido actualizar el registro.", "success");
		}
		if(alerta =="6"){
			swal("Error al guardar", "No se ha podido generar la matricula.", "error");
		}
		if(alerta =="5"){
			swal("Guardado correctamente", "Matricula generada al alumno correctamente.", "success");
		}
	}
});
</script>
<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
