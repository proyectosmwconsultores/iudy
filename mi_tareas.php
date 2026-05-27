<?php $_v = 36;
$section = "Mis tareas enviadas";
include("head.php");
if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario la lista de tareas enviadas de la materia.');
}
$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_datosModuloD($_GET['idAsignacion']);
$lst_tareas = $contenido->get_lst_tareas($_GET['idAsignacion']);
$lst_prom = $contenido->get_lst_prom_id($_GET['idAsignacion'], $_SESSION['IdUsua']);
$IdUsua = $_SESSION['IdUsua'];
$prom = 6;
$grad = $materia[0]["IdGrado"];
//$prom = 6;
//$grad = $datP[0]["IdGrado"];
if ($grad == 1) {
  $prom = 7;
} elseif ($grad == 2) {
  $prom = 7;
} elseif ($grad == 3) {
  $prom = 6;
} elseif ($grad == 4) {
  $prom = 6;
} elseif ($grad == 7) {
  $prom = 6;
}


?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <div class="topbar-planeacion">
        <div class="topbar-planeacion__left">
          <h1> <i class="fa fa-flag"></i> MIS TAREAS </h1>
        </div>
        <div class="topbar-planeacion__right">
          <span>MATERIA</span>
          <i class="fa fa-angle-right"></i>
          <span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
        </div>
      </div>
      <div class="materia-wrap">
        <div class="materia-head">
          <div class="materia-head-left">
          </div>
          <div class="badge-minima">
            <i class="fa fa-warning"></i>
            Calificación mínima aprobatoria: <?php echo $prom; ?>
          </div>
        </div>
        <?php if (!empty($lst_tareas) && sizeof($lst_tareas) > 0) { ?>
          <?php
          $sumP = 0;
          $nP = 0;
          $pi = 0;
          $pf = 0;
          $ci = 0;
          $cf = 0;
          $por = 0;
          $cal = 0;
          $miCal = 0;

          for ($tx = 0; $tx < sizeof($lst_tareas); $tx++) {
            $nP = $lst_tareas[$tx]['NoParcial'];
            $lst_cal_id = $contenido->get_lst_cal_id($_GET['idAsignacion'], $lst_tareas[$tx]['IdActividadesDocente'], $IdUsua);
            $cal = isset($lst_cal_id[0]['Calificacion']) ? $lst_cal_id[0]['Calificacion'] : 0;

            $idT = $lst_tareas[$tx]['IdTipoActividad'];
            $pi = $lst_tareas[$tx]['NoParcial'];
            $ci = $lst_tareas[$tx]['NoParcial'];

            if ($idT == 1) {
              $ico_ = 'fa fa-edit';
            } elseif ($idT == 2) {
              $ico_ = 'fa fa-comments';
            } elseif ($idT == 3) {
              $ico_ = 'fa fa-folder';
            } elseif ($idT == 4) {
              $ico_ = 'fa fa-map-signs';
            } else {
              $ico_ = 'fa fa-book';
            }

            /* CERRAR PARCIAL ANTERIOR */
            if (($ci <> $cf) && ($cf <> 0)) { ?>
              <div class="parcial-foot">
                <span>Calificación: </span>
                <strong><?php echo $miCal;
                        $sumP += $miCal; ?></strong>
              </div>
      </div>
    <?php
              $por = 0;
              $miCal = 0;
            }

            /* ABRIR NUEVO PARCIAL */
            if ($pi <> $pf) { ?>
      <div class="parcial-box">
        <div class="parcial-head">
          <h3><?php echo $lst_tareas[$tx]['Titulo']; ?></h3>
        </div>
        <div class="parcial-body">
        <?php } ?>

        <div class="actividad-row">
          <div class="actividad-main">
            <div class="actividad-titulo">
              <a class="actividad-link"
                onclick="window.open('miAula.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>&idToks=<?php echo $lst_tareas[$tx]['IdParcialDocente'] . '_' . $lst_tareas[$tx]['IdSemanaDocente'] . '_' . $lst_tareas[$tx]['IdActividadesDocente']; ?>','_self')"
                href="javascript:void(0);">
                <i class="<?php echo $ico_; ?>"></i>
                <?php echo $lst_tareas[$tx]['NomActividad']; ?>
              </a>
            </div>

            <div class="actividad-meta">
              <?php echo $lst_tareas[$tx]['Etiqueta_semana']; ?> · <?php echo $lst_tareas[$tx]['TipoActividad']; ?>
            </div>
          </div>

          <div class="actividad-col estado">
            <span class="estado-pill <?php echo (strtolower($lst_tareas[$tx]['Estatus']) == 'finalizado') ? 'finalizado' : 'pendiente'; ?>">
              <?php echo ucfirst(strtolower($lst_tareas[$tx]['Estatus'])); ?>
            </span>
          </div>

          <div class="actividad-col inicio">
            <?php echo fechaMes($lst_tareas[$tx]['FecIni']); ?>
          </div>

          <div class="actividad-col fin">
            <?php echo fechaMes($lst_tareas[$tx]['FecFin']); ?>
          </div>

          <div class="actividad-col porcentaje <?php echo ($idT == 4) ? 'tachado' : ''; ?>">
            <?php echo $cal . '/' . $lst_tareas[$tx]['Porcentaje']; ?>
          </div>

          <div class="actividad-col grade">
            <?php echo $cal; ?>
          </div>
        </div>

      <?php
            $miCal += $cal;
            $por += $lst_tareas[$tx]['Porcentaje'];
            $pf = $lst_tareas[$tx]['NoParcial'];
            $cf = $lst_tareas[$tx]['NoParcial'];
          }

          /* CERRAR ÚLTIMO PARCIAL */
          if (sizeof($lst_tareas) > 0) { ?>
        <div class="parcial-foot">
          <span>Calificación: </span>
          <strong><?php echo $miCal;
                  $sumP += $miCal; ?></strong>
        </div>
        </div>
      <?php } ?>

    <?php } else { ?>

      <div class="parcial-box">
        <div class="parcial-head">
          <h3>Lista de tareas</h3>
        </div>
        <div class="parcial-body">
          <div class="tareas-empty-state">
            <div class="tareas-empty-icon">
              <i class="fa fa-clipboard"></i>
            </div>

            <h4>Aún no hay tareas disponibles</h4>

            <p>
              Por el momento esta materia no tiene actividades publicadas.
              Cuando el docente habilite tareas, ejercicios o evaluaciones, aparecerán en esta sección.
            </p>

            <div class="tareas-empty-note">
              <i class="fa fa-info-circle"></i>
              Revisa más tarde para consultar nuevas actividades.
            </div>
          </div>
        </div>
      </div>

    <?php } ?>

        <div class="promedio-final">
          <span>Promedio final de la materia</span>
          <div class="promedio-box">
            <?php if (!empty($lst_tareas) && sizeof($lst_tareas) > 0) { ?>
              <?php if (isset($materia[0]["Fecha_impresion"])) { ?>
                <?php echo isset($lst_prom[0]) ? $lst_prom[0]['Promedio'] : '0'; ?>
              <?php } else { ?>
                PENDIENTE
              <?php } ?>
            <?php } else { ?>
              SIN TAREAS
            <?php } ?>
          </div>
        </div>
      </div>
      
    </div>
    
  </div>
  <section class="content"></section>
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