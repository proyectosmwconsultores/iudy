<?php $section = "Generar pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de generar pagos'); }
if(isset($_POST["txt_camps"])){ $_POST["txt_camps"]= $_POST["txt_camps"]; } else { $_POST["txt_camps"] = ''; }
if(isset($_POST["txtOferta"])){ $_POST["txtOferta"]= $_POST["txtOferta"]; } else { $_POST["txtOferta"] = ''; }
if(isset($_POST["txtCicloEscolar"])){ $_POST["txtCicloEscolar"]= $_POST["txtCicloEscolar"]; } else { $_POST["txtCicloEscolar"] = ''; }
if(isset($_POST["txtConcepto"])){ $_POST["txtConcepto"]= $_POST["txtConcepto"]; } else { $_POST["txtConcepto"] = ''; }
$campus=$t->get_campusPermiso($_SESSION['IdUsua']);
$lstConceptos=$t->get_conceptosPlan($_POST["txtOferta"],$_POST["txt_camps"]);
$lstCiclo=$t->get_cEscolarLst();
$calen=$t->get_calendarioPag($_POST["txtOferta"],$_POST["txtCicloEscolar"],$_POST["txtConcepto"]);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Generar pagos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Generar</a></li>
					<li class="active">Pagos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="adGenerarPagos.php" method="POST" enctype="multipart/form-data">
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php if(isset($bytesCodificados)){ echo $bytesCodificados; } ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="16" type="hidden"/>

	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<!-- <div class="col-md-2">
								<div class="form-group">
									<a class="btn btn-app" onclick="generarPag()" href="javascript:void(0);">
	                    <i class="fa fa-file"></i> Crear pago
	                  </a>
								</div>
							</div> -->
							<div class="col-md-6">
								<div class="form-group">
									<label>Escuela / campus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txt_camps" id="txt_camps" onchange="document.frm.submit();">
											<option value="">- Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
											<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if(isset($_POST["txt_camps"])){ if($_POST["txt_camps"]==$campus[$i]["IdCampus"]){ ?>selected="selected"<?php }} ?>><?php echo $campus[$i]["Campus"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Tipo de oferta educativa:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<option value="1"<?php if($_POST["txtOferta"]=="1"){?>selected="selected"<?php }?>>Doctorado</option>
											<option value="2"<?php if($_POST["txtOferta"]=="2"){?>selected="selected"<?php }?>>Maestria</option>
											<option value="3"<?php if($_POST["txtOferta"]=="3"){?>selected="selected"<?php }?>>Licenciatura</option>
											<option value="4"<?php if($_POST["txtOferta"]=="4"){?>selected="selected"<?php }?>>Bachillerato</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label>Ciclo escolar:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){ $tipoO = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-7">
								<div class="form-group">
									<label>Conceptos de pagos:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control select2" name="txtConcepto" id="txtConcepto" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($lstConceptos);$i++) { ?>
											<option value="<?php echo $lstConceptos[$i]["IdConceptoPlanes"]; ?>"<?php if($_POST["txtConcepto"]==$lstConceptos[$i]["IdConceptoPlanes"]){   $monto = $lstConceptos[$i]["Costo"];  ?>selected="selected"<?php }?>><?php echo $lstConceptos[$i]["NomPlan"]; ?></option>
											<?php } ?>
										</select>
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
														<th>Ajuste</th>
														<th>Campus</th>
														<th>Nombre</th>
														<th>Monto</th>
														<th>Recargo</th>
														<th>Fecha</th>
													</tr>
												</thead>
												<tbody>
													<?php for ($i=0;$i< sizeof($calen);$i++) { ?>
													<tr id="<?php echo $calen[$i]["IdCalendario"]; ?>">
														<td>
															<button onclick="generarPag01(<?php echo $calen[$i]["IdCalendario"]; ?>,<?php echo $calen[$i]["IdConceptosPlanes"]; ?>,<?php echo $calen[$i]["IdCampus"]; ?>)" type="button" class="btn btn-warning"><i class="fa fa-align-left"></i></button>
															<!-- <button onclick="del_calendario(<?php echo $calen[$i]["IdCalendario"]; ?>)" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button> -->
														</td>
														<td><?php echo $calen[$i]["Campus"]; ?></td>
														<td><?php echo $calen[$i]["NomPlan"]; ?></td>
														<td>$ <?php echo $calen[$i]["Monto"]; ?></td>
														<td>$ <?php echo $calen[$i]["Recargo"]; ?></td>
														<td><?php echo $calen[$i]["FecBase"]; ?></td>
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

	    </form>
    </section>
		</div>
		<div id="dataGrp" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuraciones de pagos</h4>
									 </div>
									 <div class="modal-body" id="employee_Grp">

									 </div>
							</div>
				 </div>
		</div>
		<div id="dataGrpx" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Creación de pagos</h4>
									 </div>
									 <div class="modal-body" id="employee_Grpx">

									 </div>
							</div>
				 </div>
		</div>
	  <?php include("footer.php"); ?>
	</div>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Select2 -->
	<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>

	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script>

	function generarPag(){
		var IdCampus = 0;
		var IdGrado = 0;
		var IdPlan = 0;
		var IdCiclo = 0;

		$.ajax({
				 url:"formConsulta/crearPago.php",
				 method:"POST",
				 data:{IdCampus:IdCampus, IdGrado:IdGrado, IdPlan:IdPlan, IdCiclo:IdCiclo},
				 success:function(data){
							$('#employee_Grpx').html(data);
							$('#dataGrpx').modal('show');
				 }
		});
	}

	function generarPag01(IdCalendario, IdConceptoPlan,IdCampus){
		var IdCiclo = document.getElementById("txtCicloEscolar").value;
		var IdOferta = 0;
		$.ajax({
				 url:"formConsulta/generarPagos.php",
				 method:"POST",
				 data:{IdCalendario:IdCalendario,IdConceptoPlan:IdConceptoPlan, IdCiclo:IdCiclo, IdCampus: IdCampus},
				 success:function(data){
							$('#employee_Grp').html(data);
							$('#dataGrp').modal('show');
				 }
		});
	}

	function del_calendario(IdCalendario){

	    var TipoGuardar = "del_calendario";
	    swal({
	      title: "\u00BFEst\u00E1 seguro que desea eliminar este calendario de pago?",
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
	             data:{TipoGuardar:TipoGuardar, IdCalendario:IdCalendario},
	             success:function(data){

	             }
	        })
	        .done(function(data) {
	          if(data==1){
	            swal("Eliminado correctamente", "El calendario de pago se ha eliminado correctamente.", "success");
	            document.getElementById(IdCalendario).style.display = 'none';
	  				}
						if(data==3){
	            swal("Error al eliminar", "No se puede eliminar este calendario de pago ya que se esta utilizando esta fecha para realizar pagos.", "error");
	  				}
	  			})
	        .error(function(data) {
	  				swal("Error al guardar", "No se puede guardar, comuniquese con el desarrollador.", "error");
	  			});

	      }
	    });
	}


	$(function () {
		$('.select2').select2()

	})
	$(function () {
		$('#example1').DataTable()
	})
	</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
