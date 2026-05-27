<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $datos = $_POST["employee_id"];

  $pieces = explode("-", $datos);
  $IdUsua = $pieces[0];
  $IdAsignacion = $pieces[1];
  $IdModulo = $pieces[2];


  $sql_preguntas = $db->query("SELECT
tblx_respuesta.IdRespuesta,
tblx_respuesta.IdPregunta,
tblx_respuesta.Respuesta,
tblx_respuesta.FecCap,
tblx_respuesta.Texto,
tblx_pregunta.Pregunta,
tblx_pregunta._Tipo
FROM
tblx_respuesta
Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
WHERE
tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND tblx_respuesta.IdUsua = '$IdUsua'
");


$sql_graf = $db->query("SELECT
tblx_respuesta.IdRespuesta,
tblx_respuesta.IdPregunta,
tblx_respuesta.Respuesta,
tblx_pregunta.Pregunta,
tblx_pregunta._Tipo
FROM
tblx_respuesta Left Join tblx_pregunta ON tblx_pregunta.IdPregunta = tblx_respuesta.IdPregunta
WHERE
tblx_respuesta.IdAsignacion =  '$IdAsignacion' AND tblx_respuesta.IdUsua = '$IdUsua' AND tblx_pregunta._Tipo = '1'");

  ?>
  <style>
  #container {
  height: 400px;
}

.highcharts-figure, .highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

#datatable {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
#datatable caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
#datatable th {
	font-weight: 600;
  padding: 0.5em;
}
#datatable td, #datatable th, #datatable caption {
  padding: 0.5em;
}
#datatable thead tr, #datatable tr:nth-child(even) {
  background: #f8f8f8;
}
#datatable tr:hover {
  background: #f1f7ff;
}
  </style>
  <form class="form-horizontal" name="frm2xfYj" id="frm2xfYj" action="addPago.php" method="POST" enctype="multipart/form-data">
    <input id="IdUsua" name="IdUsua" value="<?php echo $IdUsua; ?>" type="hidden"/>
    <input id="IdUsuaCap" name="IdUsuaCap" value="<?php echo $_SESSION["IdUsua"]; ?>" type="hidden"/>

    <input id="TipoGuardar" name="TipoGuardar" value="savBeca" type="hidden"/>


  <div class="table-responsive">
    <table class="table table-bordered">
      <div class="box box-primary" style="border-top: none; margin-top: -45px;">
          <table class="table table-striped" style="font-size: 12px;">
                <tbody>
                  <tr style="background: #003A70; color: white; padding: 10px;">
                      <th colspan="6">Pregunta de la encuesta</th>
                  </tr>
                <?php $v = 0; while($_preg = $db->recorrer($sql_preguntas)){ $idPreg = $_preg['IdPregunta'];
                    $sql_res = $db->query("SELECT * FROM tblxx_respuesta WHERE tblxx_respuesta.IdPregunta = '$idPreg'");
                   ?>
                  <tr>
                      <td colspan="6"><b><?php echo $v = ($v + 1); ?>.- </b> <?php echo $_preg['Pregunta']; ?></td>
                  </tr>
                  <tr>
                      <td style="width: 100px; text-align: right;"><i class="fa fa-fw fa-clock-o"></i> <?php echo $_preg['FecCap']; ?></td>
                      <?php if($_preg['_Tipo'] == 1){ $pt = ''; while($_res = $db->recorrer($sql_res)){ ?>
                      <td <?php if($_res['Valor'] == $_preg['Respuesta']){ $pt = '('.$_res['Valor'].' pts)'; echo " style='background: red; color: white;'";} else { $pt = '';} ?>><?php echo $_res['Texto'].' '.$pt; ?></td>
                      <?php } }  else { ?>
                      <td colspan="5"><b style="color: blue;">Respuesta:</b> <?php echo $_preg['Texto']; ?></td>
                      <?php } ?>
                  </tr>

                <?php } ?>
              </tbody></table>


      </div>
    </table>
  </div>
<figure class="highcharts-figure">
  <div id="container"></div>
  <table id="datatable" style="display: none;">
    <thead>
      <tr>
        <th>Pregunta</th>
        <th>Pregunta</th>
      </tr>
    </thead>
    <tbody>
      <?php while($_gra = $db->recorrer($sql_graf)){  ?>
      <tr>
        <th><?php echo $_gra['Pregunta']; ?></th>
        <th><?php echo $_gra['Respuesta']; ?></th>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</figure>

  </form>

<script>
Highcharts.chart('container', {
  data: {
    table: 'datatable'
  },
  chart: {
    type: 'column'
  },
  title: {
    text: 'Resultados de la encuesta'
  },
  yAxis: {
    allowDecimals: false,
    title: {
      text: 'Puntos'
    }
  },
  tooltip: {
    formatter: function () {
      return '<b>Pregunta: </b> ' + this.point.name.toLowerCase() + ' <br> <b>Puntos: </b> ' + this.point.y;
    }
  }
});
</script>
