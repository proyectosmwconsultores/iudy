<?php
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$_cert = $formatos->obtener_datos_certificado($IdUsua);
$_ciclo = $formatos->get_mis_periodos($IdUsua);
$tipo = $formatos->get_tipo_titulacion($IdUsua);
if (isset($_cert[0]['Gestion'])) {$gestion = $_cert[0]['Gestion']; } else { $gestion = "MARÍA ANAID NATALIA LÓPEZ MARTÍNEZ"; }
if (isset($_cert[0]['Escolar'])) { $escolar = $_cert[0]['Escolar']; } else { $escolar = "CARLOS SANTIAGO SÁNCHEZ"; }

if (isset($_cert[0]['t_gestion'])) {$tgestion = $_cert[0]['t_gestion']; } else { $tgestion = "María Anaid Natalia López Martínez"; }
if (isset($_cert[0]['t_control'])) { $tescolar = $_cert[0]['t_control']; } else { $tescolar = "Carlos Santiago Sánchez"; }

?>

<form class="form-horizontal">
  <div class="box-body">

    <div class="form-group">
      <label class="col-sm-4 control-label">Periodo escolar en la que inicia:</label>
      <div class="col-sm-8">
        <select name="txt_ciclo_cer" id="txt_ciclo_cer" class="form-control">
          <option value="0">- NORMAL-</option>
          <?php for ($i = 0; $i < sizeof($_ciclo); $i++) { ?>
            <option value="<?php echo $_ciclo[$i]['IdCiclo']; ?>" <?php if ($_ciclo[$i]['IdCiclo'] == $_cert[0]['IdCiclo']) { ?>selected="selected" <?php } ?>> <?php echo $_ciclo[$i]['Ciclo']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <button onclick="sav_datos_impresion_cert(<?php echo $IdUsua; ?>)" type="button" class="btn bg-orange btn-flat pull-right"><i class="fa fa-fw fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>

  <hr>
  <div class="box-body">
    <div class="bg-purple color-palette" style="padding: 5px;"><span><i class="fa fa-files-o"></i> Datos para la impresión del Certificado de Estudios</span></div>
    <br>
    <div class="form-group">
      <label class="col-sm-3 control-label">Fecha impresión:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_fecha" id="cer_fecha" class="form-control" value="<?php echo $_cert[0]['Fecha']; ?>">
      </div>
      <label class="col-sm-3 control-label">No. Certificado:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_folio" id="cer_folio" class="form-control" value="<?php echo $_cert[0]['Folio']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Estudios de:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_estudios" id="cer_estudios" class="form-control" value="<?php echo $_cert[0]['Estudios']; ?>">
      </div>
      <label class="col-sm-3 control-label">Entidad federativa:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_entidad" id="cer_entidad" class="form-control" value="<?php echo $_cert[0]['Entidad']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Institución:</label>
      <div class="col-sm-6">
        <input type="text" name="cer_institucion" id="cer_institucion" class="form-control" value="<?php echo $_cert[0]['Institucion']; ?>">
      </div>
      <label class="col-sm-1 control-label">CCT:</label>
      <div class="col-sm-2">
        <input type="text" name="cer_cct" id="cer_cct" class="form-control" value="<?php echo $_cert[0]['CCT']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Año de inicio:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_inicio" id="cer_inicio" maxlength='4' class="form-control" value="<?php echo $_cert[0]['Cer_inicio']; ?>">
      </div>
      <label class="col-sm-3 control-label">Año de termino:</label>
      <div class="col-sm-3">
        <input type="text" name="cer_final" id="cer_final" maxlength='4' class="form-control" value="<?php echo $_cert[0]['Cer_final']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Directora de Gestión Escolar y Titulación:</label>
      <div class="col-sm-8">
        <input type="text" name="cer_gestion" id="cer_gestion" class="form-control" value="<?php echo $gestion; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Director de Control Escolar e Incorporación:</label>
      <div class="col-sm-8">
        <input type="text" name="cer_escolar" id="cer_escolar" class="form-control" value="<?php echo $escolar; ?>">
      </div>
    </div>
  </div>

  <div class="box-footer">
    <button onclick="sav_datos_certificado(<?php echo $IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"> <i class="fa fa-fw fa-save"></i> Guardar datos</button>
  </div>

  <div class="box-body">
    <div class="bg-purple color-palette" style="padding: 5px;"><span><i class="fa fa-files-o"></i> Datos para la impresión del Título de Estudios</span></div>
    <br>
    <div class="form-group">
      <label class="col-sm-3 control-label">Inicia carrera:</label>
      <div class="col-sm-3">
        <input type="text" name="t_inicio" id="t_inicio" class="form-control" value="<?php echo $_cert[0]['t_inicio']; ?>">
      </div>
      <label class="col-sm-3 control-label">Termina carrera:</label>
      <div class="col-sm-3">
        <input type="text" name="t_final" id="t_final" class="form-control" value="<?php echo $_cert[0]['t_final']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Modalidad de titulación:</label>
      <div class="col-sm-8">
        <select name="txt_tipo_titulo" id="txt_tipo_titulo" class="form-control">
          <option value="">- Seleccione-</option>
          <?php for ($i = 0; $i < sizeof($tipo); $i++) { ?>
            <option value="<?php echo $tipo[$i]['idTipo']; ?>" <?php if ($tipo[$i]['idTipo'] == $_cert[0]['t_idTipo']) { ?>selected="selected" <?php } ?>> <?php echo $tipo[$i]['Tipo1']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Fecha de examen profesional:</label>
      <div class="col-sm-4">
      <input type="text" name="t_examen" id="t_examen" class="form-control" value="<?php echo $_cert[0]['t_fecha_examen']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Fecha de impresión:</label>
      <div class="col-sm-4">
      <input type="text" name="t_impresion" id="t_impresion" class="form-control" value="<?php echo $_cert[0]['t_impresion']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Libro No:</label>
      <div class="col-sm-3">
        <input type="text" name="t_no" id="t_no" class="form-control" value="<?php echo $_cert[0]['t_no']; ?>">
      </div>
      <label class="col-sm-3 control-label">Foja No:</label>
      <div class="col-sm-3">
        <input type="text" name="t_foja" id="t_foja" class="form-control" value="<?php echo $_cert[0]['t_foja']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Directora de Gestión Escolar y Titulación:</label>
      <div class="col-sm-8">
        <input type="text" name="t_gestion" id="t_gestion" class="form-control" value="<?php echo $tgestion; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Director de Control Escolar e Incorporación:</label>
      <div class="col-sm-8">
        <input type="text" name="t_escolar" id="t_escolar" class="form-control" value="<?php echo $tescolar; ?>">
      </div>
    </div>
  </div>

  <div class="box-footer">
    <button onclick="sav_datos_titulo(<?php echo $IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"> <i class="fa fa-fw fa-save"></i> Guardar datos</button>
  </div>

  <div class="box-body">
    <div class="bg-purple color-palette" style="padding: 5px;"><span><i class="fa fa-files-o"></i> Configurar acta de titulación</span></div>
    <br>
    <div class="form-group">
      <label class="col-sm-3 control-label">Hora:</label>
      <div class="col-sm-3">
        <input type="text" name="a_hora" id="a_hora" class="form-control" value="<?php echo $_cert[0]['acta_hora']; ?>">
      </div>
      <label class="col-sm-3 control-label">Fecha de impresión:</label>
      <div class="col-sm-3">
        <input type="text" name="a_fecha" id="a_fecha" class="form-control" value="<?php echo $_cert[0]['acta_fecha']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Aprobado con forme a:</label>
      <div class="col-sm-8">
        <input type="text" name="a_aprobo" id="a_aprobo" class="form-control" value="<?php echo $_cert[0]['acta_aprobo']; ?>">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button onclick="sav_datos_acta_titulo(<?php echo $IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"> <i class="fa fa-fw fa-save"></i> Guardar datos</button>
  </div>

</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    $('#cer_fecha').datepicker({
      autoclose: true
    })
    $('#t_inicio').datepicker({
      autoclose: true
    })
    $('#t_final').datepicker({
      autoclose: true
    })
    $('#t_examen').datepicker({
      autoclose: true
    })
    $('#t_impresion').datepicker({
      autoclose: true
    })
    $('#a_fecha').datepicker({
      autoclose: true
    })
  })
</script>