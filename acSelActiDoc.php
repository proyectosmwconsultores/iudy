<?php $valor = 1; $section = "Registro creación de actividades"; include("head.php");
if($_SESSION['Permisos']) {
$datos = 1;
$docentes=$t->get_Docentes();
$educativa=$t->get_educativaBus($_POST[txtDocente]);
$modulo=$t->get_moduloBus($_POST["txtDocente"],$_POST["txtEducativa"]);

if(isset($_POST["Mov"]) && $_POST["Mov"]=="Buscar"){
  $ingresos=$t->get_activiadescreadasDoc($_POST["txtModulo"]);
  if($ingresos[0]["IdTipoActividad"]){
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
          Registro
          <small>Avances de la creación de actividades por parte del asesor acad&eacute;mico</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Registro</a></li>
          <li class="active">Creación de actividades</li>
        </ol>
      </section>
      <section class="content">
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Búsqueda de información</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <form name="frm" id="frm" action="acSelActiDoc.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET[Mov];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Asesor acad&eacute;mico:: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtDocente" id="txtDocente" onchange="document.frm.submit();">
                          <option value="0"> - SELECCIONE -</option>
                          <?php for ($i=0;$i< sizeof($docentes);$i++) { ?>
          							<option value="<?php echo $docentes[$i]["IdUsua"]; ?>"<?php if($_POST[txtDocente]==$docentes[$i]["IdUsua"]){?>selected="selected"<?php }?>><?php echo $docentes[$i]["Nombre"].' '.$docentes[$i]["APaterno"].' '.$docentes[$i]["AMaterno"]; ?></option>
          							<?php } ?>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Oferta educativa: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-key"></i>
          						  </div>
                        <select class="form-control" name="txtEducativa" id="txtEducativa" onchange="document.frm.submit();">
          							<option value=""> - SELECCIONE - </option>
          							<?php for ($i=0;$i< sizeof($educativa);$i++) { ?>
          							<option value="<?php echo $educativa[$i]["IdEducativa"]; ?>"<?php if($_POST[txtEducativa]==$educativa[$i]["IdEducativa"]){?>selected="selected"<?php }?>><?php echo $educativa[$i]["Nombre"]; ?></option>
          							<?php } ?>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
          			  <div class="box-primary">
          				  <div class="box-body">
          					<div class="form-group">
          						<label>Módulo: </label>
          						<div class="input-group">
          						  <div class="input-group-addon">
          							<i class="fa fa-fw fa-map-signs"></i>
          						  </div>
                        <select class="form-control" name="txtModulo" id="txtModulo">
          							<option value=""> - SELECCIONE - </option>
          							<?php for ($i=0;$i< sizeof($modulo);$i++) { ?>
          							<option value="<?php echo $modulo[$i]["IdAsignacion"]; ?>"<?php if($_POST[txtModulo]==$modulo[$i]["IdAsignacion"]){?>selected="selected"<?php }?>><?php echo $modulo[$i]["NoModulo"].'- '.$modulo[$i]["NombreMod"]; ?></option>
          							<?php } ?>
          						  </select>
          						</div>
          					</div>
          				  </div>
          			  </div>
          			</div>
                <div class="col-md-3">
                  <div class="box-primary">
                    <div class="box-body">
                    <div class="form-group">
                      <label>&nbsp; </label>
                      <div class="input-group">
                        <button type="button" class="btn btn-primary" onClick="val_datosBusquedaDocAct()"> <i class="fa fa-fw fa-search"></i> Buscar</button>
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
                          <th>Tipo actividad</th>
                          <th>Porcentaje</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($ingresos);$i++) {
                           $tipo = $ingresos[$i]["Tipo"];
                           if($tipo == "P"){
                             $txtTipo = "Parcial ".$ingresos[$i]["NoParcial"];
                           } else {
                             $txtTipo = "Extraordinario ".$ingresos[$i]["NoParcial"];
                           }
                           $txtSem = "Semana ".$ingresos[$i]["NoSemana"];
                           $total = $total  +  $ingresos[$i]["Porcentaje"]; ?>
                        <tr class="view_data" href="javascript:void(0);" name="view" value="view" id=<?php echo $ingresos[$i]["IdAsignacion"].'-'.$ingresos[$i]["IdActividadesDocente"].'-'.$ingresos[$i]["TipoActividad"]; ?> style=" cursor: pointer;">
                          <th>
                            <?php echo $ingresos[$i]["TipoActividad"].' / '.$txtTipo.' / '.$txtSem; ?>
                          </th>
                          <td><?php echo $ingresos[$i]["Porcentaje"]; ?></td>
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
                <input id="Total" name="Total" value="<?php echo $total; ?>" type="hidden"/>
              <br><br><br><br>
            </div>
            <script>
            var Tipo = document.getElementById("Tipo").value;
            var Total = document.getElementById("Total").value;
              Highcharts.chart('container', {
                data: {
                  table: 'datatable'
                },
                chart: {
                  type: 'column'
                },
                title: {
                  text: Tipo + '<br>' + 'Gráfica de actividades creadas por el asesor académico'
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
          url:"formConsulta/viewRegistroActividades.php",
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
