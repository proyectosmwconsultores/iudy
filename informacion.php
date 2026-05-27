<?php $mnAl = 2; $section = "Mi espacio"; include("head.php");
if($_SESSION['IdUsua']){ $addIngresos=$t->add_ingresos($_SESSION['IdUsua'],'Está consultando la informacion general del curso'); }

$AsignacionId=$t->get_datosModuloD($_SESSION['IdAsignacion']);
$datosModulo = $t->get_datosModulo($AsignacionId[0]["IdEducativa"],$AsignacionId[0]["IdModulo"]);
$datosModuloId = $t->get_datosModuloId($_SESSION['IdAsignacion'],$AsignacionId[0]["IdEducativa"],$AsignacionId[0]["IdModulo"]);
$datDocents = $t->get_datDocnts($_SESSION['IdAsignacion']);
$horario=$t->get_horario($_SESSION['IdAsignacion']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <?php if($_SESSION['EstatusAsig'] == "F"){ include("formConsulta/alerta.php"); } ?>
    <section class="content-header">
      <h1>
        Información de la asignatura
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i><?php echo $AsignacionId[0]["NombreMod"];?></a></li>
        <li class="active">Informaci&oacute;n</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-4">
    			<div class="col-md-12">
    			  <div class="box box-primary">
    				<div class="box-body box-profile">
    				  <h4 class="text-muted text-center"><b><?php echo $datosModuloId[0]["Nombre"]; ?></b></h4><br>
    				  <p class="text-muted text-center"><?php echo  $datosModuloId[0]["CodeModulo"].' - '.$datosModuloId[0]["NombreMod"]; ?></p>
    				  <ul class="list-group list-group-unbordered">
    					<li class="list-group-item">
    					  <b>Inicio</b> <a class="pull-right"><?php echo obtenerFechaEnLetra($datosModuloId[0]["FecIni"]); ?></a>
    					</li>
    					<li class="list-group-item">
    					  <b>Final</b> <a class="pull-right"><?php echo obtenerFechaEnLetra($datosModuloId[0]["FecFin"]); ?></a>
    					</li>
    				  </ul>
    				</div>
    			  </div>
    			</div>


        </div>
    		<div class="col-md-8">
          <?php if($configuracion[28]["Descripcion"] == "SI") { ?>
          <div class="col-md-12">
    			  <div class="box box-widget widget-user-2"><a href="docente.php?U=<?php echo $datDocents[0]["IdUsua"]?>">
    				<div class="widget-user-header bg-aqua-active">

    				  <div class="widget-user-image">
    					<img class="img-circle" src="assets/perfil/<?php echo $datDocents[0]["Foto"] ?>" alt="User Avatar" style="width: 60px; height: 60px;">
              </div>
    				  <h3 class="widget-user-username" style="font-size: 14px;"><?php echo $datDocents[0]["Nombre"].' '.$datDocents[0]["APaterno"]; ?></h3>
    				  <h5 class="widget-user-desc"><?php echo $datDocents[0]["Cargo"]; ?></h5>
    				</div></a>
    			  </div>
    			</div>
    			<!-- <div class="col-md-6">
    			  <div class="box box-widget widget-user-2"><a href="docente.php?U=<?php echo $datDocents[1]["IdUsua"]?>">
    				<div class="widget-user-header bg-aqua">
      				  <div class="widget-user-image">
      					<img class="img-circle" src="assets/perfil/<?php echo $datDocents[1]["Foto"] ?>" alt="User Avatar">
      				  </div>
              </a>
    				  <h3 class="widget-user-username" style="font-size: 14px;"><?php echo $datDocents[1]["Nombre"].' '.$datDocents[1]["APaterno"]; ?></h3>
    				  <h5 class="widget-user-desc"><?php echo $datDocents[1]["Cargo"]; ?></h5>
    				</div></a>
    			  </div>
    			</div> -->
        <?php } ?>


          <div class="col-md-12">
            <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-fw fa-globe"></i>
                <h3 class="box-title">Objetivo de la asignatura:</h3>
              </div>
              <div class="box-body">
                <p><?php echo $datosModulo[0]["Objetivo"]; ?></p>
              </div>
            </div>
            <?php if($horario[0]){ ?>
            <div class="box box-solid">
              <div class="box-header with-border">
                <i class="fa fa-fw fa-server"></i>
                <h3 class="box-title">Horario de clases:</h3>
              </div>
              <div class="box-body">
                <p><?php echo $datosModulo[0]["Introduccion"]; ?></p>
                <?php if($horario[0]){ ?>
                <tr>
                  <td><b>Días de clases:</b></td>
                  <?php for ($h=0;$h< sizeof($horario);$h++) { ?>
                    <td>
                  <?php echo $horario[$h]["Dia"].' '.$horario[$h]["HraIni"].':'.$horario[$h]["MinIni"].' a '.$horario[$h]["HraFin"].':'.$horario[$h]["MinFin"].' ';  ?>
                  </td>
                    <?php } ?>
                </tr>
              <?php } ?>
              </div>
            </div><?php } ?>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div id="dataModal2" class="modal fade"> <!--MODAL ME GUSTA-->

       <div class="modal-dialog">
            <div class="modal-content">

                 <div class="modal-body" id="employee_detail2">

                 </div>
            </div>
       </div>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->
<script>
$(document).ready(function(){
		 $(document).on('click', '.view_tutor', function(){
					var employee_id = $(this).attr("id");

					if(employee_id != '')
					{
							 $.ajax({
										url:"formConsulta/viewSeguimiento.php",
										method:"POST",
										data:{employee_id:employee_id},
										success:function(data){
												 $('#employee_detail2').html(data);
												 $('#dataModal2').modal('show');
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

</body>
</html>
