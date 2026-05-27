<?php $_v = 35;  $section = "Información de la materia"; include("head.php");

$contenido->get_validar_mat($_GET['idAsignacion'],$_SESSION['IdUsua']);
$lst_info1=$contenido->get_lst_info1($_GET['idAsignacion']);
$lst_info2=$contenido->get_lst_info2($_GET['idAsignacion']);
$materia=$t->get_datosModuloD($_GET['idAsignacion']);
$xmodulo = "Esta en la materia -> ".$materia[0]['NombreMod'];
$addIngresos=$t->add_registros($_SESSION['IdUsua'],$xmodulo,'Mi información','Mi información -> General de la materia',$_GET['idAsignacion'],$_SESSION['IdUsua'],0); 


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
<div class="wrapper">
  <?php include("menuV.php"); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Información general de la materia</h1>
    </section>
    <section class="content">
      <form name="frm" id="frm" action="mi_informacion.php" method="POST" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6">
            <div class="box-body">
              <div class="box box-widget widget-user">
  	            <div class="widget-user-header bg-black" style="background: url('assets/fondo/fondo_docente.jpg') center center; width: 100%; cursor: pointer;">
  	              <h3 class="widget-user-username"><?php echo $lst_info1[0]['Campus']; ?></h3>
  	              <h5 class="widget-user-desc"><?php echo $lst_info1[0]['Nombre']; ?></h5>
  								<h5 class="widget-user-desc"><?php echo $lst_info1[0]['NombreMod']; ?></h5>
  	            </div>
  	          </div>
              <div class="box box-widget widget-user-2" style="margin-top: -20px;">
                <div class="box-footer no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="#"><i class="fa fa-calendar"></i> Inicia el día <?php echo obtenerFechaEnLetra($lst_info1[0]["FecIni"]); ?></a></li>
                    <li><a href="#"><i class="fa fa-calendar"></i> Finaliza el día <?php echo obtenerFechaEnLetra($lst_info1[0]["FecFin"]); ?></a></li>
                  </ul>
                </div><br><?php if(isset($lst_info1[0]['Objetivo'])){ ?>
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <i class="fa fa-info-circle"></i>
                    <h3 class="box-title">Objetivo:</h3>
                  </div>
                  <div class="box-body">
                    <blockquote>
                      <p style="text-align: justify;"><?php echo $lst_info1[0]['Objetivo']; ?></p>
                    </blockquote>
                  </div>
                </div><?php } ?>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box-body">
              <div class="box box-widget widget-user">
                      <div class="widget-user-header bg-black" style="background: url('assets/fondo/fondo_docente.jpg') center center;">
                        <h3 class="widget-user-username"><?php echo $lst_info2[0]["Nombre"].' '.$lst_info2[0]["APaterno"].' '.$lst_info2[0]["AMaterno"]; ?></h3>
                        <h5 class="widget-user-desc">Docente</h5>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle" src="assets/perfil/<?php echo $lst_info2[0]["Foto"]; ?>" alt="User Avatar">
                      </div><br>
          						<div class="box-body" style="text-align: justify;">
                        <p><?php echo $lst_info2[0]["Semblanza"]; ?></p>
                      </div>
                    </div>
            </div>
          </div>


  				</div>
      </form>

    </section>
  </div>
  <?php include("footer.php"); ?>
</div>
<!-- ./wrapper -->

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
