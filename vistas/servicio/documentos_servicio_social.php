<?php
session_start();
require('../../php/clases/class.System.php');
$db = new Conexion();
$IdAviso = $_POST['IdAviso'];
$sql_con1 = $db->query("SELECT * FROM tbla_aviso_docs WHERE tbla_aviso_docs.IdAviso = '$IdAviso' AND tbla_aviso_docs.Tipo = '1' ");
$db->rows($sql_con1);
$_docs1 = $db->recorrer($sql_con1);

$sql_con2 = $db->query("SELECT * FROM tbla_aviso_docs WHERE tbla_aviso_docs.IdAviso = '$IdAviso' AND tbla_aviso_docs.Tipo = '2' ");
$db->rows($sql_con2);
$_docs2 = $db->recorrer($sql_con2);

$sql_con3 = $db->query("SELECT * FROM tbla_aviso_docs WHERE tbla_aviso_docs.IdAviso = '$IdAviso' AND tbla_aviso_docs.Tipo = '3' ");
$db->rows($sql_con3);
$_docs3 = $db->recorrer($sql_con3);

$sql_con4 = $db->query("SELECT * FROM tbla_aviso_docs WHERE tbla_aviso_docs.IdAviso = '$IdAviso' AND tbla_aviso_docs.Tipo = '4' ");
$db->rows($sql_con4);
$_docs4 = $db->recorrer($sql_con4);


$sql_cic = $db->query("SELECT * FROM tblc_periodo_ps WHERE tblc_periodo_ps.Tipo = 'S' ORDER BY tblc_periodo_ps.Inicia ASC ");

#1 Instructivo para servicio social
#2 Carta de asignación de servicio social
#3 Formato de reporte inicial de servicio social
#3 Formato de reporte global de servicio social

?>
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Instructivo para Servicio Social</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Buscar archivo:</label>
        <div class="col-sm-8">
          <input type="file" class="form-control" id="txt_archivo1" name="txt_archivo1">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <?php if(isset($_docs1[0])){ ?>
      <button type="button" onclick="del_documento_ss(<?php echo $IdAviso; ?>,<?php echo $_docs1['IdDocs']; ?>)" class="btn btn-danger pull-right"><i class="fa fa-fw fa-trash"></i> Eliminar archivo</button>
      <button style="margin-right: 10px;" type="button" onClick="window.open('<?php echo $_docs1['Archivo']; ?>','_blank')" href="javascript:void(0);" class="btn btn-success pull-right"><i class="fa fa-fw fa-eye"></i> Ver archivo</button>
      <?php } else { ?>
      <button type="button" onclick="subir_archivo_ss(<?php echo $IdAviso; ?>,1)" class="btn btn-info pull-right"><i class="fa fa-fw fa-upload"></i> Subir archivo</button>
      <?php } ?>
    </div>
  </form>
</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Carta de asignación de Servicio Social</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Buscar archivo:</label>
        <div class="col-sm-8">
          <input type="file" class="form-control" id="txt_archivo2" name="txt_archivo2">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <?php if(isset($_docs2[0])){ ?>
      <button type="button" onclick="del_documento_ss(<?php echo $IdAviso; ?>,<?php echo $_docs2['IdDocs']; ?>)" class="btn btn-danger pull-right"><i class="fa fa-fw fa-trash"></i> Eliminar archivo</button>
      <button style="margin-right: 10px;" type="button" onClick="window.open('<?php echo $_docs2['Archivo']; ?>','_blank')" href="javascript:void(0);" class="btn btn-success pull-right"><i class="fa fa-fw fa-eye"></i> Ver archivo</button>
      <?php } else { ?>
      <button type="button" onclick="subir_archivo_ss(<?php echo $IdAviso; ?>,2)" class="btn btn-info pull-right"><i class="fa fa-fw fa-upload"></i> Subir archivo</button>
      <?php } ?>
    </div>
  </form>
</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Formato de reporte inicial de Servicio Social</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Buscar archivo:</label>
        <div class="col-sm-8">
          <input type="file" class="form-control" id="txt_archivo3" name="txt_archivo3">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <?php if(isset($_docs3[0])){ ?>
      <button type="button" onclick="del_documento_ss(<?php echo $IdAviso; ?>,<?php echo $_docs3['IdDocs']; ?>)" class="btn btn-danger pull-right"><i class="fa fa-fw fa-trash"></i> Eliminar archivo</button>
      <button style="margin-right: 10px;" type="button" onClick="window.open('<?php echo $_docs3['Archivo']; ?>','_blank')" href="javascript:void(0);" class="btn btn-success pull-right"><i class="fa fa-fw fa-eye"></i> Ver archivo</button>
      <?php } else { ?>
      <button type="button" onclick="subir_archivo_ss(<?php echo $IdAviso; ?>,3)" class="btn btn-info pull-right"><i class="fa fa-fw fa-upload"></i> Subir archivo</button>
      <?php } ?>
    </div>
  </form>
</div>

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Formato de reporte global de Servicio Social</h3>
  </div>
  <form class="form-horizontal">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label">Buscar archivo:</label>
        <div class="col-sm-8">
          <input type="file" class="form-control" id="txt_archivo4" name="txt_archivo4">
        </div>
      </div>
    </div>
    <div class="box-footer">
      <?php if(isset($_docs4[0])){ ?>
      <button type="button" onclick="del_documento_ss(<?php echo $IdAviso; ?>,<?php echo $_docs4['IdDocs']; ?>)" class="btn btn-danger pull-right"><i class="fa fa-fw fa-trash"></i> Eliminar archivo</button>
      <button style="margin-right: 10px;" type="button" onClick="window.open('<?php echo $_docs4['Archivo']; ?>','_blank')" href="javascript:void(0);" class="btn btn-success pull-right"><i class="fa fa-fw fa-eye"></i> Ver archivo</button>
      <?php } else { ?>
      <button type="button" onclick="subir_archivo_ss(<?php echo $IdAviso; ?>,4)" class="btn btn-info pull-right"><i class="fa fa-fw fa-upload"></i> Subir archivo</button>
      <?php } ?>
    </div>
  </form>
</div>
