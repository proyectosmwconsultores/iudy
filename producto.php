<?php $_v = 50; $section = "Mi producto"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de productos.'); }
$prod=$t->get_producto($_SESSION['IdUsua']);


if(isset($prod[0]['Vigencia'])){
$dias = dias_restantes($prod[0]['Vigencia']);
$msj = 0;
if(($dias >= 0) && ($dias < 20)){
	$msj = 1;
}
if($dias >= 20){
	$msj = 2;
}
if($dias < 0){
	$msj = 3;
	$updD=$t->upd_prod_to($_SESSION['IdUsua'],$prod[0]['IdCompra']);
}
}

// if(($dias > 0) && ($dias < 20)){
// 	$msj = 1;
// }
?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($msj == 1){ include("formConsulta/pendiente.php"); } ?>
			<section class="content-header">
				<h1>
					Mi producto en la Plataforma MWComenius
				</h1>
			</section>
			<section class="content">
				<div class="row">

      </div>


				<div class="row">
					<?php for ($i=0;$i< sizeof($prod);$i++) {
						$ocupado = $prod[$i]['Activos'];
					  $disponible = ($prod[$i]['Total'] - $ocupado);
						$idE = $prod[$i]['IdEstatus']; $idC = $prod[$i]['IdCompra'];
						if($idE == 1){ $idS = 'warning'; $idB = 'yellow'; } elseif($idE == 8){ $idS = 'success'; $idB = 'green'; }elseif($idE == 22){ $idS = 'danger'; $idB = 'red'; } elseif($idE == 57){ $idS = 'danger'; $idB = 'red'; }
						 ?>
						 <input id="txtDispo" name="txtDispo" value="<?php echo $disponible; ?>" type="hidden"/>
						 <input id="txtOcupa" name="txtOcupa" value="<?php echo $ocupado; ?>" type="hidden"/>

						 <div class="col-md-12">
	           <div class="box">
	             <div class="box-body">
	               <div class="row">
	                 <div class="col-md-8">
	 									<div class="box box-widget widget-user-2">

	             <div class="widget-user-header bg-<?php echo $idB; ?>">
	               <div class="widget-user-image">
	                 <img class="img-circle" src="assets/images/paquete.jpg" alt="User Avatar">
	               </div>

	               <h3 class="widget-user-username">Paquete <?php echo $prod[$i]['Paquete']; ?></h3>
	               <h5 class="widget-user-desc">Estatus: <?php echo $prod[$i]['Estatus']; ?></h5>
	             </div>
	             <div class="box-footer no-padding">
	               <ul class="nav nav-stacked">
									 <?php if($idE == 8){ ?>
	                 <li><a href="#"> Vencimiento: <?php if($prod[$i]['Vigencia']){ echo $prod[$i]['Vigencia']; } ?><span class="pull-right badge bg-blue"><i class="fa fa-fw fa-calendar-check-o"></i></span></a> </li>
	                 <li><a href="#"> Monto: <?php if($prod[$i]['Monto']){ echo '$ '.$prod[$i]['Monto']; } ?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-money"></i></span></a> </li>
									 <li><a href="#"> Fecha compra: <?php if($prod[$i]['Vigencia']){ echo $prod[$i]['FecCap']; } ?> <span class="pull-right badge bg-green"><i class="fa fa-fw fa-clock-o"></i></span></a> </li>
								 	 <?php } if($idE == 1){ ?>
										 <li><a href="#"> Espacio a comprar: <?php if($prod[$i]['Espacio']){ echo $prod[$i]['Espacio']; } ?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-money"></i></span></a> </li>
										 <li><a href="#"> Precio: <?php if($prod[$i]['Monto']){ echo '$ '.$prod[$i]['Monto']; } ?> <span class="pull-right badge bg-aqua"><i class="fa fa-fw fa-money"></i></span></a> </li>
	                 <li><a onClick="window.open('comprar.php?idCompra=<?php echo time().$prod[$i]['IdCompra']; ?>','_self')" href="javascript:void(0);" style="margin-left: 0px;" class="btn btn-default btn-block btn-sm bg-navy btn-flat margin"> <i class="fa fa-fw fa-cart-plus"></i> Procesar pago </a> </li>
								 	 <?php } ?>
	                 <li><a href="#">
										 <?php if(isset($prod[$i]['Vigencia'])){
				 							$porInd = (100 / $prod[$i]['Total']);
				 							$avance = ($porInd * $prod[$i]['Activos']);

				 							 ?>
				 							 <span class="progress-text">Avance de captura de alumnos</span>
				 							 <span class="progress-number" style="float: right;"><b><?php echo $prod[$i]['Activos']; ?></b>/<?php echo $prod[$i]['Total']; ?></span>
				 								<div class="progress progress-sm active">

				                 <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $avance; ?>%">
				                   <span class="sr-only">20% Complete</span>
				                 </div>
				               </div><?php } ?>
									 </a></li>
	               </ul>

	             </div>
	           </div>

	                 </div>
	                 <!-- /.col -->
	                 <div class="col-md-4">
										 <p class="text-center">
	                    <strong>Espacio disponible</strong>
	                  </p>
	 									<div class="chart-responsive">
	 					          <canvas id="pieChart" height="170" style="width: 204px; height: 170px;" width="204"></canvas>
	 					        </div>
										<div class="box-footer no-padding">
									    <ul class="nav nav-pills nav-stacked">
									      <li><a href="javascript:void(0);">Ocupado<span class="pull-right text-red"><i class="fa fa-angle-up"></i> <?php echo $ocupado; ?></span></a></li>
									      <li><a href="#">Disponible <span class="pull-right text-green"><i class="fa fa-angle-down"></i> <?php echo $disponible; ?></span></a></li>
									    </ul>
									  </div>
	                 </div>
	                 <!-- /.col -->
	               </div>

	               <!-- /.row -->
	             </div>
	             <!-- ./box-body -->
	 						<div class="box-footer clearfix">
								<a href="javascript:void(0)" class="btn btn-sm btn-<?php echo $idS; ?> btn-flat pull-left"><i class="fa fa-flag"></i> <?php echo $prod[$i]['Estatus']; ?></a>
	 						  <a style=" margin-left: 5px;"onClick="window.open('miscompras.php','_self')" href="javascript:void(0);" class="btn btn-sm btn-info btn-flat pull-left"><i class="fa fa-expeditedssl"></i> Mis compras</a>
								<?php if($idE == 1){ ?>
									<a onClick="window.open('comprar.php?idCompra=<?php echo time().$prod[$i]['IdCompra']; ?>','_self')" href="javascript:void(0);" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-fw fa-cart-plus"></i> Comprar</a>
								<?php } ?>
								<?php if($msj == 1){ ?>
									<a style=" margin-left: 5px;"onClick="window.open('renovar.php?idCompra=<?php echo time().$prod[$i]['IdCompra']; ?>','_self')" href="javascript:void(0);" class="btn btn-sm btn-primary btn-flat pull-left"><i class="fa fa-play-circle"></i> Renovar paquete</a>
								<?php } ?>
	 						<a onClick="mostrarLista(<?php echo $prod[$i]['IdCompra']; ?>)" href="javascript:void(0);" style="margin-right: 5px;" class="btn btn-sm btn-primary btn-flat pull-right"><i class="fa fa-users"></i> Alumnos</a>
	 					</div>
	           </div>
	         </div>
			<?php } ?>
      	</div>
			</section>

		</div>

		 <div id="dataEva"  class="modal fade">
		 		 <div class="modal-dialog">
		 					<div class="modal-content">
		 							 <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
		 										<button type="button" class="close" data-dismiss="modal">&times;</button>
		 										<h4 class="modal-title"><i class="fa fa-fw fa-flag-checkered"></i> Lista de alumnos dados de alta</h4>
		 							 </div>
		 							 <div class="modal-body" id="employee_eva">
		 							 </div>
		 					</div>
		 		 </div>
		 </div>
	  <?php include("footer.php"); ?>
	</div>

<!-- jQuery 3 -->

<script>
function mostrarLista(IdCompra){
	$.ajax({
			 url:"reportes/listaAlumnos.php",
			 method:"POST",
			 data:{IdCompra:IdCompra},
			 success:function(data){
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
			 }
	});
}

    $(function () {
      var Disponible = document.getElementById("txtDispo").value;
      var Ocupado = document.getElementById("txtOcupa").value;

  		// -------------
    // - PIE CHART -
    // -------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
    var PieData        = [
      {
        value    : Ocupado,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Usuarios activos'
      },
      {
        value    : Disponible,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Espacios disponibles'
      }
    ];
    var pieOptions     = {
      // Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      // String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      // Number - The width of each segment stroke
      segmentStrokeWidth   : 1,
      // Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      // Number - Amount of animation steps
      animationSteps       : 100,
      // String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      // Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      // Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      // Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : false,
      // String - A legend template
      legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
      // String - A tooltip template
      tooltipTemplate      : '<%=value %> <%=label%>'
    };
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    // -----------------
    // - END PIE CHART -
    // -----------------

  	});

</script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="bower_components/chart.js/Chart.js"></script>
<!-- Page script -->
</body>
</html>
