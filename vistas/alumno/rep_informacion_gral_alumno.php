<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$chk = $formatos->chek_materias_repetidas($IdUsua);
$cal = $formatos->get_cal_all_us($IdUsua);
$alumno = $formatos->get_datos_alumno_id($IdUsua);
$pagPend = $formatos->get_pagPendientes($IdUsua);
$beca = $formatos->get_datBeca($IdUsua);
$misGrados = $formatos->get_mis_grados_estudiados($IdUsua);


$creditosall = $formatos->get_total_creditos($alumno[0]['IdOferta'], $alumno[0]['_idCampus'], $alumno[0]['Termino'], $alumno[0]['IdGrado']);
$miscreditos = $formatos->get_mis_creditos($IdUsua);
$porceActual = 0;
$grpz = $alumno[0]["TipoCiclo"];
$_mod10 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 10);
$_mod14 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 14);
$_mod15 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 15);

$donacion = $formatos->get_donacion_id($IdUsua);

if ($grpz == "C") {
  $txtGrp = "CUATRIMESTRE";
} elseif ($grpz == "S") {
  $txtGrp = "SEMESTRE";
} elseif ($grpz == "T") {
  $txtGrp = "TRIMESTRE";
} else {
  $txtGrp = "---";
}

?>
<?php


if ($alumno[0]['IdOferta'] == 30) {
  if ($alumno[0]['Termino'] > 1) {
    $cred = $creditosall[0]['Total'];
  } else {
    $cred = 0;
  }
} else {
  $cred = $creditosall[0]['Total'];
}
?>

