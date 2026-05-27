<?php $section = "Mis Documentos";
include("head.php");
$var = 1;
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'Está en Mis Documentos');
}
$datosUser = $t->get_datoDocente($_SESSION['IdUsua']);
$tipoDocumentos = $espacio->get_tipo_docs($datosUser[0]["IdOferta"]);
$misDocumentos = $espacio->get_misDocAlumnos($_SESSION['IdUsua']);
$misDocAceptados = $espacio->get_misDocAlumAcep($_SESSION['IdUsua']);

if (isset($_POST["Mov"]) && $_POST["Mov"] == "SubDocAlum") {
  $espacio->add_docAlumno();
  exit;
}

$datosUser = $t->get_datosUser($_SESSION['IdUsua']);
$datInformacion = $t->get_datInformacion($_SESSION['IdUsua']);
?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1><i class="fa fa-bell"></i> Mi espacio</h1>
        <ol class="breadcrumb">
          <li><a href="espacioUser.php"><i class="fa fa-bell"></i> Mi espacio</a></li>
        </ol>
      </section>

      <section class="content">
        <div class="kx-page">
          <div class="kx-layout">
            <!-- SIDEBAR -->
            <?php include("espacioAlumno.php");  ?>
            <section class="pay-page">
              <div class="paytabs-card">
                <section class="ms-page">

                  <!-- Card: Perfil -->
                  <article class="ms-card">
                    <header class="ms-banner" style="background: #<?php echo $configuracion[34]['Descripcion']; ?>;">
                      <div class="ms-banner-left">
                        <div class="ms-avatar" aria-hidden="true">
                          <span class="ms-avatar-ring"></span>
                          <span class="ms-avatar-ico">👤</span>
                        </div>

                        <div class="ms-user">
                          <div class="ms-user-name"><?php echo $datosUser[0]["NombreUser"]; ?> <?php echo $datosUser[0]["APaterno"]; ?> <?php echo $datosUser[0]["AMaterno"]; ?></div>
                          <div class="ms-user-role">MATRICULA: <?php echo $datosUser[0]["Usuario"]; ?></div>
                        </div>
                      </div>
                    </header>

                    <div class="ms-body">
                      <ul class="ms-info">
                        <li class="ms-info-row">
                          <span class="ms-info-ico" aria-hidden="true">🏛️</span>
                          <span class="ms-info-text"><?php echo $datInformacion[0]["Campus"]; ?></span>
                          <span class="ms-info-right">📞 <b><?php if (isset($datInformacion[0]["Celular"])) {
                                                              echo $datInformacion[0]["Celular"];
                                                            } else {
                                                              echo "- - -";
                                                            } ?></b></span>
                        </li>

                        <li class="ms-info-row">
                          <span class="ms-info-ico" aria-hidden="true">🎓</span>
                          <span class="ms-info-text"><?php echo $datInformacion[0]["NomEducativa"]; ?></span>
                          <span class="ms-info-right">🏷️ <b><?php echo $datInformacion[0]["CveGrupo"];  ?></b></span>
                        </li>

                        <li class="ms-info-row">
                          <span class="ms-info-ico" aria-hidden="true">✉️</span>
                          <span class="ms-info-text"><?php if (isset($datInformacion[0]["Correo"])) {
                                                        echo $datInformacion[0]["Correo"];
                                                      } else {
                                                        echo "- - -";
                                                      } ?></span>
                          <span class="ms-info-right"><?php if (isset($datInformacion[0]["FecNac"])) {
                                                        echo $datInformacion[0]["FecNac"];
                                                      } else {
                                                        echo "- - -";
                                                      } ?></span>
                        </li>
                      </ul>
                    </div>
                    <hr>
                    <?php 
                    $chkHra=$t->get_chkHorario($_SESSION["IdUsua"]);
                    ?>
                    <div class="paytabs-header">

                      <div class="paytabs-title-area">
                        <div class="paytabs-icon">💳</div>
                        <div>
                          <div class="paytabs-title">Mi horario de clases</div>
                          <div class="paytabs-sub">Mi horario de clases activo </div>
                        </div>
                      </div>
                    </div>
                    <table class="docs-table" aria-label="Documentos en revisión">
                      <thead>
                        <tr>
                          <th>Materia</th>
                          <th style="text-align: center;">Lun</th>
                          <th style="text-align: center;">Mar</th>
                          <th style="text-align: center;">Mié</th>
                          <th style="text-align: center;">Jue</th>
                          <th style="text-align: center;">Vie</th>
                          <th style="text-align: center;">Sáb</th>
                          <th style="text-align: center;">Dom</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($h=0;$h< sizeof($chkHra);$h++) {
                  $chHra=$t->get_chkHor($chkHra[$h]['IdAsignacion']); ?>
                  <tr style="font-size: 12px;">
                    <td><?php echo $chkHra[$h]['NombreMod']; ?></td>
                    <?php for ($v=0;$v< sizeof($chHra);$v++) { ?>
                    <td style="text-align: center;"><?php if($chHra[$v]['Total']){ echo $chHra[$v]['HraIni'].':'.$chHra[$v]['MinIni'].'-'.$chHra[$v]['HraFin'].':'.$chHra[$v]['MinFin']; } else { echo '-';} ?></td>
                  <?php }  ?>
                  </tr>
                  <?php } ?>
                          
                      </tbody>
                    </table>
                  </article>
                </section>                
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