<?php  $section = "Configurar conceptos de pagos"; include("head.php");
if($_SESSION['Permisos']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el modulo de bancos'); }

$lstBancos=$t->get_bancos_campus($_SESSION['IdCampus']);

?>
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					<i class="fa fa-fw fa-gears"></i> Configuraci&oacute;n de cuentas de bancos
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Configuraci&oacute;n</a></li>
					<li class="active">Cuentas de bancos</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="adBancos.php" method="POST" enctype="multipart/form-data">
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-12">
	              <div class="box-primary">
	                <div class="box-body">
	                  <a class="btn btn-app" onclick="window.open('welcome.php','_self')" href="javascript:void(0);" id="1">
	                    <i class="fa fa-rotate-left"></i> Regresar
	                  </a>
										<a class="btn btn-app view_total" href="javascript:void(0);">
	                    <i class="fa fa-file"></i> Nueva cuenta
	                  </a>
                  </div>
	              </div>
	            </div>




	          </div>
						<!-- saveBanco -->

	        </div>
	      </div>
				<div class="row">
					<?php  for ($i=0;$i< sizeof($lstBancos);$i++) {  $IdEs = $lstBancos[$i]["IdEstatus"]; if($lstBancos[$i]["IdBanco"] <> 1){ ?>
	        <div class="col-md-4">
	          <div class="box box-widget widget-user-2">
	            <div class="widget-user-header bg-aqua view_editar" href="javascript:void(0);" name="view" value="view" id="<?php echo $lstBancos[$i]["IdBanco"]; ?>" style="cursor: pointer;">
	              <div class="widget-user-image">
	                <img class="img-circle" src="assets/indice.png" alt="User Avatar">
	              </div>
	              <h3 class="widget-user-username"><?php echo $lstBancos[$i]["Banco"]; ?></h3>
	              <h5 class="widget-user-desc"><?php echo $lstBancos[$i]["Nombre"]; ?></h5>
	            </div>
	            <div class="box-footer no-padding">
	              <ul class="nav nav-stacked">
									<li><a href="#">Convenio <span class="pull-right badge bg-green"><?php echo $lstBancos[$i]["Convenio"]; ?></span></a></li>
	                <li><a href="#">No. Cuenta <span class="pull-right badge bg-green"><?php echo $lstBancos[$i]["NoCuenta"]; ?></span></a></li>
									<li><a href="#">Clabe <span class="pull-right badge bg-green"><?php echo $lstBancos[$i]["Clabe"]; ?></span></a></li>
									<li><a href="#">Estatus <span class="pull-right badge bg-<?php if($IdEs == 8) { echo "green"; } else { echo "red"; } ?>"><?php if($IdEs == 8) { echo "Activo"; } else { echo "Inactivo"; } ?></span></a></li>
									<li><a onclick="setting_bank(<?php echo $lstBancos[$i]["IdBanco"]; ?>)" href="javascript:void(0);"><i class="fa fa-cog"></i> Configurar</a></li>
	              </ul>
	            </div>
	          </div>
	        </div><?php } } ?>
      </div>
			<div id="dataModal4" class="modal fade"> <!--MODAL ME GUSTA-->
					 <div class="modal-dialog">
								<div class="modal-content">
										 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title"><i class="fa fa-fw fa-bank"></i> Crear cuenta de banco</h4>
										 </div>
										 <div class="modal-body" id="employee_detail4">

										 </div>
								</div>
					 </div>
			</div>

			<div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->
					 <div class="modal-dialog">
								<div class="modal-content">
										 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title"><i class="fa fa-fw fa-bank"></i> Actualizar cuenta de banco</h4>
										 </div>
										 <div class="modal-body" id="employee_detail2">

										 </div>
								</div>
					 </div>
			</div>
			<div id="dataModal5" class="modal fade"> <!--MODAL ME GUSTA-->
					 <div class="modal-dialog">
								<div class="modal-content">
										 <div class="modal-header" style="background: <?php echo $configuracion[34]['Descripcion']; ?>; color: <?php echo $configuracion[35]['Descripcion']; ?>; font-size: 16px;">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title"><i class="fa fa-fw fa-exclamation-circle"></i> Configurar cuenta de banco</h4>
										 </div>
										 <div class="modal-body" id="employee_detail5">
										 </div>
								</div>
					 </div>
			</div>
	    </form>
    </section>

		</div>

    <!-- Mainly scripts -->
    <script src="assets/table/js/jquery-3.1.1.min.js"></script>
    <script src="assets/table/js/bootstrap.min.js"></script>


	  <?php include("footer.php"); ?>
	</div>
<script>
function setting_bank(IdBanco){
	var IdCampus = 0;
	$.ajax({
			 url:"formConsulta/setting_bank.php",
			 method:"POST",
			 data:{IdBanco:IdBanco, IdCampus:IdCampus},
			 success:function(data){
						$('#employee_detail5').html(data);
						$('#dataModal5').modal('show');
			 }
	});
}

$(document).ready(function(){
		 $(document).on('click', '.view_total', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/addBanco.php",
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

$(document).ready(function(){
		 $(document).on('click', '.view_editar', function(){
					var employee_id = $(this).attr("id");
					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/updBanco.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
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
