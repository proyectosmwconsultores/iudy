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
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <style>
  .highcharts-figure, .highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
  }

  .highcharts-data-table table {
  	font-family: Verdana, sans-serif;
  	border-collapse: collapse;
  	border: 1px solid #EBEBEB;
  	margin: 10px auto;
  	text-align: center;
  	width: 100%;
  	max-width: 500px;
  }
  .highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
  }
  .highcharts-data-table th {
  	font-weight: 600;
    padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }


  input[type="number"] {
  	min-width: 50px;
  }
  </style>
  <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description">
      Pie charts are very popular for showing a compact overview of a
      composition or comparison. While they can be harder to read than
      column charts, they remain a popular choice for small datasets.
    </p>
  </figure>
  <script>
  Highcharts.chart('container', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Browser market shares in January, 2018'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Brands',
      colorByPoint: true,
      data: [{
        name: 'Chrome',
        y: 61.41,
        sliced: true,
        selected: true
      }, {
        name: 'Internet Explorer',
        y: 11.84
      }, {
        name: 'Firefox',
        y: 10.85
      }, {
        name: 'Edge',
        y: 4.67
      }, {
        name: 'Safari',
        y: 4.18
      }, {
        name: 'Sogou Explorer',
        y: 1.64
      }, {
        name: 'Opera',
        y: 1.6
      }, {
        name: 'QQ',
        y: 1.2
      }, {
        name: 'Other',
        y: 2.61
      }]
    }]
  });
  </script>
