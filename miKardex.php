<?php $section = "Mi Kardex";
include("head.php");
$var = 8;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está consultado sus datos personsales');
}
$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datUs = $t->get_karUser($_SESSION['IdUsua']);
// $chkRep=$t->get_chkRep($datUs[0]["Usuario"],$datUs[0]["IdOferta"]);
$grp = $datUs[0]["TipoCiclo"];
if ($grp == "C") {
  $txtGrp = "CUATRIMESTRE";
} elseif ($grp == "S") {
  $txtGrp =  "SEMESTRE";
} else {
  $txtGrp = "TRIMESTRE";
}

$alumno = $espacio->get_datos_alumno_id($_SESSION['IdUsua']);
$creditosall = $espacio->get_total_creditos($alumno[0]['IdOferta'], $alumno[0]['IdCampus'], $alumno[0]['Termino']);
$miscreditos = $espacio->get_mis_creditos($_SESSION['IdUsua']);
$promx = $espacio->get_promedio_alumno_id($_SESSION['IdUsua']);


if ($alumno[0]['IdOferta'] == 30) {
  if ($alumno[0]['Termino'] > 1) {
    $cred = $creditosall[0]['Total'];
  } else {
    $cred = 0;
  }
} else {
  $cred = $creditosall[0]['Total'];
}
if ($cred == 0) {
  $cred = 456;
  $cred = $cred . ' (PENDIENTE LA TERMINACIÓN)';
  $divi = (100 / 456);
  $porceActual = intval($divi * $miscreditos[0]['Total']);
} else {
  $divi = (100 / $cred);
  $porceActual = intval($divi * $miscreditos[0]['Total']);
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Mi k&aacute;rdex</h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-dashboard"></i> Mi espacio</a></li>
          <li class="active"> Mi kardex</li>
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
                    <div class="paytabs-icon">📊</div>
                    <div>
                      <div class="paytabs-title">Mi kardex de calificaciones </div>
                      <div class="paytabs-sub">Mi lista de calificaciones finales </div>
                    </div>
                  </div>
                </div>


                <!-- Contenido -->
                <div class="paytabs-content">
                  <div class="paypanel is-active" data-content="pendientes">
                    <div class="col-md-12">
                      <p><b>Créditos (<?php echo $porceActual; ?>%): </b> <code><?php echo $miscreditos[0]['Total']; ?> de <?php echo $cred; ?></code> </p>
                      <div class="progress progress-sm active">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $porceActual; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porceActual; ?>%">
                          <span class="sr-only"><?php echo $porceActual; ?>% Complete</span>
                        </div>
                      </div>
                    </div>

                    <?php for ($i = 1; $i <= 10; $i++) {
                      $cal = $t->get_calificacion($_SESSION["IdUsua"], $i);
                      if (isset($cal[0])) { ?>
                        <div class="col-md-12">
                          <table class="table table-striped">
                            <tr style="background: #89a5ee; color: #1d182d;">
                              <td>
                                <!-- <button type="button" class="btn btn-danger btn-sm" onclick="javascript:window.open('repositorio/pdf/docBoleta.php?tokenId=<?php echo time() . $datUs[0]["Usuario"]; ?>&Grado=<?php echo time() . $i; ?>');" href="javascript:void(0);" title="Descargar boleta calificaciones"><i class="fa fa-align-left"></i> Imprimir</button> -->
                                <?php echo $i; ?>° <?php echo $txtGrp;  ?>
                              </td>
                              <td style="text-align: center; width: 180px;">PROMEDIO FINAL</td>
                            </tr>
                            <?php for ($x = 0; $x < sizeof($cal); $x++) { ?>
                              <tr>
                                <td><?php echo $cal[$x]["NombreMod"]; ?></td>
                                <td style="text-align: center; width: 80px;">
                                  <?php echo $cal[$x]["Promedio"]; ?> <b><?php echo $cal[$x]["_obs"]; ?></b>
                                </td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div><?php }
                          } ?>

                    <div class="col-md-12">
                      <div class="box box-widget widget-user">
                        <div class="box-footer">
                          <div class="row">
                            <div class="col-sm-12 border-right">
                              <div class="description-block">
                                <h5 class="description-header">PROMEDIO FINAL</h5>
                                <span class="description-text" style="font-size: 25px;"><?php echo bcdiv($promx[0]['Promedio'], 1, 1); ?></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <hr>

                    <?php $calP = $t->get_calProceso($_SESSION["IdUsua"], $datUs[0]["IdOferta"], $datUs[0]["SemCua"]);
                    if (isset($calP[0])) {
                      if ($txtGrp == 'SEMESTRE') {
                    ?>


                        <div class="col-md-12">
                          <table class="table table-striped">
                            <tr style="background: #c1c5ffc4; color: black;">
                              <td colspan="6" style="text-align: center;">
                                <i class="fa fa-book"></i> MIS MATERIAS ACTIVAS
                              </td>
                            </tr>
                            <tr style="background: #e7e9ffc4; color: white;">
                              <td>
                                <?php echo $txtGrp; ?> <?php echo $datUs[0]["SemCua"]; ?>°
                              </td>
                              <td style="text-align: center;">Parcial 1</td>
                              <td style="text-align: center;">Parcial 2</td>
                              <td style="text-align: center;">Evaluación final</td>
                              <td style="text-align: center;">Promedio</td>
                              <td style="text-align: center;">Promedio Final</td>
                            </tr>
                            <?php for ($x = 0; $x < sizeof($calP); $x++) { ?>
                              <tr>
                                <td><?php echo $calP[$x]["NombreMod"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php echo $calP[$x]["ParcialF1"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php echo $calP[$x]["ParcialF2"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php echo $calP[$x]["ParcialF3"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php if (isset($calP[$x]["ParcialF3"])) {
                                                                                echo $calP[$x]["Promedio"];
                                                                              } ?></td>
                                <td style="text-align: center; width: 80px;"><?php if (isset($calP[$x]["ParcialF3"])) {
                                                                                echo $calP[$x]["Promedio_final"];
                                                                              } ?></td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div>
                      <?php } else { ?>
                        <div class="col-md-12">
                          <table class="table table-striped">
                            <tr style="background: #c1c5ffc4; color: black;">
                              <td colspan="3" style="text-align: center;">
                                <i class="fa fa-book"></i> MIS MATERIAS ACTIVAS
                              </td>
                            </tr>
                            <tr style="background: #e7e9ffc4; color: black;">
                              <td>
                                <?php echo $txtGrp; ?> <?php echo $datUs[0]["SemCua"]; ?>°
                              </td>
                              <td style="width: 100px; text-align: center;"><?php if ($datUs[0]['IdGrado'] == 3) {
                                                                              echo "Parcial 1";
                                                                            } else {
                                                                              echo "Módulo 1";
                                                                            } ?></td>
                              <td style="width: 150px;  text-align: center;">Promedio Final</td>
                            </tr>
                            <?php for ($x = 0; $x < sizeof($calP); $x++) { ?>
                              <tr>
                                <td><?php echo $calP[$x]["NombreMod"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php echo $calP[$x]["ParcialF1"]; ?></td>
                                <td style="text-align: center; width: 80px;"><?php echo $calP[$x]["Promedio_final"]; ?></td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div>
                    <?php }
                    }  ?>

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
  <!-- Select2 -->

  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>


</body>

</html>