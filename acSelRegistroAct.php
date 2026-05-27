<?php $valor = 1; $section = "Registro actividad"; include("head.php");
if($_SESSION['Permisos']) {
$datos = 1;
$anios=$t->get_anios();
$meses=$t->get_meses();
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Buscar"){
  $ingresos=$t->get_ingresos($_POST["txtAnio"],$_POST["txtMes"]);
  if($ingresos[0]["Ingresos"]){
    $datos = 2;
  }else{
    $datos = 3;
  }
}
$Fe = $_POST["txtAnio"].'-'.$_POST["txtMes"].'-'.date("d");
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<script src="assets/grafica/highcharts.js"></script>
<script src="assets/grafica/data.js"></script>
<script src="assets/grafica/exporting.js"></script>
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Usuarios activos
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Usuarios</a></li>
          <li class="active">Usuarios activos</li>
        </ol>
      </section>
      <section class="content">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Búsqueda de información para la gráfica</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="acSelRegistroAct.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
              <input id="Mes" name="Mes" value="<?php echo obtenerAnioMes($Fe); ?>" type="hidden"/>
                <div class="col-md-4">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Año: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtAnio" id="txtAnio">
          							<?php for ($i=0;$i< sizeof($anios);$i++) { ?>
          							<option value="<?php echo $anios[$i]["Anio"]; ?>"<?php if($_POST[txtAnio]==$anios[$i]["Anio"]){?>selected="selected"<?php }?>><?php echo $anios[$i]["Anio"]; ?></option>
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
          						<label>Mes: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtMes" id="txtMes">
          							<option value=""> - Seleccione Mes - </option>
          							<?php for ($i=0;$i< sizeof($meses);$i++) { ?>
          							<option value="<?php echo $meses[$i]["IdMes"]; ?>"<?php if($_POST[txtMes]==$meses[$i]["IdMes"]){?>selected="selected"<?php }?>><?php echo $meses[$i]["Mes"]; $mes =  $meses[$i]["Mes"]; ?></option>
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
                      <label>&nbsp; </label>
                      <div class="input-group">
                        <button type="button" class="btn btn-primary" onClick="val_datosBusqueda()"> <i class="fa fa-fw fa-search"></i> Buscar</button>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="box-body">
            <?php if($datos == 2) { ?>
            <div class="row">
                <div class="col-md-12">
                  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                  <div class="box-body no-padding">
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                          <th>Fecha</th>
                          <th>Entradas en el día</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($ingresos);$i++) { ?>
                        <tr class="view_data" href="javascript:void(0);" name="view" value="view" id=<?php echo $ingresos[$i]["Dia"]; ?> style=" cursor: pointer;">
                          <th>
                            <?php echo obtenerFechaEnLetra($ingresos[$i]["Dia"]); ?>
                          </th>
                          <td><?php echo $ingresos[$i]["Ingresos"]; ?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
                    <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-body" id="employee_detail"></div>
                     </div>
                    </div>
                   </div>
                </div>
              <br><br><br><br>
            </div>
            <script>
              var Tipo = document.getElementById("Tipo").value;
              var Mes = document.getElementById("Mes").value;
              Highcharts.chart('container', {
                data: {
                  table: 'datatable'
                },
                chart: {
                  type: 'line'
                },
                title: {
                  text: Tipo + '<br>' + 'Gráfica de usuarios en la plataforma del mes de ' + Mes
                },
                yAxis: {
                  allowDecimals: false,
                  title: {
                    text: 'Ingresos'
                  }
                }
              });
            </script>
          <?php } elseif($datos == 3) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                No se encontraron registros en la búsqueda
              </div>
              <?php } ?>
          </div>
        </div>
      </section>
    </div>
    <?php include("footer.php"); ?>
  </div>
<script>
  $(document).ready(function(){
    $(document).on('click', '.view_data', function(){
      var employee_id = $(this).attr("id");
      if(employee_id != ''){
        $.ajax({
          url:"formConsulta/viewRegistro.php",
          method:"POST",
          data:{employee_id:employee_id},
          success:function(data) {
            $('#employee_detail').html(data);
            $('#dataModal').modal('show');
          }
        });
      }
    });
  });
</script>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
