<?php
session_start();
require('../../php/clases/class.System.php');
require('../../hace.php');
$db = new Conexion();
$IdAsignacion = $_POST['IdAsignacion'];
$IdCampus = $_POST['IdCampus'];
$IdCiclo = $_POST['IdCiclo'];
$IdGrupo = $_POST['IdGrupo'];
$anio = date("Y-m-d");

$sql_asig = $db->query("SELECT
  tblp_asignacion.IdAsignacion,
  tblp_educativa.IdGrado,
  tblp_modulo.CodeModulo,
  tblp_modulo.NombreMod,
  tblc_usuario.Nombre,
  tblc_usuario.APaterno,
  tblc_usuario.AMaterno
  FROM
  tblp_asignacion
  Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_asignacion.IdEducativa
  Left Join tblp_modulo ON tblp_modulo.IdModulo = tblp_asignacion.IdModulo
  Left Join tblc_usuario ON tblc_usuario.IdUsua = tblp_asignacion.IdUsua
  WHERE
  tblp_asignacion.IdAsignacion =  '$IdAsignacion' AND
  tblp_asignacion.Tipo =  '2'
  ");
$db->rows($sql_asig);
$asig = $db->recorrer($sql_asig);
$idGrado = $asig['IdGrado'];

$sql_campus = $db->query("SELECT * FROM tblc_campus ");
$sql_ciclo = $db->query("SELECT * FROM tblc_ciclo");
$sql_grp = $db->query("SELECT
tblc_ciclogrupo.IdCicloGrupo,
tblc_ciclogrupo.IdCiclo,
tblc_ciclogrupo.IdGrupo,
tblc_ciclogrupo.Grado,
tblp_grupo.CveGrupo,
tblp_educativa.Abreviatura,
tblp_grupo.Ingles,
tblc_dias_clases._Dias,
tblp_grupo.IdOferta
FROM
tblc_ciclogrupo
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_ciclogrupo.IdGrupo
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblp_grupo.IdOferta
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
WHERE
tblc_ciclogrupo.IdCiclo =  '$IdCiclo' AND
tblp_grupo.IdCampus =  '$IdCampus' AND
tblc_dias_clases.Tipo =  '1' AND 
tblp_educativa.IdGrado =  '$idGrado'
ORDER BY tblp_educativa.IdGrado ASC,
tblp_grupo.IdOferta ASC,
tblc_ciclogrupo.Grado ASC
");
//echo "SELECT tblp_grupo.IdGrupo, tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.id_campus WHERE tblp_grupo.IdGrupo =  '$IdGrupo' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ";

$sql_materias = $db->query("SELECT tblp_grupo.IdGrupo, tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.id_campus WHERE tblp_grupo.IdGrupo =  '$IdGrupo' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ");

$sql_materias2 = $db->query("SELECT tblp_grupo.IdGrupo, tblp_modulo.IdModulo, tblp_modulo.CodeModulo, tblp_modulo.NombreMod FROM tblp_grupo Left Join tblp_modulo ON tblp_modulo.IdEducativa = tblp_grupo.IdOferta AND tblp_modulo.IdCampus = tblp_grupo.id_campus WHERE tblp_grupo.IdGrupo =  '$IdGrupo' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ");
$db->rows($sql_materias2);
$matrt = $db->recorrer($sql_materias2);

if(!isset($matrt['IdModulo'])){
      $sql_ropx = $db->query("SELECT tblp_grupo.IdGrupo, tblp_grupo.IdOferta, tblc_rvoe.IdCampus FROM tblp_grupo LEFT JOIN tblc_rvoe ON tblp_grupo.id_rvoe = tblc_rvoe.IdRvoe WHERE tblp_grupo.IdGrupo = '$IdGrupo' ");
      $db->rows($sql_ropx);
      $al_campx = $db->recorrer($sql_ropx);
    
    
      $sql_materias = $db->query("SELECT * FROM tblp_modulo WHERE tblp_modulo.IdCampus = '".$al_campx['IdCampus']."' AND tblp_modulo.IdEducativa = '".$al_campx['IdOferta']."' ORDER BY tblp_modulo.Grado ASC, tblp_modulo.CodeModulo ASC ");
}


if ($IdGrupo) {
  $sql_alumnos = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.IdEstatus =  '8' AND tblc_usuario.IdGrupo =  '$IdGrupo' ");
  $db->rows($sql_alumnos);
  $alumnos = $db->recorrer($sql_alumnos);
  $lstalumnos = $alumnos['Total'];
}


  

?>

<div class="box-body">
  <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-check-square-o"></i> MATERIA: </b></span> <?php echo $asig['CodeModulo'] . ' - ' . $asig['NombreMod']; ?> </div>
  <div class="bg-purple color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-user"></i> DOCENTE: </b></span> <?php echo $asig['Nombre'] . ' ' . $asig['APaterno'] . ' ' . $asig['AMaterno']; ?> </div>
  <br>

  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Periodo escolar:</label>
        <div class="col-sm-8">
          <select class="form-control" disabled>
            <?php while ($ciclo = $db->recorrer($sql_ciclo)) { ?>
              <option value="<?php echo $ciclo['IdCiclo']; ?>" <?php if ($IdCiclo == $ciclo['IdCiclo']) { ?>selected="selected" <?php } ?>><?php echo $ciclo['Tipo']; ?> - <?php echo $ciclo['Ciclo']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Campus:</label>
        <div class="col-sm-8">
          <select name="_idCampus" id="_idCampus" class="form-control" onchange="_selCampusId('<?php echo $IdAsignacion; ?>',<?php echo $IdCiclo; ?>)">
            <option value="">- Seleccione - </option>
            <?php while ($campus = $db->recorrer($sql_campus)) { ?>
              <option value="<?php echo $campus['IdCampus']; ?>" <?php if ($IdCampus == $campus['IdCampus']) { ?>selected="selected" <?php } ?>><?php echo $campus['Campus']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Grupo:</label>
        <div class="col-sm-9">
          <select name="_idGrupo" id="_idGrupo" class="form-control" onchange="_selGrupoId('<?php echo $IdAsignacion; ?>',<?php echo $IdCiclo; ?>)">
            <option value="">- Seleccione - </option>
            <?php while ($grp = $db->recorrer($sql_grp)) { ?>
              <option value="<?php echo $grp['IdGrupo']; ?>" <?php if ($IdGrupo == $grp['IdGrupo']) { ?>selected="selected" <?php } ?>><?php echo $grp['Grado']; ?>° <?php echo $grp['CveGrupo']; ?> (<?php echo $grp['_Dias']; ?>) - <?php echo $grp['Abreviatura']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Materia:</label>
        <div class="col-sm-9">
          <select name="_idMateria" id="_idMateria" class="form-control">
            <option value="">- Seleccione - </option>
            <?php while ($materias = $db->recorrer($sql_materias)) { ?>
              <option value="<?php echo $materias['IdModulo']; ?>"><?php echo $materias['CodeModulo']; ?> - <?php echo $materias['NombreMod']; ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <?php if (isset($lstalumnos)) { ?>
            <div class="bg-orange color-palette" style="padding: 8px; color: blue;"><span style="color: black;"><b><i class="fa fa-fw fa-user"></i> Total alumnos que llevarán esta materia: </b></span> <b style="color: blue;"><?php echo $lstalumnos; ?> </b></div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if (isset($lstalumnos)) { ?>
      <div class="box-footer">
        <button onclick="asignar_matetria_especial('<?php echo $IdAsignacion ?>',<?php echo $IdCiclo; ?>)" type="button" class="btn bg-navy btn-flat btn-sm pull-right"><i class="fa fa-save"></i> Asignar materia a los alumnos</button>
      </div>
    <?php } ?>
  </form>
</div>