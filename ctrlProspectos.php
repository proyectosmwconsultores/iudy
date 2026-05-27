<?php $section = "Prospectos en proceso"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado los prospectos en proceso'); }
$oferta=$t->get_OfertaETodos();

if($_GET['Id']){
	$_POST['txtOferta'] = $_GET['Id'];
}

if(($_POST['txtIdUsua']) && ($_POST['txtOferta'])){
		$t->get_addVisto($_POST["txtOferta"],$_POST['txtIdUsua']);
}

// $lstProspectos=$t->get_prospectosEduc($_POST["txtOferta"],$_POST["datepicker"],$_POST["datepicker2"]);

$lstProspectos=$t->get_prospectosEduc($_POST["txtOferta"],$configuracion["32"]["Descripcion"]);

if($_POST['txtIdUsua']){
	$estatusDocs=$t->get_estatusDocs($_POST['txtIdUsua']);
	$lstDocs=$t->get_listaDocs($_POST['txtIdUsua']);
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="delProspecto"){
  $espacio->del_prospecto();
  exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="aceptProspecto"){
  $espacio->acept_prospecto();
  exit;
}

if(isset($_POST["Mov"]) && $_POST["Mov"]=="Guardar"){
		$t->add_sendNotificar($_POST["txtIdUsua"]);
		exit;
	}

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Nuevos prospectos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Inicio</a></li>
					<li class="active">Prospectos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="ctrlProspectos.php" method="POST" enctype="multipart/form-data">
					<input id="IdAlumno" name="IdAlumno" value="<?php echo $_POST['txtIdUsua'];?>" type="hidden"/>
					<input id="IdPermiso" name="IdPermiso" value="<?php echo $_SESSION["Permisos"]; ?>" type="hidden"/>
					<input id="IdEncargado" name="IdEncargado" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
					<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
					<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <!-- <div class="col-md-4">
              <div class="box-primary">
                <div class="box-body">
                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
                    <i class="fa fa-rotate-left"></i> Regresar
                  </a>
                </div>
              </div>
            </div> -->
            <div class="col-md-5">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Oferta educativa:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-bank"></i></div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
											<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
											<?php } ?>
										</select>
                  </div>
                </div>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-3">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Fecha inicial:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="<?php echo $_POST["datepicker"] ?>" onchange="document.frm.submit();">
                  </div>
                </div>
                </div>
              </div>
            </div>
						<div class="col-md-3">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Fecha final:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
                    <input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2" value="<?php echo $_POST["datepicker2"] ?>" onchange="document.frm.submit();">
                  </div>
                </div>
                </div>
              </div>
            </div> -->
						<div class="col-md-7">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>Prospectos:</label>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
										<select class="form-control" name="txtIdUsua" id="txtIdUsua" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstProspectos);$i++) { ?>
											<option value="<?php echo $lstProspectos[$i]["IdUsua"]; ?>"<?php if($_POST["txtIdUsua"]==$lstProspectos[$i]["IdUsua"]){?>selected="selected"<?php }?>><?php echo $lstProspectos[$i]["Nombre"].' '.$lstProspectos[$i]["APaterno"].' '.$lstProspectos[$i]["AMaterno"]; if($lstProspectos[$i]["Visto"] == 1) { echo " (Nuevo)"; } ?></option>
											<?php } ?>
										</select>
                  </div>
                </div>
                </div>
              </div>
            </div>

						<div class="form-group" name="imgLoadDoc" id="imgLoadDoc" style="display: none;">
							<div class="col-sm-12" style="text-align: center;">
									<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
							</div>
						</div>
