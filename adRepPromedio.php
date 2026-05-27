<?php $valor = 3; $section = "Generación de reconocimientos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de generación de reconocimientos.'); }

$ciclo=$t->get_ciclo_esc_fin();
if(isset($_POST["txtCiclo"])){ $_POST["txtCiclo"] = $_POST["txtCiclo"]; } else { $_POST["txtCiclo"] = ''; }
$Usuarios=$t->get_lst_esc($_POST["txtCiclo"]);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Generación de reconocimientos de promedio por periodo escolar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> >Alumnos</a></li>
					<li class="active">Reconocimientos</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adRepPromedio.php" method="POST" enctype="multipart/form-data">
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
                  </div>
	              </div>
	            </div>
							<div class="col-md-8">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Periodo escolar:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-users"></i></div>
											<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="document.frm.submit();">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($ciclo);$i++) { ?>
												<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCiclo"]==$ciclo[$i]["IdCiclo"]){ ?>selected="selected"<?php }?>><?php echo $ciclo[$i]["Ciclo"]; ?></option>
												<?php } ?>
											</select>
											<span class="input-group-btn">
	                      <button onclick="generar_const()" type="button" class="btn btn-info btn-flat"><i class="fa fa-fw fa-hourglass"></i> Generar</button>
	                    </span>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>







	              <div class="col-md-12">
									<table class="table table-striped">
										<tbody id='tbl_cons'>

											<?php $valor = 0; $_x = 0;
											$camp_i = 0; $camp_f = 0;
											$ofer_i = 0; $ofer_f = 0;
											for ($i=0;$i< sizeof($Usuarios);$i++) {
												$valor = $Usuarios[$i]["IdEstatus"];
												if($valor == 1){ $cond_c = "style='background: red;';";  } else { $cond_c = ""; }
												$tm = substr($Usuarios[$i]["CveGrupo"], 7,1);
												if($tm == 'C'){ $_txa = "CUATRIMESTRE"; } else { $_txa = "SEMESTRE"; }

												$camp_i = $Usuarios[$i]["IdCampus"];
												$ofer_i = $Usuarios[$i]["IdOferta"];

												if($camp_i <> $camp_f){ if($_x == 1){ $ofer_i = 0; } ?>
													<tr style="background: #4c489e; color: #fff;">
														<td colspan="8"><b>CAMPUS:</b> <?php echo $Usuarios[$i]["Campus"]; ?></td>
													</tr>
												<?php }
												if($ofer_i <> $ofer_f){ ?>
													<tr style="background: #b4b0ff; color: #000;">
														<td style="width: 10px;"><i class="fa fa-fw fa-bookmark"></i> </td>
														<td colspan="5"><b>PLAN DE ESTUDIOS:</b> <?php echo $Usuarios[$i]["Educativa"]; ?></td>
														<td colspan="2" style="text-align: right;">
															<?php if($Usuarios[$i]["IdEstatus"] == 3){ ?>
															<button id="btn-<?php echo $Usuarios[$i]["IdCampus"].'-'.$Usuarios[$i]["IdOferta"]; ?>" onclick="marca_disponible(<?php echo $Usuarios[$i]["IdCampus"]; ?>,<?php echo $Usuarios[$i]["IdOferta"]; ?>)" type="button" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-exclamation-triangle"></i> Activar reconocimiento</button>
															<?php } ?>
														</td>
													</tr>
												<?php } ?>
											<tr <?php echo $cond_c; ?>>
												<td style="width: 10px;">
													<?php if($Usuarios[$i]["IdEstatus"] == 4){ ?>
															<button onclick="window.open('repositorio/portafolio/miReconocimiento.php?idToks=<?php echo time().$Usuarios[$i]["IdConstancia"]; ?>','_blank')" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat btn-xs "><i class="fa fa-fw fa-file-pdf-o"></i></button>
													<?php } ?>
												</td>

												<td><?php echo $Usuarios[$i]["Lugar"]; ?>° </td>
												<td><?php echo number_format($Usuarios[$i]["Promedio"], 2, '.', ','); ?></td>
												<td><?php echo $Usuarios[$i]["APaterno"].' '.$Usuarios[$i]["AMaterno"].' '.$Usuarios[$i]["Nombre"]; ?></td>
												<td><?php echo $Usuarios[$i]["Usuario"]; ?></td>
												<td><?php echo $Usuarios[$i]["Grado"].'° '.$_txa; ?></td>
												<td><?php echo $Usuarios[$i]["CveGrupo"]; ?></td>
												<td><?php echo $Usuarios[$i]["Estatus"]; ?></td>
											</tr>
										<?php $camp_f = $Usuarios[$i]["IdCampus"]; $ofer_f = $Usuarios[$i]["IdOferta"]; $_x = 1; } ?>
										</tbody>
									</table>
	              </div>
	          </div>
	        </div>
	      </div>

	    </form>
    </section>

		</div>

		<div id="dataModalIni" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-gift"></i> Generar constancias de reconocimientos a los mejores promedios por grupo.</h4>
									 </div>
									 <div class="modal-body" id="employee_detailIni">

									 </div>
							</div>
				 </div>
		</div>

		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<!-- Select2 -->
		<script src="bower_components/select2/dist/js/select2.full.min.js"></script>


		<!-- <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script> -->
		<!-- iCheck 1.0.1
		<script src="bower_components/plugins/iCheck/icheck.min.js"></script>
		<!-- FastClick
		<script src="bower_components/fastclick/lib/fastclick.js"></script>
		<!-- AdminLTE App -->
		<script src="dist/js/adminlte.min.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="dist/js/demo.js"></script>


	  <?php include("footer.php"); ?>
	</div>
<script>

function generar_const(){
	var IdCiclo = document.getElementById("txtCiclo").value;

	$.ajax({
			 url:"formConsulta/generar_constancias.php",
			 method:"POST",
			 data:{IdCiclo:IdCiclo},
			 success:function(data){
						$('#employee_detailIni').html(data);
						$('#dataModalIni').modal('show');
			 }
	});

}

function marca_disponible(IdCampus, IdOferta){
	var IdCiclo = document.getElementById("txtCiclo").value;
	var TipoGuardar = "habi_constas_us";
	var Boton = 'btn-'+IdCampus+'-'+IdOferta;
	var datos = 'TipoGuardar=' + TipoGuardar + '&IdCiclo=' + IdCiclo + '&IdCampus=' + IdCampus + '&IdOferta=' + IdOferta;
	$.ajax({
		type:"POST",
		url:"formConsulta/setting.php",
		data:datos,
		success:function(data){

		}
	})
	.done(function(data) {
		if(data==1){
			swal("Guardado correctamente", "Los reconocimientos han sido publicadas correctamente a los alumnos.", "success");
			document.getElementById(Boton).style.display = 'none';
		}

	})
	.error(function(data) {
		swal("Error al agregar 0x138", "No se puede guardar, comuniquese con el desarrollador.", "error");
	});

}


$(function () {
	$('.select2').select2()

})

</script>

</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
