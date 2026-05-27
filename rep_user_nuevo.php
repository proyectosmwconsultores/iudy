<?php $section = "Reporte de alumno nuevo ingreso"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de reporte de alumnos por ciclo escolar'); }

if(isset($_POST['txtCampus'])){ $_POST["txtCampus"] = $_POST['txtCampus']; } else { $_POST["txtCampus"] = ''; }
if(isset($_POST['txtCiclo'])){ $_POST["txtCiclo"] = $_POST['txtCiclo']; } else { $_POST['txtCiclo'] = ''; }
$campus=$t->get_campusPermiso($_SESSION['IdUsua']);
$ciclo=$t->get_all_ciclos();

$lst_user_grp=$t->get_user_grp_all($_POST["txtCampus"],$_POST["txtCiclo"]);

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
					Reporte de alumnos por periodo escolar
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Reportes</a></li>
					<li class="active">Alumnos</li>
				</ol>
			</section>
			<section class="content">
				<form name="frm" id="frm" action="rep_user_nuevo.php" method="POST" enctype="multipart/form-data">
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
							<div class="col-md-6">
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
							<div class="col-md-6">
								<div class="form-group">
									<label>Plan de estudios:</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-gears"></i>
										</div>
										<select class="form-control" name="txtCiclo" id="txtCiclo" onchange="document.frm.submit();">
											<option value=""> - Seleccione - </option>
											<?php for ($i=0;$i< sizeof($ciclo);$i++) { ?>
											<option value="<?php echo $ciclo[$i]["IdCiclo"]; ?>"<?php if($_POST['txtCiclo']==$ciclo[$i]["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $ciclo[$i]["Tipo"].' - '.$ciclo[$i]["Ciclo"]; ?></option>
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
														<th>Plan de estudios</th>
														<th>Total</th>
													</tr>
												</thead>
												<tbody>
													<?php if(isset($lst_user_grp[0])){
													 for ($i=0;$i< sizeof($lst_user_grp);$i++) { ?>
													<tr>
														<td><?php echo $lst_user_grp[$i]["Nombre"]; ?></td>
														<td><?php echo $lst_user_grp[$i]["Total"]; ?></td>
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
