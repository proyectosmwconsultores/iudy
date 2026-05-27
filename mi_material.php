<?php $_v = 32;
$section = "Material didáctico de la materia";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado al material didáctico de la materia.');
}
$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_datosModuloD($_GET['idAsignacion']);
$lst_material = $contenido->get_lst_material($_GET['idAsignacion']);


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <div class="topbar-planeacion">
        <div class="topbar-planeacion__left">
          <h1> <i class="fa fa-flag"></i> MIS MATERIALES DIDÁCTICO </h1>
        </div>
        <div class="topbar-planeacion__right">
          <span>MATERIA</span>
          <i class="fa fa-angle-right"></i>
          <span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
        </div>
      </div>
      <div class="materia-wrap">
        <div class="parcial-box">
          <div class="parcial-head">
            <h3>Lista de material didáctico</h3>
          </div>

          <div class="parcial-body">
            <?php if (!empty($lst_material) && sizeof($lst_material) > 0) { ?>

              <?php for ($tx = 0; $tx < sizeof($lst_material); $tx++) { ?>
                <div class="actividad-docs">
                  <div class="actividad-main">
                    <div class="actividad-titulo">
                      <a href="javascript:void(0);" class="actividad-link" onclick="verBiblioteca(<?php echo $lst_material[$tx]['IdBiblioteca']; ?>)">
                        <i class="fa fa-edit"></i>
                        <?php echo $lst_material[$tx]['Nombre']; ?>
                      </a>
                    </div>
                    <div class="actividad-meta">
                      <?php echo $lst_material[$tx]['Titulo']; ?>
                      ·
                      <?php echo $lst_material[$tx]['Etiqueta_semana']; ?>
                      ·
                      <?php echo $lst_material[$tx]['NomActividad']; ?>
                    </div>
                  </div>

                  <div class="actividad-col estado" style="cursor: pointer;" onclick="verBiblioteca(<?php echo $lst_material[$tx]['IdBiblioteca']; ?>)">
                    <span class="estado-pill finalizado">Descargar</span>
                  </div>
                </div>
              <?php } ?>

            <?php } else { ?>

              <div class="material-empty-state">
                <div class="material-empty-icon">
                  <i class="fa fa-folder-open-o"></i>
                </div>

                <h4>Aún no hay material didáctico disponible</h4>

                <p>
                  Por el momento esta materia no cuenta con recursos publicados.
                  Cuando el docente agregue archivos, guías o lecturas, aparecerán aquí.
                </p>

                <div class="material-empty-note">
                  <i class="fa fa-info-circle"></i>
                  Revisa más tarde esta sección.
                </div>
              </div>

            <?php } ?>
          </div>
        </div>
      </div>
      </section>
    </div>
  </div>

  <div id="dataBli" class="modal fade"> <!--MODAL ME GUSTA-->
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background: #5a284f; color: #fbeb00; font-size: 16px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><i class="fa fa-fw fa-caret-square-o-right"></i> <b id='lbl_bib'></b></h4>
        </div>
        <div class="modal-body" id="employee_bli">
        </div>
      </div>
    </div>
  </div>

  <script>
    function verBiblioteca(IdBiblioteca) {
      $.ajax({
        url: "formConsulta/verDocumento.php",
        method: "POST",
        data: {
          IdBiblioteca: IdBiblioteca
        },
        success: function(data) {
          $('#employee_bli').html(data);
          $('#dataBli').modal('show');
        }
      });
    }

    
  </script>

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