<?php if (isset($alumno[0]['IdOferta'])) {
  if ($alumno[0]['IdOferta'] == 30) {
    $cred = 456;
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


  if ($porceActual == 100) {
    $formatos->get_concluido_creditos($IdUsua, $alumno[0]['IdGrado']);
  }
?>
  <p><b>Créditos (<?php echo $porceActual; ?>%): </b> <code><?php echo $miscreditos[0]['Total']; ?> de <?php echo $cred; ?></code> </p>
  <div class="progress progress-sm active">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $porceActual; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porceActual; ?>%">
      <span class="sr-only"><?php echo $porceActual; ?>% Complete</span>
    </div>
  </div>
<?php } ?>

<p class="text-muted text-center" style="color: blue;"><?php if (isset($alumno[0]["Trayectoria"])) { echo "<i class='fa fa-fw fa-graduation-cap'></i> " . $alumno[0]["Trayectoria"]; } ?></p>


<section class="pay-page">
  <div class="paytabs-card">
    <div class="paytabs-header">
      <div class="paytabs-title-area">
        <div class="paytabs-icon">📋</div>
        <div>
          <div class="paytabs-title"><?php echo $alumno[0]["NomEducativa"]; ?> <b style="color: blue;"><?php if ($alumno[0]["Termino"] > 1) { if ($alumno[0]["Termino"] == '2') { echo "(CLINICA)"; } elseif ($alumno[0]["Termino"] == '3') { echo "(ORGANIZACIONAL)"; } elseif ($alumno[0]["Termino"] == '4') { echo "(EDUCATIVA)"; } } ?></b></div>
          <div class="paytabs-sub"><?php echo $alumno[0]["Campus"]; ?></div>
        </div>
      </div>
    </div>
    <div class="paytabs-content">
      <div class="paypanel is-active" data-content="pendientes">
        <table class="docs-table" aria-label="Documentos en revisión">
          <tbody>
            <tr>
              <td style="text-align: right;" class="text-blue">CAMPUS:</td>
              <td class="docs-td-strong"><?php echo $alumno[0]["Campus"]; ?></td>
              <td style="text-align: right;" class="text-blue">MODALIDAD:</td>
              <td class="docs-td-strong"><?php echo $alumno[0]['_Modalidad'] . ' - ' . $alumno[0]['_Dias']; ?></td>
            </tr>
            <tr>
              <td style="text-align: right;" class="text-blue">GRUPO:</td>
              <td class="docs-td-strong"><?php echo $alumno[0]["CveGrupo"]; ?></td>
              <td style="text-align: right;" class="text-blue">GRADO:</td>
              <td class="docs-td-strong"><?php if ($alumno[0]["_horario"] == 'P') { echo 'PERSONALIZADO'; } else { echo $alumno[0]["SemCua"] . $alumno[0]["Abreviatura"] . ' ' . $txtGrp; } ?></td>
            </tr>
            <tr>
              <td style="text-align: right;" class="text-blue">CELULAR:</td>
              <td class="docs-td-strong"><?php echo $alumno[0]["Celular"]; ?></td>
              <td style="text-align: right;" class="text-blue">Correo:</td>
              <td class="docs-td-strong"><?php echo $alumno[0]["Correo"]; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <div class="paytabs-card" style="margin-top: 15px;">
    <div class="paytabs-header">
      <div class="paytabs-title-area">
        <div class="paytabs-icon">📋</div>
        <div>
          <div class="paytabs-title">Pagos pendientes del alumno </div>
          <div class="paytabs-sub">Lista de pagos pendientes del alumno </div>
        </div>
      </div>
    </div>
    <div class="paytabs-content">
      <div class="paypanel is-active" data-content="pendientes">
        <table class="docs-table" aria-label="Documentos en revisión">
          <thead>
            <tr>
              <td class="text-blue">Concepto</td>
              <td class="text-blue">Mes</td>
              <td class="text-blue">Fecha límite de pago</td>
            </tr>
          </thead>
          <tbody>
            <?php $kx = 0;
            for ($p = 0; $p < sizeof($pagPend); $p++) {
              $kx = 1;
              $nomMat = '';
              if (isset($pagPend[$p]["IdModulo"])) {
                $miMatx = $formatos->get_misMat($pagPend[$p]["IdModulo"]);
                $nomMat = ' <b>*' . $miMatx[0]['NombreMod'] . '</b>';
              }
            ?>
              <tr>
                <td class="docs-td-strong"><?php echo $pagPend[$p]["NomPlan"] . $nomMat; if ($pagPend[$p]['IdEstatus'] == 58) { echo "<b style='color: blue;'> - (Congelado)</b>"; } ?> </td>
                <td class="docs-td-strong"><?php echo obtenerAnioMes($pagPend[$p]["Fecha"]); ?></td>
                <td class="docs-td-strong"><?php echo obtenerFechaCorta($pagPend[$p]["Fecha"]); ?></td>
              </tr>
            <?php  }  ?>
          </tbody>
        </table>
        <div class="box-footer">
          <?php if (isset($donacion[0])) { ?>
            <button onclick="javascript:window.open('repositorio/formatos/donacion.php?idToks=<?php echo $donacion[0]['Code']; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-cloud-download"></i> Descargar oficio de donación </button>
          <?php } ?>
          <?php if ((isset($_mod14[0])) && ($kx == 1)) { ?>
            <button onclick="javascript:window.open('repositorio/pdf/saldoTotal.php?tokenId=<?php echo time() . time() . $IdUsua; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-fw fa-cloud-download"></i> Descargar pagos pendientes</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  

  <div class="paytabs-card" style="margin-top: 15px;">
    <div class="paytabs-header">
      <div class="paytabs-title-area">
        <div class="paytabs-icon">📋</div>
        <div>
          <div class="paytabs-title">Trámites escolares </div>
          <div class="paytabs-sub">Fichas de inscripción por grado </div>
        </div>
      </div>
    </div>
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
                    <!-- <a class="pay-btn is-ghost" onclick="window.open('repositorio/portafolio/ficha_inscripcion.php?id=<?php echo time() . $_SESSION['IdUsua']; ?>&idToks=<?php echo time() . $misGrados[$i]['IdCiclo']; ?>','_blank')" href="javascript:void(0);" title="Subir comprobante"><i class="fa fa-fw fa-cloud-download"></i></a> -->
                  </div>
                </td>
                <td class="docs-td-strong" style="text-align: center;"><?php if ($misGrados[$i]["Dia"] == 'P') { echo "-"; } else { echo $misGrados[$i]["Grado"] . '°'; } ?></td>
                <td class="docs-td-muted"><?php echo $misGrados[$i]["Ciclo"]; ?></td>
              </tr><?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>