
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
}
th {
    text-align: left;
}
td, th {
    padding: 0;
}
.datatable th, td {
    border: 1px solid silver;
    padding: 4px 24px;
}
</style>

<?php
echo "hola bb";
echo $_POST["Envio"];
 ?>

    <div class="col-md-4">
      <div id="container" style="min-width: 310px; height: 350px; margin: 0 auto"></div>
      <table id="datatable" name="datatable" style="width: 100%; display: none;">
        <thead>
          <tr>
            <th></th>
            <th>Caja</th>
            <th>Banorte</th>
            <th>Banamex</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th style="font-size: 12px;"> Enero </th>
            <td style="font-size: 12px;"> 120.00</td>
            <td style="font-size: 12px;"> 101 </td>
            <td style="font-size: 12px;"> 123</td>
          </tr>
          </tbody>
      </table>

    </div>


<script>

Highcharts.chart('container', {
  		data: {
  			table: 'datatable'
  		},

  		chart: {
  			type: 'column'
  		},
  		title: {
  			text: '<b>PLATAFORMA CECIS CERTIFIER<br>Gráfica con datos de </b><br> Con rango de fecha:  '
  		},
  		yAxis: {
  			allowDecimals: false,
  			title: {
  				text: 'Pesos'
  			}
  		},
  		tooltip: {
  			formatter: function () {
  				return '<b>' + this.series.name + '</b><br/>' +
  					'$ ' + this.point.y + '.00 ' + this.point.name;
  			}
  		}


  	});
</script>
