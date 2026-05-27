<?php
session_start();
require('../../php/clases/class_practicas.php');
require('../../hace.php');
$practicas = new Class_practicas();
$IdUsua = $_POST['IdUsua'];
$var = 1;
$pract_pro = $practicas->get_mis_avisos_practica_id($IdUsua);
$pract_id = $practicas->get_mi_practica_id($IdUsua);

if (isset($pract_pro[0])) {
  $var = 3;
} else {
  $var = 1;
}
if (isset($pract_id[0]['IdPractica'])) {
  $aviso_id = $practicas->get_aviso_id($pract_id[0]['IdAviso']);
  $docs_prac = $practicas->get_docs_practica_id($IdUsua);
  $var = 2;
}


?>
<?php if ((isset($pract_pro[0])) && ($var == 3)) { ?>
  <div class="alert alert-warning alert-dismissible">
    <h4><i class="icon fa fa-flag"></i> <?php echo $pract_pro[0]['Titulo']; ?></h4>
    <p style="font-size: justify;">
      <?php echo $pract_pro[0]['Texto']; ?>
    </p>
    <p>Convocatoria disponible: <?php echo obtenerFechaCorta($pract_pro[0]['Inicio']); ?> al <?php echo obtenerFechaCorta($pract_pro[0]['Final']); ?></p>
    <button onclick="inscripcion_practica(<?php echo $IdUsua; ?>,<?php echo $pract_pro[0]['IdAviso']; ?>,1)" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Clic aquí para inscribirte </button>
  </div>
<?php } ?>
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
    <div class="box-header">
      <div class="direct-chat-text"><b>CONVOCATORIA EN LA QUE SE ENCUENTRA REGISTRADO:</b><br>
        <?php echo $aviso_id[0]['Titulo']; ?><br>(<?php echo obtenerAnioMes($aviso_id[0]['Pra_ini']); ?> <?php echo obtenerAnioMes($aviso_id[0]['Pra_fin']); ?>)
      </div>
      <br><br>
      <h3 class="box-title"><i class="fa fa-question-circle"></i> Documentos disponibles para descargar:</h3>
    </div>
    <div class="box-body">
      <p>Estimado alumno, ahora ya tiene disponible para descargar los documentos de carta de asignación y carta de presentación.</p>
      <p>
        <button onclick="javascript:window.open('repositorio/formatos/carta_asignacion.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-print"></i> Carta de Asignacion</button>
        <button onclick="javascript:window.open('repositorio/formatos/carta_presentacion.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-purple btn-flat"><i class="fa fa-print"></i> Carta de Presentación</button>
        <button onclick="javascript:window.open('assets/docs/ServicioSocial/REPORTE_BIMESTRAL.doc','_blank');" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat"><i class="fa fa-download"></i> Reporte bimestral</button>
        
        
        
        <button onclick="inscripcion_practica(<?php echo $IdUsua; ?>,<?php echo $pract_pro[0]['IdAviso']; ?>,1)" href="javascript:void(0);" type="button" class="btn bg-orange btn-flat"><i class="fa fa-edit"></i> Datos de la Práctica Profesional</button>
       
        
      </p>
    </div>
  </div>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-fw fa-file-archive-o"></i> Reporte de actividades</h3>
    </div>
    <div class="box-body">
      <p>Estimado alumno, en este espacio deberá subir sus reporte de actividades bimestrales.</p>
      <div class="form-group">
        <label class="col-sm-4 control-label">Tipo de documento:</label>
        <div class="col-sm-8">
          <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
            <option value=""> - Seleccione - </option>
            <option value="101">CARTA DE ASIGNACION</option>
            <option value="102">CARTA DE ACEPTACION</option>
            <option value="116">REPORTE BIMESTRAL 1 </option>
            <option value="117">REPORTE BIMESTRAL 2 </option>
            <option value="118">REPORTE BIMESTRAL 3 </option>
            <option value="119">CARTA DE TERMINACIÓN </option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label">Buscar:</label>
        <div class="col-sm-8">
          <input id="txtArchivo" name="txtArchivo" type="file" onchange="validarPDF(this,'txtArchivo');">
          <p style="color: blue;">El archivo puede ser en formato .pdf/.png/.jpg</p>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <div class="checkbox">
            <label style="color: red;">
              <i class="fa fa-fw fa-warning"></i> Nota: Su archivo debe pesar menos de 10 MB.
            </label>
            <label style="color: blue;">
              <i class="fa fa-fw fa-info-circle"></i> Recuerde que los documentos originales deberán ser entregados en el area de Gestión Escolar.
            </label>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button onclick="save_docs_practica(<?php echo $IdUsua; ?>,<?php echo $pract_id[0]['IdPractica']; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-save"></i> Guardar archivo</button>
      </div>
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

  <?php if (($_SESSION['Permisos'] == 3) && (isset($pract_id[0]['_cer_fecha_liberacion']))) { ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-fw fa-flag"></i> Liberación de constancia</h3>
      </div>
      <div class="box-body">
        <p>En este espacio podrá descargar su constancia liberación de prácticas profesionales.</p>
        <p style="text-align: center;">
          <?php if ($pract_id[0]['_cer_fecha_liberacion']) { ?>
            <button onclick="javascript:window.open('repositorio/formatos/constancia_practica_profesional.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-print"></i> Descargar constancia de Liberación de Prácticsa Profesionales</button>
          <?php } ?>
        </p>
      </div>
    </div>
  <?php } ?>

<?php } ?>