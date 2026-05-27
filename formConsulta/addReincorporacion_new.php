<?php 
session_start();
require('../php/clases/class.System.php');
$db = new Conexion();

$IdCiclo = $_POST["IdCiclo"];
$Tipo = $_POST["Tipo"];

$anio = date("Y");
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
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND tblc_dias_clases.Tipo =  '1' ORDER BY tblp_grupo.IdCampus ASC, tblp_grupo.IdOferta ASC, tblc_ciclogrupo.Grado ASC ");
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
  tblp_grupo.Ingles <>  'SI'
  ORDER BY
  tblp_grupo.IdCampus ASC,
  tblp_educativa.Nombre ASC");
}

$sql2 = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Anio = '$anio' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC");

?>

<form class="form-horizontal">
  <div class="box-body">
  <div class="form-group">
      <label class="col-sm-3 control-label">Periodo escolar en la que iniciará:</label>
      <div class="col-sm-9">
      <select class="form-control" name="txt_id_ciclo_new" id="txt_id_ciclo_new" style="width:100%" onchange="sel_ciclo_es_new('<?php echo $Tipo; ?>')">
        <option value=""> - Seleccione - </option>
        <?php
        while ($y2 = $db->recorrer($sql2)) { ?>
          <option class="form-control" value="<?php echo $y2["IdCiclo"] ?>" <?php if ($IdCiclo == $y2["IdCiclo"]) { ?>selected="selected" <?php } ?>><?php echo $y2["Tipo"]; ?> - <?php echo $y2["Ciclo"]; ?> </option>
        <?php } ?>
      </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Tipo de grupo:</label>
      <div class="col-sm-4">
      <select class="form-control" name="txt_tipo_grupo" id="txt_tipo_grupo" onchange="sel_tipo_grupo('<?php echo $IdCiclo; ?>')">
          <option value="R" <?php if ($Tipo == 'R') { ?>selected="selected" <?php } ?>> REGULAR </option>
          <option value="P" <?php if ($Tipo == 'P') { ?>selected="selected" <?php } ?>> PERSONALIZADO </option>
      </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Grupo donde se reincorporará:</label>
      <div class="col-sm-9">
      <select class="form-control" name="txt_id_grupo_new" id="txt_id_grupo_new" style="width:100%">
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
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nombre:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txt_nombre_new" name="txt_nombre_new">
      </div>
      <label class="col-sm-2 control-label">A. Paterno:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txt_paterno_new" name="txt_paterno_new">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">A. Materno:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txt_materno_new" name="txt_materno_new">
      </div>
      <label class="col-sm-2 control-label">Celular:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="txt_celular_new" name="txt_celular_new">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Correo:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" id="txt_correo_new" name="txt_correo_new">
      </div>
    </div>
     
    <div class="form-group">
      <label class="col-sm-3 control-label">Observaciones de la reincorporación:</label>
      <div class="col-sm-9">
      <textarea name="txt_comen_seg_new" id="txt_comen_seg_new" class="form-control" rows="3" placeholder="Comentario adicional ..."></textarea>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
      <label class="control-label"><i class="fa fa-warning"></i> Nota: al crear el nuevo alumno para reincorporación se le asignará una matrícula nueva.</label>
      </div>
    </div>
    
  </div>

  <div class="box-footer">
    <button type="button" class="btn btn-block btn-info" onclick="new_seguimi_reincor(<?php echo $_SESSION['IdUsua']; ?>,'<?php echo $Tipo; ?>')"> <i class="fa fa-fw fa-save"></i> Enviar para seguimiento de reincorporación</button>
  </div>
</form>
