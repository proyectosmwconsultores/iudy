<?php
  session_start();
  require('../php/clases/class.System.php');
  $db = new Conexion();
  $IdDocs = $_POST['IdDocs'];

  //
  $sql_seg = $db->query("SELECT
tblc_docdocentes.IdDocDocente,
tblc_docdocentes.Archivo,
tblc_docdocentes.Anio,
tblc_docdocentes.Mes,
tblc_docdocentes.Formato,
tblc_tipodocumento.NomDocumento
FROM
tblc_docdocentes
Left Join tblc_tipodocumento ON tblc_tipodocumento.IdTipoDocumento = tblc_docdocentes.IdTipoDocumento WHERE tblc_docdocentes.IdDocDocente = '$IdDocs'");
  $db->rows($sql_seg);
  $_doc = $db->recorrer($sql_seg);
  ?>
  <input type="hidden" name="nom_" id="nom_" value="<?php echo $_doc["NomDocumento"]; ?>">
  <script>
  $(document).ready(function(){
    var nom_ = document.getElementById("nom_").value;
    document.getElementById('_pre').innerHTML = nom_;
  });
  </script>
  <button onClick="window.open('assets/docs/Docentes/<?php echo $_doc['Anio']; ?>/<?php echo $_doc['Mes']; ?>/<?php echo $_doc['Archivo']; ?>','_blank')" href="javascript:void(0);" title="Descargar documento del docente" type="button" class="btn btn-block btn-warning btn-sm"><i class="fa fa-fw fa-cloud-download"></i> Descargar documento</button> <br>
  <?php if($_doc['Formato'] == 'pdf'){ ?>
    <iframe src="assets/docs/Docentes/<?php echo $_doc['Anio']; ?>/<?php echo $_doc['Mes']; ?>/<?php echo $_doc['Archivo']; ?>" width="100%" height="400px">
  <?php } else { ?>
    <img src="assets/docs/Docentes/<?php echo $_doc['Anio']; ?>/<?php echo $_doc['Mes']; ?>/<?php echo $_doc['Archivo']; ?>" style="width: 100%;">
  <?php } ?>
