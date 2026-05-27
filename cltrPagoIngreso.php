<?php $section = "Generar Pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de generar pagos nuevo ingreso'); }

if(isset($_POST["Mov"]) && $_POST["Mov"]=="genPago"){
  $t->add_generarPagos();
  exit;
}

$lstAlumnos=$t->get_lstNvoIngreso();



?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<form name="frm" id="frm" action="ctrlPagoIngreso.php" method="POST" enctype="multipart/form-data">
		<input id="TipoGuardar" name="TipoGuardar" value="val_addGenerarPag" type="hidden"/>
		<input id="Mov" name="Mov" value="<?php echo $_GET['Mov'];?>" type="hidden"/>
		<input id="IdUsua" name="IdUsua" value="<?php echo $datosUser[0]["IdUsua"] ?>" type="hidden"/>
		<input id="Alerta" name="Alerta" value="<?php echo $_SESSION['Alerta'];?>" type="hidden"/>
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Generar pagos de nuevo ingreso
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-book"></i> Pagos</a></li>
					<li class="active">Generar pagos</li>
				</ol>
			</section>
			<section class="content">
				<div class="row">
						<div class="col-xs-12">
							<div class="box">
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Ajuste</th>
												<th>Nombre</th>
												<th>Tel&eacute;fono</th>
												<th>Correo</th>
												<th>Oferta educativa</th>
											</tr>
										</thead>
										<tbody>
											<?php for ($i=0;$i< sizeof($lstAlumnos);$i++) { $id = $lstAlumnos[$i]["IdUsua"];   ?>
											<tr>
												<td style="text-align: center">
													<button type="button" class="btn btn-danger view_total" href="javascript:void(0);" title="Generar pago nuevo" name="view" value="view" id="<?php echo $id; ?>" ><i class="fa fa-cc-mastercard"></i> Pago</button>
												</td>
												<td><?php echo $lstAlumnos[$i]["Nombre"].' '.$lstAlumnos[$i]["APaterno"].' '.$lstAlumnos[$i]["AMaterno"]; ?></td>
												<td><?php echo $lstAlumnos[$i]["Telefono"]; ?></td>
												<td><?php echo $lstAlumnos[$i]["Correo"]; ?></td>
												<td><?php echo $lstAlumnos[$i]["NomEducativa"]; ?></td>
											</tr>
										<?php }  ?>
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
	<div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
			 <div class="modal-dialog">
						<div class="modal-content">
								 <div class="modal-header" style="background: #367fa9; color: white; font-size: 16px;">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Generar pago de nuevo ingreso</h4>
								 </div>
								 <div class="modal-body" id="employee_detail4">

								 </div>
						</div>
			 </div>
	</div>

	</form>
</body>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>

$(document).ready(function(){
		 $(document).on('click', '.view_total', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/pagoIngreso.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail4').html(data);
												 $('#dataModal4').modal('show');
										}
							 });
					}
		 });
});

// function val_TipoFolio(valor){
//     var pagar = document.getElementById("txtIdCurso-"+valor).checked;
//     if(pagar == true){
//       var numero = 1;
//       $.post("formConsulta/updPago.php", { valor:valor, numero:numero }, function(data){
//       });
//     }else if(pagar == false){
//       var numero = 0;
//       $.post("formConsulta/updPago.php", { valor:valor, numero:numero }, function(data){
//       });
//     }
//
//   }

$(document).ready(function(){
	var alerta = document.frm.Alerta.value;
	if(alerta){
		if(alerta =="0"){
			swal("Error", "Error no se puede Generar", "error");
		}
		if(alerta =="1"){
			swal("Guardado", "Pago generado con exito", "success");
		}
	}
});

  $(function () {
    $('#example1').DataTable()
  })
</script>
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
	//Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
