<?php $_v = 50; $section = "Mis compras"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de productos.'); }
// if(isset($_GET['idDetalle'])){
//   $t->get_validarDatos($_GET['idToks']);
// }
$prod=$t->get_misCompras($_SESSION['IdUsua']);

?> 

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content-header">
				<h1>
					Mis compras realizadas en la Plataforma MWComenius
				</h1>
			</section>
			<section class="content">
				<div class="row">

      </div>


				<div class="row">

						 <div class="col-md-12">
	           <div class="box">
							 <div class="box box-primary">
			            <div class="box-header with-border">
			              <h3 class="box-title">Lista de compras realizadas</h3>
			            </div>
			            <div class="box-body">
										<table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Paquete</th>
									<th>Tipo compra</th>
									<th>Vigencia</th>
									<th>Estatus</th>
									<th>Fec. compra</th>
                  <th>Monto</th>
                </tr>
								<?php $m = 0; for ($i=0;$i< sizeof($prod);$i++) {
									if($prod[$i]['IdTipo'] == 1){ $valT = 'Nueva compra'; } elseif($prod[$i]['IdTipo'] == 2){ $valT = 'Renovación de la compra'; } elseif($prod[$i]['IdTipo'] == 3){ $valT = 'Actualización del paquete'; }
									?>
                <tr>
                  <td><?php echo $m = ($m + 1); ?></td>
									<td>Paquete <?php echo $prod[$i]['Paquete']; ?></td>
									<td><?php echo $valT; ?></td>
									<td><?php echo $prod[$i]['Vigencia']; ?></td>
									<td><?php echo $prod[$i]['Estatus']; ?></td>
									<td><?php echo $prod[$i]['FecCap']; ?></td>
                  <td><?php echo $prod[$i]['Monto']; ?></td>
                </tr>
								<?php } ?>
              </tbody></table>


			            </div>
			          </div>
	           </div>
	         </div>

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
