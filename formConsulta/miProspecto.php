<?php
session_start();
require('../php/clases/class.System.php');
include('../hace.php');
$db = new Conexion();

$IdUsua = $_POST['IdUsua'];
$Tipo = $_POST['Tipo'];
$anio = date("Y");

$sql_user = $db->query("SELECT tblc_usuario.Nombre, tblc_usuario.APaterno, tblc_usuario.AMaterno, tblc_usuario.IdOferta, tblc_usuario.IdCampus, tblc_usuario.Grado, tblc_usuario.GPago, tblc_usuario.id_ciclo_ini, tblc_usuario.IdOferta, tblc_usuario.IdGrupo, tblc_usuario.id_paquete, tblp_educativa.IdGrado FROM tblc_usuario LEFT JOIN tblp_educativa ON tblc_usuario.IdOferta = tblp_educativa.IdEducativa WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql_user);
$_user = $db->recorrer($sql_user);
$_grado = $_user['IdGrado'];
$IdGrado = $_user['IdGrado'];
$IdGrupo = $_user['IdGrupo'];
$IdOferta = $_user['IdOferta'];
$Id_Ciclo = $_user['id_ciclo_ini'];
$Id_Campus = $_user['IdCampus'];
$idpaq = $_user['id_paquete'];
$g_pago = $_user['GPago'];

$sql_info = $db->query("SELECT * FROM tblp_informacion WHERE tblp_informacion.IdUsua = '$IdUsua'");
$db->rows($sql_info);
$_info = $db->recorrer($sql_info);
$tipoGrado = $_info['C_tipo'];

if ($idpaq == 'LMS') {
  $idpaq = 9;
} else {
  $idpaq = 0;
}
if ($g_pago == 1) {
  $sql_pag_gen = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.FecCap, tblc_conceptosplanes.NomPlan, tblp_pagos.IdEstatus, tblp_pagos.IdConcepto, tblp_pagos.Descuento, tblp_pagos.Monto, tblh_detallepagos.Archivo, tblh_detallepagos.Estatus AS EstatusDetalle, tblp_pagos.FecBase, tblp_pagos.FecDesc, tblc_estatus.Estatus FROM tblp_pagos Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan Left Join tblh_detallepagos ON tblh_detallepagos.IdUsua = tblp_pagos.IdUsua AND tblh_detallepagos.IdPago = tblp_pagos.IdPago Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.Capturado WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.TipoSolicitud =  '2' ORDER BY tblp_pagos.FecDesc ASC ");

  $sql_pag_pos_gen = $db->query("SELECT
tblp_pagos.IdPago,
tblp_pagos.FecCap,
tblc_conceptosplanes.NomPlan,
tblp_pagos.IdEstatus,
tblp_pagos.IdConcepto,
tblp_pagos.Descuento,
tblp_pagos.Monto,
tblp_pagos.FecBase,
tblp_pagos.FecDesc,
tblc_estatus.Estatus,
tblp_modulo.CodeModulo,
tblp_modulo.NombreMod
FROM
tblp_pagos
Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblp_pagos.IdConceptoPlan
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_pagos.Capturado
Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_pagos.IdModulo
WHERE tblp_pagos.IdUsua = '$IdUsua' AND tblp_pagos.TipoSolicitud = '2'");

  $g_pago = 1;
} else {
  $g_pago = 0;
}

if ($g_pago == 0) {
  $cond_estatus_activo = " WHERE tblc_ciclo._activo = '1' ";
} else {
  $cond_estatus_activo = " ";
}

$sql_ciclo = $db->query("SELECT tblc_ciclo.IdCiclo, tblc_ciclo.Tipo, tblc_ciclo.Ciclo FROM tblc_ciclo $cond_estatus_activo ORDER BY tblc_ciclo.Tipo ASC,  tblc_ciclo.FInicio DESC");

if ($Tipo == 'R') {
  $sql_grupo = $db->query("SELECT
  tblp_grupo.IdGrupo,
  tblp_grupo.CveGrupo,
  tblc_estatus.Estatus,
  tblc_dias_clases._Dias,
  tblc_modalidad._Modalidad,
  tblc_campus._campus,
  tblp_educativa.Abreviatura
  FROM
  tblp_grupo
  Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
  Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
  Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
  Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
  WHERE tblc_dias_clases.Tipo =  '1' AND tblp_grupo.IdCicloIni = '$Id_Ciclo' AND tblp_grupo.IdOferta = '" . $_user["IdOferta"] . "' AND tblp_grupo.Disponible = 'SI' ");
} else {
  $sql_grupo = $db->query("SELECT
    tblp_grupo.IdGrupo,
    tblp_grupo.CveGrupo,
    tblc_estatus.Estatus,
    tblc_dias_clases._Dias,
    tblc_modalidad._Modalidad,
    tblc_campus._Campus,
    tblp_educativa.Abreviatura
    FROM
    tblp_grupo
    Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
    Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
    Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
    Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
    Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
    WHERE
    tblp_grupo.Dia =  'P' AND tblp_grupo.Ingles <> 'SI' AND tblp_grupo.IdOferta = '" . $_user["IdOferta"] . "' ");
}

if (($_grado == 4) && (($tipoGrado == 'CAMBIO DE PLANTEL') || ($tipoGrado == 'CONVALIDACION'))) {

  $sql_grupo = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblc_dias_clases._Dias,
tblp_educativa.Nombre,
tblc_campus.Campus as _campus,
tblp_educativa.Abreviatura
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
WHERE
tblc_ciclogrupo.IdCiclo =  '$Id_Ciclo'
 ");
}

$_valx = 1;
if ($Id_Ciclo) {
  if (($_grado == 1) || ($_grado == 2)) {
    $sql_pos_pag = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND ((tblc_conceptosplanes.IdConcepto = 1) || (tblc_conceptosplanes.IdConcepto = 2)) ORDER BY tblc_conceptosdetalle.IdConcepto ASC");
    $sql_mate_ini = $db->query("SELECT tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_modulo WHERE tblp_modulo.IdEducativa =  '$IdOferta' ORDER BY tblp_modulo.CodeModulo ASC LIMIT 1");
    $db->rows($sql_mate_ini);
    $_mateIni = $db->recorrer($sql_mate_ini);
    $_materia = $_mateIni['CodeModulo'] . ' ' . $_mateIni['NombreMod'];
  }
  //tblp_calendario.IdCampus = '$Id_Campus' AND
  //echo "SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo, tblp_calendario.Monto, tblc_conceptos.NomConcepto, tblc_conceptos.IdConcepto FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosdetalle.IdConcepto WHERE tblp_calendario.IdCiclo =  '$Id_Ciclo' AND tblc_conceptos.Grado1 =  '1' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' ORDER BY tblc_conceptos.IdConcepto ASC, tblp_calendario.FecDescuento ASC";

  $sql_pag = $db->query("SELECT tblp_calendario.IdCalendario, tblp_calendario.FecDescuento, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.NomPlan, tblc_conceptosplanes.Costo, tblp_calendario.Monto, tblc_conceptos.NomConcepto, tblc_conceptos.IdConcepto FROM tblp_calendario Left Join tblc_conceptosdetalle ON tblc_conceptosdetalle.IdConceptoPlan = tblp_calendario.IdConceptosPlanes Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosdetalle.IdConcepto WHERE tblp_calendario.IdCiclo =  '$Id_Ciclo' AND tblc_conceptos.Grado1 =  '1' AND tblc_conceptosdetalle.IdOferta =  '$IdOferta' ORDER BY tblc_conceptos.IdConcepto ASC, tblp_calendario.FecDescuento ASC");

  $sql_beca = $db->query("SELECT tblc_conceptosplanes.NomPlan, tblc_conceptosdetalle.IdConceptoPlan, tblc_conceptosplanes.IdConcepto FROM tblc_conceptosdetalle Left Join tblc_conceptosplanes ON tblc_conceptosplanes.IdConceptoPlanes = tblc_conceptosdetalle.IdConceptoPlan Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblc_conceptosplanes.IdConcepto WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosplanes.IdCampus = '$Id_Campus'");
  $sql_lst_beca = $db->query("SELECT
tblp_beca.IdBeca,
tblp_beca.Porcentaje,
tblp_beca.IdConcepto,
tblp_beca.Nota,
tblp_beca.FecCap,
tblp_beca.Crm,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_convenio.Convenio,
tblc_conceptos.NomConcepto
FROM
tblp_beca
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_beca.IdUsuaCap
Left Join tblc_convenio ON tblc_convenio.IdConvenio = tblp_beca.IdConvenio
Left Join tblc_conceptos ON tblc_conceptos.IdConcepto = tblp_beca.IdConcepto
WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' AND tblp_beca.IdConcepto = '1'");
  $db->rows($sql_lst_beca);
  $_beca = $db->recorrer($sql_lst_beca);

  $sql_lst_beca2 = $db->query("SELECT
tblp_beca.IdBeca,
tblp_beca.Porcentaje
FROM
tblp_beca
WHERE tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' AND tblp_beca.IdConcepto = '2'");
  $db->rows($sql_lst_beca2);
  $_beca2 = $db->recorrer($sql_lst_beca2);
}

$sql_cicloLimite = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$Id_Ciclo'");
$db->rows($sql_cicloLimite);
$_cicloImpresion = $db->recorrer($sql_cicloLimite);

$mostrar = 1;
if ($_user['IdGrado'] <= 4) {
  if ($_cicloImpresion['Limite'] <= date("Y-m-d")) {
    $mostrar = 0;
  }
}

?>

<form name="frm2xfYj" id="frm2xfYj" action="miProspecto.php" method="POST" enctype="multipart/form-data">
  <input id="IdUsua_c" name="IdUsua_c" value="<?php echo $_SESSION['IdUsua']; ?>" type="hidden" />
  <div class="table-responsive">
    <div class="box box-primary" style="border-top: none; margin-top: -5px;">
      <div class="col-md-12">
        <div class="form-group">
          <div class="bg-navy-active color-palette" style="padding: 15px;"><span><i class="fa fa-fw fa-user"></i> <?php echo $_user['Nombre'] . ' ' . $_user['APaterno'] . ' ' . $_user['AMaterno']; ?></span></div>
          <?php if (!isset($_user['id_ciclo_ini'])) {
            $_valx = 2; ?>
            <div class="bg-red-active color-palette" style="padding: 10px; margin-top: 5px;"><span><i class="fa fa-fw fa-times-circle"></i> No ha seleccionado el ciclo en el que iniciar el registro el prospecto.</span></div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label>Ciclo escolar en la inicia la alta del prospecto:</label>
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-code-fork"></i>
            </div>
            <select class="form-control select2" name="_txtCiclo" id="_txtCiclo" style="width: 100%;" <?php if ($g_pago == 1) { echo "disabled"; } ?>>
              <option value=""> - Seleccione - </option>
              <?php while ($_ciclo = $db->recorrer($sql_ciclo)) { ?>
                <option value="<?php echo $_ciclo["IdCiclo"]; ?>" <?php if ($_user['id_ciclo_ini'] == $_ciclo["IdCiclo"]) { ?>selected="selected" <?php } ?>> <?php echo $_ciclo["Tipo"]; ?> - <?php echo $_ciclo["Ciclo"]; ?></option>
              <?php } ?>
            </select>
            <?php if ($g_pago == 0) { ?>
              <span class="input-group-btn">
                <button type="button" class="btn btn-success btn-flat" onclick="savx_periodoIni(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>,'<?php echo $Tipo; ?>')"><i class="fa fa-fw fa-save"></i> Guardar</button>
              </span><?php } ?>
          </div>
        </div>
      </div>


      <?php if (($g_pago == 0) && (isset($Id_Ciclo))) {
        $_valx = 2; ?>

        <div class="col-md-12">
          <div class="bg-gray-active color-palette" style="padding: 4px;"><span style="color: black;"> <i class="fa fa-fw fa-check-circle"></i> PAGOS INICIALES DEL ALUMNO EN EL PERIODO ESCOLAR</span></div>
          <div class="form-group">
            <table class="table table-striped" style="font-size: 12px;">
              <tbody>
                <tr>
                  <th>NOMBRE DEL CONCEPTO</th>
                  <th style="text-align: center;">BECA (%)</th>
                  <th>FECHA</th>
                  <th style="text-align: right;">COSTO</th>
                  <th style="text-align: right;">DESCUENTO</th>
                  <th style="text-align: right;">TOTAL</th>
                </tr>
                <?php $des = 0;
                $pag = 0;
                $_np = 0;
                //$IdCal1 = 0; $IdCal2 = 0; $cx = 0;
                $IdPlan1 = 0;
                $IdPlan2 = 0;
                $Fec1 = '';
                $Fec2 = '';
                if (!empty($sql_pag)) {
                  while ($_pag = $db->recorrer($sql_pag)) {
                    $_np = ($_np + 1);
                    $id_con_plan = $_pag['IdConcepto'];
                    $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$id_con_plan' AND tblp_beca.IdUsua = '$IdUsua' AND tblp_beca.IdEstatus = '8' ");
                    $db->rows($sqlx9);
                    $datosx91 = $db->recorrer($sqlx9);
                    $Descuento = $datosx91['Descuento'];
                    $desc = $datosx91['Descuento'];
                    $Porcentaje = $datosx91['Porcentaje'];
                    if ($Descuento) {
                      $pag = ($_pag['Monto'] - $Descuento);
                    } else {
                      $Porcentaje = 0;
                      $desc = 0;
                      $pag = $_pag['Monto'];
                    }
                ?>
                    <tr>
                      <td><?php echo $_pag['NomPlan']; ?> - <b><?php echo obtener_AnioMesMAY($_pag['FecDescuento']); ?></b></td>
                      <td style="text-align: center;"><?php echo intval($Porcentaje); ?>%</td>
                      <td><?php echo $_pag['FecDescuento']; ?></td>
                      <td style="text-align: right;">$<?php echo number_format($_pag['Monto'], 2, '.', ','); ?></td>
                      <td style="text-align: right;">$<?php echo number_format($desc, 2, '.', ','); ?></td>
                      <td style="text-align: right;">$<?php echo number_format($pag, 2, '.', ','); ?></td>
                    </tr><?php }
                      } ?>

              </tbody>
            </table>
            <?php if ($_np > 2) { ?>
              <button style="float: right;" type="button" class="btn btn-success btn-flat" onclick="sav_Pagos_Ini(<?php echo $IdUsua; ?>,<?php echo $Id_Ciclo; ?>,<?php echo $IdOferta; ?>,<?php echo $Id_Campus; ?>,<?php echo $idpaq; ?>,'<?php echo $Tipo; ?>')"><i class="fa fa-fw fa-save"></i> Aplicar pagos iniciales</button>
            <?php } ?>
            <input type="hidden" name="IdPlan1" id="IdPlan1" value="<?php echo $IdPlan1; ?>">
            <input type="hidden" name="IdPlan2" id="IdPlan2" value="<?php echo $IdPlan2; ?>">
            <input type="hidden" name="Fec1" id="Fec1" value="<?php echo $Fec1; ?>">
            <input type="hidden" name="Fec2" id="Fec2" value="<?php echo $Fec2; ?>">
          </div>
        </div>

      <?php } ?>
      <?php if ($g_pago == 1) { ?>
        <div class="col-md-12" style="font-size: 12px;">
          <div class="form-group">
            <label>Seguimiento de los pagos generados:</label>
            <table class="table table-striped">
              <tbody>
                <tr>
                  <th>CONCEPTO</th>
                  <th>ESTATUS</th>
                  <th style="width: 80px; text-align: center;">MONTO</th>
                  <th style="width: 80px; text-align: center;">DESCUENTO</th>
                  <th style="width: 100px; text-align: center;">TOTAL A PAGAR</th>
                </tr>
                <?php $recargo = 0;
                if (!empty($sql_pag_gen)) {
                  while ($_gen = $db->recorrer($sql_pag_gen)) {
                    $val_es = $_gen['Estatus'];
                    $_valx = 1;
                    $IdPag = $_gen['IdPago'];
                    $IdEstatus = $_gen['IdEstatus'];
                    if ($IdEstatus == 4) {
                      $val_es = 'Pago aprobado';
                    }
                    $_mon = ($_gen['Monto'] - $_gen['Descuento']);
                    $id_con_plan = $_gen['IdConcepto'];
                    $sqlx9 = $db->query("SELECT * FROM tblp_beca WHERE tblp_beca.IdConcepto = '$id_con_plan' AND tblp_beca.IdUsua = '$IdUsua' ");
                    $db->rows($sqlx9);
                    $datosx91 = $db->recorrer($sqlx9);
                    $Descuento = $datosx91['Descuento'];
                    if ($Descuento) {
                      $Porcentaje = $datosx91['Porcentaje'];
                      $desc = $datosx91['Descuento'];
                      $pag = ($_gen['Monto'] - $Descuento);
                    } else {
                      $Porcentaje = 0;
                      $desc = 0;
                      $pag = $_gen['Monto'];
                    }

                ?>
                    <tr>
                      <td><?php echo $_gen['NomPlan']; ?> - <b><?php echo obtener_AnioMesMAY($_gen['FecDesc']); ?></b></td>
                      <td><?php echo $val_es; ?></td>
                      <td style="text-align: right;">$ <?php echo number_format($_gen['Monto'], 2, '.', ','); ?></td>
                      <td style="text-align: right;">$ <?php echo number_format($desc, 2, '.', ','); ?></td>
                      <td style="text-align: right;">$ <?php echo number_format($pag, 2, '.', ','); ?></td>
                    </tr><?php }
                      } ?>
              </tbody>
            </table>
          </div>
        </div><?php  } ?>
      <?php if ($_user['IdGrado'] <= 4) { ?>
        <div class="col-md-12">
          <blockquote>
            <p style='color: blue;'><i class="fa fa-fw fa-info-circle"></i> Fecha límite para inscribir el alumno al periodo escolar seleccionado es el:</p>
            <small style='color: red;'><i class="fa fa-fw fa-calendar"></i> <?php echo obtenerFechaCorta($_cicloImpresion['Limite']); ?></small>
          </blockquote>
        </div><?php } ?>

      <?php if ($mostrar == 0) { ?>
        <div class="col-md-12">
          <blockquote>
            <p style='color: red;'><i class="fa fa-fw fa-warning"></i> La fecha límite de inscripción a caducado.</p>
          </blockquote>
        </div><?php } ?>

      <?php if ($mostrar == 1) { ?>
        <div class="col-md-3">
          <div class="form-group">
            <label>Tipo grupo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control" name="_tipox" id="_tipox" onchange="sel_tipo_grupo(<?php echo $IdUsua; ?>)">
                <option value=""> - Seleccione - </option>
                <option value="R" <?php if ($Tipo == 'R') { ?>selected="selected" <?php } ?>> REGULAR</option>
                <option value="P" <?php if ($Tipo == 'P') { ?>selected="selected" <?php } ?>> PERSONALIZADO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="form-group">
            <label>Clave de grupo:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-user"></i>
              </div>
              <select class="form-control select2" name="_txtGrupo" id="_txtGrupo" style="width: 100%;">
                <option value=""> - Seleccione - </option>
                <?php while ($_grupo = $db->recorrer($sql_grupo)) { ?>

                  <?php if (($_grado == 4) && (($tipoGrado == 'CAMBIO DE PLANTEL') || ($tipoGrado == 'CONVALIDACION'))) {
                    $grado = $_grupo['Grado'] . '° ';
                  } else {
                    $grado = '';
                  } ?>
                  <option value="<?php echo $_grupo["IdGrupo"]; ?>" <?php if ($_user['IdGrupo'] == $_grupo["IdGrupo"]) { ?>selected="selected" <?php } ?>> <?php echo $_grupo['_campus'] . ' - ' . $grado . ' ' . $_grupo['CveGrupo'] . ' / ' . $_grupo['Estatus'] . ' ** (' . $_grupo['_Modalidad'] . ' - ' . $_grupo['_Dias'] . ')'; ?> - <?php echo $_grupo['Abreviatura']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <?php if ($_valx == 2) { ?>
              <button type="button" class="btn btn-block btn-danger"> <i class="fa fa-fw fa-times-circle"></i> No disponible</button>
            <?php } elseif (!isset($IdGrupo)) { ?>
              <button type="button" class="btn btn-block btn-success" onclick="aceptarPros(<?php echo $IdUsua; ?>,'<?php echo $Tipo; ?>')"> <i class="fa fa-fw fa-check-circle"></i> Aceptar prospecto como alumno</button>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</form>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('.select2').select2()
  })

  $(function() {
    $('#txtFecha_1').datepicker({
      autoclose: true
    })
    $('#txtFecha_2').datepicker({
      autoclose: true
    })

  })

  function savx_periodoIni(IdProspecto, IdAdmin, Tipo) {
    var IdCiclo = document.getElementById("_txtCiclo").value;

    if (IdCiclo == "") {
      swal("Error al guardar", "Debe seleccionar el ciclo escolar.", "error");
      return 0;
    }

    var TipoGuardar = "savProsCicl";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea guardar este ciclo escolar para este prospecto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdProspecto: IdProspecto,
                IdCiclo: IdCiclo,
                IdAdmin: IdAdmin
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "El ciclo escolar se ha guardado correctamente al prospecto.", "success");
                $.ajax({
                  url: "formConsulta/miProspecto.php",
                  method: "POST",
                  data: {
                    IdUsua: IdProspecto,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_Grpx').html(data);
                    $('#dataGrpx').modal('show');
                  }
                });
              }

              if (data == 0) {
                swal("Error al guardar", "No se puede guardar los cambios solicitados.", "error");
              }
            })

        }
      });

  }

  function sav_Pagos_Ini(IdProspecto, IdCiclo, IdOferta, IdCampus, IdPaq, Tipo) {


    var TipoGuardar = "savPag_Ini_Pros";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea aplicar estos pagos iniciales a este prospecto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdProspecto: IdProspecto,
                IdCiclo: IdCiclo,
                IdOferta: IdOferta,
                IdCampus: IdCampus,
                IdPaq: IdPaq
              },
              success: function(data) {

              }
            })
            .done(function(data) {
              if (data == 1) {
                swal("Guardado correctamente", "Los pagos se han generado correctamente al prospecto.", "success");
                $.ajax({
                  url: "formConsulta/miProspecto.php",
                  method: "POST",
                  data: {
                    IdUsua: IdProspecto,
                    Tipo: Tipo
                  },
                  success: function(data) {
                    $('#employee_Grpx').html(data);
                    $('#dataGrpx').modal('show');
                  }
                });
              }

              if (data == 0) {
                swal("Error al guardar", "No se puede guardar los cambios solicitados.", "error");
              }
            })

        }
      });

  }


  function aceptarPros(IdProspecto, Tipo) {
    var IdGrupo = document.getElementById("_txtGrupo").value;

    if (IdGrupo == "") {
      swal("Error al guardar", "Debe seleccionar el grupo donde se dara de alta el prospecto.", "error");
      return 0;
    }

    var TipoGuardar = "savNewUsuario";
    swal({
        title: "\u00BFEst\u00E1 seguro que desea agregar este prospecto a este grupo?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Aceptar',
        cancelButtonText: "Cancelar",
      },
      function(isConfirm) {
        if (isConfirm) {
          $(".confirm").attr('disabled', 'disabled');
          $.ajax({
              url: "formConsulta/setting.php",
              method: "POST",
              data: {
                TipoGuardar: TipoGuardar,
                IdProspecto: IdProspecto,
                IdGrupo: IdGrupo,
                Tipo: Tipo
              },
              success: function(data) {
                alert(data);
              }
            })
            .done(function(data) {

              if (data == 1) {
                swal("Guardado correctamente", "Los datos se han guardado correctamente, favor de aplicar los pagos iniciales.", "success");
                $.ajax({
                  url: "formConsulta/miProspecto.php",
                  method: "POST",
                  data: {
                    IdUsua: IdProspecto,
                    Tipo
                  },
                  success: function(data) {
                    $('#employee_Grpx').html(data);
                    $('#dataGrpx').modal('show');
                  }
                });
              }

              if (data == 0) {
                swal("Error al guardar", "No se puede guardar los cambios solicitados.", "error");
              }
            })
            .error(function(data) {
              swal("Error al agregar 0x130", "No se puede actualizar, comuniquese con el desarrollador.", "error");
            });

        }
      });

  }

  function sel_tipo_grupo(IdUsua) {
    var Tipo = document.getElementById("_tipox").value;
    $.ajax({
      url: "formConsulta/miProspecto.php",
      method: "POST",
      data: {
        IdUsua: IdUsua,
        Tipo: Tipo
      },
      success: function(data) {
        $('#employee_Grpx').html(data);
        $('#dataGrpx').modal('show');
      }
    });
  }
</script>