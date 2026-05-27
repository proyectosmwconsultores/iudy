<?php $_v = 31; $section = "Mi dashboard"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está en el módulo de productos.'); }
$lst1=$t->get_lstSum1($_SESSION['IdUsua']);
$lst2=$t->get_lstSum2($_SESSION['IdUsua']);
$lst3=$t->get_lstSum3($_SESSION['IdUsua']);
$lst4=$t->get_lstSum4($_SESSION['IdUsua']);

$lstA=$t->get_lst_Use($_SESSION['IdUsua'],8);
$lstI=$t->get_lst_Use($_SESSION['IdUsua'],50);
$gra1=$t->get_lstGra1($_SESSION['IdUsua']);
$prod=$t->get_producto($_SESSION['IdUsua']);

$lstGA=$t->get_lstGrpA($_SESSION['IdUsua'],8);
$lstGG=$t->get_lstGrpA($_SESSION['IdUsua'],55);

$porInd = (100 / $prod[0]['Total']);
$avance = ($porInd * $prod[0]['Activos']);

$lstMA=$t->get_lst_MatA($_SESSION['IdUsua'],8);
$tMatA = $lstMA[0]['Total'];

$mToA = 10;
if($tMatA < 10){
	$porInd_a = (100 / $mToA);
	$avance_a = ($porInd_a * $tMatA);
} else {
	$mToA = 20;
	$porInd_a = (100 / $mToA);
	$avance_a = ($porInd_a * $tMatA);
}

$lstMF=$t->get_lst_MatA($_SESSION['IdUsua'],26);
$tMatF = $lstMF[0]['Total'];

$mToF = 10;
if($tMatF < 10){
	$porInd_f = (100 / $mToF);
	$avance_f = ($porInd_f * $tMatF);
} else {
	$mToF = 20;
	$porInd_f = (100 / $mToF);
	$avance_f = ($porInd_f * $tMatF);
}

$lstC=$t->get_lstSum5($_SESSION['IdUsua']);
$tCic = $lstC[0]['Total'];

$mCicT = 10;
if($tCic < 10){
	$porCic = (100 / $mCicT);
	$avance_c = ($porCic * $tCic);
} else {
	$mCicT = 20;
	$porCic = (100 / $mCicT);
	$avance_c = ($porCic * $tCic);
}

