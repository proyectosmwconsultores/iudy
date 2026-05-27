<?php $section = "Reporte de pagos aprobados pagos"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está visualizando el reporte de pagos aprobados'); }
if(isset($_GET['anio'])){ $_POST['txtAnio'] = $_GET['anio']; } else{ $_POST['txtAnio'] = ''; }
if(isset($_GET['campus'])){ $_POST['txtCampus'] = $_GET['campus']; } else{ $_POST['txtCampus'] = ''; }
if(isset($_GET['mes'])){ $_POST['txtMes'] = $_GET['mes']; } else{ $_POST['txtMes'] = ''; }
$campus = $t->get_lstCampusAc();
$ing_mes=$t->get_ingresos_anio($_POST['txtAnio'],$_POST['txtCampus']);
$oferta=$t->get_ingresos_oferta($_POST['txtAnio'],$_POST['txtCampus'],$_POST['txtMes']);
$forma=$t->get_ingresos_forma($_POST['txtAnio'],$_POST['txtCampus'],$_POST['txtMes']);
$dias=$t->get_ingresos_dias($_POST['txtAnio'],$_POST['txtCampus'],$_POST['txtMes']);

$_mes = "";
?>
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<!-- <script src="https://code.highcharts.com/highcharts-3d.js"></script> -->

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">

	<div class="wrapper">
		<?php include("menuV.php"); ?>
		<div class="content-wrapper">

      <section class="content-header">
				<h1>
					Dashborad de Ingresos <?php echo $_GET['anio']; ?>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-user"></i> Dashborad</a></li>
					<li class="active">Ingresoso</li>
				</ol>
			</section>
			<section class="content">
      <form name="frm" id="frm" action="dashboard.php" method="POST" enctype="multipart/form-data">
	      <div class="box box-default">
	        <div class="box-body">
	          <div class="row">
	            <div class="col-md-2">
	              <div class="box-primary">

	              </div>
	            </div>




	            <div class="col-md-6">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Campus:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
											<select class="form-control" name="txtCampus" id="txtCampus" onchange="sel_campus(<?php echo $_POST['txtAnio']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($campus);$i++) { ?>
												<option value="<?php echo $campus[$i]["IdCampus"]; ?>"<?php if(isset($_POST["txtCampus"])){ if($_POST["txtCampus"]==$campus[$i]["IdCampus"]){  ?>selected="selected"<?php } } ?>><?php echo $campus[$i]["Campus"]; ?></option>
												<?php } ?>
											</select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>
              <div class="col-md-4">
	              <div class="box-primary">
	                <div class="box-body">
	                <div class="form-group">
	                  <label>Mes:</label>
	                  <div class="input-group">
	                    <div class="input-group-addon"><i class="fa fa-book"></i></div>
											<select class="form-control" name="txtMes" id="txtMes" onchange="sel_mes(<?php echo $_POST['txtAnio']; ?>,<?php echo $_POST['txtCampus']; ?>)">
												<option value=""> - Seleccione - </option>
												<?php for ($i=0;$i< sizeof($ing_mes);$i++) { ?>
												<option value="<?php echo $ing_mes[$i]["IdMes"]; ?>"<?php if(isset($_POST["txtMes"])){ if($_POST["txtMes"]==$ing_mes[$i]["IdMes"]){ $_mes = $ing_mes[$i]["Mes"]  ?>selected="selected"<?php } } ?>><?php echo $ing_mes[$i]["Mes"]; ?></option>
												<?php } ?>
											</select>
	                  </div>
	                </div>
	                </div>
	              </div>
	            </div>

              <div class="col-md-12">
                <div id="container1x" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
              <div class="col-md-6">
                  <div id="container"></div>
              </div>
              <div class="col-md-6">
                  <div id="container_forma"></div>
              </div>
              <div class="col-md-12">
                <div id="container_dias" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
              </div>
	          </div>
	        </div>
	      </div>
        <input type="hidden" name="_mes" id="_mes" value="<?php echo $_mes; ?>">
        <input type="hidden" name="_anio" id="_anio" value="<?php echo $_GET['anio']; ?>">
	    </form>
    </section>

		</div>



	  <?php include("footer.php"); ?>
	</div>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- Sparkline -->

	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
  <script>
  function sel_campus(Anio){
    var IdCampus = document.getElementById("txtCampus").value;
    parent.location.href='dashboard.php?anio='+Anio+'&campus='+IdCampus; //direcciona la pagina madre
  }

  function sel_mes(Anio,IdCampus){
    var Mes = document.getElementById("txtMes").value;
    parent.location.href='dashboard.php?anio='+Anio+'&campus='+IdCampus+'&mes='+Mes; //direcciona la pagina madre
  }

  var Mes = document.getElementById('_mes').value;

  var Fecha = "Ingresos por plan de estudios";
  var Forma = "Formas de pagos";

