<?php $_v = 88;
$section = "Mi asistencia";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado al módulo de asistencia.');
}
$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_datosModuloD($_GET['idAsignacion']);
$lst_asis = $contenido->get_lst_asistencia($_GET['idAsignacion'], $_SESSION['IdUsua']);

?>

<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <div class="topbar-planeacion">
        <div class="topbar-planeacion__left">
          <h1> <i class="fa fa-flag"></i> MIS ASISTENCIA </h1>
        </div>
        <div class="topbar-planeacion__right">
          <span>MATERIA</span>
          <i class="fa fa-angle-right"></i>
          <span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
        </div>
      </div>

      <div class="asis-wrap">

        <div class="asis-topbar">
          <div class="asis-topbar-left">
          </div>
          <div class="asis-topbar-right">
            <span class="asis-counter"><?php echo sizeof($lst_asis); ?> registros</span>
          </div>
        </div>

        <?php if (sizeof($lst_asis) > 0) { ?>
          <div class="asis-grid">
            <?php
            for ($c = 0; $c < sizeof($lst_asis); $c++) {

              $claseEstado = 'ok';
              $textoRevision = '';
              $claseRevision = '';

              if ($lst_asis[$c]['Valor'] == 2) {
                $textoRevision = 'En revisión';
                $claseRevision = 'revision';
              } elseif ($lst_asis[$c]['Valor'] == 3) {
                $textoRevision = 'No aprobado';
                $claseRevision = 'rechazado';
              } elseif ($lst_asis[$c]['Valor'] == 4) {
                $textoRevision = 'Aprobado';
                $claseRevision = 'aprobado';
              }

              if (
                stripos($lst_asis[$c]['Asistencia'], 'falta') !== false ||
                stripos($lst_asis[$c]['Asistencia'], 'ausencia') !== false
              ) {
                $claseEstado = 'bad';
              } elseif (
                stripos($lst_asis[$c]['Asistencia'], 'retardo') !== false
              ) {
                $claseEstado = 'warn';
              }
            ?>
              <div class="asis-card">
                <div class="asis-card-date">
                  <i class="fa fa-calendar-o"></i>
                  <?php echo obtenerFechaCorta($lst_asis[$c]['Fecha']); ?>
                </div>

                <div class="asis-card-status">
                  <span class="asis-pill <?php echo $claseEstado; ?>">
                    <?php echo $lst_asis[$c]['Icono']; ?>
                    <?php echo $lst_asis[$c]['Asistencia']; ?>
                  </span>

                  <?php if ($textoRevision != '') { ?>
                    <span class="asis-pill soft <?php echo $claseRevision; ?>">
                      <?php echo $textoRevision; ?>
                    </span>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        <?php } else { ?>
          <div class="asis-empty">
            <div class="asis-empty-icon">
              <i class="fa fa-calendar-times-o"></i>
            </div>
            <h4>Aún no hay registros de asistencia</h4>
            <p>Cuando el docente publique sesiones registradas, aparecerán en esta sección.</p>
          </div>
        <?php } ?>
      </div>
      <div id="dataTar" class="modal fade"> <!--MODAL ME GUSTA-->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fa fa-fw fa-quote-left"></i> Solicitud de permiso</h4>
            </div>
            <div class="modal-body" id="employee_tar">
            </div>
          </div>
        </div>
      </div>

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
  <script>
    // function solicitar_permiso(IdAsistencia, IdAsignacion) {

    //   $.ajax({
    //     url: "formConsulta/solicitar_permiso.php",
    //     method: "POST",
    //     data: {
    //       IdAsistencia: IdAsistencia,
    //       IdAsignacion: IdAsignacion
    //     },
    //     success: function(data) {
    //       $('#employee_tar').html(data);
    //       $('#dataTar').modal('show');
    //     }
    //   });
    // }
  </script>
</body>

</html>