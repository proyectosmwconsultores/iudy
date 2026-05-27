<?php $valor = 1; $section = "Registro tipo usuario"; include("head.php");
if($_SESSION['Permisos']) {
$datos = 1;
if(isset($_POST["Mov"]) && $_POST["Mov"]=="Buscar"){
  $ingresos=$t->get_tipoIngresos($_POST["datepicker"],$_POST["datepicker2"]);
  $ingresos_list=$t->get_tipo_total_user($_POST["datepicker"],$_POST["datepicker2"]);
  if($ingresos[0]["Total"]){
    $datos = 2;
  }else{
    $datos = 3;
  }
}

$Fe = $_POST["datepicker"].' al '.$_POST["datepicker2"];
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
          Entradas por tipo de usuarios
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Usuarios</a></li>
          <li class="active">Tipo de usuario</li>
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
              <form name="frm" id="frm" action="acSelTipoU.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
              <input id="Mes" name="Mes" value="<?php echo $Fe; ?>" type="hidden"/>
              <div class="col-md-5">
                <div class="box-primary">
                  <div class="box-body">
                  <div class="form-group">
                    <label>Fec. Inicial: </label>
                    <div class="input-group">
                      <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" value="<?php echo $_POST["datepicker"]; ?>" id="datepicker" name="datepicker">
                    </div>
                  </div>
                  </div>
                </div>
              </div>
                <div class="col-md-5">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Fec. Final: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-calendar"></i>
          						  </div>
                        <input type="text" class="form-control pull-right" value="<?php echo $_POST["datepicker2"]; ?>" id="datepicker2" name="datepicker2">
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>

                <div class="col-md-2">
                  <div class="box-primary">
                    <div class="box-body">
                    <div class="form-group">
                      <label>&nbsp; </label>
                      <div class="input-group">
                        <button type="button" class="btn btn-primary" onClick="val_datosBusquedaTipo()"> <i class="fa fa-fw fa-search"></i> Buscar</button>
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
                        <tr style="background: #d2d6de; color: black;">
                          <th>Tipo usuario</th>
                          <th>Entradas</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($ingresos);$i++) { ?>
                        <tr class="view_data" href="javascript:void(0);" name="view" value="view" id=<?php echo $_POST["datepicker"].'.'.$_POST["datepicker2"].'-'.$ingresos[$i]["Permisos"]; ?> style=" cursor: pointer;">
                          <th>
                            <?php echo $ingresos[$i]["Cargo"]; ?>
                          </th>
                          <td><?php echo $ingresos[$i]["Total"]; ?></td>
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
              <br>
              <div class="col-md-12">
                  <div style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                  <div class="box-body no-padding">
                    <table id="datatable" class="table table-striped">
                      <thead>
                        <tr style="background: #d2d6de; color: black;">
                          <th></th>
                          <th>USUARIO</th>
                          <th>NOMBRE</th>
                          <th>PATERNO</th>
                          <th>MATERNO</th>
                          <th>FECHA</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $v = 0; for ($i=0;$i< sizeof($ingresos_list);$i++) { ?>
                        <tr>
                          <td><b><?php echo $v = ($v + 1); ?>.- </b></td>
                          <td><?php echo $ingresos_list[$i]["Usuario"]; ?></td>
                          <td><?php echo $ingresos_list[$i]["Nombre"]; ?></td>
                          <td><?php echo $ingresos_list[$i]["APaterno"]; ?></td>
                          <td><?php echo $ingresos_list[$i]["AMaterno"]; ?></td>
                          <td><?php echo $ingresos_list[$i]["FecIng"]; ?></td>
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

              <br><br><br>
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
                  text: Tipo + '<br>' + 'Gráfica según tipo de usuario y rango de fecha de ' + Mes
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
          url:"formConsulta/viewRegistroTipo.php",
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

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker-->
<script src="bower_components/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Select2 -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
