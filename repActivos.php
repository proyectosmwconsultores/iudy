<?php $valor = 3; $section = "Reporte de usuarios activos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizado la lista de usuarios activos'); }
$estatus=$t->get_estatuS();
$lstCam=$t->get_campA();
if(isset($_POST["txtEstatus"])){  $_POST["txtEstatus"] = $_POST["txtEstatus"]; } else { $_POST["txtEstatus"] = ''; }
$usuarios=$t->get_usuariosT($_POST["txtEstatus"]);

$bytesCodificados = base64_encode(file_get_contents("assets/images/campus/logo_campus.png"));
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
					Reporte de usuarios activos en la plataforma
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Reporte</a></li>
					<li class="active">Usuarios activos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">

					<form name="frm" id="frm" action="repActivos.php" method="POST" enctype="multipart/form-data">
						<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
						<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
						<input id="Numero" name="Numero" value="1" type="hidden"/>
						<div class="col-md-12">
							<div class="box box-default">
				        <div class="box-body">
				          <div class="row">
				            <div class="col-md-8">
				              <div class="box-primary">
				                <div class="box-body">
				                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);">
				                    <i class="fa fa-rotate-left"></i> Regresar
				                  </a><?php if(isset($usuarios[0])){ ?>

													 <a class="btn btn-app" onclick="window.open('repositorio/pdf/usuariosActivos.php?tok=<?php echo $_POST["txtEstatus"]; ?>','_blank')" href="javascript:void(0);">
				                    <i class="fa fa-print"></i> Imprimir
				                  </a>
												<?php } ?>
			                  </div>
				              </div>
				            </div>


				            <div class="col-md-4">
				              <div class="box-primary">
				                <div class="box-body">
				                <div class="form-group">
				                  <label>Estatus:</label>
				                  <div class="input-group">
				                    <div class="input-group-addon"><i class="fa fa-calendar-check-o"></i></div>
														<select class="form-control" name="txtEstatus" id="txtEstatus" onchange="document.frm.submit();">
															<option value=""> - Seleccione - </option>
															<option value="99"<?php if($_POST["txtEstatus"]==99){?>selected="selected"<?php }?>> Todos </option>
															<option value="8"<?php if($_POST["txtEstatus"]==8){ ?>selected="selected"<?php }?>> Activo </option>
															<option value="9"<?php if($_POST["txtEstatus"]==9){ ?>selected="selected"<?php }?>> Inactivo </option>
															<option value="15"<?php if($_POST["txtEstatus"]==15){ ?>selected="selected"<?php }?>> Baja definitiva </option>
															<option value="20"<?php if($_POST["txtEstatus"]==20){ ?>selected="selected"<?php }?>> Baja por deserción </option>
															<option value="31"<?php if($_POST["txtEstatus"]==31){ ?>selected="selected"<?php }?>> En captura </option>
															<option value="50"<?php if($_POST["txtEstatus"]==50){ ?>selected="selected"<?php }?>> Bloqueado temporalmente </option>

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
														<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 12px;" >
															<thead>
																<tr>
																	<th style="text-align: center;">Campus</th>
																	<th style="text-align: center;">Rectoria</th>
																	<th style="text-align: center;">Dir. Campus</th>
																	<th style="text-align: center;">Coor. Acad</th>
																	<th style="text-align: center;">Aux. Coord. Acad</th>
																	<th style="text-align: center;">Ges. Escolar</th>
																	<th style="text-align: center;">Administración</th>
																	<th style="text-align: center;">Admisión</th>
																	<th style="text-align: center;">Ext. Univer.</th>
																	<th style="text-align: center;">Docente</th>
																	<th style="text-align: center;">Alumno</th>
																	<th style="text-align: center;">Total</th>
															</thead>
															<tbody>
																<?php $sumT = 0;
																$sum1 = 0; $sum2 = 0; $sum3 = 0; $sum4 = 0; $sum5 = 0; $sum6 = 0; $sum7=0; $sum8=0; $sum9=0; $sum10=0;
																for ($i=0;$i< sizeof($lstCam);$i++) { $sumCamp = 0;
																	$s1 = 0; $s2 = 0; $s3 = 0; $s4 = 0; $s5 = 0; $s6 = 0; $s7=0;
																	$usuOn1=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],10);
																	$usuOn2=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],5);
																	$usuOn3=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],9);
																	$usuOn4=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],11);
																	$usuOn5=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],7);
																	$usuOn6=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],6);
																	$usuOn7=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],8);
																	$usuOn8=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],13);
																	$usuOn9=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],2);
																	$usuOn10=$t->get_usuariosGrup($_POST["txtEstatus"],$lstCam[$i]["IdCampus"],3);

																	if(isset($usuOn1[0]["Total"])){ $s1 = $usuOn1[0]["Total"]; } else { $s1 = 0; }
																	if(isset($usuOn2[0]["Total"])){ $s2 = $usuOn2[0]["Total"]; } else { $s2 = 0; }
																	if(isset($usuOn3[0]["Total"])){ $s3 = $usuOn3[0]["Total"]; } else { $s3 = 0; }
																	if(isset($usuOn4[0]["Total"])){ $s4 = $usuOn4[0]["Total"]; } else { $s4 = 0; }
																	if(isset($usuOn5[0]["Total"])){ $s5 = $usuOn5[0]["Total"]; } else { $s5 = 0; }
																	if(isset($usuOn6[0]["Total"])){ $s6 = $usuOn6[0]["Total"]; } else { $s6 = 0; }
																	if(isset($usuOn7[0]["Total"])){ $s7 = $usuOn7[0]["Total"]; } else { $s7 = 0; }
																	if(isset($usuOn8[0]["Total"])){ $s8 = $usuOn8[0]["Total"]; } else { $s8 = 0; }
																	if(isset($usuOn9[0]["Total"])){ $s9 = $usuOn9[0]["Total"]; } else { $s9 = 0; }
																	if(isset($usuOn10[0]["Total"])){ $s10 = $usuOn10[0]["Total"]; } else { $s10 = 0; }
																	$sumCamp = ($s1 + $s2 + $s3 + $s4 + $s5 + $s6 + $s7 + $s8 + $s9 + $s10);
																	 ?>
																<tr>
																	<td><?php echo $lstCam[$i]["Campus"]; ?></td>
																	<td style="text-align: center;"><?php echo $s1; ?></td>
																	<td style="text-align: center;"><?php echo $s2; ?></td>
																	<td style="text-align: center;"><?php echo $s3; ?></td>
																	<td style="text-align: center;"><?php echo $s4; ?></td>
																	<td style="text-align: center;"><?php echo $s5; ?></td>
																	<td style="text-align: center;"><?php echo $s6; ?></td>
																	<td style="text-align: center;"><?php echo $s7; ?></td>
																	<td style="text-align: center;"><?php echo $s8; ?></td>
																	<td style="text-align: center;"><?php echo $s9; ?></td>
																	<td style="text-align: center;"><?php echo $s10; ?></td>
																	<td style="text-align: center;"><?php echo $sumCamp; ?></td>
																</tr>
																<?php
																	$sum1 = ($sum1 + $s1);
																	$sum2 = ($sum2 + $s2);
																	$sum3 = ($sum3 + $s3);
																	$sum4 = ($sum4 + $s4);
																	$sum5 = ($sum5 + $s5);
																	$sum6 = ($sum6 + $s6);
																	$sum7 = ($sum7 + $s7);
																	$sum8 = ($sum8 + $s8);
																	$sum9 = ($sum9 + $s9);
																	$sum10 = ($sum10 + $s10);

																	$sumT = ($sumT + $sumCamp);
															 } ?>
															</tfoot>
															<tfoot>
							                <tr>
																<th rowspan="1" colspan="1">Totales:</th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum1; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum2; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum3; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum4; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum5; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum6; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum7; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum8; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum9; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sum10; ?></th>
																<th style="text-align: center;" rowspan="1" colspan="1"><?php echo $sumT; ?></th>
															</tr>
							                </tfoot>
														</table>
													</div>
													</div>
				                </div>


				              </div>
				          </div>
				        </div>
				      </div>
						</div>

					</form>
				</div>
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

<!-- jQuery 3 -->


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
