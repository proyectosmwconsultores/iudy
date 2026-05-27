<?php
$_v = 60;
$section = "Mi materia";
include("head.php");

if ($_SESSION['IdUsua']) {
  $addIngresos = $t->add_ingresos($_SESSION['IdUsua'], 'El usuario ha ingresado a la materia.');
}

$contenido->get_validar_mat($_GET['idAsignacion'], $_SESSION['IdUsua']);
$materia = $t->get_materia_id($_GET['idAsignacion']);
$actividades = $t->get_actividades_id($_GET['idAsignacion']);

?>
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

<body class="hold-transition skin-<?php echo $configuracion[15]["Descripcion"]; ?> sidebar-mini fixed">
  <div class="wrapper">
    <?php include("menuV.php"); ?>
    <div class="content-wrapper">
      <div class="topbar-planeacion">
        <div class="topbar-planeacion__left">
          <h1> <i class="fa fa-flag"></i> MI ASIGNATURA </h1>
        </div>
        <div class="topbar-planeacion__right">
          <span>MATERIA</span>
          <i class="fa fa-angle-right"></i>
          <span class="active"><?php echo $materia[0]['NombreMod']; ?></span>
        </div>
      </div>
      <section class="content">
        <form name="frm" id="frm" action="doSelActa.php" method="POST" enctype="multipart/form-data">
          <input id="idAsignacion" name="idAsignacion" value="<?php echo $_GET["idAsignacion"]; ?>" type="hidden" />
          <input id="IdMenu" name="IdMenu" value="11" type="hidden" />

          <div class="materia-shell">

            <!-- SIDEBAR -->
            <aside class="materia-sidebar">

              <div class="panel-card">
                <div class="panel-card-body">
                  <div class="teacher-card">
                    <div class="teacher-avatar">
                      <img style="width: 60px; height: 60px;" src="assets/perfil/<?php echo $materia[0]['Foto']; ?>" alt="Docente">
                    </div>
                    <div class="teacher-info">
                      <h5>
                        <?php echo $materia[0]['Nombre'] . ' ' . $materia[0]['APaterno'] . ' ' . $materia[0]['AMaterno']; ?>
                      </h5>
                      <span>Responsable de la materia</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="panel-card">
                <div class="panel-card-body">
                  <h4 class="panel-title">Fechas de la materia</h4>

                  <div class="info-stack">
                    <div class="info-row">
                      <div class="info-icon">
                        <i class="fa fa-calendar-check-o"></i>
                      </div>
                      <div class="info-copy">
                        <span>Inicia</span>
                        <strong><?php echo !empty($materia[0]['FecIni']) ? obtenerFechaCorta($materia[0]['FecIni']) : 'No disponible'; ?></strong>
                      </div>
                    </div>

                    <div class="info-row">
                      <div class="info-icon danger">
                        <i class="fa fa-calendar-times-o"></i>
                      </div>
                      <div class="info-copy">
                        <span>Finaliza</span>
                        <strong><?php echo !empty($materia[0]['FecFin']) ? obtenerFechaCorta($materia[0]['FecFin']) : 'No disponible'; ?></strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="agenda-panel">
                <div class="agenda-head">
                  <h3>Próximas actividades</h3>
                  <p>Eventos relevantes de la materia</p>
                </div>

                <div class="agenda-list">
                  <?php for ($c = 0; $c < sizeof($actividades); $c++) { ?>
                    <div class="agenda-item" onclick="window.open('miAula.php?idAsignacion=<?php echo $_GET['idAsignacion']; ?>&idToks=<?php echo $actividades[$c]['IdParcialDocente'] . '_' . $actividades[$c]['IdSemanaDocente'] . '_' . $actividades[$c]['IdActividadesDocente']; ?>','_self')" style="cursor: pointer;">
                      <div class="agenda-dot blue"></div>
                      <div class="agenda-content">
                        <strong><?php echo $actividades[$c]['NomActividad']; ?></strong>
                        <span><?php echo $actividades[$c]['FecFin']; ?> · 11:59 pm</span>
                      </div>
                    </div>
                  <?php } ?>
                </div>


            </aside>
            <div class="agenda-panel">
              <div class="agenda-head">
                <h3><?php echo $materia[0]['Educativa']; ?></h3>
                <p><?php echo $materia[0]['CodeModulo']; ?> · <?php echo $materia[0]['NombreMod']; ?></p>
              </div>

              <!-- MAIN -->
              <main class="materia-main">
                <div class="calendar-panel">
                  <div class="calendar-panel-head">
                    <div>
                      <h3>Calendario académico</h3>
                      <p>Consulta actividades, entregas y eventos programados de la materia.</p>
                    </div>
                  </div>

                  <div class="calendar-container">
                    <div id="calendarMateria"></div>
                  </div>
                </div>

              </main>
            </div>
        </form>
      </section>
    </div>

    <div id="dataEva" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header" style="background: #4c489e; color: white; font-size: 16px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><i class="fa fa-fw fa-wechat"></i> Comentarios realizados</h4>
          </div>
          <div class="modal-body" id="employee_eva"></div>
        </div>
      </div>
    </div>


    <?php include("footer.php"); ?>
  </div>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">

  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales-all.global.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      inicializarCalendarioMateria();
    });

    function inicializarCalendarioMateria() {
      var calendarEl = document.getElementById('calendarMateria');
      if (!calendarEl) return;

      var idAsignacion = document.getElementById('idAsignacion').value;

      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        height: 'auto',
        firstDay: 0,
        navLinks: true,
        nowIndicator: true,
        dayMaxEvents: 3,
        fixedWeekCount: false,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
          today: 'Hoy',
          month: 'Mes',
          week: 'Semana',
          day: 'Día'
        },

        events: function(fetchInfo, successCallback, failureCallback) {
          $.ajax({
            url: 'alumnos/getEventosCalendario.php',
            type: 'POST',
            dataType: 'json',
            data: {
              idAsignacion: idAsignacion,
              start: fetchInfo.startStr,
              end: fetchInfo.endStr
            },
            success: function(response) {
              successCallback(response);
            },
            error: function() {
              failureCallback();
            }
          });
        },

        eventClick: function(info) {
          info.jsEvent.preventDefault();

          if (info.event.extendedProps.urlInterna) {
            window.location.href = info.event.extendedProps.urlInterna;
            return;
          }

          if (info.event.url) {
            window.open(info.event.url, '_blank');
          }
        }
      });

      calendar.render();
    }
  </script>



  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
  <script src="dist/js/demo.js"></script>