<?php
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();
$IdUsua = $_POST["IdUsua"];
$IdCiclo = $_POST["IdCiclo"];
$Tipo = $_POST["Tipo"];
$IdCampus = $_POST["IdCampus"];

$sql6 = $db->query("SELECT * FROM tblc_usuario WHERE tblc_usuario.IdUsua = '$IdUsua'");
$db->rows($sql6);
$datos61 = $db->recorrer($sql6);
$Nombre = $datos61["Usuario"] . ' - ' . $datos61["Nombre"] . ' ' . $datos61["APaterno"] . ' ' . $datos61["AMaterno"];
$IdO = $datos61["IdOferta"];
$IdC = $datos61["IdCampus"];



if($IdCampus == 6){
  $condicionCampus = " AND tblp_grupo.IdCampus = '6' ";
} else {
  $condicionCampus = " AND tblp_grupo.IdOferta = '$IdO' ";
}

if($Tipo == 'R'){
  $sql_grupo = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblc_ciclogrupo.Promedio,
tblc_ciclogrupo.Migrado,
tblp_grupo.CveGrupo,
tblc_campus.Campus,
tblc_campus._campus,
tblc_dias_clases._Dias,
tblp_educativa.Abreviatura
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_dias_clases.Tipo =  '1' $condicionCampus ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.IdOferta ASC, tblc_ciclogrupo.Grado ASC ");
} else {
  
  $sql_grupo = $db->query("SELECT
  tblp_grupo.IdGrupo,
  tblc_campus._campus,
  tblp_grupo.CveGrupo,
  tblp_educativa.Abreviatura,
  tblp_grupo.Ingles
  FROM
  tblp_grupo
  Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
  WHERE
  tblp_grupo.Dia =  'P' AND
  tblp_grupo.Ingles <>  'SI' $condicionCampus
  ORDER BY
  tblp_grupo.IdCampus ASC,
  tblp_educativa.Nombre ASC");
}




$anio = date("Y");
$sql = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblc_ciclogrupo.Promedio,
tblc_ciclogrupo.Migrado,
tblp_grupo.CveGrupo,
tblc_campus.Campus,
tblc_dias_clases._Dias
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND
tblp_grupo.IdOferta =  '$IdO' AND ((tblc_dias_clases.Tipo =  '1') || (tblc_dias_clases.Tipo =  '2'))
ORDER BY
tblp_grupo.IdCampus ASC,
tblc_ciclogrupo.Grado ASC
");
$sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio >= '$anio' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC");

?>


<form role="form">
  <div class="box-body">
  <div class="form-group">
      <label>Periodo escolar en la que iniciará:</label>
      <select class="form-control select2" name="txt_id_ciclo" id="txt_id_ciclo" style="width:100%" onchange="sel_ciclo_es_new_anterior(<?php echo $IdUsua; ?>,'<?php echo $Tipo; ?>')">
        <option value=""> - Seleccione - </option>
        <?php
        while ($y2 = $db->recorrer($sql2)) { ?>
          <option class="form-control" value="<?php echo $y2["IdCiclo"] ?>"  <?php if($IdCiclo==$y2["IdCiclo"]){ ?>selected="selected"<?php } ?>><?php echo $y2["Tipo"]; ?> -  <?php echo $y2["Ciclo"]; ?> </option>
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Tipo de grupo:</label>
      <div class="col-sm-4">
      <select class="form-control" name="txt_tipo_grupo" id="txt_tipo_grupo" onchange="sel_tipo_grupo_anterior('<?php echo $IdCiclo; ?>',<?php echo $IdUsua; ?>)">
          <option value="R" <?php if ($Tipo == 'R') { ?>selected="selected" <?php } ?>> REGULAR </option>
          <option value="P" <?php if ($Tipo == 'P') { ?>selected="selected" <?php } ?>> PERSONALIZADO </option>
      </select>
      </div>
    </div>
    <div class="form-group">
      <label>Grupo donde se reincorporará:</label>
      <select class="form-control select2" name="txt_id_grupo" id="txt_id_grupo" style="width:100%">
        <option value=""> - Seleccione - </option>
        <?php
        while ($x2 = $db->recorrer($sql_grupo)) { 
          if($Tipo == 'R'){  ?>
          <option class="form-control" value="<?php echo $x2["IdGrupo"] ?>"> <?php echo $x2["_campus"] . ' - ' . $x2["Grado"] . '° ' . $x2["CveGrupo"] . ' - ' . $x2["_Dias"].' - '.$x2["Abreviatura"]; ?> </option>
          <?php } else { ?>
            <option class="form-control" value="<?php echo $x2["IdGrupo"] ?>"> <?php echo $x2["_campus"] . ' - '. $x2["CveGrupo"] .' - '.$x2["Abreviatura"]; ?> </option>
          <?php } ?>
        <?php } ?>
      </select>
    </div>
    
    <div class="form-group">
      <label>Observaciones de la reincorporación:</label>
      <textarea name="txt_comen_seg" id="txt_comen_seg" class="form-control" rows="3" placeholder="Comentario adicional ..."></textarea>
    </div>
    
  </div>

  <div class="box-footer">
    <button type="button" class="btn btn-block btn-info" onclick="add_seguimi_reincor(<?php echo $IdUsua; ?>,<?php echo $_SESSION['IdUsua']; ?>,<?php echo $IdCampus; ?>)"> <i class="fa fa-fw fa-save"></i> Enviar para seguimiento de reincorporación</button>
  </div>
</form>
<script>
  $(function() {
    $('.select2').select2()

  })
</script>