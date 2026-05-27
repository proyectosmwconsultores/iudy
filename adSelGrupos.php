<?php $valor = 3; $section = "Lista de todos los grupos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado cualquier tipo de usuario'); }

$estatus=$t->get_estatusUser();
$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));

$campusId=$t->get_campusId();
$GrupoLst=$t->get_grupoTipo($_POST["txtCampus"]);
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
					Lista de todos los grupos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Lista</a></li>
					<li class="active">Grupos</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adSelGrupos.php" method="POST" enctype="multipart/form-data">
				<input id="IdUsua" name="IdUsua" value="" type="hidden"/>
				<input id="IdAdministrador" name="IdAdministrador" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="4" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de facturas solicitadas" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
				<input id="Tipo" name="Tipo" value="Man" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-8">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
                  </div>
	              </div>
	            </div>
							<div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Campus:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
											<select class="form-control select2" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campusId);$i++) { ?>
												<option value="<?php echo $campusId[$i]["IdCampus"]; ?>"<?php if($_POST["txtCampus"]==$campusId[$i]["IdCampus"]){ ?>selected="selected"<?php }?>><?php echo $campusId[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>



	              <div class="col-md-12">
	                <div class="box">
										<div class="box-body">
										<div class="table-responsive">
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<!-- <th>Ajuste</th> -->
														<th>IdGrupo</th>
														<th>Descripción</th>
														<th>Turno</th>
														<th>Modalidad</th>
														<th>Días</th>
														<th>Oferta</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($GrupoLst);$i++) { $mmod = "<b>NO IDENTIFICADO</b>";  $tturno = "<b>ERROR</b>";
														$turno = $GrupoLst[$i]["Turno"];
														$mod = $GrupoLst[$i]["Modalidad"];
														if($turno == "M"){ $tturno = "Matutino"; } elseif($turno == "V"){ $tturno = "Vespertino"; }
														if($mod == "E"){ $mmod = "Escolar"; } elseif($mod == "N"){ $mmod = "No escolarizada"; } elseif($mod == "M") { $mmod = "Mixto"; }
														 ?>
													<tr>
														<!-- <td>
															<a onClick="window.open('adUpdUsuario.php?IdUser=<?php echo time().$Usuarios[$i]["IdUsua"]; ?>','_self')" href="javascript:void(0);">
																<button title="Editar usuario" type="button" class="btn btn-info"><i class="fa fa-edit"></i></button>
															</a>
														</td> -->

														<td><?php echo $GrupoLst[$i]["CveGrupo"]; ?></td>
														<td><?php echo $GrupoLst[$i]["Descripcion"]; ?></td>
														<td><?php echo $tturno; ?></td>
														<td><?php echo $mmod; ?></td>
														<td><?php echo $GrupoLst[$i]["Dias"]; ?></td>
														<td><?php if($GrupoLst[$i]["Nombre"]) { echo $GrupoLst[$i]["Nombre"]; } else { echo $GrupoLst[$i]["Oferta"]; } ?></td>
													</tr>

												<?php  } ?>
												</tfoot>
											</table>
										</div>
										</div>
	                </div>


	              </div>
	          </div>
	        </div>
	      </div>
				<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
							<div class="modal-dialog">
									 <div class="modal-content">
												<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
														 <button type="button" class="close" data-dismiss="modal">&times;</button>
														 <h4 class="modal-title">Configuración de baja de usuario</h4>
												</div>
												<div class="modal-body">
													<div class="form-group" name="imgLoadPagos" id="imgLoadPagos" style="display: none; text-align: center; margin: 0 auto;">
																<img src="assets/images/cargando.gif" style="position: absolute; z-index:99999;">
													</div>


							              <div class="box-body">
							                <div class="form-group">
							                  <label for="exampleInputEmail1">Seleccione tipo de baja</label>
																<select class="form-control" name="txtEstatus" id="txtEstatus">
																	<option value=""> - Seleccione - </option>
																	<?php for ($i=0;$i< sizeof($estatus);$i++) { ?>
																	<option value="<?php echo $estatus[$i]["IdEstatus"]; ?>"<?php if($_POST["txtEstatus"]==$estatus[$i]["IdEstatus"]){?>selected="selected"<?php }?>><?php echo $estatus[$i]["Estatus"]; ?></option>
																	<?php } ?>
																</select>
							                </div>
							                <div class="form-group">
							                  <label for="exampleInputPassword1">Comentario:</label>
							                  <textarea class="form-control" rows="3" name="txtComentario" id="txtComentario" placeholder="Escriba un mensaje al usuario ..."></textarea>
							                </div>

							                <div class="checkbox">
							                  <label>
							                    <input type="checkbox" checked disabled> <b>Nota:</b> al dar clic guardar configuraci&oacute;n, autom&aacute;ticamente se le notificar&aacute; al usuario via correo electr&oacute;nico sobre su respectiva baja.
							                  </label>
							                </div>
							              </div>
							              <div class="box-footer">
							                <button type="button" class="btn btn-block btn-info btn" onClick="val_bajaUsuario()" > <i class="fa fa-save"></i> Guardar configuraci&oacute;n</button></td>
							              </div>

												</div>
									 </div>
							</div>
				 </div>
	    </form>
    </section>

		</div>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
	  <!-- Bootstrap 3.3.7 -->
	  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	  <!-- Select2 -->
	  <script src="bower_components/select2/dist/js/select2.full.min.js"></script>

	  <!-- InputMask -->
	  <script src="bower_components/plugins/input-mask/jquery.inputmask.js"></script>
	  <script src="bower_components/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	  <script src="bower_components/plugins/input-mask/jquery.inputmask.extensions.js"></script>
	  <!-- date-range-picker -->
	  <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
	  <!-- bootstrap datepicker -->
	  <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	  <!-- bootstrap color picker -->
	  <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
	  <!-- bootstrap time picker-->
	  <script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
	  <!-- SlimScroll
	  <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	  <!-- iCheck 1.0.1
	  <script src="bower_components/plugins/iCheck/icheck.min.js"></script>
	  <!-- FastClick
	  <script src="bower_components/fastclick/lib/fastclick.js"></script>
	  <!-- AdminLTE App -->
	  <script src="dist/js/adminlte.min.js"></script>
	  <!-- AdminLTE for demo purposes -->
	  <script src="dist/js/demo.js"></script>

	 <!-- DataTables -->
	 <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	 <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	  <?php include("footer.php"); ?>
	</div>
<script>

    $(function () {
  		$('.select2').select2()

    })
		$(function () {
			$('#example1').DataTable()
		})


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
			swal("Error al subir", "No se ha podido subir el archivo al servidor", "error");
		}
		if(alerta =="1"){
			swal("Guardado correctamente", "Datos guardado correctamente y notificado al usuario.", "success");
		}
		if(alerta =="2"){
			swal("Error al guardar", "No se ha podido actualizar el registro", "success");
		}
	}
});
</script>
<!-- jQuery 3 -->

</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
