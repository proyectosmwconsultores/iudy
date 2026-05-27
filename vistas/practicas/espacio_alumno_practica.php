<?php
session_start();
require('../../php/clases/class_practicas.php');
require('../../hace.php');
$practicas = new Class_practicas();
$IdUsua = $_POST['IdUsua'];
$var = 1;




$pract_id = $practicas->get_mi_practica_id($IdUsua);
$docs_prac = $practicas->get_docs_practica_id($IdUsua);

if (isset($pract_id[0]['IdPractica'])) {
  $aviso_id = $practicas->get_aviso_id($pract_id[0]['IdAviso']);
  $var = 2;
}


?>

<?php if ($var == 1) { ?>
  <blockquote>
    <p>No tiene activo ninguna convocatoria de prácticas profesionales.</p>
    <small>Le recomendamos estar atento a las convocatorias.</small>
  </blockquote>
  <p style="text-align: center;">
    <img src="assets/images/iconos/not_found.gif" style="width: 50%;">
  </p><?php } ?>

<?php if ($var == 2) { ?>
  <div class="box">
    <div class="box-body">
      <p>Documentos disponibles para descargar carta de asignación y carta de presentación.</p>
      <p>
        <button onclick="javascript:window.open('repositorio/formatos/carta_asignacion.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-print"></i> Carta de Asignacion</button>
        <button onclick="javascript:window.open('repositorio/formatos/carta_presentacion.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-purple btn-flat"><i class="fa fa-print"></i> Carta de Presentación</button>
        <button onclick="javascript:window.open('assets/docs/ServicioSocial/REPORTE_BIMESTRAL.doc','_blank');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat"><i class="fa fa-download"></i> Reporte bimestral</button>
        <button onclick="inscripcion_practica(<?php echo $IdUsua; ?>,<?php echo $pract_id[0]['IdAviso']; ?>,1)" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat"><i class="fa fa-edit"></i> Datos de la Práctica Profesional</button>
      </p>
    </div>
  </div>

  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-fw fa-database"></i> Lista de documentos subidos</h3>
    </div>
    <div class="box-body">
      <p>En este espacio podrá visualizar los documentos que haya subido con respecto a las prácticas profesionales.</p>
      <table class="table table-striped" style="font-size: 12px;">
        <tbody>
          <tr>
            <th style="width: 10px">#</th>
            <th>Tipo de documento</th>
            <th>Fec. captura</th>
            <th>Estatus</th>
            <th></th>
          </tr>
          <?php $d = 0;
          for ($i = 0; $i < sizeof($docs_prac); $i++) { ?>
            <tr>
              <td><b><?php echo $d = ($d + 1); ?>.- </b></td>
              <td><?php echo $docs_prac[$i]['NomDocumento']; ?></td>
              <td><?php echo $docs_prac[$i]['FecCap']; ?></td>
              <td><?php echo $docs_prac[$i]['Estatus']; ?></td>
              <td>
                <button onclick="ver_docs_practica(<?php echo $docs_prac[$i]['IdDocsPractica']; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-eye"></i></button>
                <?php if ($docs_prac[$i]['IdEstatus'] == 2) { ?>
                  <button onclick="del_docs_practica(<?php echo $docs_prac[$i]['IdDocsPractica']; ?>,<?php echo $IdUsua; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
<?php } ?>