<?php if($_POST["txtIdUsua"]){ ?>
	<div class="col-md-3">
		<div class="box box-primary">
			<img class="profile-user-img img-responsive img-circle" src="assets/perfil/<?php echo $estatusDocs[0]["Foto"]; ?>" alt="User profile picture">
			<h3 class="profile-username text-center"><?php echo $estatusDocs[0]["Nombre"]; ?></h3>
			<p class="text-muted text-center"><?php echo $estatusDocs[0]["APaterno"].' '.$estatusDocs[0]["AMaterno"]; ?></p>
			<div class="box-header with-border">
				<h3 class="box-title">Informaci&oacute;n del prospecto</h3>
			</div>
			<div class="box-body">
				<strong><i class="fa fa-phone margin-r-5"></i> <?php echo $estatusDocs[0]["Telefono"]; ?></strong><br>
				<strong><i class="fa fa-envelope margin-r-5"></i> <?php echo $estatusDocs[0]["Correo"]; ?></strong><br>
				<strong><i class="fa fa-calendar margin-r-5"></i> <?php echo $estatusDocs[0]["FecCap"]; ?></strong>
				<p class="text-muted"></p>
				<br>


				<p>
					<?php if($estatusDocs[0]["Documentos"] == "SI"){?>
						<a class="btn btn-app">
							<span class="badge bg-yellow"></span>
							<i class="fa fa-lock"></i> Cerrado
						</a>
					<?php  } else { ?>
						<a class="btn btn-app" href="javascript:void(0);" onClick="val_aceptProspecto()">
							<span class="badge bg-purple"></span>
							<i class="fa fa-unlock"></i> &nbsp;Aceptar datos del prospecto &nbsp;
						</a><br>
						<!-- <a class="btn btn-app view_tutor" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST['txtIdUsua']; ?>">
							<span class="badge bg-purple"></span>
							<i class="fa fa-unlock"></i> Cerrar
						</a> -->
						<a class="btn btn-app view_notificar" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST['txtIdUsua']; ?>">
							<span class="badge bg-purple"></span>
							<i class="fa fa-bullhorn"></i> Notificar
						</a>
						<a class="btn btn-app coment_data" href="javascript:void(0);" name="view" value="view" id="<?php echo $_POST['txtIdUsua']; ?>">
							<span class="badge bg-purple"></span>
							<i class="fa fa-comments"></i> Seguimiento
						</a>

						<a class="btn btn-app" href="javascript:void(0);" onClick="val_delProspecto()">
							<span class="badge bg-purple"></span>
							<i class="fa fa-trash"></i> Eliminar
						</a>


					<?php }  ?>

        </p>


			</div>
		</div>
	</div>
              <div class="col-md-9">
                <div class="box">
                  <div class="box-body">
                    <div class="box-body no-padding">
                      <div id="txtHint"></div>
                    </div>
                    <div name="tabla1" id="tabla1" style=" display: block;">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Documento</th>
                        <th>Fec. Captura</th>
                        <th>Opci&oacute;n</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($lstDocs);$i++) { ?>

                        <tr>
                          <td><?php echo $lstDocs[$i]["NomDocumento"]; ?></td>
                          <td><?php echo $lstDocs[$i]["FecCap"]; ?></td>

                          <td>
                            <button  type="button" class="btn btn-block btn-success btn-xs view_docs" href="javascript:void(0);" name="view" value="view" id="<?php echo $lstDocs[$i]["IdTipoDocumento"] ?>"><i class="fa fa-gears"></i> Ajuste </button>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>
              </div>
						<?php } ?>
          </div>
        </div>
      </div>

			<div id="dataModalXX" class="modal fade"> <!--MODAL ME GUSTA-->
						<div class="modal-dialog">
								 <div class="modal-content">
											<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
													 <button type="button" class="close" data-dismiss="modal">&times;</button>
													 <h4 class="modal-title">Notificar al prospecto</h4>
											</div>
											<div class="modal-body" id="employee_detail3X">

											</div>
											<div class="modal-body" style="margin-top: -20px;">
												<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none; text-align: center; margin: 0 auto;">
															<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
												</div>
												<div class="box-body">
                <div class="form-group">
                  <label>Comentario:</label>
                  <textarea class="form-control" rows="3" name="txtComentario" id="txtComentario" placeholder="Comentario para el prospecto ..."></textarea>
                </div>



                <!-- checkbox -->
                <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" checked disabled>
                      <b>Nota:</b> se le notificar&aacute; al prospecto v&iacute;a correo electr&oacute;nico de los documentos no aprobados.
                    </label>

                  </div>
									<button type="button" class="btn btn-block btn-danger btn" onClick="val_notificarUserX()" > <i class="fa fa-save"></i> Enviar notificaci&oacute;n</button></td>


            </div>
											</div>
								 </div>
						</div>
			 </div>

    </form>
    </section>


		</div>
	  <?php include("footer.php"); ?>
	</div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
		<input id="IdAlumno" name="IdAlumno" value="0" type="hidden"/>
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Notificar al prospecto</h4>
								 </div>
								 <div class="modal-body" id="employee_detail3">

								 </div>

						</div>
			 </div>
	</div>

	<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
		<input id="IdAlumno" name="IdAlumno" value="0" type="hidden"/>
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Opci&oacute;n para cerrar estatus</h4>
								 </div>
								 <div class="modal-body" id="employee_detail2">

								 </div>
						</div>
			 </div>
	</div>
	<div id="dataModalCx" class="modal fade"> <!--MODAL ME GUSTA-->
				<div class="modal-dialog">
						 <div class="modal-content">
									<div class="modal-body" id="employee_detailCx">
									</div>
						 </div>
				</div>
	 </div>
	<div id="dataModal3" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #056fb1; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Documentos subidos</h4>
								 </div>
								 <div class="modal-body" id="employee_detail3">

								 </div>
						</div>
			 </div>
	</div>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<!-- date-range-picker -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>


