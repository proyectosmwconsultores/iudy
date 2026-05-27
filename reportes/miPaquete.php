<?php session_start();
  require('../php/clases/class.System.php');

  $db = new Conexion();
  $IdUsua = $_POST["IdUsua"];

  $sql8 = $db->query("SELECT
tblp_compra.IdCompra,
tblp_compra.Total,
tblp_compra.Activos,
tblc_estatus.Estatus,
tblc_paquete.Paquete
FROM
tblp_compra
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_compra.IdEstatus
Left Join tblc_paquete ON tblc_paquete.IdPaquete = tblp_compra.IdPaquete WHERE tblp_compra.IdUsua =  '$IdUsua' AND tblp_compra.IdEstatus =  '8'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdCompra = $datos81["IdCompra"];
  $total = $datos81["Total"];
  $ocupado = $datos81["Activos"];
  $disponible = ($total - $ocupado);


  ?>
  <input id="txtDispo" name="txtDispo" value="<?php echo $disponible; ?>" type="hidden"/>
<input id="txtOcupa" name="txtOcupa" value="<?php echo $ocupado; ?>" type="hidden"/>
  <div class="box-header with-border">
    <h3 class="box-title">Paquete <?php echo $datos81["Paquete"]; ?></h3>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>

  <div class="box-body">
    <div class="row">
      <div class="col-md-8">
        <div class="chart-responsive">
          <canvas id="pieChart" height="170" style="width: 204px; height: 170px;" width="204"></canvas>
        </div>
        <!-- ./chart-responsive -->
      </div>
      <!-- /.col -->
      <div class="col-md-4">
        <ul class="chart-legend clearfix">
          <li><i class="fa fa-circle-o text-yellow"></i> Ocupado</li>
          <li><i class="fa fa-circle-o text-light-blue"></i> Disponible</li>
        </ul>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.box-body -->
  <div class="box-footer no-padding">
    <ul class="nav nav-pills nav-stacked">
      <li><a onClick="mostrarLista(<?php echo $IdCompra; ?>)" href="javascript:void(0);">Ocupado<span class="pull-right text-red"><i class="fa fa-angle-down"></i> <?php echo $ocupado; ?></span></a></li>
      <li><a href="#">Disponible <span class="pull-right text-green"><i class="fa fa-angle-up"></i> <?php echo $disponible; ?></span></a></li>
    </ul>
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

  <script>


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
