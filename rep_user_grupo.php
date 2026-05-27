<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de reporte de usuarios por grupo'); }

if(isset($_POST['txtCampus'])){ $_POST["txtCampus"] = $_POST['txtCampus']; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST['txtOferta'])){ $_POST["txtOferta"] = $_POST['txtOferta']; } else { $_POST['txtOferta'] = ''; }
$campus=$t->get_campusPermiso($_SESSION['IdUsua']);
$oferta=$t->get_lstoFEst4s($_POST["txtCampus"], $_SESSION['IdUsua']);

$lst_grp=$t->get_grp_total($_POST["txtCampus"],$_POST["txtOferta"]);

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
					Reporte de alumnos por grupo
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="rep_user_grupo.php" method="POST" enctype="multipart/form-data">
					<input id="IdUsua" name="IdUsua" value="<?php echo $_SESSION['IdUsua'];?>" type="hidden"/>
				<input id="Mov" name="Mov" value="" type="hidden"/>
				<input id="IdDoc" name="IdDoc" value="" type="hidden"/>
				<input id="Alerta" name="Alerta" value="<?php echo isset($_SESSION['Alerta']);?>" type="hidden"/>
				<input id="Universidad" name="Universidad" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
				<input id="Logo" name="Logo" value="<?php echo $bytesCodificados; ?>" type="hidden"/>
				<input id="Numero" name="Numero" value="6" type="hidden"/>
				<input id="Nombre" name="Nombre" value="Reporte de verificación de pagos" type="hidden"/>
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<label>Campus:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCampus" id="txtCampus" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
											<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if($_POST['txtCampus']==$campus[$i]["IdCampus"]){?>selected="selected"<?php }?>><?php echo $campus[$i]["Campus"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label>Plan de estudios:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<option value="x"<?php if($_POST['txtOferta']=='x'){?>selected="selected"<?php }?>>TODOS LOS PLANES DE ESTUDIOS</option>
											<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
											<option value="<?php echo $oferta[$i]["IdOferta"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdOferta"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
											<?php } ?>
										</select>
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
														<th>Ajuste</th>
														<th style="text-align: center;">Alumnos</th>
														<th>Grupo</th>
														<th>Nivel</th>
														<th>Estatus</th>
														<th>Modalidad</th>
														<th>Plan de estudios</th>
													</tr>
												</thead>
												<tbody>
													<?php if(isset($lst_grp[0])){
													 for ($i=0;$i< sizeof($lst_grp);$i++) {
														 $t_ci = $lst_grp[$i]["TipoCiclo"]; if($t_ci == 'C'){ $txt_c = 'Cuatrimestre'; } elseif($t_ci == 'S'){ $txt_c = 'Semestre'; }
														 $t_tu = $lst_grp[$i]["Turno"]; if($t_tu == 'M'){ $txt_t = 'Matutino'; } elseif($t_tu == 'V'){ $txt_t = 'Vespertino'; }
														 $t_mo = $lst_grp[$i]["Modalidad"]; if($t_mo == 'E'){ $txt_m = 'Escolarizado'; } elseif($t_mo == 'N'){ $txt_m = 'No escolarizado'; }
														 $t_di = $lst_grp[$i]["Dia"]; if($t_di == 'L'){ $txt_d = 'Lunes / Viernes'; } elseif($t_di == 'S'){ $txt_d = 'Sábado'; } elseif($t_di == 'D'){ $txt_d = 'Domingo'; }
														  ?>
													<tr>
														<td>
															<button type="button" class="btn btn-danger btn-xs view_grupo" href="javascript:void(0);" name="view" value="view" id="<?php echo $lst_grp[$i]["IdGrupo"]; ?>" style="cursor: pointer; "><i class="fa fa-fw fa-edit"></i></button>
															<!-- <button type="button" class="btn btn-primary btn-xs"><i class="fa fa-fw fa-edit"></i></button> -->
														</td>
														<td style="text-align: center;"><?php echo $lst_grp[$i]["Total"]; ?></td>
														<td><?php echo $lst_grp[$i]["CveGrupo"]; ?></td>
														<td><?php echo $txt_c.' '.$lst_grp[$i]["IdGrado"]; ?></td>
														<td><?php echo $lst_grp[$i]["Estatus"]; ?></td>
														<td><?php echo $txt_m.' - '.$txt_d; ?></td>
														<td><?php echo $lst_grp[$i]["Nombre"]; ?></td>
													</tr>
												<?php } } ?>
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

		<div id="dataModalGrp" class="modal fade"> <!--MODAL ME GUSTA-->
				 <div class="modal-dialog">
							<div class="modal-content">
									 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title"><i class="fa fa-fw fa-cog"></i> Configuración de grupo</h4>
									 </div>
									 <div class="modal-body" id="employee_detailGrp">
									 </div>
							</div>
				 </div>
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

<script>
$(document).ready(function(){
     $(document).on('click', '.view_grupo', function(){
          var employee_id = $(this).attr("id");
          if(employee_id != '')
          {
               $.ajax({
                    url:"formConsulta/updGrupo.php",
                    method:"POST",
                    data:{employee_id:employee_id},
                    success:function(data){
                         $('#employee_detailGrp').html(data);
                         $('#dataModalGrp').modal('show');
                    }
               });
          }
     });
});


</script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
