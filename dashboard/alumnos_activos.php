<?php
session_start();
$IdUsua = $_SESSION['IdUsua'];
require('../php/clases/class.System.php');
$db = new Conexion();

//$baj_plan2 = $db->query("SELECT tblc_usuario.IdUsua, tblp_informacion.P_curp FROM tblc_usuario LEFT JOIN tblp_informacion ON tblc_usuario.IdUsua = tblp_informacion.IdUsua WHERE tblc_usuario.Permisos = 3 ");
//while ($_baj2 = $db->recorrer($baj_plan2)) {
  //  $curp = $_baj2['P_curp'];
    //if(isset($_baj2['P_curp'])){
      //$sexo = substr($curp, 10, 1);
     // $db->query("UPDATE tblc_usuario SET Sexo = '$sexo' WHERE tblc_usuario.IdUsua = '".$_baj2['IdUsua']."' ");  
    //}
//}

echo $IdCiclo = $_POST['IdCiclo'];

$baj_plan2 = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_alumnos.IdGrupo,
tblc_alumnos.IdCiclo,
tblc_alumnos.IdUsua,
tblc_alumnos.Grado,
tblc_usuario.Sexo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario._horario,
tblc_usuario._tipoReincorporacion,
tblc_usuario._fecReincorporacion,
tblc_usuario.id_ciclo_ini,
tblc_usuario.id_ciclo_reincorporacion,
tblc_rvoe.Educativa,
tblc_rvoe.Rvoe,
tblc_rvoe.Vigencia,
tblc_rvoe.Turno,
tblc_rvoe.Modalidad,
tblc_rvoe.Escuela,
tblc_rvoe.Localidad,
tblc_rvoe.Clave,
tblc_rvoe.Clave_dgp,
tblc_rvoe.Clave_rpe,
tblc_rvoe.Creditos,
tblc_rvoe.Materias,
tblc_rvoe._ciclo,
tblc_rvoe._anio,
tblc_rvoe._duracion,
tblc_rvoe._cct,
tblc_rvoe.clave_estadistica,
tblc_campus.Campus,
tblc_estatus.Estatus,
tblp_grupo.Modalidad AS ModalidadGrupo,
tblp_grupo.Dia,
tblp_grupo.TipoCiclo,
tblp_grupo.Periodo,
tblc_ciclo.Tipo,
tblc_ciclo.Anio,
tblc_ciclo.Valor,
tblc_ciclo.FInicio,
tblc_ciclo.FFinal,
tblp_informacion.P_curp,
tblp_informacion.E_escuela_procedencia,
tblp_informacion.FecIns
FROM
tblc_alumnos
Left Join tblc_usuario ON tblc_usuario.IdUsua = tblc_alumnos.IdUsua
Left Join tblc_rvoe ON tblc_rvoe.IdRvoe = tblc_usuario._idRvoe
Left Join tblc_campus ON tblc_campus.IdCampus = tblc_usuario._idCampus
Left Join tblc_estatus ON tblc_estatus.IdEstatus = tblc_usuario.IdEstatus
Left Join tblp_grupo ON tblp_grupo.IdGrupo = tblc_usuario.IdGrupo
Left Join tblc_ciclo ON tblc_ciclo.IdCiclo = tblc_alumnos.IdCiclo
Left Join tblp_informacion ON tblp_informacion.IdUsua = tblc_usuario.IdUsua
Left Join tblp_educativa ON tblp_educativa.IdEducativa = tblc_usuario._idOferta
WHERE
tblc_alumnos.IdCiclo =  '$IdCiclo' AND tblp_educativa.IdGrado <=  '4'
ORDER BY
tblc_usuario._idCampus ASC,
tblc_usuario._idOferta ASC");

?>


<table class="table table-striped">
        <tbody>
          <tr>
            <th></th>
            <th>USUARIO</th>
            <th>NOMBRE</th>
            <th>ESTATUS</th>
            <th>TIPO</th>
            <th>INSCRIPCION</th>
            
          </tr>
          <?php $c = 0; while ($_baj2 = $db->recorrer($baj_plan2)) { if($_baj2['Usuario']){ $c = ($c + 1);
            $sql_cic = $db->query("SELECT tblp_pagos.IdEstatus FROM tblp_pagos WHERE tblp_pagos.IdCiclo = '$IdCiclo' AND tblp_pagos.IdUsua = '".$_baj2['IdUsua']."' AND ((tblp_pagos.IdConcepto = '1') || (tblp_pagos.IdConcepto = '3')) ");
            $db->rows($sql_cic);
            $_cic = $db->recorrer($sql_cic);
            if(isset($_cic['IdEstatus'])){
              $id = $_cic['IdEstatus'];
              if($id == 4){
                $vax = "<b>PAGADO</b>";
              } else {
                $vax = "<b style='color: red;'>PENDIENTE</b>";
              }
            } else {
              $vax = "<b style='color: red;'>PENDIENTE*</b>";
            }
            
            ?>
            <tr>
              <td><b><?php echo $c; ?>.- </b></td>
              <td><?php echo $_baj2['IdUsua']; ?> - <?php echo $_baj2['Usuario']; ?></td>
              <td><?php echo $_baj2['APaterno']; ?> <?php echo $_baj2['AMaterno']; ?> <?php echo $_baj2['Nombre']; ?></td>
              <td><?php echo $_baj2['Estatus']; ?></td>
              <td><?php if($_baj2['_horario'] == "P"){ echo "PERSONALIZADO"; } else { echo "REGULAR"; } ?></td>
              <td><?php echo $vax; ?></td>
            </tr><?php } } ?>
        </tbody>
      </table>

      <button onclick="window.open('dashboard/exp_alumnos_inscritos.php?IdCiclo=<?php echo $IdCiclo; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-danger btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar excel SEP</button>
      <button onclick="window.open('dashboard/exp_alumnos_inscritos_estatus.php?IdCiclo=<?php echo $IdCiclo; ?>','_self')" href="javascript:void(0);" type="button" class="btn btn-block btn-info btn-xs"><i class="fa fa-fw fa-cloud-download"></i> Descargar este excel</button>
