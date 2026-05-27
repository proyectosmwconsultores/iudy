<?php session_start();
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
require('../../hace.php');
$formatos = new Class_formatos();
$cal = $formatos->get_cal_all_us($IdUsua);
$alumno = $formatos->get_datos_alumno_id($IdUsua);
$pagPend = $formatos->get_pagPendientes($IdUsua);
$beca = $formatos->get_datBeca($IdUsua);
$creditosall = $formatos->get_total_creditos($alumno[0]['IdOferta'],$alumno[0]['IdCampus'],$alumno[0]['Termino']);
$miscreditos = $formatos->get_mis_creditos($IdUsua);

$grpz = $alumno[0]["TipoCiclo"];
$_mod10 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 10);
$_mod14 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 14);
$_mod15 = $formatos->get_mod_lista_id($_SESSION['IdUsua'], 15);

if ($grpz == "C") {
  $txtGrp = "CUATRIMESTRE";
} elseif ($grpz == "S") {
  $txtGrp = "SEMESTRE";
} else {
  $txtGrp = "TRIMESTRE";
}

?>
<?php if($alumno[0]['IdOferta'] == 30){
if($alumno[0]['Termino'] > 1){ 
    $cred = $creditosall[0]['Total']; } else {  $cred = 0;}
  } else {
    $cred = $creditosall[0]['Total'];
  } 
?>

<?php if(isset($alumno[0]['IdOferta'])){ 
  if($cred == 0){
    $cred = 456;
    $cred = $cred.' (PENDIENTE LA TERMINACIÓN)';
    $divi = (100 / 456);
    $porceActual = intval($divi * $miscreditos[0]['Total']);
  } else {
    $divi = (100 / $cred);
    $porceActual = intval($divi * $miscreditos[0]['Total']);
  }
  
  ?>
<p><b>Créditos:</b> <code><?php echo $miscreditos[0]['Total']; ?> de <?php echo $cred; ?></code></p>
<div class="progress progress-sm active">
  <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $porceActual; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $porceActual; ?>%">
  <span class="sr-only"><?php echo $porceActual; ?>% Complete</span>
  </div>
</div>
<?php } ?>

<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #c1c5ffc4;">
      <th colspan="4"><i class="fa fa-fw fa-book"></i> <?php echo $alumno[0]["NomEducativa"]; ?> <b style="color: blue;"><?php if($alumno[0]["Termino"] > 1){ if($alumno[0]["Termino"] == '2'){ echo "(CLINICA)"; } elseif($alumno[0]["Termino"] == '3'){ echo "(ORGANIZACIONAL)"; } elseif($alumno[0]["Termino"] == '4'){ echo "(EDUCATIVA)"; }  } ?></b></th>
    </tr>
    <tr>
      <td style="text-align: right;" class="text-blue">CAMPUS:</td>
      <td><?php echo $alumno[0]["Campus"]; ?></td>
      <td style="text-align: right;" class="text-blue">MODALIDAD:</td>
      <td><?php echo $alumno[0]['_Modalidad'] . ' - ' . $alumno[0]['_Dias']; ?></td>
    </tr>
    <tr>
      <td style="text-align: right;" class="text-blue">GRUPO:</td>
      <td><?php echo $alumno[0]["CveGrupo"]; ?></td>
      <td style="text-align: right;" class="text-blue">GRADO:</td>
      <td><?php echo $alumno[0]["SemCua"] . $alumno[0]["Abreviatura"] . ' ' . $txtGrp; ?></td>
    </tr>
    <tr>
      <td style="text-align: right;" class="text-blue">CELULAR:</td>
      <td><?php echo $alumno[0]["Celular"]; ?></td>
      <td style="text-align: right;" class="text-blue">Correo:</td>
      <td><?php echo $alumno[0]["Correo"]; ?></td>
    </tr>
  </tbody>
</table>


<?php if (isset($beca[0]["IdBeca"])) { ?>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>
      <tr style="background: #c1c5ffc4;">
        <th colspan="6"><i class="fa fa-fw fa-black-tie"></i> Becas activas del alumno </th>
      </tr>
      <tr>
        <td class="text-blue">Concepto</td>
        <td class="text-blue">Beca (%)</td>
        <td class="text-blue">Aplicado por</td>
        <td class="text-blue">Fecha captura</td>
      </tr>
      <?php for ($b = 0; $b < sizeof($beca); $b++) { ?>
        <tr id="bec_<?php echo $beca[$b]["IdBeca"]; ?>">
          <td><?php echo $beca[$b]["NomConcepto"]; ?></td>
          <td><?php echo $beca[$b]["Porcentaje"]; ?>%</td>
          <td><?php if ($beca[$b]["Crm"] == 1) {
                echo $beca[$b]["Nota"];
              } else {
                echo $beca[$b]["Nombre"] . ' ' . $beca[$b]["APaterno"] . ' ' . $beca[$b]["AMaterno"];
              } ?></td>
          <td><?php echo $beca[$b]["FecCap"]; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <hr><?php } ?>


<table class="table table-striped" style="font-size: 12px;">
  <tbody>
    <tr style="background: #c1c5ffc4;">
      <th colspan="6"><i class="fa fa-fw fa-bell"></i> Pagos pendientes del alumno </th>
    </tr>
    <tr>
      <td class="text-blue">Concepto</td>
      <td class="text-blue">Mes</td>
      <td class="text-blue">Fecha límite de pago</td>
    </tr>
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
        <td><?php echo $pagPend[$p]["NomPlan"] . $nomMat;
            if ($pagPend[$p]['IdEstatus'] == 58) {
              echo "<b style='color: blue;'> - (Congelado)</b>";
            } ?> </td>
        <td><?php echo obtenerAnioMes($pagPend[$p]["Fecha"]); ?></td>
        <td><?php echo obtenerFechaCorta($pagPend[$p]["Fecha"]); ?></td>
      </tr>
    <?php  }  ?>

  </tbody>
</table>

<div class="btn-group">
  <?php if ((isset($_mod14[0])) && ($kx == 1)) { ?>
    <button onclick="javascript:window.open('repositorio/pdf/saldoTotal.php?tokenId=<?php echo time() . time() . $IdUsua; ?>');" href="javascript:void(0);" style="margin-left: 5px;" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-fw fa-cloud-download"></i> Descargar pagos pendientes</button>
  <?php } ?>
</div>