<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];
$IdReincorporacion = $_POST["IdReincorporacion"];

$sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql6);
$datos61 = $db->recorrer($sql6);
$Nombre = $datos61["Usuario"] . ' - ' . $datos61["Nombre"] . ' ' . $datos61["APaterno"] . ' ' . $datos61["AMaterno"];
$IdO = $datos61["IdOferta"];
$IdC = $datos61["IdCampus"];


$sql_rein = $db->query("SELECT * FROM tblp_reincorporacion WHERE tblp_reincorporacion.IdReincorporacion = '$IdReincorporacion'");
$db->rows($sql_rein);
$dat_rei = $db->recorrer($sql_rein);
$IdCiclo = $dat_rei["IdCiclo"];
$rwIdCiclo = $dat_rei["IdCiclo"];
$_idGrupo = $dat_rei["IdGrupo"];

$anio = date("Y");

$sql_mod = $db->query("SELECT * FROM tblc_modulousuario WHERE tblc_modulousuario.IdModulo = '66' AND tblc_modulousuario.IdUsua = '".$_SESSION['IdUsua']."'");
$db->rows($sql_mod);
$_mod = $db->recorrer($sql_mod);
$idMod = $_mod["IdModulo"];

$sql_grp = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.Dia,
tblc_campus.Campus,
tblc_dias_clases._Dias
FROM tblp_grupo Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE tblp_grupo.IdGrupo = '$_idGrupo'");
$db->rows($sql_grp);
$_grpx = $db->recorrer($sql_grp);

$sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio = '$anio' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC");
$sql_rvoe = $db->query("SELECT
tblc_campus._campus,
tblc_rvoe.IdRvoe,
tblc_rvoe.IdEducativa,
tblc_rvoe.IdCampus,
tblc_rvoe.Rvoe,
tblc_rvoe.Educativa
FROM
tblc_rvoe
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_rvoe.IdCampus
WHERE
tblc_rvoe.IdEducativa =  '$IdO'
");

?>

<form role="form">
  <div class="box-body">
    <div class="form-group">
      <label>Periodo escolar en la que iniciará:</label>
      <select class="form-control select2" disabled style="width:100%" onchange="sel_ciclo_es(<?php echo $IdUsua; ?>)">
        <option value=""> - Seleccione - </option>
        <?php
        while ($y2 = $db->recorrer($sql2)) { ?>
          <option class="form-control" value="<?php echo $y2["IdCiclo"] ?>" <?php if ($IdCiclo == $y2["IdCiclo"]) { ?>selected="selected" <?php } ?>><?php echo $y2["Tipo"]; ?> - <?php echo $y2["Ciclo"]; ?> </option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Grupo donde se reincorporará:</label>
      <?php if($_grpx["Dia"] == 'P'){ ?>
        <input type="text" disabled class="form-control" value="<?php echo $_grpx["Campus"] . ' ' . $_grpx["CveGrupo"] . ' - ' . $_grpx["_Dias"]; ?>">  
      <?php } else { ?>
        <input type="text" disabled class="form-control" value="<?php echo $_grpx["Campus"] . ' - ' . $_grpx["CveGrupo"] . ' - ' . $_grpx["_Dias"]; ?>">
      <?php } ?>
      
    </div>
   <br>
    <div class="form-group">
      <label class="col-sm-6 control-label" style="text-align: right;">Fecha reincorporación:</label>
      <div class="col-sm-6">
      <input type="text" class="form-control pull-right" id="datepicker1" name="datepicker1">
      </div>
    </div><br>
    <div class="form-group">
      <label>Plan de estudios:</label>
      <select class="form-control select2" style="width:100%" name="txt_oferta" id="txt_oferta">
        <option value=""> - Seleccione - </option>
        <?php
        while ($y2 = $db->recorrer($sql_rvoe)) { ?>
          <option class="form-control" value="<?php echo $y2["IdRvoe"] ?>" ><?php echo $y2["_campus"]; ?> - <?php echo $y2["Rvoe"].' '.$y2["Educativa"]; ?> </option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label>Observaciones de la reincorporación:</label>
      <textarea name="txt_comen_segx" id="txt_comen_segx" class="form-control" rows="3" placeholder="Comentario adicional ..."><?php echo $dat_rei["Nota"]; ?></textarea>
    </div>

  </div>
  <?php if (($dat_rei["IdEstatus"] == 3) && (isset($idMod[0]))) {  $p = 0; ?>
    <div class="box-footer">
      <?php if($datos61["_tipoReincorporacion"] == 'SI'){ 
        
        $sql8 = $db->query("SELECT tblc_usuario.IdGrupo, tblc_usuario.IdCampus, tblc_usuario.IdOferta, tblc_usuario.IdGrupo FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
  $db->rows($sql8);
  $datos81 = $db->recorrer($sql8);
  $IdOferta = $datos81['IdOferta'];
  $IdGrupo = $datos81['IdGrupo'];
  $IdCampus = $datos81['IdCampus'];
  
    
    
    #Verificamos que exista el pago reinscripcion
      $sql_cicl = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdConcepto =  '3' AND tblp_pagos.IdCiclo =  '$rwIdCiclo'");
      $db->rows($sql_cicl);
      $_ciclo = $db->recorrer($sql_cicl);
      if (!isset($_ciclo["IdPago"])) {
           #Generamos los pagos de reinscripci贸n
          $sql_reins = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_costos_ciclo.IdCosto, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_conceptosdetalle.IdConceptoPlan FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '3' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
          while ($_reins = $db->recorrer($sql_reins)) {
              $anio = substr($_reins['Fecha'], 0, 4);
              $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo)
              VALUES('$IdUsua','" . $_reins['Monto'] . "','1','$IdOferta',NOW(),'" . $_reins['Fecha'] . "','$rwIdCiclo','$anio','" . $_reins['IdConceptoPlan'] . "','$IdCampus','NO-F3','2','1','32','3',0,0,0,'$IdGrupo')");
              $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','103','1','$rwIdCiclo','T','$IdGrupo')");
              $insertar = $db->query("INSERT INTO tblc_docalumnos (IdUsua, IdTipoDocumento, Estatus, IdCiclo, Doc, IdGrupo) VALUES ('$IdUsua','105','1','$rwIdCiclo','T','$IdGrupo')");
              $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','3','0',NOW(),'1','8','1000','$rwIdCiclo','0','" . $_reins['Monto'] . "',0,'" . $_reins['Monto'] . "')");
              
          }
          
      }
      
        $sql_cicl = $db->query("SELECT tblc_conceptosdetalle.IdConceptoDetalle, tblc_conceptosdetalle.IdConceptoPlan, tblc_costos_ciclo.Monto, tblc_costos_ciclo.Fecha, tblc_costos_ciclo.Numero, tblc_costos_ciclo.IdCosto FROM tblc_conceptosdetalle Left Join tblc_costos_ciclo ON tblc_costos_ciclo.IdPlan = tblc_conceptosdetalle.IdConceptoPlan WHERE tblc_conceptosdetalle.IdOferta =  '$IdOferta' AND tblc_conceptosdetalle.IdConcepto =  '2' AND tblc_costos_ciclo.IdCiclo =  '$rwIdCiclo'");
          $db->rows($sql_cicl);
          $_ciclo = $db->recorrer($sql_cicl);
          $rwIdConceptoCol = $_ciclo["IdConceptoDetalle"];
          $rwMonto = $_ciclo["Monto"];
          $rwNumero = $_ciclo["Numero"];
          $rwFecha = $_ciclo["Fecha"];
          $rwIdConceptoPlan = $_ciclo["IdConceptoPlan"];
  
      
      #Verificamos que exista el pago mensualidad
      $sql_mens = $db->query("SELECT tblp_pagos.IdPago FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '$IdUsua' AND tblp_pagos.IdConcepto =  '2' AND tblp_pagos.IdCiclo =  '$rwIdCiclo'");
      $db->rows($sql_mens);
      $_mensu = $db->recorrer($sql_mens);
      if (!isset($_mensu["IdPago"])) {
          
            $fecha_actual = $rwFecha;
              for ($i = 1; $i <= $rwNumero; $i++) {
                $anio = substr($fecha_actual, 0, 4);
                
                  $insertar = $db->query("INSERT INTO tblp_pagos (IdUsua,Monto,IdEstatus,IdOferta,FecCap,Fecha,IdCiclo,Anio,IdConceptoPlan,IdCampus, Facturar,TipoSolicitud, Capturado, _idEstatus, IdConcepto, TotalPagado, Recargos, Descuento, IdGrupo) VALUES('$IdUsua','$rwMonto','1','$IdOferta',NOW(),'$fecha_actual','$rwIdCiclo','$anio','$rwIdConceptoPlan','$IdCampus','NO-F4','2','1','32','2',0,0,0,'$IdGrupo')");
                
                $fecha_actual = date("Y-m-d", strtotime($fecha_actual . "+ 1 month"));
              }
              $insertar = $db->query("INSERT INTO tblp_beca (IdUsua, IdConcepto, Porcentaje, FecCap, IdUsuaCap, IdEstatus, IdConvenio, IdCiclo, Promedio, Importe, Descuento, Total)  VALUES ('$IdUsua','2','0',NOW(),'1','8','1000','$rwIdCiclo','0','$rwMonto', 0, '$rwMonto')");
              
      }
      
      
        
        $p = 1;  ?>
        <button type="button" class="btn btn-block btn-success" > <i class="fa fa-fw fa-check-circle"></i> Pagos iniciales del alumno aplicado correctamente.</button>
      <?php } else { ?>
        <button type="button" class="btn btn-block btn-primary" onclick="sav_pagos_seguimi_reincor(<?php echo $IdUsua; ?>,<?php echo $IdReincorporacion; ?>,<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdCiclo; ?>)"> <i class="fa fa-fw fa-warning"></i> Aplicar pagos iniciales al alumno para su reincorporación</button>
      <?php } ?>
      <?php if($p == 1){ ?>
      <button type="button" class="btn btn-block btn-primary" onclick="sav_seguimi_reincor(<?php echo $IdUsua; ?>,<?php echo $IdReincorporacion; ?>,<?php echo $_SESSION['IdUsua']; ?>)"> <i class="fa fa-fw fa-warning"></i> Aceptar alumno para reincorporación</button>
      <?php } ?>
    </div><?php  } ?>
</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function () {
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
  })
</script>