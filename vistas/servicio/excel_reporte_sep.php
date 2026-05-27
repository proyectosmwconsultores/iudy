<?php session_start();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte-sep_servicio_social.xls");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");

require('../../php/clases/class_servicio.php');
$practicas = new Class_servicio();
$IdAviso = $_GET['IdAviso'];

$sql_lsta = $practicas->get_rep_servicio_social_sep($IdAviso);
?>
<meta charset="utf-8">
  <table style="font-size: 12px; font-family: Arial;">
    <thead> 
      <tr style="background: #d2cece;">
        <th>NO</th>
        <th>N° DE REG</th>
        <th>APELLIDO PATERNO</th>
        <th>APELLIDO MATERNO</th>
        <th>NOMBRE</th>
        <th>NOMBRE COMPLETO</th>
        <th>DEPENDENCIA</th>
        <th>UBICACION DE ASIG.</th>
        <th>NOMBRE DEL TITULAR</th>
        <th>CARGO</th>
        <th>PROGRAMA/PROYECTO</th>
        <th>AREA DE ATENCION</th>
        <th>PRODUCTIVO</th>
        <th>COMERCIO</th>
        <th>SERVICIO</th>
        <th>PUBLICA</th>
        <th>PRIVADA</th>
        <th>EDAD</th>
        <th>MATRICULA</th>
        <th>CURP</th>
        <th>LICENCIATURA</th>
        <th>RVOES</th>
        <th>M</th>
        <th>H</th>
        <th>CUATRIMESTRE</th>
        <th>SEMESTRE</th>
        <th>REPETIDOR S.S</th>
        <th>EGRESADO</th>
        <th>OBSERVACIONES</th>
      </tr>
    </thead>
    <tbody>
      <?php $g = 0;
      foreach ($sql_lsta as $matx) { $g = ($g + 1); ?>
        <tr>
          <td><?php echo $g; ?></td>
          <td></td>
          <td><?php echo $matx['APaterno']; ?></td>
          <td><?php echo $matx['AMaterno']; ?></td>
          <td><?php echo $matx['Nombre']; ?></td>
          <td><?php echo $matx['APaterno'] . ' ' . $matx['AMaterno'] . ' ' . $matx['Nombre']; ?></td>
          <td><?php echo $matx['Empresa']; ?></td>
          <td><?php echo $matx['Area_ubicacion']; ?></td>
          <td><?php echo $matx['Grado_responsable'].'. '.$matx['Nombre_responsable']; ?></td>
          <td><?php echo $matx['Cargo']; ?></td>
          <td><?php echo $matx['Area_asignado']; ?></td>
          <td><?php echo $matx['Area_atencion']; ?></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><?php echo $matx['Usuario']; ?></td>
          <td><?php echo $matx['Curp']; ?></td>
          <td><?php echo $matx['Educativa']; ?></td>
          <td><?php echo $matx['Rvoe']; ?></td>
          <td><?php if($matx['Sexo'] == 'M'){ echo "M"; } ?></td>
          <td><?php if($matx['Sexo'] == 'H'){ echo "H"; } ?></td>
          <td><?php echo $matx['Grado']; ?></td>
        </tr><?php } ?>
    </tbody>
  </table>
