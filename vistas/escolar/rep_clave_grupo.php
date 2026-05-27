<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../../php/clases/class.System.php');
include('../../hace.php');
$db = new Conexion();
$IdCiclo = $_POST['IdCiclo'];
$Tipo = $_POST['Tipo'];

$sql_cicxc = $db->query("SELECT * FROM tblc_ciclo WHERE tblc_ciclo.Tipo = '$Tipo' ORDER BY tblc_ciclo.Tipo ASC, tblc_ciclo.FInicio DESC ");

$sql_lsta = $db->query("SELECT
tblp_grupo.IdGrupo,
tblp_grupo.CveGrupo,
tblp_grupo.IdCampus,
tblp_grupo.Grado,
tblp_grupo.Anio,
tblp_grupo.FechaIni,
tblp_grupo.FechaFin,
tblc_modalidad._Modalidad,
tblc_dias_clases._Dias,
tblc_estatus.Estatus,
tblc_campus.Campus,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe
FROM
tblp_grupo
Left Join tblc_modalidad ON tblc_modalidad.`Mod` = tblp_grupo.Modalidad
Left Join tblc_dias_clases ON tblc_dias_clases.Dia = tblp_grupo.Dia
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblp_grupo.IdEstatus
Left Join tblc_campus ON tblc_campus.IdCampus = tblp_grupo.IdCampus
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblp_grupo.id_rvoe
WHERE tblp_grupo.IdCicloIni = '$IdCiclo'
ORDER BY
tblp_grupo.IdCampus ASC,
tblc_rvoe.Educativa ASC,
tblp_grupo.Grado ASC");
$sql_cic = $db->query("SELECT tblc_ciclo.Ciclo FROM tblc_ciclo WHERE tblc_ciclo.IdCiclo = '$IdCiclo'");
$db->rows($sql_cic);
$_cic = $db->recorrer($sql_cic);

?>

<div class="col-md-5">
  <div class="form-group">
    <br>
    <div class="btn-group">
      <button type="button" onclick="sel_tipo_perxy('SEMESTRE')" class="btn btn-<?php if($Tipo == "SEMESTRE"){ echo "info"; } else { echo "default"; } ?>"><?php if($Tipo == "SEMESTRE"){ echo "<i class='fa fa-fw fa-check-circle'></i>"; } ?> SEMESTRE</button>
      <button type="button" onclick="sel_tipo_perxy('CUATRIMESTRE')" class="btn btn-<?php if($Tipo == "CUATRIMESTRE"){ echo "info"; } else { echo "default"; } ?>"><?php if($Tipo == "CUATRIMESTRE"){ echo "<i class='fa fa-fw fa-check-circle'></i>"; } ?> CUATRIMESTRE</button>
      <button type="button" onclick="sel_tipo_perxy('TRIMESTRE')" class="btn btn-<?php if($Tipo == "TRIMESTRE"){ echo "info"; } else { echo "default"; } ?>"><?php if($Tipo == "TRIMESTRE"){ echo "<i class='fa fa-fw fa-check-circle'></i>"; } ?> TRIMESTRE</button>
    </div>
  </div>

</div>
<div class="col-md-7">
  <div class="form-group">
    <label>Periodo escolar:</label>
    <div class="input-group">
      <div class="input-group-addon">
        <i class="fa fa-fw fa-key"></i>
      </div>
      <select class="form-control select2" name="txtCiclo" id="txtCiclo" onchange="cargar_periodo_escolar('<?php echo $Tipo; ?>')">
        <option value=""> - Seleccione - </option>
        <?php while ($_cPer = $db->recorrer($sql_cicxc)) { ?>
          <option value="<?php echo $_cPer["IdCiclo"]; ?>" <?php if($_cPer["IdCiclo"] == $IdCiclo){ ?>selected="selected"<?php } ?>><?php echo $_cPer["Ciclo"]; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</div>

<div class="box-body">


  <div class="bg-purple-active color-palette" style="padding: 8px;"><span style="color: yellow;"><b><i class="fa fa-fw fa-info-circle"></i> PERIODO ESCOLAR: </b></span><?php echo $_cic["Ciclo"]; ?> <b style="float: right; color: yellow; cursor: pointer;" onclick="crear_grupo(<?php echo $IdCiclo; ?>)" href="javascript:void(0);"><i class="fa fa-fw fa-check-square-o"></i> CREAR GRUPO </b></div>
  <table class="table table-striped" style="font-size: 12px;">
    <tbody>

      <?php $g = 0;
      $ci = 0;
      $cf = 0;
      while ($matx = $db->recorrer($sql_lsta)) {
        $ci = $matx['IdCampus'];
        $sql_gra = $db->query("SELECT Count(tblc_usuario.IdUsua) AS Total FROM tblc_usuario WHERE tblc_usuario.IdGrupo =  '" . $matx['IdGrupo'] . "' ");
        $db->rows($sql_gra);
        $_gra = $db->recorrer($sql_gra);
        if ($ci <> $cf) { $g = 0; ?>
          <tr>
            <td colspan="9" style="background: #dad3ff;"><i class="fa fa-fw fa-bell"></i> <?php echo $matx['Campus']; ?></td>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th>GRUPO</th>
            <th></th>
            <th>PLAN DE ESTUDIOS</th>
            <th>AÑO</th>
            <th>GENERACIÓN</th>
            <th>MODALIDAD</th>
            <th>ESTATUS</th>
            <th style="text-align: center;">ALUMNOS</th>
          </tr>
        <?php } ?>
        <tr>
          <td><b><?php echo $g = ($g + 1); ?>.- </b></td>
          <td style="text-aling: center;" ><?php echo $matx['Grado']; ?>° </td>
          <td style="cursor: pointer; color: blue;" onclick="mostra_datos_grp(<?php echo $matx['IdGrupo']; ?>)"><?php echo $matx['CveGrupo']; ?></td>
          <td><?php echo $matx['IdGrupo']; ?></td>
          <td><?php echo $matx['Rvoe'] . ' - ' . $matx['Educativa']; ?></td>
          <td>20<?php echo $matx['Anio']; ?></td>
          <td><?php echo obtener_AnioMesMAYG($matx['FechaIni']); ?> / <?php echo obtener_AnioMesMAYG($matx['FechaFin']); ?></td>
          <td><?php echo $matx['_Modalidad']; ?> - <?php echo $matx['_Dias']; ?></td>
          <td><?php echo $matx['Estatus']; ?></td>
          <td style="text-align: center;"><?php echo $_gra['Total']; ?></td>
        </tr><?php $cf = $matx['IdCampus'];
            } ?>
    </tbody>
  </table>
</div>