?>

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">
			<?php if($_SESSION['comEst'] == 1){ include("formConsulta/msjCompra.php"); } ?>
			<section class="content-header">
				<h1>
					Mi dashboard en la Plataforma MWComenius
				</h1>
			</section>
			<section class="content">
				<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onClick="mostrarCampus()" href="javascript:void(0);" style="cursor: pointer;">
            <span class="info-box-icon bg-aqua"><i class="fa fa-fw fa-bank"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text">Escuela / Campus</span><br>
              <span class="info-box-number"><?php echo $lst1[0]['Total']; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onClick="mostrarMaterias()" href="javascript:void(0);" style="cursor: pointer;">
            <span class="info-box-icon bg-red"><i class="fa fa-fw fa-gears"></i></span>

            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text">Materias</span>
              <span class="info-box-number"><?php echo $lst2[0]['Total']; ?></span>
            </div>
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onClick="mostrarGrupos(0)" href="javascript:void(0);" style="cursor: pointer;">
            <span class="info-box-icon bg-green"><i class="fa fa-fw fa-puzzle-piece"></i></span>
            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text">Grupos</span>
              <span class="info-box-number"><?php echo $lst3[0]['Total']; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onClick="mostrarAlumnos(0)" href="javascript:void(0);" style="cursor: pointer;">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content" style="text-align: center;">
              <span class="info-box-text">Alumnos</span>
              <span class="info-box-number"><?php echo $lst4[0]['Total']; ?></span>
            </div>
          </div>
        </div>
      </div>

			<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Usuarios activos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <p class="text-center">
                    <strong>Panel de usuarios activos por grupo</strong>
                  </p>

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 180px; width: 699px;" height="180" width="699"></canvas>
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <p class="text-center">
                    <strong>Tabulador</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">Espacio en MWComenius</span>
                    <span class="progress-number"><b><?php echo $prod[0]['Activos']; ?></b>/<?php echo $prod[0]['Total']; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-aqua" style="width: <?php echo $avance; ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Clases activas</span>
                    <span class="progress-number"><b><?php echo $tMatA; ?></b>/<?php echo $mToA; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" style="width: <?php echo $avance_a; ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Clases finalizadas</span>
                    <span class="progress-number"><b><?php echo $tMatF; ?></b>/<?php echo $mToF; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" style="width: <?php echo $avance_f; ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">Ciclos escolares</span>
                    <span class="progress-number"><b><?php echo $lstC[0]['Total']; ?></b>/<?php echo $mCicT; ?></span>

                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" style="width: <?php echo $avance_c; ?>%"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-3 col-xs-6" onClick="mostrarAlumnos(8)" href="javascript:void(0);" style="cursor: pointer;">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i></span>
                    <h5 class="description-header"><?php echo $lstA[0]['Total']; ?></h5>
                    <span class="description-text">Alumnos activos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
								<div class="col-sm-3 col-xs-6" onClick="mostrarAlumnos(50)" href="javascript:void(0);" style="cursor: pointer;">
                  <div class="description-block">
                    <span class="description-percentage text-red"><i class="fa fa-caret-down"></i></span>
                    <h5 class="description-header"><?php echo $lstI[0]['Total']; ?></h5>
                    <span class="description-text">Alumnos bloqueados</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6" onClick="mostrarGrupos(8)" href="javascript:void(0);" style="cursor: pointer;">
                  <div class="description-block border-right">
                    <span class="description-percentage text-yellow"><i class="fa fa-caret-up"></i></span>
                    <h5 class="description-header"><?php echo $lstGA[0]['Total']; ?></h5>
                    <span class="description-text">Grupos activos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6" onClick="mostrarGrupos(55)" href="javascript:void(0);" style="cursor: pointer;">
                  <div class="description-block border-right">
                    <span class="description-percentage text-green"><i class="fa fa-caret-up"></i></span>
                    <h5 class="description-header"><?php echo $lstGG[0]['Total']; ?></h5>
                    <span class="description-text">Grupos graduados</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->

              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>


			</section>

		</div>

		 <div id="dataEva"  class="modal fade">
		 		 <div class="modal-dialog">
		 					<div class="modal-content">
		 							 <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
		 										<button type="button" class="close" data-dismiss="modal">&times;</button>
		 										<h4 class="modal-title"><i class="fa fa-fw fa-flag-checkered"></i> <b id='lbl_Pre'></b></h4>
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
function mostrarCampus(){
	$.ajax({
			 url:"dashboard/campus.php",
			 method:"POST",
			 data:{},
			 success:function(data){
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
			 }
	});
}

function mostrarMaterias(){
	$.ajax({
			 url:"dashboard/materias.php",
			 method:"POST",
			 data:{},
			 success:function(data){
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
			 }
	});
}

function mostrarGrupos(IdEstatus){
	$.ajax({
			 url:"dashboard/grupos.php",
			 method:"POST",
			 data:{IdEstatus:IdEstatus},
			 success:function(data){
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
			 }
	});
}

function mostrarAlumnos(IdEstatus){
	$.ajax({
			 url:"dashboard/alumnos.php",
			 method:"POST",
			 data:{IdEstatus:IdEstatus},
			 success:function(data){
						$('#employee_eva').html(data);
						$('#dataEva').modal('show');
			 }
	});
}


$(function () {

  'use strict';

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  // -----------------------
  // - MONTHLY SALES CHART -
  // -----------------------

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart       = new Chart(salesChartCanvas);

  var salesChartData = {
		// labels  : ['Enero', 'Febrero'],
		labels  : [<?php for ($i=0;$i< sizeof($gra1);$i++) { ?>'<?php echo $gra1[$i]['CveGrupo']; ?>',<?php } ?>],

    datasets: [
      {
        label               : 'Banco',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
				// data                : [90, 48]
        data                : [<?php for ($x=0;$x< sizeof($gra1);$x++) { echo $gra1[$x]['Total'].','; } ?>]
      }
    ]
  };

  var salesChartOptions = {
    // Boolean - If we should show the scale at all
    showScale               : true,
    // Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : false,
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
    bezierCurveTension      : 0.3,
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
    datasetStrokeWidth      : 2,
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard2.js"></script> -->
<!-- Page script -->
</body>
</html>
