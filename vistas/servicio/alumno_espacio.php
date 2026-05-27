<?php
session_start();
require('../../php/clases/class_servicio.php');
require('../../hace.php');
$practicas = new Class_servicio();
$IdUsua = $_POST['IdUsua'];
$var = 1;
$pract_id = $practicas->get_mi_practica_id($IdUsua);

if (isset($pract_id[0]['IdServicio'])) {
  $aviso_id = $practicas->get_aviso_id($pract_id[0]['IdAviso']);
  $docs_prac = $practicas->get_docs_practica_id($IdUsua, $pract_id[0]['IdServicio']);
  $var = 2;
} else {
  $pract_pro = $practicas->get_mis_avisos_practica_id($IdUsua);
  if (isset($pract_pro[0])) {
    $servic = $practicas->get_mi_servicio_all($IdUsua,$pract_pro[0]['IdAviso']);
    $var = 3;
  } else {
    $var = 1;
  }
}

?>
<button onclick="abrir_archivo_pdf()" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat pull-right"><i class="fa fa-fw fa-info-circle"></i> Instructivo para Servicio Social </button><br><br>

<?php if ($var == 2) { ?>
  <div class="alert alert-info alert-dismissible">
    <h4><i class="icon fa fa-flag"></i> <?php echo $aviso_id[0]['Titulo']; ?></h4>
    <p>Convocatoria disponible: <?php echo obtenerFechaCorta($aviso_id[0]['Inicio']); ?> al <?php echo obtenerFechaCorta($aviso_id[0]['Final']); ?></p>
  </div>
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-warning"></i> Documentos disponibles para descargar</h3>
    </div>
    <div class="box-body">
      <p>Estimado alumno, ahora ya tienes disponible para descargar los siguientes documentos:</p>
      <ul class="mailbox-attachments clearfix">
        <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('repositorio/formatos/carta_presentacion_ss.php?idToks=<?php echo time() . $pract_id[0]['IdServicio']; ?>');" href="javascript:void(0);">
          <div class="mailbox-attachment-info">
            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Carta de presentación</a>
            <span class="mailbox-attachment-size">
              Clic para descargar
              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
            </span>
          </div>
        </li>
        <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('assets/docs/ServicioSocial/CARTA_DE_ASIGNACION_DE_SERVICIO_SOCIAL26.xlsx','_blank');" href="javascript:void(0);">
          <div class="mailbox-attachment-info" style="background: #c5cfec;">
            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Carta de asignación</a>
            <span class="mailbox-attachment-size">
              Clic para descargar
              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
            </span>
          </div>
        </li>
        <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('assets/docs/ServicioSocial/FORMATO_DE_REPORTE_INICIAL_IUDY_2026.doc','_blank');" href="javascript:void(0);">
          <div class="mailbox-attachment-info">
            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Reporte inicial</a>
            <span class="mailbox-attachment-size">
              Clic para descargar
              <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
            </span>
          </div>
        </li>
      </ul>
      <?php if ($pract_id[0]['_validado'] == 1) { ?>
        <h5> <span class="mailbox-read-time pull-center" style="color: blue;">Recuerda que debes descargar los documentos anteriores, capturar la información requerida y llevarlos al área correspondientes para su revisión.</span></h5>
      <?php } ?>
      <?php if ($pract_id[0]['_validado'] == 2) { ?>
        <ul class="mailbox-attachments clearfix">
          <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('assets/docs/ServicioSocial/6_FORMATO_DE_REPORTE_BIMESTRAL-IUDY_25.doc','_blank');"  href="javascript:void(0);">
            <div class="mailbox-attachment-info">
              <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Formato de reporte Bimestral</a>
              <span class="mailbox-attachment-size">
                Clic para descargar
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
            </div>
          </li>
          <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('assets/docs/ServicioSocial/6_FORMATO_DE_REPORTE_GLOBAL2025B.doc','_blank');" href="javascript:void(0);">
            <div class="mailbox-attachment-info" style="background: #c5cfec;">
              <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Formato de reporte Global</a>
              <span class="mailbox-attachment-size">
                Clic para descargar
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
            </div>
          </li>
          <li style="width: 250px; cursor: pointer;" onclick="javascript:window.open('assets/docs/ServicioSocial/6_FORMATO_DE_REPORTE_FINAL-IUDY_25.doc','_blank');" href="javascript:void(0);">
            <div class="mailbox-attachment-info">
              <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> Formato de reporte Final</a>
              <span class="mailbox-attachment-size">
                Clic para descargar
                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
              </span>
            </div>
          </li>
        </ul>
        <h5> <span class="mailbox-read-time pull-center" style="color: blue;">Recuerda que debes descargar los documentos anteriores, capturar la información requerida y llevarlos al área correspondientes para su revisión, una vez aprobado deberás subirlo en el espacio de abajo.</span></h5>
      <?php } ?>
    </div>
  </div>
  <?php if ($pract_id[0]['_validado'] == 2) { ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-fw fa-file-archive-o"></i> Reporte de actividades</h3>
      </div>
      <div class="box-body">
        <p>Estimado alumno, en este espacio deberá subir sus reporte de actividades del servicio social</p>
        <div class="form-group">
          <label class="col-sm-4 control-label">Tipo de documento:</label>
          <div class="col-sm-8">
            <select class="form-control" name="txtTipoDoc" id="txtTipoDoc">
              <option value=""> - Seleccione - </option>
              <!--NORMAL-->
              <option value="101">CARTA DE ACEPTACION</option> <!--REVISAR-->
              <option value="102">CARTA DE ASIGNACION</option>
              <option value="116">REPORTE INICIAL </option>
              <option value="116">REPORTE BIMESTRAL 1 </option>
              <option value="117">REPORTE BIMESTRAL 2 </option>
              <option value="118">REPORTE BIMESTRAL 3 </option>
              <option value="122">REPORTE FINAL </option>
              <option value="101">CARTA DE TERMINACION</option> <!--REVISAR-->
              
              <!--AUTOMATICO-->
              <option value="101">CONSTANCIA LABORAL</option> <!--REVISAR-->
              <option value="101">CARTA DE ASIGNACION</option>
              <option value="121">REPORTE GLOBAL </option>
              
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
          <button onclick="save_docs_practica(<?php echo $IdUsua; ?>,<?php echo $pract_id[0]['IdServicio']; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-save"></i> Guardar archivo</button>
        </div>
      </div>
    </div>
    <div class="box">
    <div class="box-header">
      <h3 class="box-title"><i class="fa fa-fw fa-database"></i> Lista de documentos subidos</h3>
    </div>
    <div class="box-body">
      <p>En este espacio podrá visualizar los documentos que haya subido con respecto al servicio social.</p>
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
                <button onclick="ver_docs_practica(<?php echo $docs_prac[$i]['IdDocsServicio']; ?>)" type="button" class="btn bg-orange btn-flat btn-xs"><i class="fa fa-eye"></i></button>
                <?php if ($docs_prac[$i]['IdEstatus'] == 2) { ?>
                  <button onclick="del_docs_practica(<?php echo $docs_prac[$i]['IdDocsServicio']; ?>,<?php echo $IdUsua; ?>)" type="button" class="btn bg-navy btn-flat btn-xs"><i class="fa fa-trash"></i></button>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if (($_SESSION['Permisos'] == 3) || (isset($pract_id[0]['_cer_fecha_liberacion']))) { ?>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><i class="fa fa-fw fa-flag"></i> Liberación de constancia</h3>
      </div>
      <div class="box-body">
        <p>En este espacio podrá descargar su constancia liberación de servicio social.</p>
        <p style="text-align: center;">
          <?php if ($pract_id[0]['_cer_fecha_liberacion']) { ?>
            <button onclick="javascript:window.open('repositorio/formatos/constancia_practica_profesional.php?idToks=<?php echo time() . $pract_id[0]['IdPractica']; ?>');" href="javascript:void(0);" type="button" class="btn bg-maroon btn-flat"><i class="fa fa-print"></i> Descargar constancia de Liberación de Prácticsa Profesionales</button>
          <?php } ?>
        </p>
      </div>
    </div>
  <?php } ?>
  <?php } ?>
<?php } ?>

<?php if ((isset($pract_pro[0])) && ($var == 3)) { ?>
  <div class="alert alert-warning alert-dismissible">
    <h4><i class="icon fa fa-flag"></i> <?php echo $pract_pro[0]['Titulo']; ?></h4>
    <p style="font-size: justify;">
      <?php echo $pract_pro[0]['Texto']; ?>
    </p>
    <p>Convocatoria disponible: <?php echo obtenerFechaCorta($pract_pro[0]['Inicio']); ?> al <?php echo obtenerFechaCorta($pract_pro[0]['Final']); ?></p>
    <button onclick="inscripcion_servicio(<?php echo $IdUsua; ?>,<?php echo $pract_pro[0]['IdAviso']; ?>,1)" href="javascript:void(0);" type="button" class="btn bg-navy btn-flat pull-right"><i class="fa fa-fw fa-check-circle-o"></i> Clic aquí para inscribirte </button>
  </div><br>
  <?php if(isset($servic[0]['IdServicio'])){ if($servic[0]['IdEstatus'] == 5){ ?>
    <div class="bg-maroon-active color-palette" style="padding: 5px;"><span><i class="fa fa-fw fa-times-circle"></i> La inscripción para su Servicio Social no fue aprobada. </span></div><br>
    <p><b>Motivo:</b> <?php echo $servic[0]['Motivo']; ?></p>
  <?php } } ?>
  
<?php } ?>
<?php if ($var == 1) { ?>
  <blockquote>
    <p>No tiene activo ninguna convocatoria de servicio social.</p>
    <small>Le recomendamos estar atento a las convocatorias.</small>
  </blockquote>
  <p style="text-align: center;">
    <img src="assets/images/iconos/not_found.gif" style="width: 50%;">
  </p><?php } ?>