<?php $valor = 1; $section = "Registro de actividades calificadas"; include("head.php");
if($_SESSION['Permisos']) {
  $lstCiclo=$t->get_CicloEscolar();
  $clvGrupo=$t->get_claveGrupoXA($_POST["txtCicloEscolar"]);
  // $modul[]oId=$t->get_ModuloIdAsig($_POST["txtClaveGrp"]);

// $datos = 1;
// $docentes=$t->get_Docentes();
// $educativa=$t->get_educativaBus($_POST["txtDocente"]);
$moduloId=$t->get_moduloBus($_POST["txtCicloEscolar"],$_POST["txtClaveGrp"]);

if(isset($_POST["Mov"]) && $_POST["Mov"]=="Buscar"){
  $ingresos=$t->get_activiadescreadasDoc($_POST["txtModulo"]);
  if($ingresos[0]["TipoActividad"]){
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
          Avances de la calificación de las actividades
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-user"></i> Actividades</a></li>
          <li class="active">Avance de la calificación</li>
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
              <form name="frm" id="frm" action="acSelActiCalDoc.php" method="POST" enctype="multipart/form-data">
              <input id="Mov" name="Mov" value="<?php echo $_GET["Mov"];?>" type="hidden"/>
              <input id="Tipo" name="Tipo" value="<?php echo $configuracion[1]["Descripcion"]; ?>" type="hidden"/>
              <input id="IdAsignacion" name="IdAsignacion" value="<?php echo $ingresos[0]["IdAsignacion"]; ?>" type="hidden"/>

              <div class="col-md-3">
  						  <div class="box-primary">
  							  <div class="box-body">
  								<div class="form-group">
  									<label>Ciclo escolar:</label>
  									<div class="input-group date">
  									  <div class="input-group-addon">
  										<i class="fa fa-calendar"></i>
  									  </div>
  										<select class="form-control" name="txtCicloEscolar" id="txtCicloEscolar" onchange="document.frm.submit();">
  										<option value=""> - Seleccione - </option>
  										<?php for ($i=0;$i< sizeof($lstCiclo);$i++) { ?>
  										<option value="<?php echo $lstCiclo[$i]["IdCiclo"]; ?>"<?php if($_POST["txtCicloEscolar"]==$lstCiclo[$i]["IdCiclo"]){?>selected="selected"<?php }?>><?php echo $lstCiclo[$i]["Ciclo"]; ?></option>
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
  									<label>Clave del grupo:</label>
  									<div class="input-group">
  									  <div class="input-group-addon">
  										<i class="fa fa-fw fa-key"></i>
  									  </div>
  									  <select class="form-control" name="txtClaveGrp" id="txtClaveGrp" onchange="document.frm.submit();">
  											<option value=""> - Seleccione - </option>
  											<?php for ($i=0;$i< sizeof($clvGrupo);$i++) { $tx = 0;

  	                        ?>
  	                        <option value="<?php echo $clvGrupo[$i]["IdGrupo"]; ?>"<?php if($_POST['txtClaveGrp']==$clvGrupo[$i]["IdGrupo"]){?>selected="selected"<?php }?>><?php echo $clvGrupo[$i]["CveGrupo"].$xxx; ?></option>
  	                        <?php
  	                        }  ?>
  									  </select>
  									</div>
  								</div>
  							  </div>
  						  </div>
  						</div>
  						<div class="col-md-6">
  						  <div class="box-primary">
  							  <div class="box-body">
  								<div class="form-group">
  									<label>Asignatura:</label>
  									<div class="input-group input-group">
  										<div class="input-group-addon">
  										<i class="fa fa-book"></i>
  									  </div>
  										<select class="form-control" name="txtModulo" id="txtModulo" onchange="document.frm.submit();">
  											<option value=""> - Seleccione - </option>
  											<?php for ($i=0;$i< sizeof($moduloId);$i++) {
  												$catBusModAsi=$t->get_catBusModAsig($moduloId[$i]["IdModulo"],$moduloId[$i]["IdEducativa"],$_POST["txtClaveGrp"]);
  												echo $IdE = $catBusModAsi[0]["IdEstatus"];
  												if($IdE){

  												 ?>
  											<option value="<?php echo $moduloId[$i]["IdAsignacion"]; ?>"<?php if($_POST['txtModulo']==$moduloId[$i]["IdAsignacion"]){  ?>selected="selected"<?php }?>><?php echo $moduloId[$i]["CodeModulo"].' - '.$moduloId[$i]["NombreMod"]; ?></option>
  										<?php } } ?>
  									  </select>
  									  <span class="input-group-btn">
                                      <button type="button" class="btn btn-primary" onClick="val_datosBusquedaDocAct()"> <i class="fa fa-fw fa-search"></i> Buscar</button>
                                    </span>
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
                          <th>Respondieron</th>
                          <th>Calificado</th>
                          <th>Por calificar</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0;$i< sizeof($ingresos);$i++) {
                          $calificaciones=$t->get_calificaciones($ingresos[$i]["IdAsignacion"], $ingresos[$i]["IdActividadesDocente"]);
                          $alumnosconstestaron=$t->alumnoscontestaron($ingresos[$i]["IdAsignacion"], $ingresos[$i]["IdActividadesDocente"]);
                          $tipo = $ingresos[$i]["Tipo"];
                          if($tipo == "P"){
                            $txtTipo = "Parcial ".$ingresos[$i]["NoParcial"];
                          } else {
                            $txtTipo = "Extraordinario ".$ingresos[$i]["NoParcial"];
                          }
                          $txtSem = "Semana ".$ingresos[$i]["NoSemana"];
                           ?>
                        <tr class="view_data" href="javascript:void(0);" name="view" value="view" id=<?php echo $ingresos[$i]["IdActividadesDocente"]; ?> style=" cursor: pointer;">
                          <th>
                            <?php echo $ingresos[$i]["TipoActividad"].' / '.$txtTipo.' / '.$txtSem; ?>
                          </th>

                          <td><?php echo $alumnosconstestaron[0]["Total"]; ?></td>
                          <td><?php echo $calificaciones[0]["Total"]; ?></td>
                          <td><?php
                           $total = $alumnosconstestaron[0]["Total"] - $calificaciones[0]["Total"];
                          if($total < 0){
                            $total = 0;
                          }
                          echo $total;
                          ?></td>

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
            <!-- <div class="col-md-12">
              <div class="box-primary">
                <div class="box-body">
                <div class="form-group">
                  <label>&nbsp; </label>
                  <div class="input-group">
                    <button type="button" class="btn btn-info" onclick="javascript:window.open('acaConcentrado.php?IdAsig=<?php echo $ingresos[0]["IdAsignacion"]; ?>&Doc=<?php echo $_POST[txtDocente]; ?>&Ofec=<?php echo $_POST[txtEducativa]; ?>&Mod=<?php echo $_POST[txtModulo]; ?>','_self');" href="javascript:void(0);"> <i class="fa fa-database"></i> VER CONCENTRADO</button>
                  </div>
                </div>
                </div>
              </div>
            </div> -->
            <script>
            var Tipo = document.getElementById("Tipo").value;
              Highcharts.chart('container', {
                data: {
                  table: 'datatable'
                },
                chart: {
                  type: 'column'
                },
                title: {
                  text: Tipo + '<br>' + 'Gráfica de actividades calificadas por el asesor académico'
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

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script>
  $(document).ready(function(){
    $(document).on('click', '.view_data', function(){
      var employee_id = $(this).attr("id");
      var IdAsignacion = document.getElementById("IdAsignacion").value;
      if(employee_id != ''){
        $.ajax({
          url:"formConsulta/viewRevisarActividades.php",
          method:"POST",
          data:{employee_id:employee_id,IdAsignacion:IdAsignacion},
          success:function(data) {
            $('#employee_detail').html(data);
            $('#dataModal').modal('show');
          }
        });
      }
    });
  });
</script>
</body>
</html>
<?php } else {
  echo "<script type='text/javascript'>window.location='php/estructura/destroy.php';</script>";
} ?>
