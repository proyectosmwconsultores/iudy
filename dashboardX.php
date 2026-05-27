<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos aprobados'); }
$bancos=$t->get_bancos();

?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link href="assets/table/css/animate.css" rel="stylesheet">
<link href="assets/table/css/style.css" rel="stylesheet">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<section class="content">
				<form name="frm" id="frm" action="dashboard.php" method="POST" enctype="multipart/form-data">
					<div class="row">
		        <div class="col-md-12">
		          <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Tablero de ingresos</h3><br><br>
									<div class="btn-group">
										<button type="button" value="1" name="mes1" id="mes1" onclick="enviarValor(1,mes1)" class="btn btn-success"> Ene</button>
										<button type="button" value="1" name="mes2" id="mes2" onclick="enviarValor(2,mes2)" class="btn btn-success">Feb</button>
										<button type="button" value="1" name="mes3" id="mes3" onclick="enviarValor(3,mes3)" class="btn btn-success">Mar</button>
										<button type="button" value="1" name="mes4" id="mes4" onclick="enviarValor(4,mes4)" class="btn btn-success">Abr</button>
										<button type="button" value="1" name="mes5" id="mes5" onclick="enviarValor(5,mes5)" class="btn btn-success">May</button>
										<button type="button" value="1" name="mes6" id="mes6" onclick="enviarValor(6,mes6)" class="btn btn-success">Jun</button>
										<button type="button" value="1" name="mes7" id="mes7" onclick="enviarValor(7,mes7)" class="btn btn-success">Jul</button>
										<button type="button" value="1" name="mes8" id="mes8" onclick="enviarValor(8,mes8)" class="btn btn-success">Ago</button>
										<button type="button" value="1" name="mes9" id="mes9" onclick="enviarValor(9,mes9)" class="btn btn-success">Sep</button>
										<button type="button" value="1" name="mes10" id="mes10" onclick="enviarValor(10,mes10)" class="btn btn-success">Oct</button>
										<button type="button" value="1" name="mes11" id="mes11" onclick="enviarValor(11,mes11)" class="btn btn-success">Nov</button>
										<button type="button" value="1" name="mes12" id="mes12" onclick="enviarValor(12,mes12)" class="btn btn-success">Dic</button>
										<div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          Seleccione año:  <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="#">2019</a></li>
                          <li><a href="#">2020</a></li>
                        </ul>
                      </div>
									</div>
		              <div class="box-tools pull-right">
		                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
		              </div>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <div class="row">
		                <div class="col-md-12">
		                  <p class="text-center">
		                    <strong>Ingresos de Enero a Diciembre de 2019</strong>
		                  </p>
		                  <div class="chart">
		                    <canvas id="salesChart" style="height: 180px;"></canvas>
		                  </div>


											<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
		                </div>

		              </div>
		              <!-- /.row -->
		            </div>
		            <!-- ./box-body -->
		            <div class="box-footer">
		              <div class="row">
		                <div class="col-sm-2 col-xs-6">
		                  <div class="description-block border-right">
		                    <span class="description-percentage text-green">Enero</span>
												<span class="description-percentage text-yellow"> 0%</span>
		                    <h5 class="description-header">Caja:</h5>
		                    <span class="description-text">Banamex:</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-2 col-xs-6">
		                  <div class="description-block border-right">
		                    <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
		                    <h5 class="description-header">$10,390.90</h5>
		                    <span class="description-text">TOTAL COST</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-2 col-xs-6">
		                  <div class="description-block border-right">
		                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
		                    <h5 class="description-header">$24,813.53</h5>
		                    <span class="description-text">TOTAL PROFIT</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
		                <!-- /.col -->
		                <div class="col-sm-2 col-xs-6">
		                  <div class="description-block">
		                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
		                    <h5 class="description-header">1200</h5>
		                    <span class="description-text">GOAL COMPLETIONS</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
										<div class="col-sm-2 col-xs-6">
		                  <div class="description-block">
		                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
		                    <h5 class="description-header">1200</h5>
		                    <span class="description-text">GOAL COMPLETIONS</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
										<div class="col-sm-2 col-xs-6">
		                  <div class="description-block">
		                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
		                    <h5 class="description-header">1200</h5>
		                    <span class="description-text">GOAL COMPLETIONS</span>
		                  </div>
		                  <!-- /.description-block -->
		                </div>
		              </div>
		              <!-- /.row -->
		            </div>
		            <!-- /.box-footer -->
		          </div>
		          <!-- /.box -->
		        </div>
		        <!-- /.col -->
		      </div>
	      </form>
      </section>

		</div>



	  <?php include("footer.php"); ?>
	</div>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- FastClick -->
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- Sparkline -->
	<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
	<!-- jvectormap  -->
	<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	<!-- SlimScroll -->
	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- ChartJS -->
	<script src="bower_components/chart.js/Chart.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
