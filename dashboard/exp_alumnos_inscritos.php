<?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=alumnos_periodo.xls");
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Expires: 0");

  require('../php/clases/class.System.php');
    require('../hace.php');
    $db = new Conexion();
    $IdCiclo = $_GET['IdCiclo'];
    $hoy = date("Y-m-d");
   

$baj_plan2 = $db->query("SELECT
tblc_alumnos.IdActivo,
tblc_alumnos.IdGrupo,
tblc_alumnos.IdCiclo,
tblc_alumnos.IdUsua,
tblc_alumnos.Grado,
tblc_usuario.IdCampus,
tblc_usuario.Sexo,
tblc_usuario.Nombre,
tblc_usuario.APaterno,
tblc_usuario.AMaterno,
tblc_usuario.Usuario,
tblc_usuario.porcentaje,
tblc_usuario.FecCap,
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
tblp_informacion.FecIns,
tblp_informacion.C_tipo
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
tblc_usuario._idOferta ASC
");


?>
<html>
  <head>
    <META HTTP-EQUIV= "Content-Type" CONTENT="text/html; charset=utf-8" />
    <META http-equiv="Content-Language" content="es" />
  </head>
  <body>
    <table class="table table-striped" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <tbody>
          <tr>
            <th>NOMBRE DE LA INSTITUCION</th>
            <th>ACTIVO/INACTIVO</th>
            <th>INSCRITO/REINSCRITOS</th>
            <th>GENERACIÓN</th>
            <th style="width: 200px;">PERIODO ESCOLAR QUE REPORTA</th>
            <th style="width: 250px;">FECHA DE INICIO DEL PERIODO ESCOLAR QUE REPORTA</th>
            <th style="width: 200px;">FECHA DE FIN DEL PERIODO ESCOLAR QUE REPORTA</th>
            <th style="width: 200px;">NUMERAL DE SEMESTRE, CUATRIMESTRE, O  MODULAR </th>
            <th style="width: 200px;">SEMESTRE , CUATRIMESTRE , O  MODULAR </th>
            <th style="width: 200px;">MATRICULA ASIGNADA POR LA INSTITUCIÓN</th>
            <th>CURP DEL ALUMNO</th>
            <th>PRIMER APELLIDO</th>
            <th>SEGUNDO APELLIDO</th>
            <th>NOMBRE(S) DEL ALUMNO(A)</th>
            <th style="width: 200px;">CLAVE DE LA INSTITUCION DEL PLANTEL</th>
            <th>CCT</th>
            <th style="width: 600px;">NOMBRE DE LA CARRERA</th>
            <th style="width: 150px;">CLAVE DE LA CARRERA</th>
            <th style="width: 150px;">AÑO DEL PLAN ESTUDIO</th>
            <th style="width: 150px;">CLAVE DE LA INSTITUCIÓN</th>
            <th>RVOE</th>
            <th style="width: 250px;">FECHA DE EXPEDICION DE RVOE</th>
            <th style="width: 150px;">DURACION EN AÑOS</th>
            <th style="width: 200px;">ESCOLARIZADA, NO ESCOLARIZADA, O MIXTA</th>
            <th style="width: 200px;">SE INCRIBE POR EQUIVALENCIA O REVALIDACION</th>
            <th>CURSA SUS ESTUDIOS EN INSTITUCION (CENTRAL)</th>
            <th style="width: 200px;">CURSA SUS ESTUDIOS EN INSTITUCION ( CAMPUS)</th>
            <th style="width: 250px;">CURSA SUS ESTUDIOS EN INSTITUCION (EXTENSION)</th>
            <th>MUJER (M)</th>
            <th>HOMBRE (H)</th>
            <th style="width: 500px;">ESCUELA DE PROCEDENCIA</th>
            <th>REINCORPORACION</th>
            <th style="width: 150px;">FEC. CAP EN PLATAFORMA</th>
            <th>FORMA DE INGRESO</th>
            <th>BECA INSCRIPCION(%)</th>
            <th>BECA MENSUALIDAD(%)</th>
            <th>INSCRIPCION</th>
            <th>MENSUALIDAD</th>
            <th>INSCRIPCION</th>
            <th>PORCENTAJE</th>
            <th>EDAD</th>
            <th>CAMPUS</th>
            
          </tr>
          <?php $c = 0; while ($_baj2 = $db->recorrer($baj_plan2)) { if($_baj2['Usuario']){ $c = ($c + 1); 
            $porcem = 0;
            $porce = 0;
            
            $sqlx9 = $db->query("SELECT tblp_beca.IdBeca, tblp_beca.Total, tblp_beca.Porcentaje FROM tblp_beca WHERE tblp_beca.IdUsua =  '".$_baj2['IdUsua']."' AND tblp_beca.IdCiclo =  '$IdCiclo' AND ((tblp_beca.IdConcepto =  '1') || (tblp_beca.IdConcepto =  '3')) LIMIT 1 ");
            $db->rows($sqlx9);
            $datosx91 = $db->recorrer($sqlx9);
            if(isset($datosx91['Porcentaje'])){ if($datosx91['Porcentaje'] < 0) { $porce = 0; } else { $porce = $datosx91['Porcentaje']; } } else { $porce = 0; }

            $sqlxm = $db->query("SELECT tblp_beca.IdBeca,  tblp_beca.Total, tblp_beca.Porcentaje FROM tblp_beca WHERE tblp_beca.IdUsua =  '".$_baj2['IdUsua']."' AND tblp_beca.IdCiclo =  '$IdCiclo' AND tblp_beca.IdConcepto =  '2' LIMIT 1 ");
            $db->rows($sqlxm);
            $datosxm1 = $db->recorrer($sqlxm);
            if(isset($datosxm1['Porcentaje'])){ if($datosxm1['Porcentaje'] < 0) { $porcem = 0; } else { $porcem = $datosxm1['Porcentaje']; } } else { $porcem = 0; }

            $sql_pag = $db->query("SELECT tblp_pagos.IdPago, tblp_pagos.IdEstatus FROM tblp_pagos WHERE tblp_pagos.IdUsua =  '".$_baj2['IdUsua']."' AND tblp_pagos.IdCiclo =  '$IdCiclo' AND ((tblp_pagos.IdConcepto =  '1') || (tblp_pagos.IdConcepto =  '3')) ");
            $db->rows($sql_pag);
            $_pag = $db->recorrer($sql_pag);
          
            ?>
            <tr>
              <td style="text-align: left;">INSTITUTO UNIVERSITARIO DE YUCATAN</td>
              <td style="text-align: left;"><?php echo $_baj2['Estatus']; ?></td>
              <td style="text-align: left;"><?php if($_baj2['id_ciclo_ini'] == $IdCiclo){ echo "INSCRITO"; } else { echo "REINSCRITO"; } ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Periodo']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Anio'].'-'.$_baj2['Valor']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['FInicio']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['FFinal']; ?></td>
              <td style="text-align: center;"><?php if($_baj2['_horario'] == 'P') { echo "P"; } else { echo $_baj2['Grado'];} ?></td>
              <td style="text-align: left;"><?php echo $_baj2['_ciclo']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Usuario']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['P_curp']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['APaterno']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['AMaterno']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Nombre']; ?></td>
              <td style="text-align: center;">270160</td>
              <td style="text-align: left;"><?php echo $_baj2['_cct']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Educativa']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['clave_estadistica']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['_anio']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Clave_dgp']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Rvoe']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['Vigencia']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['_duracion']; ?></td>
              <td style="text-align: center;"><?php echo $_baj2['Modalidad']; ?></td>
              <td style="text-align: left;"><?php if($_baj2['id_ciclo_reincorporacion'] == $IdCiclo){ echo "REINCORPORACION"; } else { echo ""; } ?></td>
              <td style="text-align: left;">VILLAHERMOSA, <?php echo $_baj2['Campus']; ?></td>
              <td style="text-align: left;"></td>
              <td style="text-align: left;"><?php echo $_baj2['Campus']; ?></td>
              <td style="text-align: center;"><?php if($_baj2['Sexo'] == "M"){ echo "M"; }?></td>
              <td style="text-align: center;"><?php if($_baj2['Sexo'] == "H"){ echo "H"; }?></td>
              <td style="text-align: left;"><?php echo $_baj2['E_escuela_procedencia']; ?></td>
              <td style="text-align: left;"><?php if(($IdCiclo == $_baj2['id_ciclo_reincorporacion']) && ($_baj2['_tipoReincorporacion'] == 'SI')){ echo $_baj2['_fecReincorporacion']; }?></td>
              <td style="text-align: left;"><?php echo $_baj2['FecCap']; ?></td>
              <td style="text-align: left;"><?php echo $_baj2['C_tipo']; ?></td>
              <td style="text-align: center;"><?php echo $porce; ?> % </td>
              <td style="text-align: center;"><?php echo $porcem; ?> % </td>
              <td style="text-align: center;"><?php echo $datosx91['Total']; ?> </td>
              <td style="text-align: center;"><?php echo $datosxm1['Total']; ?> </td>
              <td style="text-align: center;"><?php if($_pag['IdEstatus'] == 4){ echo "PAGADO"; } else { echo "NO PAGADO"; } ?> </td>
              <td style="text-align: center;"><?php echo $_baj2['porcentaje']; ?> </td>
              <td style="text-align: center;"><?php if(isset($_baj2['P_curp'])){ echo edadDesdeCURP($_baj2['P_curp']); } ?></td>
              <td style="text-align: center;"><?php if($_baj2['IdCampus'] == "1"){ echo "VILLAHERMOSA"; } ?> <?php if($_baj2['IdCampus'] == "2"){ echo "COMALCALCO"; } ?> <?php if($_baj2['IdCampus'] == "3"){ echo "TEAPA"; } ?> <?php if($_baj2['IdCampus'] == "4"){ echo "ZAPATA"; } ?> </td>
            </tr><?php } } ?>
        </tbody>
      </table>
  </body>