<script>

$(document).ready(function(){
		 $(document).on('click', '.coment_data', function(){
					var employee_id = $(this).attr("id");
					var IdEncargado = document.getElementById("IdEncargado").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewNotificar.php",
										method:"POST",
										data:{employee_id:employee_id,IdEncargado:IdEncargado},
										success:function(data){
												 $('#employee_detailCx').html(data);
												 $('#dataModalCx').modal('show');
										}
							 });
					}
		 });
});


$(document).ready(function(){
		 $(document).on('click', '.view_notificar', function(){
					var employee_id = $(this).attr("id");

					//document.getElementById("IdDoc").value = employee_id;
					if(employee_id != '')
					{
							 $.ajax({
								  										url:"formConsulta/closeNotificar.php",
								  										method:"POST",
								 // 										data:{employee_id:employee_id, Oferta:Oferta},

										data:{employee_id:employee_id},
										success:function(data){
												 //$('#employee_detailXX').html(data);
												  $('#employee_detail3X').html(data);
												 $('#dataModalXX').modal('show');
										}
							 });
					}
		 });
});

// $(document).ready(function(){
// 		 $(document).on('click', '.view_notificar', function(){
// 					var employee_id = $(this).attr("id");
// 					document.getElementById("IdAlumno").value = employee_id;
// 				  var Oferta = document.getElementById("txtOferta").value;
// 					if(employee_id != '')
// 					{
// 							 $.ajax({
// 										url:"formConsulta/closeNotificar.php",
// 										method:"POST",
// 										data:{employee_id:employee_id, Oferta:Oferta},
// 										success:function(data){
// 												 $('#employee_detail3').html(data);
// 												 $('#dataModal3').modal('show');
// 										}
// 							 });
// 					}
// 		 });
// });

$(document).ready(function(){
		 $(document).on('click', '.view_tutor', function(){
					var employee_id = $(this).attr("id");
					document.getElementById("IdAlumno").value = employee_id;
				  var Oferta = document.getElementById("txtOferta").value;
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/closeEstatus.php",
										method:"POST",
										data:{employee_id:employee_id, Oferta:Oferta},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
										}
							 });
					}
		 });
});

$(document).ready(function(){
		 $(document).on('click', '.view_docs', function(){
					var employee_id = $(this).attr("id");
					IdUsua = document.getElementById("txtIdUsua").value;
					var valor = 1
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewDocs.php",
										method:"POST",
										data:{employee_id:employee_id, IdUsua:IdUsua, valor:valor},
										success:function(data){
												 $('#employee_detail3').html(data);
												 $('#dataModal3').modal('show');
										}
							 });
					}
		 });
});


  $(function () {
    $('#example1').DataTable()
  })


		    //Date picker
		    $('#datepicker').datepicker({
		      autoclose: true
		    })

				$('#datepicker2').datepicker({
		      autoclose: true
		    })

				$(document).ready(function(){
					var alerta = document.frm.Alerta.value;
					if(alerta){
						if(alerta =="0"){
							swal("Error al subir", "No se ha podido subir el archivo al servidor", "error");
						}
						if(alerta =="1"){
							swal("Notificación enviado correctamente", "La notificación ha sido enviada al prospecto correctamente", "success");
						}
						if(alerta =="3"){
							swal("Error al guardar", "No se ha podido enviar notificacion", "success");
						}
						if(alerta =="4"){
							swal("Guardado correctamente", "Datos del prospecto ha sido guardado correctamente", "success");
						}
						if(alerta =="5"){
							swal("Error al guardar", "No se ha podido guardar los datos del prospecto", "success");
						}
					}
				});


</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
