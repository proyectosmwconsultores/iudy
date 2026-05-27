<?php $valor = 1; $section = "Registro actividad"; include("head.php");
if($_SESSION['Permisos']) {
  $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está observando el reporte de analitica');
$datos = 1;
$oferta=$t->get_OfertaE();
$pendiente=$t->get_valorTotal(1, $_POST["txtOferta"]);
$proceso=$t->get_valorTotal(2, $_POST["txtOferta"]);
$revision=$t->get_valorTotal(3, $_POST["txtOferta"]);
$recargos= 0; $tiempo = 0; $procesoT = 0; $revisionT = 0;
$userR = 0; $userT = 0; $userP = 0; $userV = 0;

for ($i=0;$i< sizeof($pendiente);$i++) {
  $descuento=$espacio->get_misDescuentoId($pendiente[$i]["IdPago"]);
  $des = $descuento[0]["Descuento"];
  if($pendiente[$i]["Recargos"]){
    $userR = $userR + 1;
    $recargos = $recargos + $pendiente[$i]["Recargos"] + $pendiente[$i]["Pagar"] - $des;
  } else {
    $tiempo = $tiempo + $pendiente[$i]["Pagar"] - $des;
    $userT = $userT + 1;
  }
}

for ($i=0;$i< sizeof($proceso);$i++) {
  $descuento=$espacio->get_misDescuentoId($proceso[$i]["IdPago"]);
  $des = $descuento[0]["Descuento"];
  $procesoT = $procesoT + $proceso[$i]["Recargos"] + $proceso[$i]["Pagar"] - $des;
  $userP = $userP + 1;
}

for ($i=0;$i< sizeof($revision);$i++) {
  $descuento=$espacio->get_misDescuentoId($revision[$i]["IdPago"]);
  $des = $descuento[0]["Descuento"];
  $revisionT = $revisionT + $revision[$i]["Recargos"] + $revision[$i]["Pagar"] - $des;
  $userV = $userV + 1;
}


if(isset($_POST["Mov"]) && $_POST["Mov"]=="Buscar"){
  $ingresos=$t->get_ingresos($_POST[txtAnio],$_POST[txtMes]);
  if($ingresos[0]["Total"]){
    $datos = 2;
  }else{
    $datos = 3;
  }
}
$Fe = date("Y-m-d");
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
          Reporte de anal&iacute;tica
          <small>Saldos</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Inicio</a></li>
          <li class="active">Anal&iacute;tica</li>
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
              <form name="frm" id="frm" action="repAnalitica.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
              <input id="Mes" name="Mes" value="<?php echo obtenerAnioMes($Fe); ?>" type="hidden"/>
                <div class="col-md-16">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Oferta educativa: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtOferta" id="txtOferta" onchange="document.frm.submit();">
          							<option value=""> - Seleccione - </option>
          							<?php for ($i=0;$i< sizeof($oferta);$i++) { ?>
          							<option value="<?php echo $oferta[$i]["IdEducativa"]; ?>"<?php if($_POST["txtOferta"]==$oferta[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $oferta[$i]["Nombre"]; ?></option>
          							<?php } ?>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
              </form>
            </div>
          </div>
          <div class="box-body">
            <?php if($_POST["txtOferta"]) { ?>
            <div class="row">
                <div class="col-md-12">
                  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                  <div class="box-body no-padding">
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr>
                            <th></th>
                            <th>En tiempo | <?php echo $userT; ?></th>
                            <th>Con recargos | <?php echo $userR; ?></th>
                            <th>En proceso | <?php echo $userP; ?> </th>
                            <th>En revisión | <?php echo $userV; ?> </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Montos totales:</th>
                                <td class="view_data" href="javascript:void(0);" name="view" value="view" id="1" style=" cursor: pointer; text-align: center;"><?php echo $tiempo; ?></td>
                                <td class="view_data" href="javascript:void(0);" name="view" value="view" id="4" style=" cursor: pointer; text-align: center;"><?php echo $recargos; ?></td>
                                <td class="view_data" href="javascript:void(0);" name="view" value="view" id="2" style=" cursor: pointer; text-align: center;"><?php echo $procesoT; ?></td>
                                <td class="view_data" href="javascript:void(0);" name="view" value="view" id="3" style=" cursor: pointer; text-align: center;"><?php echo $revisionT; ?></td>
                            </tr>

                        </tbody>
                      </table>
                    </div>
                </div>
            </div>
            <script>
              var Tipo = document.getElementById("Tipo").value;
              var Mes = document.getElementById("Mes").value;
              Highcharts.chart('container', {
                data: {
                  table: 'datatable'
                },
                chart: {
                  type: 'column'
                },
                title: {
                  text: Tipo + '<br>' + 'Reporte de análitica en la plataforma del mes de ' + Mes
                },
                yAxis: {
                  allowDecimals: false,
                  title: {
                    text: 'Montos'
                  }
                }
              });
            </script>
          <?php } else { ?>
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
  <div id="dataModal" class="modal fade"> <!--MODAL ME GUSTA-->
    <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-body" id="employee_detail"></div>
     </div>
    </div>
   </div>

<script>
  $(document).ready(function(){
    $(document).on('click', '.view_data', function(){
      var employee_id = $(this).attr("id");
      var IdOferta = document.getElementById("txtOferta").value;
      if(employee_id != ''){
        $.ajax({
          url:"formConsulta/viewAnalitica.php",
          method:"POST",
          data:{employee_id:employee_id, IdOferta:IdOferta},
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
