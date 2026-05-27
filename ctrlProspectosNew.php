<?php $section = "Prospectos en proceso"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando los prospectos en proceso'); }
$oferta=$t->get_OfertaETodos();

if($_GET['Id']){
	$_POST['txtOferta'] = $_GET['Id'];
}

if(($_POST['txtIdUsua']) && ($_POST['txtOferta'])){
		$t->get_addVisto($_POST["txtOferta"],$_POST['txtIdUsua']);
}
//$moduloId=$t->get_prospectosEduc($_POST["txtOferta"]);

$lstProspectos=$t->get_prospectosMod($_POST["txtOferta"],$_POST["datepicker"],$_POST["datepicker2"]);


?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Prospectos en proceso
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Inicio</a></li>
					<li class="active">Prospectos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
					<form name="frm" id="frm" action="ctrlProspectosNew.php" method="POST" enctype="multipart/form-data">
						<input id="IdAlumno" name="IdAlumno" value="<?php echo $_POST['txtIdUsua'];?>" type="hidden"/>
						<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
						<div class="col-md-4">

							<div class="form-group">
								<label>Oferta educativa:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-gears"></i>
									</div>
									<select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
										<option value=""> - Seleccione - </option>
										<option value="9999"<?php if($_POST['txtOferta']==9999){?>selected="selected"<?php }?>>Todas las ofertas educativas</option>
										<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
										<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST['txtOferta']==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha inicial:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker" name="datepicker" value="<?php echo $_POST["datepicker"] ?>" onchange="document.frm.submit();">
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Fecha final:</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right" id="datepicker2" name="datepicker2" value="<?php echo $_POST["datepicker2"] ?>" onchange="document.frm.submit();">
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Prospestos en proceso</h3>
							</div>
							<div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th></th>
											<th>Oferta educativa</th>
											<th>Nombre prospecto</th>
											<th>Correo</th>
											<th>Tel&eacute;fono</th>
											<th>Fec. Captura</th>
											<th style="text-align: center;">No. Documentos</th>
										</tr>
									</thead>
									<tbody>
										<?php for ($i=0;$i< sizeof($lstProspectos);$i++) {
											$lstNoDoc=$t->get_listNoDoc($lstProspectos[$i]["IdEducativa"]);
											 $nomDocs = $lstNoDoc[0][0] - 1;
											 $id = $lstProspectos[$i]["IdUsua"]; if($lstProspectos[$i]["NoDoc"] < $nomDocs){  ?>
										<tr id="<?php echo $id; ?>">
											<td><button type="button" class="btn btn-danger" href="javascript:void(0);" onClick="val_delProspectoNew(<?php echo $id; ?>)"  style="float: center;"><i class="fa fa-trash"></i></button></td>
											<td><?php echo $lstProspectos[$i]["NomEducativa"]; ?></td>
											<td><?php echo $lstProspectos[$i]["Nombre"].' '.$lstProspectos[$i]["APaterno"].' '.$lstProspectos[$i]["AMaterno"]; ?></td>
											<td><?php echo $lstProspectos[$i]["Correo"]; ?></td>
											<td><?php echo $lstProspectos[$i]["Telefono"]; ?></td>
											<td><?php echo $lstProspectos[$i]["FecCap"]; ?></td>
											<td style="text-align: center;"><?php echo $lstProspectos[$i]["NoDoc"]; ?></td>
										</tr>
									<?php } } ?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
      </div>

			</section>
		</div>
	  <?php include("footer.php"); ?>
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
							swal("Error", "Error no se puede Eliminar", "error");
						}
						if(alerta =="1"){
							swal("Eliminado", "Registro del prospecto eliminado correctamente", "success");
						}
					}
				});


</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