<!-- <script src="dist/js/pages/dashboard2.js"></script>
<script src="bower_components/chart.js/Chart.js"></script>

<script src="dist/js/adminlte.min.js"></script>

<script src="dist/js/demo.js"></script> -->
<!-- Page script -->

<script>
$(function () {
	crearGrafica(0,0);
});

function enviarValor(mes,valor){
	  var valorIngreso = valor.value;
		var valorEnvio = 0;
		if(valorIngreso == 1){
			valorEnvio = 0;
		} else {
			valorEnvio = 1;
		}
		document.getElementById("mes"+mes).value = valorEnvio;
		//alert(valorIngreso);
		crearGrafica(mes,valorIngreso)
}

function crearGrafica(mes,valor) {
	var mesesAnio= new Array();
	var banco1= new Array();


  // 'use strict';

	mesesAnio[0]='Ene';
	mesesAnio[1]='Feb';
	mesesAnio[2]='Mar';
	mesesAnio[3]='Abr';
	mesesAnio[4]='May';
	mesesAnio[5]='Jun';
	mesesAnio[6]='Jul';
	mesesAnio[7]='Ago';
	mesesAnio[8]='Sep';
	mesesAnio[9]='Oct';
	mesesAnio[10]='Nov';
	mesesAnio[11]='Dic';


	<?php  for ($i=0;$i< sizeof($bancos);$i++) {
		$meses01=$t->get_mesesLst(2019,"01",$bancos[$i]["IdBanco"]);
		$meses02=$t->get_mesesLst(2019,"02",$bancos[$i]["IdBanco"]);
		$meses03=$t->get_mesesLst(2019,"03",$bancos[$i]["IdBanco"]);
		$meses04=$t->get_mesesLst(2019,"04",$bancos[$i]["IdBanco"]);
		$meses05=$t->get_mesesLst(2019,"05",$bancos[$i]["IdBanco"]);
		$meses06=$t->get_mesesLst(2019,"06",$bancos[$i]["IdBanco"]);
		$meses07=$t->get_mesesLst(2019,"07",$bancos[$i]["IdBanco"]);
		$meses08=$t->get_mesesLst(2019,"08",$bancos[$i]["IdBanco"]);
		$meses09=$t->get_mesesLst(2019,"09",$bancos[$i]["IdBanco"]);
		$meses10=$t->get_mesesLst(2019,"10",$bancos[$i]["IdBanco"]);
		$meses11=$t->get_mesesLst(2019,"11",$bancos[$i]["IdBanco"]);
		$meses12=$t->get_mesesLst(2019,"12",$bancos[$i]["IdBanco"]);
		if($i == 0){
			$todos = $mes1.$mes2.$mes3.$mes4.$mes5.$mes6.$mes7.$mes8;
		}

	}
	?>

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart       = new Chart(salesChartCanvas);

  var salesChartData = {
		// labels  : [Ene, Feb, Mar, Abr, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic],
	//	labels  : [<?php echo $linea; ?>],
   labels  : mesesAnio,
    datasets: [

			<?php  for ($i=0;$i< sizeof($bancos);$i++) {
				$meses01=$t->get_mesesLst(2019,"01",$bancos[$i]["IdBanco"]);
				$meses02=$t->get_mesesLst(2019,"02",$bancos[$i]["IdBanco"]);
				$meses03=$t->get_mesesLst(2019,"03",$bancos[$i]["IdBanco"]);
				$meses04=$t->get_mesesLst(2019,"04",$bancos[$i]["IdBanco"]);
				$meses05=$t->get_mesesLst(2019,"05",$bancos[$i]["IdBanco"]);
				$meses06=$t->get_mesesLst(2019,"06",$bancos[$i]["IdBanco"]);
				$meses07=$t->get_mesesLst(2019,"07",$bancos[$i]["IdBanco"]);
				$meses08=$t->get_mesesLst(2019,"08",$bancos[$i]["IdBanco"]);
				$meses09=$t->get_mesesLst(2019,"09",$bancos[$i]["IdBanco"]);
				$meses10=$t->get_mesesLst(2019,"10",$bancos[$i]["IdBanco"]);
				$meses11=$t->get_mesesLst(2019,"11",$bancos[$i]["IdBanco"]);
				$meses12=$t->get_mesesLst(2019,"12",$bancos[$i]["IdBanco"]);


				if($i == 0){
					$fillColor = "rgb(210, 214, 222)"; $strokeColor = "rgb(210, 214, 222)"; $pointColor = "rgb(210, 214, 222)"; $pointStrokeColor= "#c1c7d1";
				}if($i == 1){
					$fillColor = "rgba(60,141,188,0.9)"; $strokeColor = "rgba(60,141,188,0.8)"; $pointColor = "#3b8bba"; $pointStrokeColor= "rgba(60,141,188,1)";
				}
				if($i == 2){
					$fillColor = "#00a65a80"; $strokeColor = "#00a65a"; $pointColor = "#00a65a80"; $pointStrokeColor= "#00a65a80";
				}if($i == 3){
					$fillColor = "#2f12f380"; $strokeColor = "#f39c12"; $pointColor = "#2f12f380"; $pointStrokeColor= "#2f12f380";
				}

				$mes1 = $_POST["mes1"];
				$mes2 = $_POST["mes2"];
				$mes3 = $_POST["mes3"];
				$mes4 = $_POST["mes4"];
				$mes5 = $_POST["mes5"];
				$mes6 = $_POST["mes6"];
				$mes7 = $_POST["mes7"];
				$mes8 = $_POST["mes8"];
				$mes9 = $_POST["mes9"];
				$mes10 = $_POST["mes10"];
				$mes11 = $_POST["mes11"];
				$mes12 = $_POST["mes12"];
				$Id = 4;
				?>
				<?php
				if($mes1 == 0){ $mes1 = $meses01[0]["Ingreso"].', '; } else { $mes1 = ""; }
				if($mes2 == 0){ $mes2 = $meses02[0]["Ingreso"].', '; } else { $mes2 = ""; }
				if($mes3 == 0){ $mes3 = $meses03[0]["Ingreso"].', '; } else { $mes3 = ""; }
				if($mes4 == 0){ $mes4 = $meses04[0]["Ingreso"].', '; } else { $mes4 = ""; }
				if($mes5 == 0){ $mes5 = $meses05[0]["Ingreso"].', '; } else { $mes5 = ""; }
				if($mes6 == 0){ $mes6 = $meses06[0]["Ingreso"].', '; } else { $mes6 = ""; }
				if($mes7 == 0){ $mes7 = $meses07[0]["Ingreso"].', '; } else { $mes7 = ""; }
				if($mes8 == 0){ $mes8 = $meses08[0]["Ingreso"].', '; } else { $mes8 = ""; }
				if($mes9 == 0){ $mes9 = $meses09[0]["Ingreso"].', '; } else { $mes9 = ""; }
				if($mes10 == 0){ $mes10 = $meses10[0]["Ingreso"].', '; } else { $mes10 = ""; }
				if($mes11 == 0){ $mes11 = $meses11[0]["Ingreso"].', '; } else { $mes11 = ""; }
				if($mes12 == 0){ $mes12 = $meses12[0]["Ingreso"].', '; } else { $mes12 = ""; }
				$todos = $mes1.$mes2.$mes3.$mes4.$mes5.$mes6.$mes7.$mes8.$mes9.$mes10.$mes11.$mes12;
			  //$todosT = $mes5.$mes2.$mes3.$mes4.$mes5.$mes6.$mes7.$mes8;
				  ?>


      {



        label               : '<?php echo $bancos[$i]["Banco"]; ?>',
        fillColor           : '<?php echo $fillColor; ?>',
        strokeColor         : '<?php echo $strokeColor; ?>',
        pointColor          : '<?php echo $pointColor; ?>',
        pointStrokeColor    : '<?php echo $pointStrokeColor; ?>',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgb(220,220,220)',

					data                : [<?php echo $todos; ?>]


			},
			<?php } ?>
    ]

  };


	  var salesChartOptions = {
	    // Boolean - If we should show the scale at all
	    showScale               : true,
	    // Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines      : true,
	    // String - Colour of the grid lines
	    scaleGridLineColor      : 'rgba(0,0,0,.05)',
	    // Number - Width of the grid lines
	    scaleGridLineWidth      : 1,
	    // Boolean - Whether to show horizontal lines (except X axis)
	    scaleShowHorizontalLines: true,
	    // Boolean - Whether to show vertical lines (except Y axis)
	    scaleShowVerticalLines  : true,
	    // Boolean - Whether the line is curved between points
	    bezierCurve             : true,
	    // Number - Tension of the bezier curve between points
	    bezierCurveTension      : 0.1,
	    // Boolean - Whether to show a dot for each point
	    pointDot                : false,
	    // Number - Radius of each point dot in pixels
	    pointDotRadius          : 4,
	    // Number - Pixel width of point dot stroke
	    pointDotStrokeWidth     : 1,
	    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
	    pointHitDetectionRadius : 20,
	    // Boolean - Whether to show a stroke for datasets
	    datasetStroke           : true,
	    // Number - Pixel width of dataset stroke
	    datasetStrokeWidth      : 1,
	    // Boolean - Whether to fill the dataset with a color
	    datasetFill             : true,
	    // String - A legend template
	    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
	    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio     : true,
	    // Boolean - whether to make the chart responsive to window resizing
	    responsive              : true

	  };

	  // Create the line chart
	  salesChart.Line(salesChartData, salesChartOptions);
	}
</script>

<script>
  $(function () {

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
