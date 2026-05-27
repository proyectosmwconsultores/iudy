 <?php $section = "Revisión de Planeación"; include("head.php");
if(($_SESSION['IdUsua']) && ($_SESSION['Permisos'])){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de revisión de Planeación'); }

	$lstCiclo=$t->get_cEscolarLst();

if(isset($_POST["txtCiclo"])){ $_POST["txtCiclo"] = $_POST["txtCiclo"]; } else { $_POST["txtCiclo"] = ''; }
if(isset($_POST["txtClaveGrp"])){ $_POST["txtClaveGrp"] = $_POST["txtClaveGrp"]; } else { $_POST["txtClaveGrp"] = ''; }

if(isset($_POST["txtCiclo"])){
  $clvGrupo=$t->get_claveGrupoXA($_POST["txtCiclo"]);
}

$revModulo=$t->get_revModulo($_POST["txtCiclo"],$_POST["txtClaveGrp"]);



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
					Revisi&oacute;n de planeaciones acad&eacute;micas
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Revisi&oacute;n</a></li>
					<li class="active">Planeaciones acad&eacute;micas</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="adPlaneacionRevision.php" method="POST" enctype="multipart/form-data">
						<div class="col-md-5">
							<div class="form-group">
								<label>Periodo del ciclo escolar:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCiclo"]==$lstCiclo[$i]["IdCiclo"]){ $tipoP = $lstCiclo[$i]["Tipo"]; ?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
            <div class="col-md-7">
								<div class="form-group">
									<label>Grupo:</label>
									<div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-fw fa-key"></i>
									  </div>
									  <select class="form-control select2" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { $tx = 0;
                        $busActivoD=$t->get_busActOfer($clvGrupo[$i]["IdGrupo"],$_SESSION["IdUsua"],$clvGrupo[$i]["IdCampus"]);
                         $tx = $busActivoD[0][0];
                        if($tx){
                        ?>
                        <option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"].' / '.$clvGrupo[$i]["Grado"].'° '.$tipoP; ?></option>
                        <?php
                        } } ?>
									  </select>
									</div>
								</div>
						</div>
            <?php if(isset($revModulo[0])){ ?>
						<div class="col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Lista de planeaciones academicas</h3>
								</div>
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
                        <th>Planeacion</th>
                        <th>IdAsignatura</th>
												<th>Asignatura</th>
												<th>Asesor acad&eacute;mico</th>
                        <th>Estatus</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($revModulo);$i++) {
                        $IdPlan = $revModulo[$i]["IdEstatusPlan"];


												?>
											<tr style="cursor: pointer; " onClick="window.open('planeacionAcademica.php?toks=<?php echo time().$revModulo[$i]["IdPlaneacion"]; ?>','_self')" href="javascript:void(0);">
                        <td><?php echo $revModulo[$i]["Planeacion"]; ?></td>
                        <td><?php echo $revModulo[$i]["CodeModulo"]; ?></td>
												<td><?php echo $revModulo[$i]["NombreMod"]; ?></td>
												<td><?php echo $revModulo[$i]["AsNombre"].' '.$revModulo[$i]["AsPaterno"].' '.$revModulo[$i]["AsMaterno"]; ?></td>
                        <td><?php

                          if($revModulo[$i]["IdEstatusPlan"] == 8){

                            if($revModulo[$i]["FecAprobado"]){
                                echo "Aprobado por: ".$revModulo[$i]["Nombre"].' '.$revModulo[$i]["APaterno"].' '.$revModulo[$i]["AMaterno"].' <br>'.obtenerFechaEnLetra($revModulo[$i]["FecAprobado"]);
                            } else {
                              echo "Pendiente generar costo por Corporativo";
                            }
                            if($IdPlan == 4){
                              echo "<br>Planeación <b>activa</b> con este asesor";
                            } else {
                              echo "<br>Planeación <b>NO</b> terminada con este asesor";
                            }
                          } elseif($revModulo[$i]["IdEstatusPlan"] == 3){
                            echo "<p style='color: blue;'>Debe revisar</p>";
                          } else {
                            echo "<p style='color: red;'>En captura</p>";
                          } ?>
                        </td>
											</tr>
											<?php } ?>
										</tfoot>
									</table>
								</div>
							</div>
						</div><?php } ?>
					</form>
				</div>
			</section>
		</div>
		<div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
					<div class="modal-dialog">
							 <div class="modal-content">
										<div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
												 <button type="button" class="close" data-dismiss="modal">&times;</button>
												 <h4 class="modal-title">Informaci&oacute;n general del parcial</h4>
										</div>
										<div class="modal-body" id="employee_detail">
										</div>
							 </div>
					</div>
		 </div>
	  <?php include("footer.php"); ?>
	</div>
</body>
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

<script>


	function revisarParcial(IdParcial){
    var User = "X";
		$.ajax({
				 url:"formConsulta/viewRevisarParcial.php",
				 method:"POST",
				 data:{IdParcial:IdParcial,User:User},
				 success:function(data){
							$('#employee_detail').html(data);
							$('#dataModal').modal('show');
				 }
		});

	}

</script>
<!-- Page script -->
<script>
$(function () {
	$('.select2').select2()

})


  $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>
