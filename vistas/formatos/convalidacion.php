<?php
session_start();
$IdAdmin = $_SESSION['IdUsua'];
$IdUsua = $_POST['IdUsua'];
require('../../php/clases/consultas_formatos.php');
$formatos = new Class_formatos();
$_ciclo = $formatos->obtener_periodo_escolar($IdUsua);
$_grados = $formatos->obtener_grado_materias($IdUsua);
$_lst = $formatos->obtener_lista_materias_conva($IdUsua);
// $_cert = $formatos->obtener_datos_certificado($IdUsua);

?>

<form class="form-horizontal">
  <div class="box-body">
    <div class="form-group">
      <label class="col-sm-4 control-label">Periodo escolar:</label>
      <div class="col-sm-8">
        <select name="txt_ciclo_sel_cova" id="txt_ciclo_sel_cova" class="form-control">
          <option value="">- Seleccione-</option>
          <?php for ($i = 0; $i < sizeof($_ciclo); $i++) { ?>
            <option value="<?php echo $_ciclo[$i]['IdCiclo']; ?>"> <?php echo $_ciclo[$i]['Ciclo']; ?> </option>
          <?php } ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Materias del:</label>
      <div class="col-sm-4">
        <select name="txt_ciclo_selx_conva" id="txt_ciclo_selx_conva" class="form-control">
          <option value="">- Seleccione-</option>
          <?php for ($i = 0; $i < sizeof($_grados); $i++) { ?>
            <option value="<?php echo $_grados[$i]['Grado']; ?>"> <?php echo $_grados[$i]['Grado']; ?>° Grado </option>
          <?php } ?>
        </select>
      </div>
    </div>

  </div>
  <div class="box-footer">
    <button onclick="cargar_conva_materias_id(<?php echo $IdUsua; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-save"></i> Cargar materias</button>
  </div>
  <table class="table table-striped">
    <tbody>
      <tr>
      </tr>

      <?php $ci = 0;
      $cf = 0;
      for ($i = 0; $i < sizeof($_lst); $i++) {
        $ci = $_lst[$i]['IdCiclo'];
        if ($ci <> $cf) { ?>
          <tr>
            <th colspan="4" style="background: #1d3462; color: white;">PERIODO ESCOLAR: <?php echo $_lst[$i]['Ciclo']; ?> </th>
          </tr>
          <tr>
            <th></th>
            <th>NOMBRE DE LA MATERIA</th>
            <th style="text-align: center;">PROMEDIO</th>
          </tr>
        <?php }
        ?>
        <tr>
          <td>
            <button onclick="eliminar_materia_id_conva(<?php echo $IdUsua; ?>,<?php echo $_lst[$i]['IdEquivalencia']; ?>)" type="button" class="btn bg-maroon btn-flat btn-sm"><i class="fa fa-trash"></i></button>
          </td>
          <td><?php echo $_lst[$i]['CodeModulo']; ?> <?php echo $_lst[$i]['NombreMod']; ?></td>
          <td style="text-align: center;">
            <div class="input-group input-group-sm">
              <input name="prom_<?php echo $_lst[$i]['IdEquivalencia']; ?>" id="prom_<?php echo $_lst[$i]['IdEquivalencia']; ?>" onchange="save_promedio_conva(<?php echo $IdUsua; ?>,<?php echo $_lst[$i]['IdEquivalencia']; ?>)" style="text-align: center;" type="text" class="form-control" value="<?php echo $_lst[$i]['Promedio']; ?>">
            </div>
          </td>
        </tr>
      <?php $cf = $_lst[$i]['IdCiclo'];
      } ?>
    </tbody>
  </table>
  <?php if($ci <> 0){ ?>
  <div class="box-body">
    
    <div class="form-group">
      <label class="col-sm-3 control-label">Comentario:</label>
      <div class="col-sm-9">
        <input type="text" name="txt_comentario_conva" id="txt_comentario_conva" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-8 control-label">Fecha de emisión:</label>
      <div class="col-sm-4">
        <input type="text" name="convalidacion_fecha" id="convalidacion_fecha" class="form-control">
      </div>
    </div>
  </div>
  <div class="box-footer">
    <button onclick="sav_materias_convalidacion(<?php echo $IdUsua; ?>,<?php echo $IdAdmin; ?>)" type="button" class="btn bg-purple btn-flat pull-right"><i class="fa fa-fw fa-save"></i> Guardar promedio convalidación</button>
  </div>
  <?php } ?>
</form>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function() {
    //Date picker
    $('#convalidacion_fecha').datepicker({
      autoclose: true
    })

  })
</script>