</html>


<?php
/**
 * Calcula la edad a partir de una CURP mexicana.
 * - Valida estructura básica de CURP.
 * - Extrae YYMMDD.
 * - Deduce el siglo (1900/2000) comparando contra el año actual (dos dígitos).
 * - Permite pasar una fecha de referencia ($refDate) para pruebas.
 *
 * @param string      $curp     CURP de 18 caracteres.
 * @param string|null $refDate  Fecha de referencia 'Y-m-d' (opcional). Por defecto: hoy.
 * @return int|null   Edad en años; null si la CURP es inválida o la fecha no existe.
 */
function edadDesdeCURP(string $curp, ?string $refDate = null): ?int
{
    $curp = strtoupper(trim($curp));

    if (!isset($curp)) {
        return null; // o puedes devolver 0 si prefieres
    }

    if (empty($curp)) {
        return null; // o puedes devolver 0 si prefieres
    }
    

    // Validación mínima de formato CURP (18 chars y patrón general)
    if (!preg_match('/^[A-Z][AEIOUX][A-Z]{2}\d{2}[01]\d[0-3]\d[HM][A-Z]{5}[0-9A-Z]\d$/', $curp)) {
        return null;
    }

    // Extraer YYMMDD (posiciones 5-10, índices 4..9 en 0-based)
    $yy = substr($curp, 4, 2);
    $mm = substr($curp, 6, 2);
    $dd = substr($curp, 8, 2);

    // Deducir siglo:
    // Si YY > año actual (dos dígitos), entonces 1900 + YY; de lo contrario 2000 + YY.
    $currentYY = (int)date('y');
    $yyNum     = (int)$yy;
    $century   = ($yyNum > $currentYY) ? 1900 : 2000;
    $year      = $century + $yyNum;

    // Validar que la fecha exista
    $birthStr = sprintf('%04d-%02d-%02d', $year, (int)$mm, (int)$dd);
    $birth    = DateTime::createFromFormat('Y-m-d', $birthStr);
    $valid    = $birth && $birth->format('Y-m-d') === $birthStr;
    if (!$valid) {
        return null;
    }

    // Fecha de referencia (para pruebas) o hoy
    $ref = $refDate ? DateTime::createFromFormat('Y-m-d', $refDate) : new DateTime('today');
    if (!$ref) $ref = new DateTime('today');

    // Calcular edad
    $diff = $birth->diff($ref);
    return (int)$diff->y;
}

// =====================
// Ejemplos de uso:
// =====================

// Nacido el 22/04/1990 (curp de ejemplo ficticia)
// echo edadDesdeCURP('PECG900422HDFRRN08'); // -> 35 (dependiendo de la fecha actual)

// Para probar con una fecha de referencia:
// echo edadDesdeCURP('PECG900422HDFRRN08', '2025-10-13'); // -> 35