Highcharts.chart('container', {
 chart: {
   type: 'pie',
   options3d: {
     enabled: true,
     alpha: 45,
     beta: 0
   }
 },
 title: {
   text: Mes
 },
 subtitle: {
   text: Fecha
 },
 accessibility: {
   point: {
     valueSuffix: '%'
   }
 },
 tooltip: {
   pointFormat: '{series.name}: <b> ${point.y} ({point.percentage:.1f}%)</b>'
 },
 plotOptions: {
   pie: {
     allowPointSelect: true,
     cursor: 'pointer',
     depth: 35,
     dataLabels: {
       enabled: true,
       format: '<b>{point.name}</b>: ${point.y} ({point.percentage:.1f}%)'
     }
   }
 },
 series: [{
   type: 'pie',
   name: 'Total ingresos',
       data: [
               <?php $vx = 0; $_comx = ''; for ($x=0;$x< sizeof($oferta);$x++) { $_comx = ','; $vx = ($vx + 1);  ?>
                 {
                   name: '<?php echo $oferta[$x]['Nombre']; ?>',
                   y: <?php echo $oferta[$x]['Total']; ?><?php echo $_comx; ?>
                   <?php if($vx == 1){ ?>
                   sliced: true,
                   selected: true
                   <?php } ?>
                 } <?php echo $_comx; $_comx = '';  ?>
               <?php } ?>
           ]
 }]
});

Highcharts.chart('container_forma', {
  chart: {
     type: 'pie',
     options3d: {
       enabled: true,
       alpha: 45
     }
   },
   title: {
     text: Mes
   },
   subtitle: {
     text: Forma
   },
   plotOptions: {
     pie: {
       innerSize: 100,
       depth: 45
     }
   },
   tooltip: {
     pointFormat: '{series.name}: <b> ${point.y} ({point.percentage:.1f}%)</b>'
   },
   plotOptions: {
     pie: {
       innerSize: 100,
       depth: 45,
       allowPointSelect: true,
       cursor: 'pointer',
       // depth: 35,
       dataLabels: {
         enabled: true,
         format: '<b>{point.name}</b>: ${point.y} ({point.percentage:.1f}%)'
       }
     }
   },
 series: [{
   type: 'pie',
   name: 'Total',
       data: [
               <?php $vx = 0; $_comx = ''; for ($x=0;$x< sizeof($forma);$x++) { $_comx = ','; $vx = ($vx + 1);  ?>
                 {
                   name: '<?php echo $forma[$x]['Descripcion']; ?>',
                   y: <?php echo $forma[$x]['sumTotal']; ?><?php echo $_comx; ?>
                   <?php if($vx == 1){ ?>
                   sliced: true,
                   selected: true
                   <?php } ?>
                 } <?php echo $_comx; $_comx = '';  ?>
               <?php } ?>
           ]
 }]
});

var Anio = document.getElementById('_anio').value;
  Highcharts.chart('container1x', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total de ingresos por mes'
    },
    subtitle: {
      text: 'Año: '+Anio
    },
    plotOptions: {
      column: {
        depth: 25
      }
    },

    xAxis: {
      categories:['Mes'],
      labels: {
        skew3d: true,
        style: {
          fontSize: '16px'
        }
      }
    },
    yAxis: {
      title: {
        text: null
      }
    },
    series: [
            <?php $v = 0; $_com = ''; for ($x=0;$x< sizeof($ing_mes);$x++) { $_com = ','; $v = ($v + 1);  ?>
              {
                name: '<?php echo $ing_mes[$x]['Mes']; ?>',
                data: [<?php echo $ing_mes[$x]['ingresosMes']; ?>]
              } <?php echo $_com; $_com = ''; } ?>
            ]
  });

  Highcharts.chart('container_dias', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Total de ingresos por mes'
    },
    subtitle: {
      text: 'Año: '+Anio
    },
    plotOptions: {
      column: {
        depth: 25
      }
    },

    xAxis: {
      categories:['Días'],
      labels: {
        skew3d: true,
        style: {
          fontSize: '16px'
        }
      }
    },
    yAxis: {
      title: {
        text: null
      }
    },
    series: [
            <?php $v = 0; $_com = ''; for ($x=0;$x< sizeof($dias);$x++) { $_com = ','; $v = ($v + 1);  ?>
              {
                name: '<?php echo $dias[$x]['FecPago']; ?>',
                data: [<?php echo $dias[$x]['totalDia']; ?>]
              } <?php echo $_com; $_com = ''; } ?>
            ]
  });
  </script>
</body>
</html>
<?php unset($_SESSION['Alerta']);  ?>
