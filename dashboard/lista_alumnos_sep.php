<?php
session_start();

$IdUsua = $_SESSION['IdUsua'];

require('../php/clases/class.System.php');
$db = new Conexion();

$IdCiclo = isset($_POST['IdCiclo']) ? intval($_POST['IdCiclo']) : 0;
$IdCampus = isset($_POST['IdCampus']) ? intval($_POST['IdCampus']) : 0;

$whereCampus = " AND tblc_rvoe.IdCampus <= 5 ";

if (!empty($IdCampus) && $IdCampus != 0) {
  $whereCampus = " AND tblc_rvoe.IdCampus = '$IdCampus' ";
}

function h(string $value)
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function esAlumnoActivo(array $item): bool
{
  $idActivo = isset($item["IdActivo"]) ? intval($item["IdActivo"]) : 0;
  $estatus = isset($item["Estatus"]) ? mb_strtolower(trim($item["Estatus"]), 'UTF-8') : "";

  return ($idActivo === 1 || $estatus === "activo" || $estatus === "activa" || $estatus === "vigente");
}

$sql_lsta = $db->query("SELECT
    tblc_alumnos.IdActivo, 
    tblc_alumnos.IdGrupo, 
    tblc_alumnos.IdCiclo, 
    tblc_alumnos.IdUsua, 
    tblc_alumnos.Grado, 
    tblc_alumnos.Tipo, 
    tblc_alumnos.IdEstatus, 
    tblc_usuario.Usuario, 
    tblc_usuario.Nombre, 
    tblc_usuario.APaterno, 
    tblc_usuario.AMaterno, 
    tblc_usuario.Porcentaje, 
    tblc_rvoe.Rvoe, 
    tblc_rvoe.Educativa, 
    tblc_rvoe.IdCampus, 
    tblc_campus.Campus, 
    tblp_grupo.CveGrupo, 
    tblc_dias_clases.Dias_clase, 
    tblc_estatus.Estatus,
    tblc_usuario._horario
FROM
    tblc_alumnos
    LEFT JOIN tblc_usuario
        ON tblc_alumnos.IdUsua = tblc_usuario.IdUsua
    LEFT JOIN tblc_rvoe
        ON tblc_usuario._idRvoe = tblc_rvoe.IdRvoe
    LEFT JOIN tblc_campus
        ON tblc_rvoe.IdCampus = tblc_campus.IdCampus
    LEFT JOIN tblp_grupo
        ON tblc_usuario.IdGrupo = tblp_grupo.IdGrupo
    LEFT JOIN tblc_dias_clases
        ON tblp_grupo.Dia = tblc_dias_clases.Dia
    LEFT JOIN tblc_estatus
        ON tblc_usuario.IdEstatus = tblc_estatus.IdEstatus
WHERE
    tblc_alumnos.IdCiclo = '$IdCiclo'
    $whereCampus
ORDER BY
    tblc_rvoe.IdCampus ASC, 
    tblc_campus.Campus ASC,
    tblc_rvoe.IdEducativa ASC,
    tblc_rvoe.Educativa ASC,
    tblc_usuario.APaterno ASC,
    tblc_usuario.AMaterno ASC,
    tblc_usuario.Nombre ASC
");

$sql_cic = $db->query("
    SELECT 
        tblc_ciclo.Ciclo 
    FROM 
        tblc_ciclo 
    WHERE 
        tblc_ciclo.IdCiclo = '$IdCiclo'
");

$db->rows($sql_cic);
$_cic = $db->recorrer($sql_cic);

$datos = array();

while ($row = $db->recorrer($sql_lsta)) {
  $datos[] = $row;
}

/*
  Concentrados generales
*/
$totalAlumnos = 0;
$totalPersonalizados = 0;

$concentradoCampus = array();
$concentradoOferta = array();
$concentradoDias = array();
$concentradoEstatus = array();

/*
  Concentrados solo usuarios/alumnos activos
*/
$totalAlumnosActivos = 0;
$totalPersonalizadosActivos = 0;

$concentradoCampusActivos = array();
$concentradoOfertaActivos = array();
$concentradoDiasActivos = array();

foreach ($datos as $item) {

  $totalAlumnos++;

  $campus = !empty($item["Campus"]) ? $item["Campus"] : "Sin campus";
  $oferta = !empty($item["Educativa"]) ? $item["Educativa"] : "Sin oferta educativa";
  $diasClase = !empty($item["Dias_clase"]) ? $item["Dias_clase"] : "Sin días asignados";
  $estatus = !empty($item["Estatus"]) ? $item["Estatus"] : "Sin estatus";

  if (!isset($concentradoCampus[$campus])) {
    $concentradoCampus[$campus] = 0;
  }

  if (!isset($concentradoOferta[$oferta])) {
    $concentradoOferta[$oferta] = 0;
  }

  if (!isset($concentradoDias[$diasClase])) {
    $concentradoDias[$diasClase] = 0;
  }

  if (!isset($concentradoEstatus[$estatus])) {
    $concentradoEstatus[$estatus] = 0;
  }

  $concentradoCampus[$campus]++;
  $concentradoOferta[$oferta]++;
  $concentradoDias[$diasClase]++;
  $concentradoEstatus[$estatus]++;

  if ($diasClase == "Personalizado") {
    $totalPersonalizados++;
  }

  /*
    Solo activos
  */
  if (esAlumnoActivo($item)) {

    $totalAlumnosActivos++;

    if (!isset($concentradoCampusActivos[$campus])) {
      $concentradoCampusActivos[$campus] = 0;
    }

    if (!isset($concentradoOfertaActivos[$oferta])) {
      $concentradoOfertaActivos[$oferta] = 0;
    }

    if (!isset($concentradoDiasActivos[$diasClase])) {
      $concentradoDiasActivos[$diasClase] = 0;
    }

    $concentradoCampusActivos[$campus]++;
    $concentradoOfertaActivos[$oferta]++;
    $concentradoDiasActivos[$diasClase]++;

    if ($diasClase == "Personalizado") {
      $totalPersonalizadosActivos++;
    }
  }
}

ksort($concentradoCampus);
ksort($concentradoOferta);
ksort($concentradoDias);
ksort($concentradoEstatus);

ksort($concentradoCampusActivos);
ksort($concentradoOfertaActivos);
ksort($concentradoDiasActivos);

$totalCampus = count($concentradoCampus);
$totalOfertas = count($concentradoOferta);

$totalCampusActivos = count($concentradoCampusActivos);
$totalOfertasActivos = count($concentradoOfertaActivos);
?>

<style>
  .students-dashboard {
    background: #f5f7fb;
    padding: 22px;
    border-radius: 14px;
    font-family: "Segoe UI", Arial, sans-serif;
  }

  .students-header {
    background: linear-gradient(135deg, #3f2b96, #6c63ff);
    color: #ffffff;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 8px 20px rgba(63, 43, 150, 0.22);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
  }

  .students-header-title {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .students-header-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.16);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .students-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.2px;
  }

  .students-header p {
    margin: 4px 0 0 0;
    font-size: 13px;
    opacity: 0.9;
  }

  .period-badge {
    background: #fff;
    color: #3f2b96;
    padding: 9px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
  }

  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 22px;
  }

  .kpi-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px 18px;
    box-shadow: 0 6px 18px rgba(20, 32, 60, 0.08);
    border: 1px solid #edf0f7;
    border-left: 5px solid #6c63ff;
  }

  .kpi-card-active {
    border-left-color: #16a34a;
  }

  .kpi-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: #6b7280;
    letter-spacing: 0.4px;
    margin-bottom: 7px;
  }

  .kpi-value {
    font-size: 28px;
    font-weight: 900;
    color: #111827;
    line-height: 1;
  }

  .kpi-help {
    margin-top: 7px;
    font-size: 11px;
    color: #9ca3af;
  }

  .students-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 18px;
    box-shadow: 0 6px 18px rgba(20, 32, 60, 0.08);
    border: 1px solid #edf0f7;
    margin-bottom: 22px;
  }

  .students-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    gap: 12px;
    flex-wrap: wrap;
  }

  .students-card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 800;
    color: #1f2937;
  }

  .students-card-subtitle {
    margin: 4px 0 0 0;
    font-size: 12px;
    color: #6b7280;
  }

  .table-responsive-custom {
    width: 100%;
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #edf0f7;
  }

  .students-table,
  .summary-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
    color: #374151;
    margin-bottom: 0;
  }

  .students-table thead th,
  .summary-table thead th {
    background: #111827;
    color: #ffffff;
    padding: 12px 10px;
    font-weight: 800;
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.4px;
    border: none;
    white-space: nowrap;
  }

  .students-table tbody td,
  .summary-table tbody td {
    padding: 11px 10px;
    border-bottom: 1px solid #eef2f7;
    vertical-align: middle;
    background: #ffffff;
  }

  .students-table tbody tr:hover td,
  .summary-table tbody tr:hover td {
    background: #f9fafb;
  }

  .row-number {
    width: 48px;
    text-align: center;
    font-weight: 800;
    color: #6b7280;
  }

  .student-name {
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
  }

  .student-small {
    font-size: 11px;
    color: #6b7280;
    margin-top: 2px;
  }

  .badge-carrera {
    background: #ecfdf5;
    color: #047857;
    padding: 5px 9px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 11px;
    display: inline-block;
  }

  .badge-grado {
    background: #fef3c7;
    color: #92400e;
    padding: 5px 9px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 11px;
    display: inline-block;
    min-width: 34px;
    text-align: center;
  }

  .badge-dia {
    background: #e0f2fe;
    color: #0369a1;
    padding: 5px 9px;
    border-radius: 999px;
    font-weight: 700;
    font-size: 11px;
    display: inline-block;
    white-space: nowrap;
  }

  .badge-personalizado {
    background: #fee2e2;
    color: #b91c1c;
    padding: 5px 9px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 11px;
    display: inline-block;
    white-space: nowrap;
  }

  .badge-activo {
    background: #dcfce7;
    color: #166534;
    padding: 5px 9px;
    border-radius: 999px;
    font-weight: 800;
    font-size: 11px;
    display: inline-block;
    white-space: nowrap;
  }

  .campus-group-row td {
    padding: 0 !important;
    border-bottom: none !important;
    background: #f5f7fb !important;
  }

  .campus-group-title {
    background: linear-gradient(135deg, #111827, #374151);
    color: #ffffff;
    padding: 13px 16px;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 0.3px;
    border-radius: 10px;
    margin: 12px 8px 8px 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .campus-group-title i {
    margin-right: 8px;
    color: #fbbf24;
  }

  .campus-count {
    background: rgba(255, 255, 255, 0.14);
    padding: 5px 11px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
  }

  .summary-section {
    margin-top: 24px;
  }

  .summary-title {
    margin: 0 0 14px 0;
    font-size: 18px;
    font-weight: 900;
    color: #111827;
  }

  .summary-title-active {
    color: #166534;
  }

  .summary-subtitle {
    margin: -7px 0 18px 0;
    font-size: 12px;
    color: #6b7280;
  }

  .summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
  }

  .summary-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
  }

  .summary-card {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px;
    box-shadow: 0 6px 18px rgba(20, 32, 60, 0.08);
    border: 1px solid #edf0f7;
  }

  .summary-card-active {
    border-top: 4px solid #16a34a;
  }

  .summary-card-title {
    margin: 0 0 12px 0;
    font-size: 14px;
    font-weight: 900;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .summary-card-title i {
    color: #6c63ff;
  }

  .summary-card-active .summary-card-title i {
    color: #16a34a;
  }

  .summary-number {
    text-align: center;
    font-weight: 900;
    color: #111827;
    font-size: 14px;
  }

  .summary-total-row td {
    background: #f3f4f6 !important;
    font-weight: 900;
    color: #111827;
  }

  .summary-total-row-active td {
    background: #dcfce7 !important;
    font-weight: 900;
    color: #166534;
  }

  .no-records {
    text-align: center;
    padding: 28px !important;
    color: #6b7280;
    font-weight: 700;
  }

  @media (max-width: 1300px) {
    .summary-grid,
    .summary-grid-3 {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 1100px) {
    .summary-grid,
    .summary-grid-3 {
      grid-template-columns: 1fr;
    }

    .kpi-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 768px) {
    .students-dashboard {
      padding: 14px;
    }

    .students-header {
      padding: 16px;
    }

    .students-header h3 {
      font-size: 16px;
    }

    .period-badge {
      width: 100%;
      text-align: center;
    }

    .kpi-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="box-body">
  <div class="students-dashboard">

    <div class="students-header">
      <div class="students-header-title">
        <div class="students-header-icon">
          <i class="fa fa-fw fa-check-square-o"></i>
        </div>

        <div>
          <h3>Listado de alumnos por campus, carrera y horario</h3>
          <p>Consulta detallada de alumnos registrados en el periodo escolar seleccionado.</p>
        </div>
      </div>

      <div class="period-badge">
        Periodo: <?php echo !empty($_cic["Ciclo"]) ? h($_cic["Ciclo"]) : "Sin periodo"; ?>
      </div>
    </div>

    <div class="kpi-grid">
      <div class="kpi-card">
        <div class="kpi-label">Total alumnos</div>
        <div class="kpi-value"><?php echo number_format($totalAlumnos); ?></div>
        <div class="kpi-help">Alumnos encontrados en el periodo</div>
      </div>

      <div class="kpi-card kpi-card-active">
        <div class="kpi-label">Total activos</div>
        <div class="kpi-value"><?php echo number_format($totalAlumnosActivos); ?></div>
        <div class="kpi-help">Alumnos activos encontrados</div>
      </div>

      <div class="kpi-card">
        <div class="kpi-label">Oferta educativa</div>
        <div class="kpi-value"><?php echo number_format($totalOfertas); ?></div>
        <div class="kpi-help">Carreras/ofertas con alumnos</div>
      </div>

      <div class="kpi-card">
        <div class="kpi-label">Personalizados</div>
        <div class="kpi-value"><?php echo number_format($totalPersonalizados); ?></div>
        <div class="kpi-help">Alumnos con días personalizados</div>
      </div>
    </div>

    <div class="students-card">

      <div class="students-card-header">
        <div>
          <h4 class="students-card-title">Detalle de alumnos</h4>
          <p class="students-card-subtitle">
            Información agrupada visualmente por campus, carrera, avance, grado y días de clase.
          </p>
        </div>
      </div>

      <div class="table-responsive-custom">
        <table class="students-table table table-hover dataTables-example">
          <tbody>
            <?php
            $campusActual = "";
            $numCampus = 0;
            $hayRegistros = false;

            foreach ($datos as $matx) {

              $hayRegistros = true;

              $campus = !empty($matx["Campus"]) ? $matx["Campus"] : "Sin campus";
              $carrera = !empty($matx["Educativa"]) ? $matx["Educativa"] : "Sin carrera";
              $alumno = trim($matx["APaterno"] . ' ' . $matx["AMaterno"] . ' ' . $matx["Nombre"]);
              $grado = !empty($matx["Grado"]) ? $matx["Grado"] : "-";
              $diasClase = !empty($matx["Dias_clase"]) ? $matx["Dias_clase"] : "Sin días asignados";
              $grupo = !empty($matx["CveGrupo"]) ? $matx["CveGrupo"] : "Sin grupo";
              $porcentaje = isset($matx["Porcentaje"]) && $matx["Porcentaje"] !== "" ? $matx["Porcentaje"] : "0";
              $estatus = !empty($matx["Estatus"]) ? $matx["Estatus"] : "Sin estatus";

              $claseDias = ($diasClase == "Personalizado") ? "badge-personalizado" : "badge-dia";
              $activoAlumno = esAlumnoActivo($matx);

              if ($campusActual != $campus) {
                $campusActual = $campus;
                $numCampus = 0;
                $totalCampusActual = isset($concentradoCampus[$campusActual]) ? $concentradoCampus[$campusActual] : 0;
            ?>
                <tr class="campus-group-row">
                  <td colspan="6">
                    <div class="campus-group-title">
                      <div>
                        <i class="fa fa-university"></i>
                        CAMPUS: <?php echo h($campusActual); ?>
                      </div>

                      <div class="campus-count">
                        <?php echo number_format($totalCampusActual); ?> alumno(s)
                      </div>
                    </div>
                  </td>
                </tr>
              <?php } ?>

              <tr>
                <td class="row-number">
                  <?php echo ++$numCampus; ?>.-
                </td>

                <td>
                  <span class="badge-carrera">
                    <?php echo $matx["Rvoe"];?> - <?php echo h($carrera); ?>
                  </span>
                </td>

                <td>
                  <div class="student-name">
                    <?php echo $matx["IdUsua"];?>- <?php echo $matx["Usuario"];?> - <?php echo !empty($alumno) ? h($alumno) : "Sin nombre"; ?>
                  </div>
                  <div class="student-small">
                    Grupo: <?php echo h($grupo); ?> / 
                    Estatus: <?php echo h($estatus); ?>
                    <?php if ($activoAlumno) { ?>
                      / <span class="badge-activo">Activo</span>
                    <?php } ?>
                  </div>
                </td>

                <td>
                  <span class="badge-grado">
                    <?php echo h($porcentaje); ?>%
                  </span>
                </td>

                <td>
                  <span class="badge-grado">
                    <?php echo h($grado); ?>°
                  </span>
                </td>

                <td>
                  <span class="<?php echo $claseDias; ?>">
                    <?php echo h($diasClase); ?>
                  </span>
                </td>
              </tr>

            <?php } ?>

            <?php if (!$hayRegistros) { ?>
              <tr>
                <td colspan="6" class="no-records">
                  No se encontraron alumnos para el periodo seleccionado.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>

    <div class="summary-section">
      <h3 class="summary-title">Concentrado de totales</h3>
      <p class="summary-subtitle">
        Resumen general de alumnos por campus, estatus, oferta educativa y días de clase.
      </p>

      <div class="summary-grid">

        <div class="summary-card">
          <h4 class="summary-card-title">
            <i class="fa fa-university"></i>
            Alumnos por campus
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Campus</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoCampus as $campus => $total) { ?>
                  <tr>
                    <td><?php echo h($campus); ?></td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row">
                  <td>Total general</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="summary-card">
          <h4 class="summary-card-title">
            <i class="fa fa-check-circle"></i>
            Alumnos por estatus
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Estatus</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoEstatus as $estatus => $total) { ?>
                  <tr>
                    <td><?php echo h($estatus); ?></td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row">
                  <td>Total general</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="summary-card">
          <h4 class="summary-card-title">
            <i class="fa fa-graduation-cap"></i>
            Alumnos por oferta educativa
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Oferta educativa</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoOferta as $oferta => $total) { ?>
                  <tr>
                    <td><?php echo h($oferta); ?></td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row">
                  <td>Total general</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="summary-card">
          <h4 class="summary-card-title">
            <i class="fa fa-calendar"></i>
            Alumnos por días de clase
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Días de clase</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoDias as $dias => $total) {
                  $claseDiasResumen = ($dias == "Personalizado") ? "badge-personalizado" : "badge-dia";
                ?>
                  <tr>
                    <td>
                      <span class="<?php echo $claseDiasResumen; ?>">
                        <?php echo h($dias); ?>
                      </span>
                    </td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row">
                  <td>Total general</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

    <div class="summary-section">
      <h3 class="summary-title summary-title-active">Concentrado solo de usuarios activos</h3>
      <p class="summary-subtitle">
        Totales considerando únicamente alumnos activos.
      </p>

      <div class="kpi-grid">
        <div class="kpi-card kpi-card-active">
          <div class="kpi-label">Activos</div>
          <div class="kpi-value"><?php echo number_format($totalAlumnosActivos); ?></div>
          <div class="kpi-help">Total de alumnos activos</div>
        </div>

        <div class="kpi-card kpi-card-active">
          <div class="kpi-label">Campus activos</div>
          <div class="kpi-value"><?php echo number_format($totalCampusActivos); ?></div>
          <div class="kpi-help">Campus con alumnos activos</div>
        </div>

        <div class="kpi-card kpi-card-active">
          <div class="kpi-label">Ofertas activas</div>
          <div class="kpi-value"><?php echo number_format($totalOfertasActivos); ?></div>
          <div class="kpi-help">Ofertas con alumnos activos</div>
        </div>

        <div class="kpi-card kpi-card-active">
          <div class="kpi-label">Personalizados activos</div>
          <div class="kpi-value"><?php echo number_format($totalPersonalizadosActivos); ?></div>
          <div class="kpi-help">Activos con días personalizados</div>
        </div>
      </div>

      <div class="summary-grid-3">

        <div class="summary-card summary-card-active">
          <h4 class="summary-card-title">
            <i class="fa fa-university"></i>
            Alumnos activos por campus
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Campus</th>
                  <th>Total activos</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoCampusActivos as $campus => $total) { ?>
                  <tr>
                    <td><?php echo h($campus); ?></td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row-active">
                  <td>Total activos</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnosActivos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="summary-card summary-card-active">
          <h4 class="summary-card-title">
            <i class="fa fa-graduation-cap"></i>
            Alumnos activos por oferta educativa
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Oferta educativa</th>
                  <th>Total activos</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoOfertaActivos as $oferta => $total) { ?>
                  <tr>
                    <td><?php echo h($oferta); ?></td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row-active">
                  <td>Total activos</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnosActivos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="summary-card summary-card-active">
          <h4 class="summary-card-title">
            <i class="fa fa-calendar"></i>
            Alumnos activos por días de clase
          </h4>

          <div class="table-responsive-custom">
            <table class="summary-table">
              <thead>
                <tr>
                  <th>Días de clase</th>
                  <th>Total activos</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($concentradoDiasActivos as $dias => $total) {
                  $claseDiasResumen = ($dias == "Personalizado") ? "badge-personalizado" : "badge-dia";
                ?>
                  <tr>
                    <td>
                      <span class="<?php echo $claseDiasResumen; ?>">
                        <?php echo h($dias); ?>
                      </span>
                    </td>
                    <td class="summary-number"><?php echo number_format($total); ?></td>
                  </tr>
                <?php } ?>

                <tr class="summary-total-row-active">
                  <td>Total activos</td>
                  <td class="summary-number"><?php echo number_format($totalAlumnosActivos); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>