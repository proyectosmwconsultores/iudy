<?php $section = "Mis tramites";
include("head.php");
$var = 5;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en mis trámites escolares');
}
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);

$alumno = $t->get_alumno_id($_SESSION['IdUsua']);
$misGrados = $espacio->get_mis_grados_estudiados($_SESSION['IdUsua']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Mis trámites</h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
          <li class="active"> Mis trámites escolares </li>
        </ol>
      </section>

      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioAlumno.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">

                <!-- Header con Tabs -->
                <div class="paytabs-header">

                  <div class="paytabs-title-area">
                    <div class="paytabs-icon">📋</div>
                    <div>
                      <div class="paytabs-title">Trámites escolares </div>
                      <div class="paytabs-sub">Fichas de inscripción por grado </div>
                    </div>
                  </div>
                </div>

                <!-- Contenido -->
                <div class="paytabs-content">
                  <div class="paypanel is-active" data-content="pendientes">
                    <table class="docs-table" aria-label="Documentos en revisión">
                      <thead>
                        <tr>
                          <th></th>
                          <th style="text-align: center;">Grado</th>
                          <th>Periodo escolar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i = 0; $i < sizeof($misGrados); $i++) { ?>
                          <tr>
                            <td class="docs-td-strong">
                              <div class="pay-actions" style="cursor: pointer;">
                                <a class="pay-btn is-ghost" onclick="window.open('repositorio/portafolio/ficha_inscripcion.php?id=<?php echo time().$_SESSION['IdUsua']; ?>&idToks=<?php echo time().$misGrados[$i]['IdCiclo']; ?>','_blank')"  href="javascript:void(0);" title="Subir comprobante"><i class="fa fa-fw fa-cloud-download"></i></a>
                              </div>
                            </td>
                            <td class="docs-td-strong" style="text-align: center;"><?php if($misGrados[$i]["Dia"] == 'P'){ echo "-";} else { echo $misGrados[$i]["Grado"].'°'; } ?></td>
                            <td class="docs-td-muted"><?php echo $misGrados[$i]["Ciclo"]; ?></td>
                          </tr><?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
    <?php include("footer.php"); ?>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- Page script -->


</body>

</html>
<?php unset($_SESSION['Alerta']);  ?>